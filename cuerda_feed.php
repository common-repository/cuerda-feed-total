<?php
/*
 * Plugin Name:       Cuerda-Feed-total
 * Plugin URI:        https://cuerda.org/
 * Description:       コンテンツ配信用 RSS フィードのプラグインです。
 * Version:           3.0.8
 * Requires at least: 5.8
 * Requires PHP:      7.4
 * Author:            Kimiya Watabe / cuerda
 * Author URI:        https://s317.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */
// cuerda（クエルダ）は本プログラムソースコードの著作権を保有しています。
// Copyright (C) 2020 CUERDA(https://cuerda.org).
if(!defined('ABSPATH')){
die('Forbidden');
}

$ynf_ftp_put_option = get_option('cuerda_ynf_ftp_put', 0);
if($ynf_ftp_put_option == ''){
	$ynf_ftp_put = 0;
}else{
	$ynf_ftp_put = $ynf_ftp_put_option;
}
if($ynf_ftp_put == 1){
	global $wp_filesystem;
	// WP_Filesystemの初期化
	if ( ! function_exists( 'WP_Filesystem' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
	}
	WP_Filesystem(); // 初期化

	function cuerda_ynf_ftp_function_trans($new_status, $old_status, $post){
		$function_name = 'transition';
		$post_id = $post->ID;
		$post_type = get_post_type($post_id);
		$post_modified = get_post_field('post_modified', $post_id, 'raw');
		$old_modified = get_post_meta($post_id, '_cuerda_old_modified', true);
		$debug_file_path = plugin_dir_path(__FILE__) . 'debug.php'; // デバッグファイル
	
		// 最終更新日時が一定以上経過しているかを確認
		if (strtotime($post_modified) > strtotime($old_modified) + 3) {
			$result = 'OK';
		} else {
			$result = 'NG';
		}
	
		// 前回のリビジョンを取得
		$old_rev = get_post_meta($post_id, '_cuerda_old_rev', true);
		if (empty($old_rev) || $old_rev === '') {
			$old_rev = '';
		}
	
		// 処理判定
		if ($post_type !== 'post' || ($new_status !== 'publish' && $old_status !== 'publish') || $result !== 'OK') {
			error_log('Skipping function: post_type=' . $post_type . ', new_status=' . $new_status . ', old_status=' . $old_status . ', result=' . $result);
			return; // スキップ条件
		}
	
		// 処理用のリビジョン
		if ($new_status === 'publish' && $old_status !== 'publish') {
			$rev = 'new';
		} elseif ($new_status === 'publish' && $old_status === 'publish') {
			$rev = $old_rev;
		} else {
			$rev = 'del';
		}
	
		// debug mode start
		$current_time_tokyo = gmdate('Y-m-d H:i:s');
		$on_debug = PHP_EOL.'--------------------------------------'.PHP_EOL.'▼'.$function_name.' '.$current_time_tokyo.' action'.PHP_EOL.' $post_id '.$post_id.PHP_EOL.' $post_type '.$post_type.PHP_EOL.' $new_status '.$new_status.PHP_EOL.' $old_status '.$old_status.PHP_EOL.' $old_modified '.$old_modified.PHP_EOL.' $post_modified '.$post_modified.PHP_EOL.' $old_rev '.$old_rev.PHP_EOL.' $rev to '.$rev.PHP_EOL;
		// ファイルの内容を保持して末尾に追記
		if ( ! empty( $wp_filesystem ) ) {
		$existing_content = $wp_filesystem->get_contents( $debug_file_path );
		$new_content = $existing_content . $on_debug;
		$wp_filesystem->put_contents( $debug_file_path, $new_content, FS_CHMOD_FILE );
		}
		// debug mode end
	
		if (defined('DISABLE_WP_CRON') && DISABLE_WP_CRON) {
			// WP Cronが無効化されている場合、非同期リクエストを直接送信
			update_post_meta($post_id, '_ynf_ftp_data', [
				'result'          => $result,
				'new_status'      => $new_status,
				'old_status'      => $old_status,
				'post_modified'   => $post_modified,
				'rev'             => $rev,
				'debug_file_path' => $debug_file_path,
				'old_rev'         => $old_rev,
				'old_modified'    => $old_modified
			]);
		} else {
			// WP Cronが有効化されている場合、イベントをスケジュール
			wp_schedule_single_event(time(), 'cuerda_async_ynf_ftp_function', array($post_id, $new_status, $old_status, $post, $post_modified, $rev, $debug_file_path, $old_rev, $old_modified));
		}
	}

	function cuerda_ynf_ftp_function_after_save($post_id, $post, $update) {
		// デバッグログ
		error_log('▼ cuerda_ynf_ftp_function_after_save が呼び出されました。'); // 関数が呼び出されたかを確認

		// 一時的に保存したデータを取得
		$ynf_ftp_data = get_post_meta($post_id, '_ynf_ftp_data', true);

		if ($ynf_ftp_data) {
			$function_name = 'after_save';

			// データが取得できているか確認し、デフォルト値を設定
			$result = isset($ynf_ftp_data['result']) ? $ynf_ftp_data['result'] : 'NG';
			$new_status = isset($ynf_ftp_data['new_status']) ? $ynf_ftp_data['new_status'] : '';
			$old_status = isset($ynf_ftp_data['old_status']) ? $ynf_ftp_data['old_status'] : '';
			$post_modified = isset($ynf_ftp_data['post_modified']) ? $ynf_ftp_data['post_modified'] : '';
			$rev = isset($ynf_ftp_data['rev']) ? $ynf_ftp_data['rev'] : '';
			$debug_file_path = isset($ynf_ftp_data['debug_file_path']) ? $ynf_ftp_data['debug_file_path'] : '';
			$old_rev = isset($ynf_ftp_data['old_rev']) ? $ynf_ftp_data['old_rev'] : '';
			$old_modified = isset($ynf_ftp_data['old_modified']) ? $ynf_ftp_data['old_modified'] : '';
	
			$enc_icatch_option = get_option('cuerda_ynf_icatch',0);
			if($enc_icatch_option == ''){
				$enc_icatch = 0;
			}else{
				$enc_icatch = $enc_icatch_option;
			}
			$enc_icatch = isset($enc_icatch) ? $enc_icatch : 0;

			if($enc_icatch == 1){
				$thumbnail_url = get_the_post_thumbnail_url($post_id);
				$image_data = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'full');
				$mime_type = get_post_mime_type(get_post_thumbnail_id($post_id));
				$go_img = 1;
				if($thumbnail_url || $image_data || $mime_type == 'image/jpeg'){

					sleep(1);
					cuerda_async_ynf_ftp_function(
						$post_id,
						$new_status,
						$old_status,
						$post, // ここで $post オブジェクトを直接渡す
						$post_modified,
						$rev,
						$debug_file_path,
						$old_rev,
						$old_modified
					);

					// debug mode start
					$current_time_tokyo = gmdate('Y-m-d H:i:s');
					$on_debug = PHP_EOL.'--------------------------------------'.PHP_EOL.'▼'.$function_name.' '.$current_time_tokyo.' action'.PHP_EOL.' $post_id '.$post_id.PHP_EOL.' $new_status '.$new_status.PHP_EOL.' $old_status '.$old_status.PHP_EOL.' $old_modified '.$old_modified.PHP_EOL.' $post_modified '.$post_modified.PHP_EOL.' $old_rev '.$old_rev.PHP_EOL.' $rev to '.$rev.PHP_EOL;
					// ファイルの内容を保持して末尾に追記
					if ( ! empty( $wp_filesystem ) ) {
					$existing_content = $wp_filesystem->get_contents( $debug_file_path );
					$new_content = $existing_content . $on_debug;
					$wp_filesystem->put_contents( $debug_file_path, $new_content, FS_CHMOD_FILE );
					}
					// debug mode end
				}
			}
			// 一時的なデータを削除
			delete_post_meta($post_id, '_ynf_ftp_data');
		} else {
			error_log('× ynf_ftp_data は作成されていません。');
		}
	}

	function cuerda_async_ynf_ftp_function($post_id, $new_status, $old_status, $post, $post_modified, $rev, $debug_file_path, $old_rev, $old_modified) {

		global $wp_filesystem;
		// WP_Filesystemの初期化
		if ( ! function_exists( 'WP_Filesystem' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
		}
		WP_Filesystem(); // 初期化

		error_log('▼ cuerda_async_ynf_ftp_function が呼び出されました。'); // 関数が呼び出されたかを確認
		$function_name = 'async';
	
		// デバッグログ
		$current_time_tokyo = gmdate('Y-m-d H:i:s');
		$on_debug = '--------------------------------------'.PHP_EOL.'▼'.$function_name.' が '.$current_time_tokyo.' アクション'.PHP_EOL.' $post_id '.$post_id.PHP_EOL.' $new_status '.$new_status.PHP_EOL.' $old_status '.$old_status.PHP_EOL.' $old_modified '.$old_modified.PHP_EOL.' $post_modified '.$post_modified.PHP_EOL.' $old_rev '.$old_rev.PHP_EOL.' $rev（新） '.$rev.PHP_EOL;
		// デバッグファイルに追記
		if ( ! empty( $wp_filesystem ) ) {
			// 既存のデバッグファイルの内容を取得して追記
			$existing_content = $wp_filesystem->get_contents( $debug_file_path );
			$new_content = $existing_content . $on_debug;
			$wp_filesystem->put_contents( $debug_file_path, $new_content, FS_CHMOD_FILE );
		}
	
		// デバッグ情報をファイルに追記
		$debug_info = gmdate('Y-m-d H:i:s') . " - Async event triggered for post ID: $post_id, new status: $new_status, old status: $old_status, rev: $rev\n";
		if ( ! empty( $wp_filesystem ) ) {
			$existing_content = $wp_filesystem->get_contents( $debug_file_path );
			$new_content = $existing_content . $debug_info;
			$wp_filesystem->put_contents( $debug_file_path, $new_content, FS_CHMOD_FILE );
		}
	
		global $wp_filesystem;
		// WP_Filesystemの初期化
		if ( ! function_exists( 'WP_Filesystem' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
		}
		WP_Filesystem(); // 初期化

		// 各投稿に一意の名前のスクリプトを生成し、存在する場合は読み込む
		$script_name = 'put_ftp_ynf_' . $post_id . '_' . $rev . '.php';
		$script_path = plugin_dir_path(__FILE__) . $script_name;

		if ( ! file_exists( $script_path ) ) {
			$script_content = '<?php require_once(plugin_dir_path(__FILE__) . "put_ftp_ynf.php");';
			
			// WP_Filesystemを使用してスクリプトを作成
			if ( ! empty( $wp_filesystem ) ) {
				$wp_filesystem->put_contents( $script_path, $script_content, FS_CHMOD_FILE );
			}
		}

		// スクリプト put_ftp_ynf の実行
		global $wp_filesystem;
		// WP_Filesystemの初期化
		if ( ! function_exists( 'WP_Filesystem' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
		}
		WP_Filesystem(); // 初期化
		// スクリプト put_ftp_ynf の実行
		if ( $wp_filesystem->exists( $script_path ) ) {
			$debug_info = gmdate('Y-m-d H:i:s') . " - Executing script for post ID: $post_id, rev: $rev\n";
			
			// デバッグ情報をファイルに追記
			$existing_content = $wp_filesystem->get_contents( $debug_file_path );
			$new_content = $existing_content . $debug_info;
			$wp_filesystem->put_contents( $debug_file_path, $new_content, FS_CHMOD_FILE );
			
			// スクリプトの実行
			require_once $script_path;
			
			// スクリプトファイルの削除
			$wp_filesystem->delete( $script_path );
		}

		// ファイルのサイズを取得
		$file_size = filesize($debug_file_path);
		// 一定サイズ以上のものだけ削除
		if ($file_size > 50000) {
			// ファイルの削除
			wp_delete_file($debug_file_path);
		}
	}
	add_action('transition_post_status', 'cuerda_ynf_ftp_function_trans', 10, 3);
	add_action('save_post', 'cuerda_ynf_ftp_function_after_save', 11, 3);
	add_action('cuerda_async_ynf_ftp_function', 'cuerda_async_ynf_ftp_function', 12, 9);

}

// オプションキーの読み込み
require 'cuerda_feed_option.php';
// フィードプログラムのアクションフック
function CFTL_do_feed_cuerda_total(){
	$feed_template_total = plugin_dir_path( __FILE__ ) . 'func_base.php';
	load_template( $feed_template_total );
}
add_action('do_feed_cuerda_total','CFTL_do_feed_cuerda_total');

// 管理メニューのアクションフック
add_action('admin_menu','CFTL_admin_menu_feed_cuerda_total');

// アクションフックのコールバック関数
function CFTL_admin_menu_feed_cuerda_total(){
	add_options_page(
		'cuerda 配信設定',// ページタイトル
		'cuerda 配信設定',// メニュータイトル
		'manage_options',// 権限
		'cuerda_feed_settings',// 固定された安全なメニュースラッグ
		'cuerda_feed_cuerda_total'// コールバック関数
	);
}
// メニュー追加のためのアクションフック
add_action( 'admin_menu', 'CFTL_admin_menu_feed_cuerda_total' );

cuerda_register_cuerda_total();
function cuerda_feed_cuerda_total(){
require 'version.php';

// 設定画面の始まり
require 'cuerda_feed_config_total.php';
//wp_register_style('cuerda-feed-style', false);
//wp_add_inline_style('cuerda-feed-style', $inline_style);
//wp_enqueue_style('cuerda-feed-style');
echo '<div class="wrap">';
echo '<h2>'.$header_name.'</h2>';

// 設定画面
if (!current_user_can('manage_options')){
cuerda_share_Unauthorized();
}else{
echo '<form method="post" action="options.php">';
settings_fields('option-settings-group_total');
do_settings_sections('option-settings-group_total');
CFTL_cuerda_share_enqueue_scripts();
submit_button();

/**********************************
ここから詳細設定
**********************************/
cuerda_share_tab();
cuerda_share_thead();
CFTL_setting_tabblock('total');
CFTL_setting_post_type('total');
CFTL_setting_post_status('total');
CFTL_setting_publish_status('total');
CFTL_setting_expires('total');
CFTL_setting_cf_youtube('total');
CFTL_setting_nordot_unit_id('total');
CFTL_setting_nordot_cu_id('total');
CFTL_setting_rel_urlpass('total');
cuerda_share_table_end();
echo '</div>';

echo '<div id="tab-content_ynf" class="tab-content">';
echo '<table class="form-table cuerda config_ynf">';
cuerda_share_thead();
cuerda_show_rss('ynf');
CFTL_setting_title('ynf');
CFTL_setting_ynf_category('ynf');
//CFTL_setting_after_date('ynf');
//CFTL_setting_publish_delay('ynf');
//CFTL_setting_cf_publish_delay('ynf');
//CFTL_setting_after_modified('ynf');
//CFTL_setting_posts_per_page('ynf');
//CFTL_setting_category__absolute('ynf');
CFTL_setting_category__in('ynf');
CFTL_setting_category__not_in('ynf');
CFTL_setting_tag__in('ynf');
CFTL_setting_tag__not_in('ynf');
CFTL_setting_author__in('ynf');
CFTL_setting_author__not_in('ynf');
CFTL_setting_post__not_in('ynf');
CFTL_setting_rel_count('ynf');
CFTL_setting_rel_tag('ynf');
//CFTL_setting_rel_manual('ynf');
//CFTL_setting_rel_feeld1('ynf');
//CFTL_setting_rel_feeld2('ynf');
//CFTL_setting_rel_feeld3('ynf');
//CFTL_setting_rel_nor_set('ynf');
//CFTL_setting_image('ynf');
CFTL_setting_icatch('ynf');
CFTL_setting_cf_creator('ynf');
//CFTL_setting_article_summary('ynf');
CFTL_setting_enclosure_alt('ynf');
//CFTL_setting_video('ynf');
CFTL_setting_area_city('ynf');
CFTL_setting_sentence_delete('ynf');
CFTL_setting_regular_expression_delete('ynf');
CFTL_setting_articletype();
cuerda_btn_script();
CFTL_setting_ftp_put_ynf();
CFTL_setting_ftp_server('ynf');
CFTL_setting_ftp_user_name('ynf');
CFTL_setting_ftp_password('ynf');
CFTL_setting_ftp_remote_dir('ynf');
CFTL_setting_ynf_id();
CFTL_setting_ldap_user('ynf');
CFTL_setting_ldap_pass('ynf');
cuerda_share_table_end();
echo '</div>';

echo '<div id="tab-content_yjt" class="tab-content">';
echo '<table class="form-table cuerda config_yjt">';
cuerda_share_thead();
cuerda_show_rss('yjt');
CFTL_setting_title('yjt');
CFTL_setting_after_date('yjt');
//CFTL_setting_publish_delay('yjt');
//CFTL_setting_cf_publish_delay('yjt');
CFTL_setting_after_modified('yjt');
CFTL_setting_posts_per_page('yjt');
//CFTL_setting_category__absolute('yjt');
CFTL_setting_category__in('yjt');
CFTL_setting_category__not_in('yjt');
CFTL_setting_tag__in('yjt');
CFTL_setting_tag__not_in('yjt');
CFTL_setting_author__in('yjt');
CFTL_setting_author__not_in('yjt');
CFTL_setting_post__not_in('yjt');
CFTL_setting_rel_count('yjt');
CFTL_setting_rel_tag('yjt');
CFTL_setting_rel_nor_set('yjt');
CFTL_setting_rel_manual('yjt');
//CFTL_setting_rel_feeld('yjt');
CFTL_setting_image('yjt');
CFTL_setting_icatch('yjt');
CFTL_setting_enclosure_alt('yjt');
//CFTL_setting_video('yjt');
CFTL_setting_cf_creator('yjt');
//CFTL_setting_area_city('yjt');
CFTL_setting_table('yjt');
CFTL_setting_sentence_delete('yjt');
CFTL_setting_regular_expression_delete('yjt');
CFTL_setting_table_inline('yjt');
CFTL_setting_table_inline_delimiter('yjt');
cuerda_share_table_end();
echo '</div>';

echo '<div id="tab-content_goo" class="tab-content">';
echo '<table class="form-table cuerda config_goo">';
cuerda_share_thead();
cuerda_show_rss('goo');
CFTL_setting_title('goo');
CFTL_setting_after_date('goo');
CFTL_setting_publish_delay('goo');
CFTL_setting_cf_publish_delay('goo');
CFTL_setting_after_modified('goo');
CFTL_setting_posts_per_page('goo');
CFTL_setting_category__absolute('goo');
CFTL_setting_category__in('goo');
CFTL_setting_category__not_in('goo');
CFTL_setting_tag__in('goo');
CFTL_setting_tag__not_in('goo');
CFTL_setting_author__in('goo');
CFTL_setting_author__not_in('goo');
CFTL_setting_post__not_in('goo');
CFTL_setting_rel_count('goo');
CFTL_setting_rel_manual('goo');
CFTL_setting_rel_feeld1('goo');
CFTL_setting_rel_feeld2('goo');
CFTL_setting_rel_feeld3('goo');
CFTL_setting_rel_tag('goo');
CFTL_setting_rel_nor_set('goo');
CFTL_setting_image('goo');
CFTL_setting_icatch('goo');
CFTL_setting_enclosure_alt('goo');
CFTL_setting_video('goo');
CFTL_setting_cf_creator('goo');
CFTL_setting_area_city('goo');
CFTL_setting_sentence_delete('goo');
CFTL_setting_regular_expression_delete('goo');

cuerda_share_table_end();
echo '</div>';

echo '<div id="tab-content_dcm" class="tab-content">';
echo '<table class="form-table cuerda config_dcm">';
cuerda_share_thead();
cuerda_show_rss('dcm');
CFTL_setting_title('dcm');
CFTL_setting_after_date('dcm');
CFTL_setting_publish_delay('dcm');
CFTL_setting_cf_publish_delay('dcm');
CFTL_setting_after_modified('dcm');
CFTL_setting_posts_per_page('dcm');
CFTL_setting_category__absolute('dcm');
CFTL_setting_category__in('dcm');
CFTL_setting_category__not_in('dcm');
CFTL_setting_tag__in('dcm');
CFTL_setting_tag__not_in('dcm');
CFTL_setting_author__in('dcm');
CFTL_setting_author__not_in('dcm');
CFTL_setting_post__not_in('dcm');
CFTL_setting_rel_count('dcm');
CFTL_setting_rel_tag('dcm');
CFTL_setting_rel_nor_set('dcm');
CFTL_setting_image('dcm');
CFTL_setting_icatch('dcm');
CFTL_setting_table('dcm');
CFTL_setting_copyright('dcm');
CFTL_setting_sentence_delete('dcm');
cuerda_share_table_end();
echo '</div>';

echo '<div id="tab-content_spb" class="tab-content">';
echo '<table class="form-table cuerda config_spb">';
cuerda_share_thead();
cuerda_show_rss('spb');
CFTL_setting_spb_category('spb');
CFTL_setting_title('spb');
CFTL_setting_ttl('spb');
CFTL_setting_after_date('spb');
//CFTL_setting_publish_delay('spb');
//CFTL_setting_cf_publish_delay('spb');
CFTL_setting_after_modified('spb');
CFTL_setting_posts_per_page('spb');
//CFTL_setting_category__absolute('spb');
CFTL_setting_category__in('spb');
CFTL_setting_category__not_in('spb');
CFTL_setting_tag__in('spb');
CFTL_setting_tag__not_in('spb');
CFTL_setting_author__in('spb');
CFTL_setting_author__not_in('spb');
CFTL_setting_post__not_in('spb');
CFTL_setting_rel_count('spb');
CFTL_setting_rel_tag('spb');
CFTL_setting_rel_nor_set('spb');
//CFTL_setting_image('spb');
CFTL_setting_icatch('spb');
CFTL_setting_table('spb');
CFTL_setting_copyright('spb');
CFTL_setting_area_city('spb');
CFTL_setting_sentence_delete('spb');
CFTL_setting_regular_expression_delete('spb');
cuerda_share_table_end();
echo '</div>';

echo '<div id="tab-content_snf" class="tab-content">';
echo '<table class="form-table cuerda config_snf">';
cuerda_share_thead();
cuerda_show_rss('snf');
CFTL_setting_title('snf');
CFTL_setting_ttl('snf');
CFTL_setting_after_date('snf');
CFTL_setting_publish_delay('snf');
CFTL_setting_cf_publish_delay('snf');
CFTL_setting_after_modified('snf');
CFTL_setting_posts_per_page('snf');
CFTL_setting_category__in('snf');
CFTL_setting_category__not_in('snf');
CFTL_setting_tag__in('snf');
CFTL_setting_tag__not_in('snf');
CFTL_setting_author__in('snf');
CFTL_setting_author__not_in('snf');
CFTL_setting_post__not_in('snf');
CFTL_setting_rel_count('snf');
CFTL_setting_rel_tag('snf');
CFTL_setting_rel_nor_set('snf');
CFTL_setting_image('snf');
CFTL_setting_video('snf');
CFTL_setting_icatch('snf');
CFTL_setting_cf_creator('snf');
CFTL_setting_logo('snf');
CFTL_setting_darkmodelogo('snf');
CFTL_setting_thumbnail('snf');
CFTL_setting_analytics('snf');
CFTL_setting_rel_ad('snf');
CFTL_setting_rel_link1('snf');
CFTL_setting_rel_title1('snf');
CFTL_setting_rel_thumbnail1('snf');
CFTL_setting_rel_advertiser1('snf');
CFTL_setting_rel_link2('snf');
CFTL_setting_rel_title2('snf');
CFTL_setting_rel_thumbnail2('snf');
CFTL_setting_rel_advertiser2('snf');
CFTL_setting_sentence_delete('snf');
CFTL_setting_regular_expression_delete('snf');
cuerda_share_table_end();
echo '</div>';

echo '<div id="tab-content_gnf" class="tab-content">';
echo '<table class="form-table cuerda config_gnf">';
cuerda_share_thead();
cuerda_show_rss('gnf');
CFTL_setting_gnf_category();
CFTL_setting_title('gnf');
CFTL_setting_ttl('gnf');
CFTL_setting_after_date('gnf');
CFTL_setting_publish_delay('gnf');
CFTL_setting_cf_publish_delay('gnf');
CFTL_setting_after_modified('gnf');
CFTL_setting_posts_per_page('gnf');
CFTL_setting_category__in('gnf');
CFTL_setting_category__not_in('gnf');
CFTL_setting_tag__in('gnf');
CFTL_setting_tag__not_in('gnf');
CFTL_setting_author__in('gnf');
CFTL_setting_author__not_in('gnf');
CFTL_setting_post__not_in('gnf');
CFTL_setting_rel_count('gnf');
CFTL_setting_rel_tag('gnf');
CFTL_setting_rel_nor_set('gnf');
CFTL_setting_image('gnf');
CFTL_setting_icatch('gnf');
CFTL_setting_enclosure_alt('gnf');
CFTL_setting_cf_creator('gnf');
CFTL_setting_logo('gnf');
CFTL_setting_wide_logo('gnf');
CFTL_setting_analytics('gnf');
CFTL_setting_analytics_gn('gnf');
//CFTL_setting_analytics_lc('gnf');
CFTL_setting_analytics_st('gnf');
CFTL_setting_copyright('gnf');
CFTL_setting_sentence_delete('gnf');
CFTL_setting_regular_expression_delete('gnf');
cuerda_share_table_end();
echo '</div>';

echo '<div id="tab-content_lnr" class="tab-content">';
echo '<table class="form-table cuerda config_lnr">';
cuerda_share_thead();
cuerda_show_rss('lnr');
CFTL_setting_title('lnr');
CFTL_setting_after_date('lnr');
CFTL_setting_publish_delay('lnr');
CFTL_setting_cf_publish_delay('lnr');
CFTL_setting_after_modified('lnr');
CFTL_setting_posts_per_page('lnr');
CFTL_setting_category__in('lnr');
CFTL_setting_category__not_in('lnr');
CFTL_setting_tag__in('lnr');
CFTL_setting_tag__not_in('lnr');
CFTL_setting_author__in('lnr');
CFTL_setting_author__not_in('lnr');
CFTL_setting_post__not_in('lnr');
CFTL_setting_rel_count('lnr');
CFTL_setting_rel_tag('lnr');
CFTL_setting_rel_nor_set('lnr');
CFTL_setting_image('lnr');
CFTL_setting_icatch('lnr');
CFTL_setting_video('lnr');
CFTL_setting_cf_creator('lnr');
CFTL_setting_area_city('lnr');
CFTL_setting_table('lnr');
CFTL_setting_expire('lnr');
CFTL_setting_sentence_delete('lnr');
CFTL_setting_regular_expression_delete('lnr');
cuerda_share_table_end();
echo '</div>';

echo '<div id="tab-content_ldn" class="tab-content">';
echo '<table class="form-table cuerda config_ldn">';
cuerda_share_thead();
cuerda_show_rss('ldn');
CFTL_setting_title('ldn');
CFTL_setting_after_date('ldn');
CFTL_setting_publish_delay('ldn');
CFTL_setting_cf_publish_delay('ldn');
CFTL_setting_after_modified('ldn');
CFTL_setting_posts_per_page('ldn');
CFTL_setting_category__in('ldn');
CFTL_setting_category__not_in('ldn');
CFTL_setting_tag__in('ldn');
CFTL_setting_tag__not_in('ldn');
CFTL_setting_author__in('ldn');
CFTL_setting_author__not_in('ldn');
CFTL_setting_post__not_in('ldn');
CFTL_setting_rel_count('ldn');
CFTL_setting_rel_tag('ldn');
CFTL_setting_rel_nor_set('ldn');
CFTL_setting_image('ldn');
CFTL_setting_icatch('ldn');
CFTL_setting_enclosure_alt('ldn');
CFTL_setting_cf_creator('ldn');
CFTL_setting_sentence_delete('ldn');
CFTL_setting_regular_expression_delete('ldn');
cuerda_share_table_end();
echo '</div>';

echo '<div id="tab-content_isn" class="tab-content">';
echo '<table class="form-table cuerda config_isn">';
cuerda_share_thead();
cuerda_show_rss('isn');
CFTL_setting_title('isn');
CFTL_setting_after_date('isn');
CFTL_setting_publish_delay('isn');
CFTL_setting_cf_publish_delay('isn');
CFTL_setting_after_modified('isn');
CFTL_setting_posts_per_page('isn');
CFTL_setting_category__in('isn');
CFTL_setting_category__not_in('isn');
CFTL_setting_tag__in('isn');
CFTL_setting_tag__not_in('isn');
CFTL_setting_author__in('isn');
CFTL_setting_author__not_in('isn');
CFTL_setting_post__not_in('isn');
CFTL_setting_rel_count('isn');
CFTL_setting_rel_tag('isn');
CFTL_setting_rel_nor_set('isn');
CFTL_setting_icatch('isn');
CFTL_setting_enclosure_alt('isn');
CFTL_setting_cf_creator('isn');
CFTL_setting_sentence_delete('isn');
CFTL_setting_regular_expression_delete('isn');
cuerda_share_table_end();
echo '</div>';

echo '<div id="tab-content_ant" class="tab-content">';
echo '<table class="form-table cuerda config_ant">';
cuerda_share_thead();
cuerda_show_rss('ant');
CFTL_setting_title('ant');
CFTL_setting_after_date('ant');
CFTL_setting_publish_delay('ant');
CFTL_setting_cf_publish_delay('ant');
CFTL_setting_after_modified('ant');
CFTL_setting_posts_per_page('ant');
CFTL_setting_category__in('ant');
CFTL_setting_category__not_in('ant');
CFTL_setting_tag__in('ant');
CFTL_setting_tag__not_in('ant');
CFTL_setting_author__in('ant');
CFTL_setting_author__not_in('ant');
CFTL_setting_post__not_in('ant');
CFTL_setting_icatch('ant');
CFTL_setting_expire('ant');
CFTL_setting_copyright('ant');
CFTL_setting_sentence_delete('ant');
CFTL_setting_regular_expression_delete('ant');
cuerda_share_table_end();
echo '</div>';

echo '<div id="tab-content_trl" class="tab-content">';
echo '<table class="form-table cuerda config_trl">';
cuerda_share_thead();
cuerda_show_rss('trl');
CFTL_setting_title('trl');
CFTL_setting_after_date('trl');
CFTL_setting_publish_delay('trl');
CFTL_setting_cf_publish_delay('trl');
CFTL_setting_after_modified('trl');
CFTL_setting_posts_per_page('trl');
CFTL_setting_category__in('trl');
CFTL_setting_category__not_in('trl');
CFTL_setting_tag__in('trl');
CFTL_setting_tag__not_in('trl');
CFTL_setting_author__in('trl');
CFTL_setting_author__not_in('trl');
CFTL_setting_post__not_in('trl');
CFTL_setting_rel_count('trl');
CFTL_setting_rel_tag('trl');
CFTL_setting_rel_nor_set('trl');
CFTL_setting_icatch('trl');
CFTL_setting_add_icatch('trl');
CFTL_setting_enclosure_alt('trl');
CFTL_setting_cf_creator('trl');
CFTL_setting_cf_creator_url('trl');
CFTL_setting_atag('trl');
CFTL_setting_table('trl');
CFTL_setting_sentence_delete('trl');
CFTL_setting_regular_expression_delete('trl');
CFTL_setting_table_inline('trl');
CFTL_setting_table_inline_delimiter('trl');
cuerda_share_table_end();
echo '</div>';

/**********************************
ここまで詳細設定
**********************************/
echo '</div><!-- //tab-content-wrap -->';
echo '</div><!-- //tab-area -->';
submit_button();
echo '</form>';
echo '</div>';
}
}
//--------------------------------------------------------------------------
// プラグイン削除の際に行うオプションの削除
//--------------------------------------------------------------------------
if ( function_exists('register_uninstall_hook') ) {
	register_uninstall_hook(__FILE__, 'uninstall_hook_feed_cuerda_total');
}
require 'cuerda_feed_option_delete.php';

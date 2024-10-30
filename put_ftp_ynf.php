<?php
// cerda（クエルダ）は本プログラムソースコードの著作権を保有しています。
// Copyright (C) 2020 CUERDA(https://cuerda.org).
if(!defined('ABSPATH')){
	die('Forbidden');
}

global $wp_filesystem;
// WP_Filesystemの初期化
if ( ! function_exists( 'WP_Filesystem' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/file.php' );
}
WP_Filesystem(); // 初期化

///////////// debug mode start
$on_debug = '→ ' . $script_name . ' に到達 ' . current_time('Y-m-d H:i:s') . PHP_EOL;
// デバッグファイルに追記
if ( ! empty( $wp_filesystem ) ) {
	$existing_content = $wp_filesystem->get_contents( $debug_file_path );
	$new_content = $existing_content . $on_debug;
	$wp_filesystem->put_contents( $debug_file_path, $new_content, FS_CHMOD_FILE );
}
///////////// debug mode end

//cuerda_valid_license();

//////////////////////////////// 投稿が対象か否かの確認

//$action_post_title = $post->post_title;
$action_post_title = get_post_field('post_title', $post_id);

// 投稿の著者を取得
$author_id = get_post_field('post_author', $post_id);
$cuerda_ynf_author__in = get_option('cuerda_ynf_author__in','');

// 投稿のカテゴリを取得
$post_categories = get_the_category($post_id);
$category_ids = wp_list_pluck($post_categories, 'term_id');
$categories_echo = implode(',', $category_ids);

// オプションから登録されているカテゴリIDを取得
$cuerda_ynf_category__in_option = get_option('cuerda_ynf_category__in');
$cuerda_ynf_category__not_in_option = get_option('cuerda_ynf_category__not_in');
$cuerda_ynf_category__in_ids = explode(',', $cuerda_ynf_category__in_option);
$cuerda_ynf_category__not_in_ids = explode(',', $cuerda_ynf_category__not_in_option);

// カテゴリとオプションから登録されている条件との共通部分を取得
$in_category_ids = array_intersect($category_ids, $cuerda_ynf_category__in_ids);
$not_in_category_ids = array_intersect($category_ids, $cuerda_ynf_category__not_in_ids);

// displayの判定
$category_in = (count($in_category_ids) > 0) ? 1 : 0;
$category_not_in = (count($not_in_category_ids) > 0) ? 1 : 0;

// 投稿のタグを取得
$post_tags = wp_get_post_tags($post_id);
$tag_ids = wp_list_pluck($post_tags, 'term_id');
$tags_echo = implode(',', $tag_ids);

// オプションから登録されているタグIDを取得
$cuerda_ynf_tag__in_option = get_option('cuerda_ynf_tag__in');
$cuerda_ynf_tag__not_in_option = get_option('cuerda_ynf_tag__not_in');
$cuerda_ynf_tag__in_ids = explode(',', $cuerda_ynf_tag__in_option);
$cuerda_ynf_tag__not_in_ids = explode(',', $cuerda_ynf_tag__not_in_option);

// タグとオプションから登録されている条件との共通部分を取得
$in_ids = array_intersect($tag_ids, $cuerda_ynf_tag__in_ids);
$not_in_ids = array_intersect($tag_ids, $cuerda_ynf_tag__not_in_ids);

// displayの判定
$tag_in = (count($in_ids) > 0) ? 1 : 0;
$tag_not_in = (count($not_in_ids) > 0) ? 1 : 0;

///////////// debug mode start
$on_debug = '↓処理判前設定'.PHP_EOL.' $author_id => '.$author_id.PHP_EOL.' $cuerda_ynf_author__in => '.$cuerda_ynf_author__in.PHP_EOL.' $categories => '.$categories_echo.PHP_EOL.' $cuerda_ynf_category__in => '.$cuerda_ynf_category__in_option.' => '.$category_in.PHP_EOL.' $cuerda_ynf_category__not_in => '.$cuerda_ynf_category__not_in_option.' => '.$category_not_in.PHP_EOL.' $tags => '.$tags_echo.PHP_EOL.' $cuerda_ynf_tag__in => '.$cuerda_ynf_tag__in_option.' => '.$tag_in.PHP_EOL.' $cuerda_ynf_tag__not_in => '.$cuerda_ynf_tag__not_in_option.' => '.$tag_not_in.PHP_EOL.'↑処理判前設定'.PHP_EOL;
if ( ! empty( $wp_filesystem ) ) {
	$existing_content = $wp_filesystem->get_contents( $debug_file_path );
	$new_content = $existing_content . $on_debug;
	$wp_filesystem->put_contents( $debug_file_path, $new_content, FS_CHMOD_FILE );
}
///////////// debug mode end

// 表示したいタグに一致するかチェック
$tag_condition = 1;
if(!empty($cuerda_ynf_tag__in_option)){
	if($tag_in === 0){
		$tag_condition = 0;
	}
}elseif(!empty($cuerda_ynf_tag__not_in_option)){
	if($tag_not_in === 0){
		$tag_condition = 1;
	}else{
		$tag_condition = 0;
	}
}

// 表示したいカテゴリに一致するかチェック
$category_condition = 1;
if(!empty($cuerda_ynf_category__in_option)){
	if($category_in === 0){
		$category_condition = 0;
	}
}elseif(!empty($cuerda_ynf_category__not_in_option)){
	if($category_not_in === 0){
		$category_condition = 1;
	}else{
		$category_condition = 0;
	}
}

// 表示したい著者に一致するかチェック
$author_condition = 1;
if(!empty($cuerda_ynf_author__in)){
	if (in_array($author_id, explode(',', get_option('cuerda_ynf_author__in')))) {
		$author_condition = 1;
	} else {
		$author_condition = 0;
	}
}else{
	// 表示させない著者に一致しないかチェック
	if (!in_array($author_id, explode(',', get_option('cuerda_ynf_author__not_in')))) {
		$author_condition = 1;
	} else {
		$author_condition = 0;
	}
}

// 初期化
$skip_do = false;

// 表示させない投稿に一致しないかチェック
$post_not_in_condition = 1;
if (in_array($post_id, explode(',', get_option('cuerda_ynf_post__not_in')))) {
	$post_not_in_condition = 0;
}

if($category_condition === 0){
	$skip_do = true;
	///////////// debug mode start
	$on_debug = 'END ここで終了。配信対象外のカテゴリです。1'.PHP_EOL;
	if ( ! empty( $wp_filesystem ) ) {
		$existing_content = $wp_filesystem->get_contents( $debug_file_path );
		$new_content = $existing_content . $on_debug;
		$wp_filesystem->put_contents( $debug_file_path, $new_content, FS_CHMOD_FILE );
	}
	///////////// debug mode end
	return;
}

if($tag_condition === 0){
	$skip_do = true;
	///////////// debug mode start
	$on_debug = 'END ここで終了。配信対象外のタグです。1'.PHP_EOL;
	if ( ! empty( $wp_filesystem ) ) {
		$existing_content = $wp_filesystem->get_contents( $debug_file_path );
		$new_content = $existing_content . $on_debug;
		$wp_filesystem->put_contents( $debug_file_path, $new_content, FS_CHMOD_FILE );
	}
	///////////// debug mode end
	return;
}

if($author_condition === 0){
	$skip_do = true;
	///////////// debug mode start
	$on_debug = 'END ここで終了。配信対象外の著者です。1'.PHP_EOL;
	if ( ! empty( $wp_filesystem ) ) {
		$existing_content = $wp_filesystem->get_contents( $debug_file_path );
		$new_content = $existing_content . $on_debug;
		$wp_filesystem->put_contents( $debug_file_path, $new_content, FS_CHMOD_FILE );
	}
	///////////// debug mode end
	return;
}

if($post_not_in_condition === 0){
	$skip_do = true;
	///////////// debug mode start
	$on_debug = 'END ここで終了。配信対象外の投稿です。'.PHP_EOL;
	if ( ! empty( $wp_filesystem ) ) {
		$existing_content = $wp_filesystem->get_contents( $debug_file_path );
		$new_content = $existing_content . $on_debug;
		$wp_filesystem->put_contents( $debug_file_path, $new_content, FS_CHMOD_FILE );
	}
	///////////// debug mode end
	return;
}

if($skip_do === true) return;

///////////// debug mode start
$on_debug = '→ 本投稿は処理対象です。'.PHP_EOL;
if ( ! empty( $wp_filesystem ) ) {
	$existing_content = $wp_filesystem->get_contents( $debug_file_path );
	$new_content = $existing_content . $on_debug;
	$wp_filesystem->put_contents( $debug_file_path, $new_content, FS_CHMOD_FILE );
}
///////////// debug mode end

//新リビジョン選定
if($rev === 'new'){
$rev = 1;
}elseif($rev === 'del'){
$rev = 'del';
}else{
$rev++;
}
$RevisionId = $rev;

// アイキャッチ画像を出力するか
$go_img = 1;
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
	if(empty($thumbnail_url) || empty($image_data) || $mime_type !== 'image/jpeg'){
		$go_img = 0;
		///////////// debug mode start
		$on_debug = '△ 画像の条件を満たしません。'.' $thumbnail_url '.$thumbnail_url.PHP_EOL.' $mime_type '.$mime_type .PHP_EOL;
		if ( ! empty( $wp_filesystem ) ) {
			$existing_content = $wp_filesystem->get_contents( $debug_file_path );
			$new_content = $existing_content . $on_debug;
			$wp_filesystem->put_contents( $debug_file_path, $new_content, FS_CHMOD_FILE );
		}
		///////////// debug mode end
	}
}
///////////// debug mode start
$on_debug = '→ 画像審査は '.$go_img.PHP_EOL.' $thumbnail_url '.$thumbnail_url.PHP_EOL.' $mime_type '.$mime_type .PHP_EOL;
if ( ! empty( $wp_filesystem ) ) {
	$existing_content = $wp_filesystem->get_contents( $debug_file_path );
	$new_content = $existing_content . $on_debug;
	$wp_filesystem->put_contents( $debug_file_path, $new_content, FS_CHMOD_FILE );
}
///////////// debug mode end

// FTPにPUTするファイルの命名規則
$DateId = current_time('Ymd');

///////////// debug mode start
$on_debug = '→ $DateIdは '.$DateId.PHP_EOL;
if ( ! empty( $wp_filesystem ) ) {
	$existing_content = $wp_filesystem->get_contents( $debug_file_path );
	$new_content = $existing_content . $on_debug;
	$wp_filesystem->put_contents( $debug_file_path, $new_content, FS_CHMOD_FILE );
}
///////////// debug mode end

if(empty($DateId)){
	$DateId = current_time('Ymd');
}
function cuerda_pad_number($number, $length) {
	return str_pad($number, $length, '0', STR_PAD_LEFT);
}
$NewsItemId = cuerda_pad_number($post_id, 8);
$cuerda_ynf_id_option = get_option('cuerda_ynf_id','');
if($cuerda_ynf_id_option == ''){
	///////////// debug mode start
	$on_debug = 'END ここで終了。Yahoo!ニュース媒体コードが設定されていません。'.PHP_EOL;
	if ( ! empty( $wp_filesystem ) ) {
		$existing_content = $wp_filesystem->get_contents( $debug_file_path );
		$new_content = $existing_content . $on_debug;
		$wp_filesystem->put_contents( $debug_file_path, $new_content, FS_CHMOD_FILE );
	}
	///////////// debug mode end
	return;
}else{
	$cuerda_ynf_id = $cuerda_ynf_id_option;
}
$remote_file_name = $DateId.'-'.$NewsItemId.'-'.$cuerda_ynf_id.'-'.$RevisionId.'.xml';
$remote_img_name = $DateId.'-'.$NewsItemId.'-'.$cuerda_ynf_id.'-'.$RevisionId.'-00-view.jpg';
if($RevisionId == 'del'){
	$go_img = 0;
}

// cuerda_mod_ynf.php スクリプトの実行結果を取得
ob_start();
cuerda_mod_ynf($post,$post_id,$NewsItemId,$DateId,$RevisionId,$enc_icatch,$go_img,$remote_img_name);
$cuerda_mod_ynf_result = ob_get_clean();

// ファイルに結果を書き込む
$filename = 'data_' . $post_id . '_'.$RevisionId.'.xml';
$file_path = plugin_dir_path(__FILE__) . $filename;
$img_path = $thumbnail_url;
$ldap_user = get_option('cuerda_ynf_ldap_user','');
$ldap_pass = get_option('cuerda_ynf_ldap_pass','');
if(!empty($ldap_user) && !empty($ldap_pass)){
	$thumbnail_url = preg_replace('/(https?:\/\/)(.*?)/im', '$1'.$ldap_user.':'.$ldap_pass.'@$2', $thumbnail_url);
}
$img_path = $thumbnail_url;

// ファイルへの書き込み
if ( ! empty( $wp_filesystem ) ) {
	$wp_filesystem->put_contents( $file_path, $cuerda_mod_ynf_result, FS_CHMOD_FILE );
}

if($cuerda_mod_ynf_result){
///////////// debug mode start
$on_debug = '→ 配信XMLは生成されました。'.PHP_EOL;
if ( ! empty( $wp_filesystem ) ) {
	$existing_content = $wp_filesystem->get_contents( $debug_file_path );
	$new_content = $existing_content . $on_debug;
	$wp_filesystem->put_contents( $debug_file_path, $new_content, FS_CHMOD_FILE );
}
///////////// debug mode end
}else{
///////////// debug mode start
$on_debug = 'END 配信XMLの生成に失敗しました。'.PHP_EOL;
if ( ! empty( $wp_filesystem ) ) {
	$existing_content = $wp_filesystem->get_contents( $debug_file_path );
	$new_content = $existing_content . $on_debug;
	$wp_filesystem->put_contents( $debug_file_path, $new_content, FS_CHMOD_FILE );
}
///////////// debug mode end
return;
}

// result のリセット
$ftp_result = "";
$execution_time = "";
$execution_time = current_time("（最終実行：Y年m月d日 H時i分s秒）");
	
//結果ファイル名
$result_file = plugin_dir_path(__FILE__) . 'ftp_result_ynf.php';
// ファイル内容を空にする
if ( ! empty( $wp_filesystem ) ) {
	$wp_filesystem->put_contents( $result_file, '', FS_CHMOD_FILE );
}
// FTPサーバーのコントロール

// 接続情報を取得
$ftp_server = get_option('cuerda_ynf_ftp_server', '');
$ftp_user_name = get_option('cuerda_ynf_ftp_user_name', '');
$ftp_user_pass = get_option('cuerda_ynf_ftp_password', '');
$ftp_remote_dir = get_option('cuerda_ynf_ftp_remote_dir', '');

// デバッグモードのログ記録関数
function cuerda_log_debug($message, $debug_file_path) {
	global $wp_filesystem;
	// WP_Filesystemの初期化
	if ( ! function_exists( 'WP_Filesystem' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
	}
	WP_Filesystem(); // 初期化
	// ファイルへの追記処理
	if ( ! empty( $wp_filesystem ) ) {
		// 既存のデバッグファイルの内容を取得して追記
		$existing_content = $wp_filesystem->get_contents( $debug_file_path );
		$new_content = $existing_content . $message . PHP_EOL;
		$wp_filesystem->put_contents( $debug_file_path, $new_content, FS_CHMOD_FILE );
	}
}

try {
	// FTP接続を確立
	$ftp_connection = @ftp_ssl_connect($ftp_server);
	if (!$ftp_connection) {
		throw new Exception("FTPサーバーにアクセスできません。");
	}

	// FTPログイン
	$ftp_login = @ftp_login($ftp_connection, $ftp_user_name, $ftp_user_pass);
	if (!$ftp_login) {
		throw new Exception("FTPサーバーへのログインに失敗しました。ユーザー名、パスワードが正しいかご確認ください。");
	}

	// パッシブモードを有効にする
	ftp_pasv($ftp_connection, true);

	// ファイルアップロード処理
	if ($go_img == 1) {
		if (!ftp_put($ftp_connection, $ftp_remote_dir . '/' . $remote_img_name, $img_path, FTP_BINARY)) {
			throw new Exception("画像のアップロードに失敗しました。");
		}
		cuerda_log_debug('→ 写真アップロード完了', $debug_file_path);
		sleep(1);
	}

	if (!ftp_put($ftp_connection, $ftp_remote_dir . '/' . $remote_file_name, $file_path, FTP_BINARY)) {
		throw new Exception("XMLのアップロードに失敗しました。");
	}

	cuerda_log_debug('→ XMLアップロード完了', $debug_file_path);

	// 新リビジョンを保存
	$rev = ($rev === 'del') ? '' : $rev;
	update_post_meta($post_id, '_cuerda_old_rev', $rev);
	cuerda_log_debug('→ 新リビジョン「' . $rev . '」を保存しました。', $debug_file_path);

	// 処理済み投稿の更新日時を保存
	update_post_meta($post_id, '_cuerda_old_modified', $post_modified);
	cuerda_log_debug('→ 処理済み投稿の更新日時 ' . $post_modified . ' を保存', $debug_file_path);

	// ステータスの日本語変換
	if ($RevisionId == 'del') {
		$new_status_jp = '公開済み記事の削除';
	} elseif ($RevisionId == 1) {
		$new_status_jp = '新規記事';
	} elseif ($new_status == 'publish' && $RevisionId > 1) {
		$new_status_jp = '公開済み記事の更新';
	}

	$ftp_result = '<strong style="color:green">配信完了</strong>' . $execution_time . '<br>タイトル「' . $action_post_title . '」の ' . $new_status_jp . 'として配信しました。';

} catch (Exception $e) {
	$ftp_result = '<strong style="color:red">配信失敗</strong>' . $execution_time . '<br>' . $e->getMessage();
	cuerda_log_debug('→ エラー: ' . $e->getMessage(), $debug_file_path);
} finally {
	// FTP接続を閉じる
	if ($ftp_connection) {
		ftp_close($ftp_connection);
	}

	// ファイルを削除
	wp_delete_file($file_path);
	// ファイルへの書き込み処理
	if ( ! empty( $wp_filesystem ) ) {
		$wp_filesystem->put_contents( $result_file, $ftp_result, FS_CHMOD_FILE );
	}
	// デバッグログ
	cuerda_log_debug('→ 処理結果: ' . $ftp_result, $debug_file_path);

}

return;

function cuerda_valid_license() {
	require 'version.php';

///////////// debug mode start
$on_debug = '→ ライセンス確認プロセス開始'.current_time('Y-m-d H:i:s').PHP_EOL;
if ( ! empty( $wp_filesystem ) ) {
	$existing_content = $wp_filesystem->get_contents( $debug_file_path );
	$new_content = $existing_content . $on_debug;
	$wp_filesystem->put_contents( $debug_file_path, $new_content, FS_CHMOD_FILE );
}
///////////// debug mode end

	// 共通変数の設定
	$sanitized_server_name = isset($_SERVER['SERVER_NAME']) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_NAME'] ) ) : '';
	$sanitized_user_agent  = isset($_SERVER['HTTP_USER_AGENT']) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) ) : '';
	$unslashed_remote_addr = isset($_SERVER['REMOTE_ADDR']) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
	$sanitized_remote_addr = $unslashed_remote_addr ? filter_var( $unslashed_remote_addr, FILTER_VALIDATE_IP ) : '';
	$cuerdaURL = "https://cuerda.org/feed/";
	$userDir   = "user/";
	$http_user_agent = esc_html($sanitized_remote_addr) . " - " . esc_html($sanitized_user_agent);

	// ライセンス確認を行う関数
	function check_license($feed_for, $version, $sanitized_server_name, $cuerdaURL, $userDir, $http_user_agent) {
		$feed_to    = $feed_for . ' ';
		$modelname  = 'feed_cuerda_' . $feed_for . '.php';
		$cuerdaID   = $cuerdaURL . $userDir . esc_html($sanitized_server_name) . "/authentication/" . $modelname;
		$useragent  = $feed_to . $version . " by " . $feed_for . "_License";

		// WordPressのHTTP APIを使ってリクエストを送信
		$args = array(
			'method'    => 'GET',
		'user-agent' => $useragent,
		'headers'   => array(
			'Referer' => $http_user_agent,
		),
		'sslverify' => false,
		);

///////////// debug mode start
$on_debug = '→ WordPressのHTTP APIを使ってリクエストを送信'.current_time('Y-m-d H:i:s').PHP_EOL;
if ( ! empty( $wp_filesystem ) ) {
	$existing_content = $wp_filesystem->get_contents( $debug_file_path );
	$new_content = $existing_content . $on_debug;
	$wp_filesystem->put_contents( $debug_file_path, $new_content, FS_CHMOD_FILE );
}
///////////// debug mode end

		// リクエスト送信
		$response = wp_remote_get($cuerdaID, $args);

		// エラーチェック
		if (is_wp_error($response)) {
			return 0; // エラー時にはライセンス無効とする
		}

		// レスポンスコードの取得
		$code = wp_remote_retrieve_response_code($response);

		// レスポンスコードに応じてライセンスを有効/無効にする
		switch ($code) {
			case 200:
			return 1; // ライセンス有効
			case 403:
			case 404:
				return 0; // ライセンス無効
			case 500:
				return 1; // 一時的なエラーを許容する場合
			default:
				return 0; // 不明なレスポンスコード
		}
	}

	// ynf ライセンス確認
	$valid_ynf = check_license('ynf', $version, $sanitized_server_name, $cuerdaURL, $userDir, $http_user_agent);

	if ($valid_ynf === 0) {
		// debug mode start
		$on_debug = 'END ここで終了。ライセンス認証失敗'.PHP_EOL;
		if ( ! empty( $wp_filesystem ) ) {
			$existing_content = $wp_filesystem->get_contents( $debug_file_path );
			$new_content = $existing_content . $on_debug;
			$wp_filesystem->put_contents( $debug_file_path, $new_content, FS_CHMOD_FILE );
		}
		// debug mode end

		$ftp_result = 'cuerda 認証キーがありません。';
		// ファイルへの書き込み処理
		if ( ! empty( $wp_filesystem ) ) {
			$wp_filesystem->put_contents( $result_file, $ftp_result, FS_CHMOD_FILE );
		}
		return;
	} else {
		// debug mode start
		$on_debug = '→ ライセンス認証完了'.PHP_EOL;
		if ( ! empty( $wp_filesystem ) ) {
			$existing_content = $wp_filesystem->get_contents( $debug_file_path );
			$new_content = $existing_content . $on_debug;
			$wp_filesystem->put_contents( $debug_file_path, $new_content, FS_CHMOD_FILE );
		}
		// debug mode end
	}
}

function cuerda_mod_ynf($post,$post_id,$NewsItemId,$DateId,$RevisionId,$enc_icatch,$go_img,$remote_img_name){
	if($RevisionId == 'del'){
		echo '<!-- 削除 -->'.PHP_EOL;
	}else{
		$feed_for = 'ynf';
		//tab整形
		$tab1 = "\t";
		$tab2 = "\t\t";
		$tab3 = "\t\t\t";
		$tab4 = "\t\t\t\t";
		$tab5 = "\t\t\t\t\t";
		$tab6 = "\t\t\t\t\t\t";
		$tab7 = "\t\t\t\t\t\t\t";
		// 投稿日時をサイトのタイムゾーンに合わせて取得
		$FirstCreated = get_post_time('Y-m-d\TH:i:s', false, $post_id, true);
		//外部スクリプト
		$city_data = 'pref_city.php';
		//媒体コード
		$cuerda_ynf_id_option = get_option('cuerda_ynf_id','');
		if($cuerda_ynf_id_option == ''){$cuerda_ynf_id = '';}else{$cuerda_ynf_id = $cuerda_ynf_id_option;}
		//記事種別
		$cuerda_ynf_articletype_option = get_option('cuerda_ynf_articletype','');
		if($cuerda_ynf_articletype_option == ''){$cuerda_ynf_articletype = '';}else{$cuerda_ynf_articletype = $cuerda_ynf_articletype_option;}
		//DateId
		$action_post_modified = current_time('Y-m-d\TH:i:s');
		// 配信元の名称
		$channel_title = get_option('cuerda_ynf_title','');
		// 著作者表示用のカスタムフィールド名 OR 画像の出典元情報のカスタムフィールド名
		if(!empty($channel_title)){
		$credit = $channel_title;
		}else{
		$credit = esc_html(get_bloginfo('name'));
		}
		$cf_creator_option = get_option('cuerda_ynf_cf_creator','');
		if($cf_creator_option == ''){$cf_creator = '';}else{$cf_creator = $cf_creator_option;}
		// 標準地域コードを出力するか
		$area_city_option = get_option('cuerda_ynf_area_city',0);
		if($area_city_option == ''){$area_city = 0;}else{$area_city = $area_city_option;}
		// table タグを除去する（値1で除去する）
		$table_option = get_option('cuerda_ynf_table',0);
		if($table_option == ''){$table = 0;}else{$table = $table_option;}
		// 連想配列に格納された特定の文字列を削除
		$sentence_delete_option = get_option('cuerda_ynf_sentence_delete','');
		if($sentence_delete_option === ''){$sentence_delete= '';}else{$sentence_delete = explode(",", $sentence_delete_option);}
		// enclosure の alt に代入するキー
		$enclosure_alt_option = get_option('cuerda_ynf_enclosure_alt',0);
		if($enclosure_alt_option == ''){$enclosure_alt = 0;}else{$enclosure_alt = $enclosure_alt_option;}
		// 関連リンク最大本数
		$rel_count_default = '5';
		$rel_count_option = get_option('cuerda_ynf_rel_count',$rel_count_default);
		if($rel_count_option == ''){$rel_count = $rel_count_default;}elseif($rel_count_option > $rel_count_default){$rel_count = $rel_count_default;}else{$rel_count = $rel_count_option;}
		// 同一タグから関連リンクを出力する
		$rel_tag_option = get_option('cuerda_ynf_rel_tag',0);
		if($rel_tag_option == ''){$rel_tag = 0;}else{$rel_tag = $rel_tag_option;}
		$post = get_post($post_id);
		$action_post_title = $post->post_title;
		$content = $post->post_content;
		$allowed_html = array(
		'table' => array(),
		'p' => array(),
		'iframe' => array(),
		'script' => array(),
		'style' => array()
		);
		$deny_html = '(<\s*iframe(\s+|>)[\s\S]*?<\s*\/iframe\s*>|<\s*script(\s+|>)[\s\S]*?<\s*\/script\s*>|<\s*style(\s+|>)[\s\S]*?<\s*\/style\s*>)';
		$content = wp_kses(do_shortcode($content), $allowed_html);
		$content = str_replace(array("[\x00-\x09\x0B\x0C\x0E-\x1F\x7F]"), '', $content);
		$content = preg_replace('/<\s*table\s*.*?>([\s\S]*?)<\s*\/table\s*>/imsu', '', $content);
		$content = preg_replace("/$deny_html/im", "", $content);
		$content = str_replace(array("\t"), "",$content);
		$content = str_replace(array("\r\n", "\r"), "\n",$content);
		$content = preg_replace("/>( |　)+<\//ims","></", $content);
		$content = preg_replace("/ {2,}/"," ", $content);
		if(!empty($sentence_delete)){
		$object = $sentence_delete;
		$escaped_object = array_map('preg_quote', $object); // 各要素をエスケープ
		$pattern = '/' . implode('|', $escaped_object) . '/im';
		$content = preg_replace($pattern, '', $content);
		}else{
		}
		$content = preg_replace('/&lt;!--[\s\S]*?--&gt;/imsu', '<!-- Comment Out -->', $content);
		$content = preg_replace('/<!--\s*[\s\S]*?--\s*>/imsu', '', $content);
		htmlspecialchars($content, ENT_QUOTES|ENT_HTML5, "UTF-8");
		$pattern = '/\n{3,}/';
		$content = preg_replace($pattern, "\n", $content);
		$content = preg_replace('/<\s*\/p\s*>\n<\s*p\s*>/imsu', "\n\n", $content);
		$content = preg_replace('/<\s*\/?p\s*>/imsu', "", $content);


		echo '<YJNewsFeed Version="1.0">'.PHP_EOL;
		echo $tab1.'<Identification>'.PHP_EOL;
		echo $tab2.'<MediaId>'.$cuerda_ynf_id.'</MediaId>'.PHP_EOL;//（媒体コードを指定 →No.1-1）
		echo $tab2.'<DateId>'.$DateId.'</DateId>'.PHP_EOL;//（記事の配信日に基づく日付を指定 →No.1-2）
		echo $tab2.'<NewsItemId>'.$NewsItemId.'</NewsItemId>'.PHP_EOL;//（記事シーケンス番号を指定 →No.1-3）
		echo $tab2.'<RevisionId>'.$RevisionId.'</RevisionId>'.PHP_EOL;//（記事バージョンを指定→No.1-4）
		echo $tab1.'</Identification>'.PHP_EOL;

		echo $tab1.'<Management>'.PHP_EOL;
		echo $tab2.'<FirstCreated>'.$FirstCreated.'</FirstCreated>'.PHP_EOL;//（初版作成日時を指定→No.2-1）
		echo $tab2.'<ThisRevisionCreated>'.$action_post_modified.'</ThisRevisionCreated>'.PHP_EOL;//（更新日時を指定→No.2-2）
		echo $tab1.'</Management>'.PHP_EOL;

		echo $tab1.'<MetaData>'.PHP_EOL;
		echo $tab2.'<ArticleType>'.$cuerda_ynf_articletype.'</ArticleType>'.PHP_EOL;//（種別を指定→No.3-1）
		echo $tab2.'<MediaFormat>text</MediaFormat>'.PHP_EOL;//（フォーマットを指定→No.3-2）
		echo $tab2.'<Author><![CDATA[';//（著作者を指定→No.3-3）
			if(!empty($cf_creator)){
				$cf = get_post_meta(get_the_ID(),$cf_creator,true);
				echo esc_html($cf);
			}elseif(!empty($channel_title)){
				echo esc_html($channel_title);
			}else{
				$author_id = get_post_field('post_author', $post_id);
				setup_postdata(get_post($post_id));
				the_author();
			}
		echo ']]></Author>'.PHP_EOL;
		echo $tab2.'<Priority>1</Priority>'.PHP_EOL;//（重み付け（優先度）を指定→No.3-4）

		echo $tab2.'<SubjectCode>'.PHP_EOL;
		$categories = get_the_category($post_id);
		if(!empty($categories)){
			$category_id = $categories[0]->term_id;
			$option_name = 'cuerda_ynf_category_' . $category_id;
			$category_option = get_option($option_name);
			if($category_option && strpos($category_option, ',') !== false){
				$values = explode(',', $category_option);
				$first_half = $values[0];
				echo $tab3 . '<Code>';
				echo $first_half;
				echo '</Code>' . PHP_EOL;
			}
		}
		echo $tab2.'</SubjectCode>'.PHP_EOL;

		if($area_city == 1){
			$postcontent = $content;
			// $feed_for 変数を配列で渡す
			$args = array(
				'feed_for' => $feed_for,
			);
			ob_start();
			include $city_data;
			$file_contents = ob_get_clean();
			// ファイルが空でないかチェック
			if (trim($file_contents) !== '') {
				echo $tab2.'<RelatedArea>'.PHP_EOL;
				echo $file_contents;
				echo $tab2.'</RelatedArea>'.PHP_EOL;
			}else{
			// ファイルが空の場合の処理
			echo $tab2.'<!-- RelatedArea does not exist -->'.PHP_EOL;
			}
		}else{
		}

		echo $tab2.'<Property>'.PHP_EOL;
		echo $tab3.'<Item>'.PHP_EOL;
		echo $tab4.'<PropertyName>amanda</PropertyName>'.PHP_EOL;//（対象プロパティを指定→No.3-7-1-1）
		echo $tab4.'<Key>old_cid</Key>'.PHP_EOL;//（拡張項目を指定→No.3-7-1-2）
		if(!empty($cat_id)){
			$SubjectCode = explode(',', $cat_id);
			if (isset($SubjectCode[1])) {
				echo $tab4 . '<Value>';
				echo $SubjectCode[1];
				echo '</Value>' . PHP_EOL;
			}
		}else{
		}
		echo $tab3.'</Item>'.PHP_EOL;
		echo $tab2.'</Property>'.PHP_EOL;
		echo $tab1.'</MetaData>'.PHP_EOL;

		echo $tab1.'<NewsLines>'.PHP_EOL;
		echo $tab2.'<Headline><![CDATA[';
		echo esc_html($action_post_title);
		echo ']]></Headline>'.PHP_EOL;

		$excerpt = get_post_field('post_excerpt', $post_id);
		if(!empty($excerpt)){
			$text_count = '30000';
			echo $tab2.'<Summary><![CDATA[';
			$remove_array = ["\r\n","\r","\n"," ","&nbsp;","　"];
			$excerpt = strip_shortcodes($excerpt);
			$excerpt = preg_replace('/&lt;!--[\s\S]*?--&gt;/imsu', '', $excerpt);
			$description = wp_trim_words($excerpt,$text_count,'…' );
			$description = str_replace($remove_array,'', $description);
			echo esc_html($description);
			echo ']]></Summary>'.PHP_EOL;
		}else{
		}
		echo $tab1.'</NewsLines>'.PHP_EOL;

		echo $tab1.'<Article>'.PHP_EOL;
		echo $tab2.'<Paragraph>'.PHP_EOL;
		echo $tab3.'<Body><![CDATA[';
			echo $content;
		echo ']]></Body>'.PHP_EOL;//（本文を指定→No.5-1-1）

		if($enc_icatch == 1 && $go_img == 1){
			$key = '_thumbnail_id';
			$post_thumbnail_id = get_post_meta($post_id, $key, true);
			$post_thumbnail = get_post($post_thumbnail_id);
			$thumb_title = $post_thumbnail->post_title;
			$thumb_caption = $post_thumbnail->post_excerpt;
			// START $enclosure_alt
			$alt_caption = ($enclosure_alt == 1) ? $thumb_title : $thumb_caption;
			// END $enclosure_alt
			if (empty($alt_caption)) {
				$alt_caption ='（写真：'.esc_html($credit).'）';
			}
			echo $tab3.'<!-- icatch -->'.PHP_EOL;
			echo $tab3.'<Enclosure>'.PHP_EOL;
			echo $tab4.'<Item Seq="1">'.PHP_EOL;
			echo $tab5.'<Caption><![CDATA[';
			echo esc_attr($alt_caption);
			echo ']]></Caption>'.PHP_EOL;
			echo $tab5.'<Credit><![CDATA[';
			echo esc_html($credit);
			echo ']]></Credit>'.PHP_EOL;
			echo $tab5.'<Image>'.PHP_EOL;
			echo $tab6.'<Path>';
			echo $remote_img_name;
			echo '</Path>'.PHP_EOL;
			echo $tab5.'</Image>'.PHP_EOL;
			echo $tab4.'</Item>'.PHP_EOL;
			echo $tab3.'</Enclosure>'.PHP_EOL;
		}
		echo $tab2.'</Paragraph>'.PHP_EOL;
		echo $tab1.'</Article>'.PHP_EOL;

		function related_posts($post, $post_id, $rel_count, $rel_urlpass, $rel_tag = 1, $tab1 = "\t") {

			if ($rel_tag === '1' && has_tag()) {
				$relargs['tag__in'] = wp_list_pluck(get_the_tags(), 'term_id');
			} elseif ($rel_tag === '1') {
				// タグが存在しない場合のエラー処理
				return;
			} else {
				$relargs['category__in'] = wp_list_pluck(get_the_category(), 'term_id');
			}

			$tab2 = $tab1 . "\t";
			$tab3 = $tab1 . "\t\t";
			// 配信する記事の種類
			$post_type_option = get_option('cuerda_ynf_post_type','post');
			if($post_type_option == ''){$post_type = array('post');}else{$post_type = explode(",", $post_type_option);}

			$publish = 'publish';
			$relargs = array(
				'post_type' => $post_type,
				'post_status' => $publish,
				'posts_per_page' => $rel_count,
				'ignore_sticky_posts' => true,
				'post__not_in' => array($post_id),
			);

			$the_query = new WP_Query($relargs);

			if ($the_query->post_count > 0) {
				echo $tab1 . '<RelatedLink>' . PHP_EOL;
				$link_count = 1;
				while ($the_query->have_posts()) :
					$the_query->the_post();
					$title = wp_strip_all_tags(get_the_title());

					if (!empty($rel_urlpass)) {
						$rel_url = $rel_urlpass . get_the_ID();
					} else {
						$rel_url = esc_url(get_the_permalink());
					}

					echo $tab2 . '<Link Id="' . $link_count . '" Type="pc">' . PHP_EOL;
					echo $tab3 . '<Title><![CDATA[' . $title . ']]></Title>' . PHP_EOL;
					echo $tab3 . '<Url><![CDATA[' . $rel_url . ']]></Url>' . PHP_EOL;
					echo $tab2 . '</Link>' . PHP_EOL;
					$link_count++;
				endwhile;
				echo $tab1 . '</RelatedLink>' . PHP_EOL;
			}

			wp_reset_postdata(); // ループ後に元の投稿データをリセット
		}

		related_posts($post_id, $rel_count, 1, '', '');

		echo '</YJNewsFeed>'.PHP_EOL;
	}
	wp_reset_postdata();
}

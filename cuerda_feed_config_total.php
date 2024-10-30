<?php
// cerda（クエルダ）は本プログラムソースコードの著作権を保有しています。
// Copyright (C) 2020 CUERDA(https://cuerda.org).
if(!defined('ABSPATH')){
die('Forbidden');
}
// デフォルト変数の読み込み
$sanitized_server_name = isset($_SERVER['SERVER_NAME']) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_NAME'] ) ) : '';
$sanitized_user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) ) : '';
$unslashed_remote_addr = isset($_SERVER['REMOTE_ADDR']) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
$sanitized_remote_addr = filter_var( $unslashed_remote_addr, FILTER_VALIDATE_IP );
$config_version = $version;
$header_name = 'cuerda 配信フィード設定';
$cuerdaURL	  = "https://cuerda.org/feed/";
$userDir		= "user/";
$modelname	  = "Cuerda-feed-total";

// DLディレクトリの取得
$path_dl		= $cuerdaURL."/version/".$modelname."/download_dir.php";
$useragent_dl   = "User-Agent: cuerda-feed-dl";

$response_dl = wp_remote_get( $path_dl, array(
	'timeout' => 15,
	'headers' => array( 'User-Agent' => $useragent_dl )
));

if ( is_wp_error( $response_dl ) ) {
	// エラーハンドリング
	$info_dl = 'Error: ' . $response_dl->get_error_message();
} else {
	$info_dl = wp_remote_retrieve_body( $response_dl );
}

$path_version   = $cuerdaURL."/version/".$modelname."/cuerda-feed-total.php";
$path_md5_hash  = $cuerdaURL."/version/".$modelname."/md5_hash.php";
$useragent_ver  = "User-Agent: cuerda-feed-version";

// バージョン情報の取得
$response_version = wp_remote_get( $path_version, array(
	'timeout' => 15,
	'headers' => array( 'User-Agent' => $useragent_ver )
));

if ( is_wp_error( $response_version ) ) {
	$info_version = 'Error: ' . $response_version->get_error_message();
} else {
	$info_version = wp_remote_retrieve_body( $response_version );
}

// MD5ハッシュの取得
$response_md5 = wp_remote_get( $path_md5_hash, array(
	'timeout' => 15,
	'headers' => array( 'User-Agent' => $useragent_ver )
));

if ( is_wp_error( $response_md5 ) ) {
	$md5_hash = 'Error: ' . $response_md5->get_error_message();
} else {
	$md5_hash = wp_remote_retrieve_body( $response_md5 );
}

// サーバーレスポンスコードの取得
$code_version = wp_remote_retrieve_response_code( $response_version );

$path_info	  = $cuerdaURL.$userDir.esc_html( $sanitized_server_name )."/info/info_feed_cuerda_total.php";
$useragent_info = "User-Agent: cuerda-feed-information";

// 情報取得
$response_info = wp_remote_get( $path_info, array(
	'timeout' => 15,
	'headers' => array( 'User-Agent' => $useragent_info )
));

if ( is_wp_error( $response_info ) ) {
	$info = 'Error: ' . $response_info->get_error_message();
} else {
	$info = wp_remote_retrieve_body( $response_info );
}

// サーバーレスポンスコードの取得
$code_info = wp_remote_retrieve_response_code( $response_info );

//*************************************************************
// 共通部品
//*************************************************************
function CFTL_enqueue_styles() {
wp_enqueue_style( 'cftl-admin-style', plugin_dir_url( __FILE__ ) . 'css/cuerda-admin.css' );
}
add_action( 'admin_enqueue_scripts', 'CFTL_enqueue_styles' );
function cuerda_share_Unauthorized(){
echo "<p>このプラグインの設定は管理者権限のあるユーザーが行えます。</p>";
echo "<p>権限のあるユーザーで WordPress に再ログインするか、管理者にお尋ねください。</p>";
}
function CFTL_cuerda_share_enqueue_scripts() {
wp_enqueue_script( 'cftl-admin-script', plugin_dir_url( __FILE__ ) . 'js/cuerda-admin.js', array(), null, true );
}
add_action( 'admin_enqueue_scripts', 'CFTL_enqueue_scripts' );
function cuerda_btn_script() {
	// FontAwesome をローカルから読み込む
	wp_enqueue_style('font-awesome', plugins_url('css/font-awesome.min.css', __FILE__));

	// インラインスタイルを追加
	wp_register_style('cuerda-custom-style', false);
	$inline_style = "
		#cuerda_ynf_ftp_password {
			border: none;
		}
		#fieldPassword {
			border: 1px solid #8c8f94;
			width: 80%;
			border-radius: 4px;
		}
		.fa {
			color: #666;
			font-size: 1.2em;
		}
	.notice div * { display: inline-block; }
	table.cuerda { font-family: monospace; background: #fff; border: 1px solid #ccc; border-bottom: none; margin-top: 0; }
	table.cuerda thead th { text-align: center; }
	table.cuerda tbody th { padding-left: 1em; }
	table.cuerda td, table.cuerda th { border-bottom: 1px solid #eee; }
	table.cuerda td { vertical-align: top; line-height: 1.8em; }
	table.cuerda input {}
	.form-table td p.id_list { border: 1px solid #ccc; border-radius: 5px; padding: 0.5em 1em; background: #eee; font-size: 0.8em; }
	.fullwidth { display: inline-block; width: 100%; }
	.width50 { display: inline-block; width: 50%; }
	.width80 { display: inline-block; width: 80%; }
	table.cuerda td textarea { min-height: 8em; }
	#cuerda_h2_a { margin: 0 0 0 1em; padding: 0.3em 1em; position: absolute; top: 10px; right: 10px; background: #288537; }
	.tab-area { width: 100%; margin: 0 auto; }
	input.tab-btns { display: none; }
	.tab-list-wrap { padding: 0; margin: 0; height: auto; list-style-type: none; display: flex; justify-content: flex-start; }
	.tab-list { display: block; width: auto; height: 100%; padding: 1em 1em; margin: 0 2px 0 0; text-align: center; border-top: 1px solid #4e7bcc; border-left: 1px solid #4e7bcc; border-right: 1px solid #4e7bcc; border-radius: 6px 6px 0 0; background: #d1dcff; box-sizing: border-box; cursor: pointer; }
	#tab-btn_main:checked ~ .tab-list-wrap #tab-list_main,
	#tab-btn_ynf:checked ~ .tab-list-wrap #tab-list_ynf,
	#tab-btn_yjt:checked ~ .tab-list-wrap #tab-list_yjt,
	#tab-btn_goo:checked ~ .tab-list-wrap #tab-list_goo,
	#tab-btn_dcm:checked ~ .tab-list-wrap #tab-list_dcm,
	#tab-btn_spb:checked ~ .tab-list-wrap #tab-list_spb,
	#tab-btn_snf:checked ~ .tab-list-wrap #tab-list_snf,
	#tab-btn_gnf:checked ~ .tab-list-wrap #tab-list_gnf,
	#tab-btn_lnr:checked ~ .tab-list-wrap #tab-list_lnr,
	#tab-btn_ldn:checked ~ .tab-list-wrap #tab-list_ldn,
	#tab-btn_isn:checked ~ .tab-list-wrap #tab-list_isn,
	#tab-btn_ant:checked ~ .tab-list-wrap #tab-list_ant,
	#tab-btn_trl:checked ~ .tab-list-wrap #tab-list_trl { background: #fff; font-weight: bold; }
	.tab-content { padding: 0; border-bottom: 1px solid #4e7bcc; border-left: 1px solid #4e7bcc; border-right: 1px solid #4e7bcc; display: none; }
	#tab-btn_main:checked ~ .tab-content-wrap #tab-content_main,
	#tab-btn_ynf:checked ~ .tab-content-wrap #tab-content_ynf,
	#tab-btn_yjt:checked ~ .tab-content-wrap #tab-content_yjt,
	#tab-btn_goo:checked ~ .tab-content-wrap #tab-content_goo,
	#tab-btn_dcm:checked ~ .tab-content-wrap #tab-content_dcm,
	#tab-btn_spb:checked ~ .tab-content-wrap #tab-content_spb,
	#tab-btn_snf:checked ~ .tab-content-wrap #tab-content_snf,
	#tab-btn_gnf:checked ~ .tab-content-wrap #tab-content_gnf,
	#tab-btn_lnr:checked ~ .tab-content-wrap #tab-content_lnr,
	#tab-btn_ldn:checked ~ .tab-content-wrap #tab-content_ldn,
	#tab-btn_isn:checked ~ .tab-content-wrap #tab-content_isn,
	#tab-btn_ant:checked ~ .tab-content-wrap #tab-content_ant,
	#tab-btn_trl:checked ~ .tab-content-wrap #tab-content_trl { display: block; }
	ul.tab-list-wrap li { margin-bottom: 0; }
	.ac-box { width: 100%; margin: 10px auto; }
	.ac-box label { max-width: 380px; font-weight: bold; text-align: center; background: #666; margin: auto; line-height: 40px; position: relative; display: block; height: 40px; border-radius: 8px; cursor: pointer; color: #fff; transition: all 0.5s; }
	.ac-box label:hover { background: #333; transition: all .3s; }
	.ac-box input { display: none; }
	.ac-box label:after { color: #fff; content: '開く'; }
	.ac-box input:checked ~ label::after { color: #fff; content: '閉じる'; }
	.ac-box div { height: 0px; padding: 0px; overflow: hidden; opacity: 0; transition: 0.5s; }
	.ac-box input:checked ~ div { height: auto; opacity: 1; }
	";
	wp_add_inline_style('cuerda-custom-style', $inline_style);
	wp_enqueue_style('cuerda-custom-style');

	// インラインスクリプトを追加
	wp_register_script('cuerda-custom-script', false);
	$inline_script = "
		function pushHideButton() {
			var txtPass = document.getElementById('cuerda_ynf_ftp_password');
			var btnEye = document.getElementById('buttonEye');
			if (txtPass.type === 'text') {
				txtPass.type = 'password';
				btnEye.className = 'fa fa-eye';
			} else {
				txtPass.type = 'text';
				btnEye.className = 'fa fa-eye-slash';
			}
		}
	";
	wp_add_inline_script('cuerda-custom-script', $inline_script);
	wp_enqueue_script('cuerda-custom-script');
}

function cuerda_share_tab() {
	require 'version.php';

	// 共通変数の設定
	$sanitized_server_name = isset($_SERVER['SERVER_NAME']) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_NAME'] ) ) : '';
	$sanitized_user_agent  = isset($_SERVER['HTTP_USER_AGENT']) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) ) : '';
	$unslashed_remote_addr = isset($_SERVER['REMOTE_ADDR']) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
	$sanitized_remote_addr = $unslashed_remote_addr ? filter_var( $unslashed_remote_addr, FILTER_VALIDATE_IP ) : '';

	$cuerdaURL = "https://cuerda.org/feed/";
	$userDir   = "user/";
	$http_user_agent = esc_html($sanitized_remote_addr) . " - " . esc_html($sanitized_user_agent);

	// ライセンス確認を行う共通関数
	function check_license($feed_for, $version, $sanitized_server_name, $cuerdaURL, $userDir, $http_user_agent) {
		$feed_to	= $feed_for . ' ';
		$modelname  = 'feed_cuerda_' . $feed_for . '.php';
		$cuerdaID   = $cuerdaURL . $userDir . esc_html($sanitized_server_name) . "/authentication/" . $modelname;
		$useragent  = $feed_to . $version . " by " . $feed_for . "有効設定画面";

		// WordPressのHTTP APIを使ってリクエストを送信
		$args = array(
			'method'	=> 'GET',
			'user-agent' => $useragent,
			'headers'   => array(
				'Referer' => $http_user_agent,
			),
			'sslverify' => false,
		);

		// リクエスト送信
		$response = wp_remote_get($cuerdaID, $args);

		// レスポンスコードの取得
		if (is_wp_error($response)) {
			return 0; // エラー時にはライセンス無効とする
		}

		$code = wp_remote_retrieve_response_code($response);

		// レスポンスコードに応じてライセンスを有効/無効にする
		switch ($code) {
			case 200:
				return 1; // ライセンス有効
			case 403:
			case 404:
			case 500:
				return 0; // ライセンス無効
			default:
				return 0; // 不明なレスポンスコード
		}
	}

	// ライセンス確認
	$valid_yjt = check_license('yjt', $version, $sanitized_server_name, $cuerdaURL, $userDir, $http_user_agent);
	$valid_ynf = check_license('ynf', $version, $sanitized_server_name, $cuerdaURL, $userDir, $http_user_agent);
	$valid_spb = check_license('spb', $version, $sanitized_server_name, $cuerdaURL, $userDir, $http_user_agent);

	// インラインスタイルの追加
	wp_register_style('cuerda-tab-style', false);
	$inline_style = '';

	if ($valid_yjt !== 1) {
		$inline_style .= '.valid_yjt{display:none;}';
	}

	if ($valid_ynf !== 1) {
		$inline_style .= '.valid_ynf{display:none;}';
	}

	if ($valid_spb !== 1) {
		$inline_style .= '.valid_spb{display:none;}';
	}

	if (!empty($inline_style)) {
		wp_add_inline_style('cuerda-tab-style', $inline_style);
		wp_enqueue_style('cuerda-tab-style');
	}

	echo '<div class="tab-area">';
	echo '<input id="tab-btn_main" class="tab-btns" name="tab" type="radio" checked>';
	echo '<input id="tab-btn_ynf" class="tab-btns valid_ynf" name="tab" type="radio">';
	echo '<input id="tab-btn_yjt" class="tab-btns valid_yjt" name="tab" type="radio">';
	echo '<input id="tab-btn_goo" class="tab-btns" name="tab" type="radio">';
	echo '<input id="tab-btn_dcm" class="tab-btns" name="tab" type="radio">';
	echo '<input id="tab-btn_spb" class="tab-btns valid_spb" name="tab" type="radio">';
	echo '<input id="tab-btn_snf" class="tab-btns" name="tab" type="radio">';
	echo '<input id="tab-btn_gnf" class="tab-btns" name="tab" type="radio">';
	echo '<input id="tab-btn_lnr" class="tab-btns" name="tab" type="radio">';
	echo '<input id="tab-btn_ldn" class="tab-btns" name="tab" type="radio">';
	echo '<input id="tab-btn_isn" class="tab-btns" name="tab" type="radio">';
	echo '<input id="tab-btn_ant" class="tab-btns" name="tab" type="radio">';
	echo '<input id="tab-btn_trl" class="tab-btns" name="tab" type="radio">';
	echo '<ul class="tab-list-wrap">';
	echo '<li id="tab_base"><label id="tab-list_main" class="tab-list" for="tab-btn_main">基本設定</label></li>';
	echo '<li id="tab_ynf"><label id="tab-list_ynf" class="tab-list valid_ynf" for="tab-btn_ynf">Yahoo!ニュース</label></li>';
	echo '<li id="tab_yjt"><label id="tab-list_yjt" class="tab-list valid_yjt" for="tab-btn_yjt">Yahoo!JAPANタイムライン</label></li>';
	echo '<li id="tab_goo"><label id="tab-list_goo" class="tab-list" for="tab-btn_goo">dmenuニュース・gooニュース</label></li>';
	echo '<li id="tab_dcm"><label id="tab-list_dcm" class="tab-list" for="tab-btn_dcm">ドコモメディア</label></li>';
	echo '<li id="tab_spb"><label id="tab-list_spb" class="tab-list valid_spb" for="tab-btn_spb">SPORTS BULL</label></li>';
	echo '<li id="tab_snf"><label id="tab-list_snf" class="tab-list" for="tab-btn_snf">スマートニュース</label></li>';
	echo '<li id="tab_gnf"><label id="tab-list_gnf" class="tab-list" for="tab-btn_gnf">グノシー・ニュースパス</label></li>';
	echo '<li id="tab_lnr"><label id="tab-list_lnr" class="tab-list" for="tab-btn_lnr">LINE NEWS</label></li>';
	echo '<li id="tab_ldn"><label id="tab-list_ldn" class="tab-list" for="tab-btn_ldn">ライブドアニュース</label></li>';
	echo '<li id="tab_isn"><label id="tab-list_isn" class="tab-list" for="tab-btn_isn">Infoseekニュース</label></li>';
	echo '<li id="tab_ant"><label id="tab-list_ant" class="tab-list" for="tab-btn_ant">antenna*</label></li>';
	echo '<li id="tab_trl"><label id="tab-list_trl" class="tab-list" for="tab-btn_trl">TRILL</label></li>';
	echo '</ul>';
	echo '<div class="tab-content-wrap">';
	echo '<div id="tab-content_main" class="tab-content">';
	echo '<table class="form-table cuerda config_total">';
}

function cuerda_share_thead(){
echo '
		<thead>
			<tr>
				<th style="width:20%">設定項目</th>
				<th style="width:25%">設定値</th>
				<th style="width:55%">この項目の説明</th>
			</tr>
		</thead>
		<tbody>
';
}
function cuerda_share_table_end(){
echo '
		</tbody>
	</table>
';
}
function cuerda_show_rss($code){
if($code!=='xxx'){
	echo '<a id="cuerda_h2_a" class="button-primary" target="_blank" href="';
	echo esc_url(home_url('/')).'?feed=cuerda_total&'.$code;
	echo '">';
	if($code==='ynf'){
	echo 'Yahoo!ニュース';
	}elseif($code==='yjt'){
	echo 'Yahoo!JAPANタイムライン';
	}elseif($code==='goo'){
	echo 'dmenuニュース・gooニュース';
	}elseif($code==='dcm'){
	echo 'ドコモメディア';
	}elseif($code==='spb'){
	echo 'SPORTS BULL';
	}elseif($code==='snf'){
	echo 'スマートニュース';
	}elseif($code==='gnf'){
	echo 'グノシー・ニュースパス';
	}elseif($code==='lnr'){
	echo 'LINE NEWS';
	}elseif($code==='ldn'){
	echo 'ライブドアニュース';
	}elseif($code==='isn'){
	echo 'Infoseekニュース';
	}elseif($code==='ant'){
	echo 'antenna*';
	}elseif($code==='trl'){
	echo 'TRILL';
	}else{
	}
		if($code=='ynf'){
		echo ' 配信先 FTP 結果情報を開く</a>';
		}else{
		echo ' RSS を開く</a>';
		}
	}
}

//*************************************************************
// これより詳細設定
//*************************************************************
//*************************************************************
// 基本設定に表示させるタブ選択
//*************************************************************
function CFTL_setting_tabblock($code) {
	// インラインスタイルの追加
	wp_register_style('cuerda-tabblock-style', false);
	$inline_style = "
		table.cat_map, table.cat_map th, table.cat_map td {
			border: none;
		}
		table.cat_map tbody th {
			min-width: 8em;
		}
		.tab-list-wrap #tab_ynf,
		.tab-list-wrap #tab_yjt,
		.tab-list-wrap #tab_goo,
		.tab-list-wrap #tab_dcm,
		.tab-list-wrap #tab_spb,
		.tab-list-wrap #tab_snf,
		.tab-list-wrap #tab_gnf,
		.tab-list-wrap #tab_lnr,
		.tab-list-wrap #tab_ldn,
		.tab-list-wrap #tab_isn,
		.tab-list-wrap #tab_ant,
		.tab-list-wrap #tab_trl {
			display: none;
		}
	";

	// オプションの状態に応じてスタイルを生成
	if (get_option('cuerda_' . esc_attr($code) . '_choice_ynf') == 1) {
		$inline_style .= '.tab-list-wrap #tab_ynf { display: block; }';
	}
	if (get_option('cuerda_' . esc_attr($code) . '_choice_yjt') == 1) {
		$inline_style .= '.tab-list-wrap #tab_yjt { display: block; }';
	}
	if (get_option('cuerda_' . esc_attr($code) . '_choice_goo') == 1) {
		$inline_style .= '.tab-list-wrap #tab_goo { display: block; }';
	}
	if (get_option('cuerda_' . esc_attr($code) . '_choice_dcm') == 1) {
		$inline_style .= '.tab-list-wrap #tab_dcm { display: block; }';
	}
	if (get_option('cuerda_' . esc_attr($code) . '_choice_spb') == 1) {
		$inline_style .= '.tab-list-wrap #tab_spb { display: block; }';
	}
	if (get_option('cuerda_' . esc_attr($code) . '_choice_snf') == 1) {
		$inline_style .= '.tab-list-wrap #tab_snf { display: block; }';
	}
	if (get_option('cuerda_' . esc_attr($code) . '_choice_gnf') == 1) {
		$inline_style .= '.tab-list-wrap #tab_gnf { display: block; }';
	}
	if (get_option('cuerda_' . esc_attr($code) . '_choice_lnr') == 1) {
		$inline_style .= '.tab-list-wrap #tab_lnr { display: block; }';
	}
	if (get_option('cuerda_' . esc_attr($code) . '_choice_ldn') == 1) {
		$inline_style .= '.tab-list-wrap #tab_ldn { display: block; }';
	}
	if (get_option('cuerda_' . esc_attr($code) . '_choice_isn') == 1) {
		$inline_style .= '.tab-list-wrap #tab_isn { display: block; }';
	}
	if (get_option('cuerda_' . esc_attr($code) . '_choice_ant') == 1) {
		$inline_style .= '.tab-list-wrap #tab_ant { display: block; }';
	}
	if (get_option('cuerda_' . esc_attr($code) . '_choice_trl') == 1) {
		$inline_style .= '.tab-list-wrap #tab_trl { display: block; }';
	}

	// インラインスタイルを追加
	wp_add_inline_style('cuerda-tabblock-style', $inline_style);
	wp_enqueue_style('cuerda-tabblock-style');

	// HTML出力
	echo '<tr valign="top">';
	echo '<th><label>タブに表示する配信先</label></th>';
	echo '<td>';
	echo '<ul class="">';

	// チェックボックスの配信先を生成
	$sources = [
		'ynf' => 'Yahoo!ニュース',
		'yjt' => 'Yahoo!JAPANタイムライン',
		'goo' => 'dmenuニュース・gooニュース',
		'dcm' => 'ドコモメディア',
		'spb' => 'SPORTS BULL',
		'snf' => 'スマートニュース',
		'gnf' => 'グノシー・ニュースパス',
		'lnr' => 'LINE NEWS',
		'ldn' => 'ライブドアニュース',
		'isn' => 'Infoseekニュース',
		'ant' => 'antenna*',
		'trl' => 'TRILL'
	];

	foreach ($sources as $source => $label) {
		$option_name = 'cuerda_' . esc_attr($code) . '_choice_' . $source;
		echo '<li>';
		echo '<input id="' . esc_attr($option_name) . '" name="' . esc_attr($option_name) . '" type="checkbox" value="1" ';
		checked(1, get_option($option_name));
		echo '>';
		echo '<label>' . esc_html($label) . '</label>';
		echo '</li>';
	}

	echo '</ul>';
	echo '</td>';
	echo '<td class="info"><p>チェックして「変更を保存」ボタンを押すと、配信先のRSSフィード設定が可能なタブが表示されます。</p></td>';
	echo '</tr>';
}

//*************************************************************
// フィードのブラウザキャッシュ
//*************************************************************
function CFTL_setting_expires($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_expires">フィードのブラウザキャッシュ</label></th>';
echo '<td><input type="number" min="5" max="300" id="cuerda_'.esc_attr($code).'_expires" name="cuerda_'.esc_attr($code).'_expires" oninput="value = onlyNumbers(value)" value="';
echo esc_attr( get_option('cuerda_'.esc_attr($code).'_expires') );
echo '" /> 秒</td>';
echo '<td class="info"><p>ブラウザからフィードへ連続的にアクセスしても、設定した時間内はブラウザキャッシュを表示させることでサーバーを保護できます。単位は秒で設定してください。設定しない場合は初期値 20 秒が適用されます。</p></td>';
echo '</tr>';
}

//*************************************************************
// このサイトの名称
//*************************************************************
function CFTL_setting_title($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_title">このサイトの名称</label></th>';
echo '<td><input type="text" id="cuerda_'.esc_attr($code).'_title" class="fullwidth" name="cuerda_'.esc_attr($code).'_title" value="';
echo esc_attr( get_option('cuerda_'.esc_attr($code).'_title') );
echo '" /></td>';
echo '<td class="info"><p>何も設定しなければサイトのタイトルである「';
echo esc_html(bloginfo('name'));
echo '」が出力されます。RSSフィードに別の媒体名を出力したい場合はその名称を登録してください。</p></td>';
echo '</tr>';
}

//*************************************************************
// 関連記事リンクに設定する記事URLを特定のパスに置き換える
//*************************************************************
function CFTL_setting_rel_urlpass($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_rel_urlpass">関連記事リンクに設定する記事URLを特定のパスに置き換える</label></th>';
echo '<td><input type="text" id="cuerda_'.esc_attr($code).'_rel_urlpass" class="fullwidth" name="cuerda_'.esc_attr($code).'_rel_urlpass" value="';
echo esc_url( get_option('cuerda_'.esc_attr($code).'_rel_urlpass') );
echo '" /></td>';
echo '<td class="info"><p>通常は何も設定する必要はありません。関連記事リンクからの流入先を次のように変更できます。</p><p>▽通常の記事ページURL例<br>https://sample.com/article/123<br>▽変更したいURL例（記事IDの前に特別なディレクトリ[front]をはさみたい）<br>https://sample.com/article/front/123</p><p>上記例の場合は次のように入力します。<br>https://sample.com/article/front/</p></td>';
echo '</tr>';
}

//*************************************************************
// ノアドット・コンテンツホルダー・ユニットID nordot_unit_id
//*************************************************************
function CFTL_setting_nordot_unit_id($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_nordot_unit_id">ノアドット・コンテンツホルダー・ユニットID</label></th>';
echo '<td><input type="text" id="cuerda_'.esc_attr($code).'_nordot_unit_id" class="fullwidth" name="cuerda_'.esc_attr($code).'_nordot_unit_id" value="';
echo esc_attr( get_option('cuerda_'.esc_attr($code).'_nordot_unit_id') );
echo '" /></td>';
echo '<td class="info"><p><a href="https://nordot.app/" target="_blank">ノアドット</a>にコンテンツホルダーとして参加している場合、そのユニットIDを登録してください。</p></td>';
echo '</tr>';
}

//*************************************************************
// ノアドット・キュレーター・ユニットID nordot_cu_id
//*************************************************************
function CFTL_setting_nordot_cu_id($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_nordot_cu_id">ノアドット・キュレーター・ユニットID</label></th>';
echo '<td><input type="text" id="cuerda_'.esc_attr($code).'_nordot_cu_id" class="fullwidth" name="cuerda_'.esc_attr($code).'_nordot_cu_id" value="';
echo esc_attr( get_option('cuerda_'.esc_attr($code).'_nordot_cu_id') );
echo '" /></td>';
echo '<td class="info"><p><a href="https://nordot.app/" target="_blank">ノアドット</a>への関連リンクにパラメータを設定する場合、キュレーター・ユニットIDを登録してください。</p></td>';
echo '</tr>';
}

//*************************************************************
// フィードへのクロール頻度
//*************************************************************
function CFTL_setting_ttl($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_ttl">フィードへのクロール頻度</label></th>';
echo '<td><input type="number" min="1" max="60" id="cuerda_'.esc_attr($code).'_ttl" name="cuerda_'.esc_attr($code).'_ttl" oninput="value = onlyNumbers(value)" value="';
echo esc_attr( get_option('cuerda_'.esc_attr($code).'_ttl') );
echo '" /> 分</td>';
echo '<td class="info"><p>配信済みコンテンツの修正や削除が配信先に反映される最長時間になります。速報ニュース等のコンテンツを扱う場合は短めがお奨めですが、サーバーへの負荷が増加します。単位は分で設定してください。設定しない場合は初期値 ';
if($code==='snf'){
echo '5';
}elseif($code==='gnf'||$code==='spb'){
echo '15';
}else{
}
echo ' 分が適用されます。</p></td>';
echo '</tr>';
}

//*************************************************************
// 配信する投稿の種類
//*************************************************************
function CFTL_setting_post_type($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_post_type">配信する投稿の種類</label></th>';
echo '<td><input type="text" id="cuerda_'.esc_attr($code).'_post_type" name="cuerda_'.esc_attr($code).'_post_type" value="';
echo esc_attr( get_option('cuerda_'.esc_attr($code).'_post_type') );
echo '" /></td>';
echo '<td class="info"><p>何も設定しなければ初期値は post です。通常はこのままですが、サイトのカスタマイズで投稿の post_type を変更または追加されている場合はその値をセットしてください。複数の場合はカンマ区切りでセットします。<br>設定例 => post,page,custom</p></td>';
echo '</tr>';
}

//*************************************************************
// フィード掲載する投稿の公開日
//*************************************************************
function CFTL_setting_after_date($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_after_date">フィード掲載する投稿の公開日</label></th>';
echo '<td><input type="number" min="0" max="30" id="cuerda_'.esc_attr($code).'_after_date" name="cuerda_'.esc_attr($code).'_after_date" oninput="value = onlyNumbers(value)" value="';
echo esc_attr( get_option('cuerda_'.esc_attr($code).'_after_date') );
echo '" /> 日前</td>';
echo '<td class="info"><p>何も設定しなければ初期値は当日を含め直近 ';
if($code==='yjt'||$code==='goo'||$code==='dcm'||$code==='spb'||$code==='lnr'){
echo '2';
}elseif($code==='snf'){
echo '14';
}elseif($code==='gnf'){
echo '3';
}else{
}
echo ' 日以内の公開日がセットされた投稿をフィードに掲載します。通常は配信先より頻繁にクロール処理されるため充分です。あまり長いとフィードに掲載するコンテンツ量が増え、サーバーに負担がかかります。</p></td>';
echo '</tr>';
}

//*************************************************************
// フィード掲載する投稿の更新日
//*************************************************************
function CFTL_setting_after_modified($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_after_modified">フィード掲載する投稿の更新日</label></th>';
echo '<td><input type="number" min="0" max="30" id="cuerda_'.esc_attr($code).'_after_modified" name="cuerda_'.esc_attr($code).'_after_modified" oninput="value = onlyNumbers(value)" value="'.esc_attr( get_option('cuerda_'.esc_attr($code).'_after_modified') ).'" /> 日前</td>';
echo '<td class="info"><p>何も設定しなければ初期値は当日を含め直近2日間に更新された投稿をフィードに掲載します。通常は配信先より頻繁にクロール処理されるため充分です。あまり長いとフィードに掲載するコンテンツ量が増え、サーバーに負担がかかります。</p></td>';
echo '</tr>';
}

//*************************************************************
// フィード掲載する最大投稿件数
//*************************************************************
function CFTL_setting_posts_per_page($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_posts_per_page">フィード掲載する最大投稿件数</label></th>';
echo '<td><input type="number" min="0" max="';
if($code==='yjt'||$code==='goo'||$code==='gnf'||$code==='snf'){
echo '300';
}elseif($code==='lnr'){
echo '100';
}elseif($code==='dcm'||$code==='spb'){
echo '50';
}else{
}
echo '" id="cuerda_'.esc_attr($code).'_posts_per_page" name="cuerda_'.esc_attr($code).'_posts_per_page" oninput="value = onlyNumbers(value)" value="';
echo esc_attr( get_option('cuerda_'.esc_attr($code).'_posts_per_page') );
echo '" /> 件</td>';
echo '<td class="info"><p>何も設定しなければ初期値は最大';
if($code==='yjt'||$code==='goo'||$code==='gnf'||$code==='snf'){
echo '100';
}elseif($code==='lnr'||$code==='trl'){
echo '30';
}elseif($code==='dcm'||$code==='spb'){
echo '50';
}else{
}
echo '件の投稿をフィードに掲載します。通常は1日あたりの新規公開および投稿更新数を目安にセットします。掲載するコンテンツ量が増えると、サーバーに負担がかかります。</p></td>';
echo '</tr>';
}

//*************************************************************
// 処理する投稿のステータス
//*************************************************************
function CFTL_setting_post_status($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_post_status">処理する投稿のステータス</label></th>';
echo '<td><input type="text" id="cuerda_'.esc_attr($code).'_post_status" name="cuerda_'.esc_attr($code).'_post_status" value="';
echo esc_attr( get_option('cuerda_'.esc_attr($code).'_post_status') );
echo '" /></td>';
echo '<td class="info"><p>何も設定しなければ初期値は publish,draft,private,pending,trash （公開済み,下書き、非公開、承認待ち、ごみ箱）です。通常はこのままですが、サイトのカスタマイズで投稿の post_status を変更または追加されている場合はその値をセットしてください。複数の場合はカンマ区切りでセットします。<br>設定例 => publish,draft,private,pending,trash,future</p></td>';
echo '</tr>';
}

//*************************************************************
// 連想配列に格納された特定の文字列を削除
//*************************************************************
function CFTL_setting_sentence_delete($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_sentence_delete">配信記事から削除する特定の文字列</label></th>';
echo '<td><input type="text" id="cuerda_'.esc_attr($code).'_sentence_delete" class="fullwidth" name="cuerda_'.esc_attr($code).'_sentence_delete" value="';
echo esc_attr( get_option('cuerda_'.esc_attr($code).'_sentence_delete') );
echo '" /></td>';
echo '<td class="info"><p>通常は何も設定する必要はありません。配信先から削除するよう指摘があった場合は、フォームにその文字列を登録すれば記事から削除されて配信することができます。文字列が複数ある場合はカンマ区切りで登録してください。</p><p>※例： ＞＞続きはこちら＜＜,前回のページ</p></td>';
echo '</tr>';
}

//*************************************************************
// 連想配列に格納された特定の正規表現を削除
//*************************************************************
function CFTL_setting_regular_expression_delete($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_regular_expression_delete">配信記事から削除する特定の正規表現</label></th>';
echo '<td><input type="text" id="cuerda_'.esc_attr($code).'_regular_expression_delete" class="fullwidth" name="cuerda_'.esc_attr($code).'_regular_expression_delete" value="';
echo esc_attr( get_option('cuerda_'.esc_attr($code).'_regular_expression_delete') );
echo '" /></td>';
echo '<td class="info"><p>通常は何も設定する必要はありません。配信先から削除するよう指摘があった場合は、フォームにその正規表現を登録すれば記事から削除されて配信することができます。正規表現が複数ある場合はカンマ区切りで登録してください。</p><p>※正規表現が不明な場合はクエルダへお問合せください。</p></td>';
echo '</tr>';
}

//*************************************************************
// 配信から除外する著者
//*************************************************************
// 著者一覧を取得し、キャッシュする関数
function cuerda_get_cached_authors() {
	static $authors = null;
	if ($authors === null) {
		$args = array(
			"orderby" => "count", // countでソート
			"order" => "DESC" // 降順
		);
		$authors = get_users($args);
	}
	return $authors;
}
function CFTL_setting_author__not_in($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_author__not_in">配信から除外する著者</label></th>';
echo '<td><input type="text" id="cuerda_'.esc_attr($code).'_author__not_in" name="cuerda_'.esc_attr($code).'_author__not_in" value="';
echo esc_attr( get_option('cuerda_'.esc_attr($code).'_author__not_in') );
echo '" /></td>';
echo '<td class="info"><p>何も設定しなければ全ての著者の投稿が配信対象です。現在登録されている下記著者情報を参考に配信から除外する著者の ID をカンマ区切りで設定してください。※例： 1,2,3</p>';
echo '<div class="ac-box">';
echo '<input id="ac-'.esc_attr($code).'-1" name="accordion-'.esc_attr($code).'-1" type="checkbox" />';
echo '<label for="ac-'.esc_attr($code).'-1">著者ID一覧を</label>';
echo '<div class="ac-small">';
echo '<p class="id_list">';
	$authors = cuerda_get_cached_authors();
	if (!empty($authors)) {
		foreach ($authors as $author) {
			echo $author->display_name . '（ID=' . $author->ID . '）｜ ';
		}
	}
echo '</p>';
echo '</div>';
echo '</div>';
echo '</td>';
echo '</tr>';
}

//*************************************************************
// 配信する著者
//*************************************************************
function CFTL_setting_author__in($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_author__in">配信する著者</label></th>';
echo '<td><input type="text" id="cuerda_'.esc_attr($code).'_author__in" name="cuerda_'.esc_attr($code).'_author__in" value="';
echo esc_attr( get_option('cuerda_'.esc_attr($code).'_author__in') );
echo '" /></td>';
echo '<td class="info"><p>特定の著者の投稿のみ配信対象とすることができます。現在登録されている下記著者情報を参考に配信する著者の ID をカンマ区切りで設定してください。ここで設定すると「配信から除外する著者」の設定は無効になります。※例： 1,2,3</p>';
echo '<div class="ac-box">';
echo '<input id="ac-'.esc_attr($code).'-2" name="accordion-'.esc_attr($code).'-2" type="checkbox" />';
echo '<label for="ac-'.esc_attr($code).'-2">著者ID一覧を</label>';
echo '<div class="ac-small">';
echo '<p class="id_list">';
	$authors = cuerda_get_cached_authors();
	if (!empty($authors)) {
		foreach ($authors as $author) {
			echo $author->display_name . '（ID=' . $author->ID . '）｜ ';
		}
	}
echo '</p>';
echo '</div>';
echo '</div>';
echo '</td>';
echo '</tr>';
}

//*************************************************************
// グノシーカテゴリーマッピング
//*************************************************************
function CFTL_setting_gnf_category(){
echo '<tr valign="top">';
echo '<td colspan="2">';
echo '<table class="cat_map">';
echo '<thead>';
echo '<tr>';
echo '<th colspan="3" style="">カテゴリーを配信先カテゴリーにマッピング</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';
$args1 = array("orderby" => "count","order" => "DESC","hide_empty" => false);
$categories = get_categories( $args1 );
foreach( $categories as $category ){
$cat_id = $category->term_id;
$cat_count = intval($category->count);
$cat_name = esc_html($category->name);
$op_name_pre = 'cuerda_gnf_category_';
$op_name = $op_name_pre.$cat_id;
$val_pol = 'politics';
$val_eco = 'economy';
$val_soc = 'society';
$val_int = 'international';
$val_tec = 'technology';
$val_spo = 'sports';
$val_ent = 'entertainment';
$val_col = 'column';
$val_gou = 'gourmet';
$val_omo = 'omoshiro';
echo '<tr><th>'.$cat_name.' ('.$cat_count.')';
echo '</th><td class="sep2">⇒</td>';
echo '<td>';
echo '<select class="cat_select" name="cuerda_gnf_category_';
echo $category->term_id;
echo '" id="cuerda_gnf_category_';
echo $category->term_id;
echo '">';
echo '<option value="">配信ジャンル選択</option>';
echo '<option value="';
echo esc_attr($val_pol);
echo '" ';
selected($val_pol,get_option($op_name));
echo '>政治</option>';
echo '<option value="';
echo esc_attr($val_eco);
echo '" ';
selected($val_eco,get_option($op_name));
echo '>経済</option>';
echo '<option value="';
echo esc_attr($val_soc);
echo '" ';
selected($val_soc,get_option($op_name));
echo '>社会</option>';
echo '<option value="';
echo esc_attr($val_int);
echo '" ';
selected($val_int,get_option($op_name));
echo '>国際</option>';
echo '<option value="';
echo esc_attr($val_tec);
echo '" ';
selected($val_tec,get_option($op_name));
echo '>テクノロジー</option>';
echo '<option value="';
echo esc_attr($val_spo);
echo '" ';
selected($val_spo,get_option($op_name));
echo '>スポーツ</option>';
echo '<option value="';
echo esc_attr($val_ent);
echo '" ';
selected($val_ent,get_option($op_name));
echo '>エンタメ</option>';
echo '<option value="';
echo esc_attr($val_col);
echo '" ';
selected($val_col,get_option($op_name));
echo '>コラム</option>';
echo '<option value="';
echo esc_attr($val_gou);
echo '" ';
selected($val_gou,get_option($op_name));
echo '>グルメ</option>';
echo '<option value="';
echo esc_attr($val_omo);
echo '" ';
selected($val_omo,get_option($op_name));
echo '>気になる（ニュースパス） / おもしろ（「グノシー」）</option>';
echo '</select>';
echo '</td>';
echo '</tr>';
}
unset($category);
echo '</tbody>';
echo '</table>';
echo '</td>';
echo '<td class="info"><p>サイトのカテゴリーをグノシー、ニュースパスのカテゴリーに変換します。</p><p>（　）カッコ内の数字は該当する投稿数です。</p></td>';
echo '</tr>';
}

//*************************************************************
// SPORTS BULL カテゴリーマッピング
//*************************************************************
function CFTL_setting_spb_category(){
echo '<tr valign="top">';
echo '<td colspan="2">';
echo '<table class="cat_map">';
echo '<thead>';
echo '<tr>';
echo '<th colspan="3" style="">カテゴリーを配信先カテゴリーにマッピング</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';
$args_spb = array("orderby" => "count","order" => "DESC","hide_empty" => false);
$categories = get_categories( $args_spb );
foreach( $categories as $category ){
$cat_id = $category->term_id;
$cat_count = intval($category->count);
$cat_name = esc_html($category->name);
$op_name_pre = 'cuerda_spb_category_';
$op_name = $op_name_pre.$cat_id;

$val_climbing = 'climbing';
$val_rugby = 'rugby';
$val_univas = 'univas';
$val_esports = 'esports';
$val_instagram = 'instagram';
$val_haruko = 'haruko';
$val_lifestyle = 'lifestyle';
$val_business = 'business';
$val_swimming = 'swimming';
$val_dance = 'dance';
$val_etc = 'etc';
$val_baseballgate = 'baseballgate';
$val_joshisoccer = 'joshisoccer';
$val_jsports = 'jsports';
$val_inhightv = 'inhightv';
$val_dazn = 'dazn';
$val_cat = 'cat';
$val_athletics = 'athletics';
$val_pingpong = 'pingpong';
$val_menicon = 'menicon';
$val_volleyball = 'volleyball';
$val_harukoyell = 'harukoyell';
$val_sailing = 'sailing';
$val_asiancup2023 = 'asiancup2023';
$val_golfnetwork = 'golfnetwork';
$val_summary = 'summary';
$val_asics = 'asics';
$val_extremesports = 'extremesports';
$val_senbatsu = 'senbatsu';
$val_big6tv = 'big6tv';
$val_tohto = 'tohto';
$val_wintersports = 'wintersports';
$val_tennis = 'tennis';
$val_soccer = 'soccer';
$val_motorsports = 'motorsports';
$val_vk = 'vk';
$val_basketball = 'basketball';
$val_crazy = 'crazy';
$val_bullsshow = 'bullsshow';
$val_samuraiblue = 'samuraiblue';
$val_baseball = 'baseball';
$val_businessman = 'businessman';
$val_hockey = 'hockey';
$val_battle = 'battle';
$val_parasports = 'parasports';
$val_taikoku = 'taikoku';
$val_golf = 'golf';
$val_cheer = 'cheer';
$val_abema = 'abema';

echo '<tr><th>'.$cat_name.' ('.$cat_count.')';
echo '</th><td class="sep2">⇒</td>';
echo '<td>';
echo '<select class="cat_select" name="cuerda_spb_category_';
echo $category->term_id;
echo '" id="cuerda_spb_category_';
echo $category->term_id;
echo '">';
echo '<option value="">配信ジャンル選択</option>';

echo '<option value="';
echo esc_attr($val_climbing);
echo '" ';
selected($val_climbing,get_option($op_name));
echo '>クライミング</option>';
echo '<option value="';
echo esc_attr($val_rugby);
echo '" ';
selected($val_rugby,get_option($op_name));
echo '>ラグビー</option>';
echo '<option value="';
echo esc_attr($val_univas);
echo '" ';
selected($val_univas,get_option($op_name));
echo '>UNIVAS</option>';
echo '<option value="';
echo esc_attr($val_esports);
echo '" ';
selected($val_esports,get_option($op_name));
echo '>eスポーツ</option>';
echo '<option value="';
echo esc_attr($val_instagram);
echo '" ';
selected($val_instagram,get_option($op_name));
echo '>話題の投稿</option>';
echo '<option value="';
echo esc_attr($val_haruko);
echo '" ';
selected($val_haruko,get_option($op_name));
echo '>バーチャル春高バレー</option>';
echo '<option value="';
echo esc_attr($val_lifestyle);
echo '" ';
selected($val_lifestyle,get_option($op_name));
echo '>ライフスタイル</option>';
echo '<option value="';
echo esc_attr($val_business);
echo '" ';
selected($val_business,get_option($op_name));
echo '>スポーツビジネス</option>';
echo '<option value="';
echo esc_attr($val_swimming);
echo '" ';
selected($val_swimming,get_option($op_name));
echo '>水泳</option>';
echo '<option value="';
echo esc_attr($val_dance);
echo '" ';
selected($val_dance,get_option($op_name));
echo '>ダンス</option>';
echo '<option value="';
echo esc_attr($val_etc);
echo '" ';
selected($val_etc,get_option($op_name));
echo '>その他競技</option>';
echo '<option value="';
echo esc_attr($val_baseballgate);
echo '" ';
selected($val_baseballgate,get_option($op_name));
echo '>BASEBALL GATE</option>';
echo '<option value="';
echo esc_attr($val_joshisoccer);
echo '" ';
selected($val_joshisoccer,get_option($op_name));
echo '>高校女子サッカー</option>';
echo '<option value="';
echo esc_attr($val_jsports);
echo '" ';
selected($val_jsports,get_option($op_name));
echo '>J SPORTS</option>';
echo '<option value="';
echo esc_attr($val_inhightv);
echo '" ';
selected($val_inhightv,get_option($op_name));
echo '>インターハイ(インハイ.tv)</option>';
echo '<option value="';
echo esc_attr($val_dazn);
echo '" ';
selected($val_dazn,get_option($op_name));
echo '>DAZN</option>';
echo '<option value="';
echo esc_attr($val_cat);
echo '" ';
selected($val_cat,get_option($op_name));
echo '>COLLEGE ATHLETE TV</option>';
echo '<option value="';
echo esc_attr($val_athletics);
echo '" ';
selected($val_athletics,get_option($op_name));
echo '>陸上</option>';
echo '<option value="';
echo esc_attr($val_pingpong);
echo '" ';
selected($val_pingpong,get_option($op_name));
echo '>卓球</option>';
echo '<option value="';
echo esc_attr($val_menicon);
echo '" ';
selected($val_menicon,get_option($op_name));
echo '>メニコンカップ</option>';
echo '<option value="';
echo esc_attr($val_volleyball);
echo '" ';
selected($val_volleyball,get_option($op_name));
echo '>バレーボール</option>';
echo '<option value="';
echo esc_attr($val_harukoyell);
echo '" ';
selected($val_harukoyell,get_option($op_name));
echo '>春高YELL</option>';
echo '<option value="';
echo esc_attr($val_sailing);
echo '" ';
selected($val_sailing,get_option($op_name));
echo '>セーリング</option>';
echo '<option value="';
echo esc_attr($val_asiancup2023);
echo '" ';
selected($val_asiancup2023,get_option($op_name));
echo '>AFCアジアカップ</option>';
echo '<option value="';
echo esc_attr($val_golfnetwork);
echo '" ';
selected($val_golfnetwork,get_option($op_name));
echo '>GOLF NETWORK</option>';
echo '<option value="';
echo esc_attr($val_summary);
echo '" ';
selected($val_summary,get_option($op_name));
echo '>まとめ</option>';
echo '<option value="';
echo esc_attr($val_asics);
echo '" ';
selected($val_asics,get_option($op_name));
echo '>ASICS</option>';
echo '<option value="';
echo esc_attr($val_extremesports);
echo '" ';
selected($val_extremesports,get_option($op_name));
echo '>アクション</option>';
echo '<option value="';
echo esc_attr($val_senbatsu);
echo '" ';
selected($val_senbatsu,get_option($op_name));
echo '>センバツLIVE!</option>';
echo '<option value="';
echo esc_attr($val_big6tv);
echo '" ';
selected($val_big6tv,get_option($op_name));
echo '>東京六大学野球</option>';
echo '<option value="';
echo esc_attr($val_tohto);
echo '" ';
selected($val_tohto,get_option($op_name));
echo '>東都大学野球</option>';
echo '<option value="';
echo esc_attr($val_wintersports);
echo '" ';
selected($val_wintersports,get_option($op_name));
echo '>ウィンタースポーツ</option>';
echo '<option value="';
echo esc_attr($val_tennis);
echo '" ';
selected($val_tennis,get_option($op_name));
echo '>テニス</option>';
echo '<option value="';
echo esc_attr($val_soccer);
echo '" ';
selected($val_soccer,get_option($op_name));
echo '>サッカー</option>';
echo '<option value="';
echo esc_attr($val_motorsports);
echo '" ';
selected($val_motorsports,get_option($op_name));
echo '>モータースポーツ</option>';
echo '<option value="';
echo esc_attr($val_vk);
echo '" ';
selected($val_vk,get_option($op_name));
echo '>バーチャル高校野球</option>';
echo '<option value="';
echo esc_attr($val_basketball);
echo '" ';
selected($val_basketball,get_option($op_name));
echo '>バスケットボール</option>';
echo '<option value="';
echo esc_attr($val_crazy);
echo '" ';
selected($val_crazy,get_option($op_name));
echo '>CRAZY ATHLETES</option>';
echo '<option value="';
echo esc_attr($val_bullsshow);
echo '" ';
selected($val_bullsshow,get_option($op_name));
echo ">BULL'S SHOW</option>";
echo '<option value="';
echo esc_attr($val_samuraiblue);
echo '" ';
selected($val_samuraiblue,get_option($op_name));
echo '>サッカー日本代表</option>';
echo '<option value="';
echo esc_attr($val_baseball);
echo '" ';
selected($val_baseball,get_option($op_name));
echo '>野球</option>';
echo '<option value="';
echo esc_attr($val_businessman);
echo '" ';
selected($val_businessman,get_option($op_name));
echo '>リーマンモンスターズ</option>';
echo '<option value="';
echo esc_attr($val_hockey);
echo '" ';
selected($val_hockey,get_option($op_name));
echo '>ホッケー</option>';
echo '<option value="';
echo esc_attr($val_battle);
echo '" ';
selected($val_battle,get_option($op_name));
echo '>相撲・格闘技</option>';
echo '<option value="';
echo esc_attr($val_parasports);
echo '" ';
selected($val_parasports,get_option($op_name));
echo '>パラスポーツ</option>';
echo '<option value="';
echo esc_attr($val_taikoku);
echo '" ';
selected($val_taikoku,get_option($op_name));
echo '>スポーツ大国</option>';
echo '<option value="';
echo esc_attr($val_golf);
echo '" ';
selected($val_golf,get_option($op_name));
echo '>ゴルフ</option>';
echo '<option value="';
echo esc_attr($val_cheer);
echo '" ';
selected($val_cheer,get_option($op_name));
echo '>CHEER</option>';
echo '<option value="';
echo esc_attr($val_abema);
echo '" ';
selected($val_abema,get_option($op_name));
echo '>ABEMA</option>';

echo '</select>';
echo '</td>';
echo '</tr>';
}
unset($category);
echo '</tbody>';
echo '</table>';
echo '</td>';
echo '<td class="info"><p>サイトのカテゴリーをSPORTS BULLのカテゴリーに変換します。</p><p>（　）カッコ内の数字は該当する投稿数です。</p></td>';
echo '</tr>';
}

//*************************************************************
// 先頭に指定するカテゴリ名
//*************************************************************
function CFTL_setting_category__absolute($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_category__absolute">先頭に指定するカテゴリ名</label></th>';
echo '<td><input type="text" id="cuerda_'.esc_attr($code).'_category__absolute" name="cuerda_'.esc_attr($code).'_category__absolute" value="';
echo esc_attr( get_option('cuerda_'.esc_attr($code).'_category__absolute') );
echo '" /></td>';
echo '<td class="info"><p>ここで設定した任意のカテゴリ名が配信先で使用されます。通常は設定不要ですが、配信先から特定のカテゴリ名を先頭に配置する様指示された場合、その名称を設定してください。<br>設定例 => エンタメ</p></td>';
echo '</tr>';
}

//*************************************************************
// 配信から除外するカテゴリー
//*************************************************************
// カテゴリー一覧を取得し、キャッシュする関数
function cuerda_get_cached_categories() {
	static $categories = null;
	if ($categories === null) {
		$args = array(
			"orderby" => "count", // countでソート
			"order" => "DESC" // 降順
		);
		$categories = get_categories($args);
	}
	return $categories;
}
function CFTL_setting_category__not_in($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_category__not_in">配信から除外するカテゴリー</label></th>';
echo '<td><input type="text" id="cuerda_'.esc_attr($code).'_category__not_in" name="cuerda_'.esc_attr($code).'_category__not_in" value="';
echo esc_attr( get_option('cuerda_'.esc_attr($code).'_category__not_in') );
echo '" /></td>';
echo '<td><p>何も設定しなければ全てのカテゴリーの投稿が配信対象です。<br>現在登録されている下記カテゴリー情報を参考に、配信から除外したいカテゴリーの ID をカンマ区切りで設定してください。※例： 1,2,3</p>';
echo '<div class="ac-box">';
echo '<input id="ac-'.esc_attr($code).'-3" name="accordion-'.esc_attr($code).'-3" type="checkbox" />';
echo '<label for="ac-'.esc_attr($code).'-3">カテゴリーID一覧を</label>';
echo '<div class="ac-small">';
echo '<p class="id_list">';
	$categories = cuerda_get_cached_categories();
	if (!empty($categories)) {
		foreach ($categories as $category) {
			echo $category->name . '（ID=' . $category->term_id . '）｜ ';
		}
	}
echo '</p>';
echo '</div>';
echo '</div>';
echo '</td>';
echo '</tr>';
}

//*************************************************************
// 配信するカテゴリー
//*************************************************************
// 設定画面でカテゴリーを表示する関数
function CFTL_setting_category__in($code) {
	echo '<tr valign="top">';
	echo '<th><label for="cuerda_'.esc_attr($code).'_category__in">配信するカテゴリー</label></th>';
	echo '<td><input type="text" id="cuerda_'.esc_attr($code).'_category__in" name="cuerda_'.esc_attr($code).'_category__in" value="';
	echo esc_attr(get_option('cuerda_'.esc_attr($code).'_category__in'));
	echo '" /></td>';
	echo '<td><p>何も設定しなければ全てのカテゴリーの投稿が配信対象です。<br>現在登録されている下記カテゴリー情報を参考に、配信したいカテゴリーの ID をカンマ区切りで設定してください。ここで設定すると「配信から除外するカテゴリー」の設定は無効になります。※例： 1,2,3</p>';
echo '<div class="ac-box">';
echo '<input id="ac-'.esc_attr($code).'-4" name="accordion-'.esc_attr($code).'-4" type="checkbox" />';
echo '<label for="ac-'.esc_attr($code).'-4">カテゴリーID一覧を</label>';
echo '<div class="ac-small">';
	echo '<p class="id_list">';
	$categories = cuerda_get_cached_categories();
	if (!empty($categories)) {
		foreach ($categories as $category) {
			echo $category->name . '（ID=' . $category->term_id . '）｜ ';
		}
	}
	echo '</p>';
echo '</div>';
echo '</div>';
echo '</td>';
echo '</tr>';
}

//*************************************************************
// 配信から除外するタグ
//*************************************************************
// タグ一覧を取得し、キャッシュする関数
function cuerda_get_cached_tags() {
	static $tags = null;
	if ($tags === null) {
		$args = array(
			"orderby" => "count", // countでソート
			"order" => "DESC" // 降順
		);
		$tags = get_tags($args);
	}
	return $tags;
}
function CFTL_setting_tag__not_in($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_tag__not_in">配信から除外するタグ</label></th>';
echo '<td><input type="text" id="cuerda_'.esc_attr($code).'_tag__not_in" name="cuerda_'.esc_attr($code).'_tag__not_in" value="';
echo esc_attr( get_option('cuerda_'.esc_attr($code).'_tag__not_in') );
echo '" /></td>';
echo '<td><p>何も設定しなければ全てのタグの投稿が配信対象です。現在登録されている下記タグ情報を参考に配信から除外するタグの ID をカンマ区切りで設定してください。※例： 1,2,3</p>';
echo '<div class="ac-box">';
echo '<input id="ac-'.esc_attr($code).'-5" name="accordion-'.esc_attr($code).'-5" type="checkbox" />';
echo '<label for="ac-'.esc_attr($code).'-5">タグID一覧を</label>';
echo '<div class="ac-small">';
echo '<p class="id_list">';
	$tags = cuerda_get_cached_tags();
	if (!empty($tags)) {
		foreach ($tags as $tag) {
			echo $tag->name . '（ID=' . $tag->term_id . '）｜ ';
		}
	}
echo '</p>';
echo '</div>';
echo '</div>';
echo '</td>';
echo '</tr>';
}

//*************************************************************
// 配信するタグ
//*************************************************************
function CFTL_setting_tag__in($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_tag_in">配信するタグ</label></th>';
echo '<td><input type="text" id="cuerda_'.esc_attr($code).'_tag__in" name="cuerda_'.esc_attr($code).'_tag__in" value="';
echo esc_attr( get_option('cuerda_'.esc_attr($code).'_tag__in') );
echo '" /></td>';
echo '<td><p>何も設定しなければ全てのタグの投稿が配信対象です。現在登録されている下記タグ情報を参考に配信するタグの ID をカンマ区切りで設定してください。ここで設定すると「配信から除外するタグ」の設定は無効になります。※例： 1,2,3</p>';
echo '<div class="ac-box">';
echo '<input id="ac-'.esc_attr($code).'-6" name="accordion-'.esc_attr($code).'-6" type="checkbox" />';
echo '<label for="ac-'.esc_attr($code).'-6">タグID一覧を</label>';
echo '<div class="ac-small">';
echo '<p class="id_list">';
	$tags = cuerda_get_cached_tags();
	if (!empty($tags)) {
		foreach ($tags as $tag) {
			echo $tag->name . '（ID=' . $tag->term_id . '）｜ ';
		}
	}
echo '</p>';
echo '</div>';
echo '</div>';
echo '</td>';
echo '</tr>';
}

//*************************************************************
// 配信から除外する投稿
//*************************************************************
function CFTL_setting_post__not_in($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_post__not_in">配信から除外する投稿</label></th>';
echo '<td><input type="text" id="cuerda_'.esc_attr($code).'_post__not_in" name="cuerda_'.esc_attr($code).'_post__not_in" value="';
echo esc_attr( get_option('cuerda_'.esc_attr($code).'_post__not_in') );
echo '" /></td>';
echo '<td class="info"><p>配信から除外したい投稿があれば、投稿 ID をカンマ区切りでセットしてください。※例： 1,2,3<br>尚、配信済み投稿を配信対象外としても配信先からは削除されません。その場合は該当投稿を下書きにするか、状態を非表示にすることで配信先へ削除電文をフィードできます。配信先から削除されたことを確認してからこの設定を行ってください。</p></td>';
echo '</tr>';
}

//*************************************************************
// 標準地域コードの自動配信
//*************************************************************
function CFTL_setting_area_city($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_area_city">標準地域コードの自動配信</label></th>';
echo '<td><label><input name="cuerda_'.esc_attr($code).'_area_city" id="cuerda_'.esc_attr($code).'_area_city" type="checkbox" value="1" ';
checked(1, get_option('cuerda_'.esc_attr($code).'_area_city'));
echo '>可能なら配信する</label></td>';
if($code!=='spb'){
echo '<td class="info"><p>チェックすることをおすすめします。都道府県及び市町村の区域を示す情報が自動配信できます。47都道府県名のタグを付与する運用が無くても投稿本文内の内容を解析して自動付与されますので、配信先でのインプレッション増が期待できます。</p><p class="id_list">例：本文中に「小豆郡小豆島町」というフレーズがあれば、prefecture = 37（香川県）、city = 37324 （小豆郡小豆島町）という情報が自動出力されます。</p></td>';
}else{
echo '<td class="info"><p>チェックすることをおすすめします。エリアや都道府県情報が自動配信できます。47都道府県名のタグを付与する運用が無くても投稿本文内の内容を解析して自動付与されます。</p></td>';
}
echo '</tr>';
}

//*************************************************************
// 関連リンクにノアドットを優先する
//*************************************************************
function CFTL_setting_rel_nor_set($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_rel_nor_set">関連リンクをノアドットページにする</label></th>';
echo '<td><label><input name="cuerda_'.esc_attr($code).'_rel_nor_set" id="cuerda_'.esc_attr($code).'_rel_nor_set" type="checkbox" value="1" ';
checked(1, get_option('cuerda_'.esc_attr($code).'_rel_nor_set'));
echo '>可能なら配信する</label></td>';
echo '<td class="info"><p>基本設定でノアドット・コンテンツホルダーIDがセットされている場合、チェックすることで関連リンクをノアドットページへのURLとして配信できます。</p></td>';
echo '</tr>';
}

//*************************************************************
// 関連リンク最大本数 lnr => 外部リンク情報最大本数 snf => 広告の代替関連記事リンク最大本数
//*************************************************************
function CFTL_setting_rel_count($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_rel_count">';
if($code==='ynf'||$code==='yjt'||$code==='goo'||$code==='gnf'||$code==='dcm'||$code==='spb'||$code==='ldn'||$code==='isn'||$code==='trl'){
echo '関連リンク最大本数';
}elseif($code==='lnr'){
echo '外部リンク情報最大本数';
}elseif($code==='snf'){
echo '広告の代替関連記事リンク最大本数';
}else{
}
echo '</label></th>';
echo '<td><input type="number" min="0" max="';
if($code==='gnf'||$code==='dcm'||$code==='ldn'||$code==='isn'||$code==='trl'){
echo '3';
}elseif($code==='ynf'||$code==='yjt'||$code==='goo'||$code==='lnr'||$code==='spb'){
echo '5';
}elseif($code==='snf'){
echo '2';
}else{
}
echo '" id="cuerda_'.esc_attr($code).'_rel_count" name="cuerda_'.esc_attr($code).'_rel_count" oninput="value = onlyNumbers(value)" value="';
echo esc_attr( get_option('cuerda_'.esc_attr($code).'_rel_count') );
echo '" /> 本</td>';
echo '<td class="info"><p>';
if($code==='gnf'||$code==='ldn'||$code==='isn'||$code==='trl'){
echo '記事当たりの関連記事リンク最大出力本数を 0 ～ 3 の数値で指定します。何も指定しない場合は初期値3本まで出力します。';
}elseif($code==='ynf'){
echo '記事当たりの関連リンク最大出力本数を 0 ～ 5 の数値で指定します。Yahoo!ニュースではレギュレーションで最大5本まで指定できますので、何も指定しない場合は初期値5本まで出力します。';
}elseif($code==='yjt'){
echo '記事当たりの関連リンク最大出力本数を 0 ～ 5 の数値で指定します。Yahoo!JAPANタイムラインではレギュレーションで最大5本まで指定できますので、何も指定しない場合は初期値5本まで出力します。';
}elseif($code==='spb'){
echo '記事当たりの関連リンク最大出力本数を 0 ～ 5 の数値で指定します。レギュレーションで最大5本まで指定できますので、何も指定しない場合は初期値5本まで出力します。';
}elseif($code==='goo'){
echo '記事当たりの関連リンク最大出力本数を 0 ～ 5 の数値で指定します。dmenuニュースではレギュレーションで最大3本ですが、gooニュースでは最大5本まで指定できますので、何も指定しない場合は初期値5本まで出力します。';
}elseif($code==='snf'){
echo '記事当たりの関連記事リンク最大出力本数を 0 ～ 2 の数値で指定します。何も指定しない場合は初期値2本まで出力します。';
}elseif($code==='lnr'){
echo '記事当たりの外部リンク情報最大出力本数を 0 ～ 5 の数値で指定します。LINE NEWS のレギュレーションでは大5本ですので、何も指定しない場合は初期値5本まで出力します。';
}elseif($code==='dcm'){
echo '記事当たりの関連リンク最大出力本数を 0 ～ 3 の数値で指定します。ドコモメディアではレギュレーションで最大3本まで指定できますので、何も指定しない場合は初期値3本まで出力します。';
}else{
}
echo '</p></td>';
echo '</tr>';
}
//*************************************************************
// 同一タグから関連リンクを出力する
//*************************************************************
function CFTL_setting_rel_tag($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda'.esc_attr($code).'_rel_tag">関連リンク出力方法</label></th>';
echo '<td><label><input name="cuerda_'.esc_attr($code).'_rel_tag" id="cuerda_'.esc_attr($code).'_rel_tag" type="checkbox" value="1" ';
checked(1, get_option('cuerda_'.esc_attr($code).'_rel_tag'));
echo '>同一タグにする</label></td>';
echo '<td class="info"><p>初期値は同一カテゴリーから投稿を新しい順に出力しますが、チェックすると同一タグから出力できます。投稿毎にタグを設定する運用をしている場合、より関連度の高い投稿が出力されるため、配信先で関連リンク・クリック率向上が期待できます。</p></td>';
echo '</tr>';
}

//*************************************************************
// 手動関連リンクを優先出力する
//*************************************************************
function CFTL_setting_rel_manual($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda'.esc_attr($code).'_rel_manual">カスタムフィールドで指定した関連リンクを優先する</label></th>';
echo '<td><label><input name="cuerda_'.esc_attr($code).'_rel_manual" id="cuerda_'.esc_attr($code).'_rel_manual" type="checkbox" value="1" ';
checked(1, get_option('cuerda_'.esc_attr($code).'_rel_manual'));
echo '>可能なら優先する</label></td>';
echo '<td class="info"><p>通常は自動で関連リンクを出力しますが、チェックすると投稿のカスタムフィールドで指定した関連リンクが優先的に出力されます。</p></td>';
echo '</tr>';
}

//*************************************************************
// 優先的に表示する手動関連リンクURLのカスタムフィールド名1
//*************************************************************
function CFTL_setting_rel_feeld1($code){

echo '<tr valign="top">';
echo '<th colspan="2" style="border:none"><strong>関連リンクURLが登録されているカスタムフィールド名</strong></th>';
echo '<td class="info" rowspan="3" style="border:none"><p>通常指定する必要はありませんが、任意の関連リンクを指定したい場合、関連リンクのURLが登録されているカスタムフィールド名を入力してください。</p></td>';
echo '</tr>';

echo '<tr valign="top">';
echo '<th style="border:none"><label for="cuerda_'.esc_attr($code).'_rel_feeld1">1本目</label></th>';
echo '<td style="border:none"><input type="text" id="cuerda_'.esc_attr($code).'_rel_feeld1" class="fullwidth" name="cuerda_'.esc_attr($code).'_rel_feeld1" value="';
echo esc_attr( get_option('cuerda_'.esc_attr($code).'_rel_feeld1') );
echo '" /></td>';
echo '</tr>';
}
//*************************************************************
// 優先的に表示する手動関連リンクURLのカスタムフィールド名2
//*************************************************************
function CFTL_setting_rel_feeld2($code){
echo '<tr valign="top">';
echo '<th style="border:none"><label for="cuerda_'.esc_attr($code).'_rel_feeld2">2本目</label></th>';
echo '<td style="border:none"><input type="text" id="cuerda_'.esc_attr($code).'_rel_feeld2" class="fullwidth" name="cuerda_'.esc_attr($code).'_rel_feeld2" value="';
echo esc_attr( get_option('cuerda_'.esc_attr($code).'_rel_feeld2') );
echo '" /></td>';
echo '</tr>';
}
//*************************************************************
// 優先的に表示する手動関連リンクURLのカスタムフィールド名3
//*************************************************************
function CFTL_setting_rel_feeld3($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_rel_feeld3">3本目</label></th>';
echo '<td><input type="text" id="cuerda_'.esc_attr($code).'_rel_feeld3" class="fullwidth" name="cuerda_'.esc_attr($code).'_rel_feeld3" value="';
echo esc_attr( get_option('cuerda_'.esc_attr($code).'_rel_feeld3') );
echo '" /></td>';
echo '</tr>';
}

//*************************************************************
// 公開中を示す投稿のステータス
//*************************************************************
function CFTL_setting_publish_status($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_publish_status">公開中を示す投稿のステータス</label></th>';
echo '<td><input type="text" id="cuerda_'.esc_attr($code).'_publish_status" name="cuerda_'.esc_attr($code).'_publish_status" value="';
echo esc_attr( get_option('cuerda_'.esc_attr($code).'_publish_status') );
echo '" /></td>';
echo '<td class="info"><p>何も設定しなければ初期値は publish （公開済み）です。通常はこのままですが、サイトのカスタマイズで公開中を示す投稿の post_status を変更されている場合はその値をセットしてください。</p></td>';
echo '</tr>';
}

//*************************************************************
// 画像のキャプション
//*************************************************************
function CFTL_setting_enclosure_alt($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_enclosure_alt">画像のキャプション</label></th>';
echo '<td><label><input name="cuerda_'.esc_attr($code).'_enclosure_alt" id="cuerda_'.esc_attr($code).'_enclosure_alt" type="checkbox" value="1" ';
checked(1, get_option('cuerda_'.esc_attr($code).'_enclosure_alt'));
echo '>画像のタイトルを適用する</label></td>';
echo '<td class="info"><p>デフォルトはメディア設定で「キャプション」に入力されたテキストが適用されますが、チェックすると「タイトル」に入力されたテキストを適用できます。</p></td>';
echo '</tr>';
}

//*************************************************************
// 投稿に添付された画像メディアの配信
//*************************************************************
function CFTL_setting_image($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_image">投稿に添付された画像メディアの配信</label></th>';
echo '<td><label><input name="cuerda_'.esc_attr($code).'_image" id="cuerda_'.esc_attr($code).'_image" type="checkbox" value="1"';
checked(1, get_option('cuerda_'.esc_attr($code).'_image'));
echo '>可能なら配信する</label></td>';
echo '<td class="info"><p>チェックすると投稿に紐づけた画像メディアを配信できます。外部配信先でも画像表示を行える権利をお持ちであればチェックすることをお奨めします。</p></td>';
echo '</tr>';
}

//*************************************************************
// アイキャッチに指定した画像メディアの配信
//*************************************************************
function CFTL_setting_icatch($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_icatch">アイキャッチに指定した画像メディアの配信</label></th>';
echo '<td><label><input name="cuerda_'.esc_attr($code).'_icatch" id="cuerda_'.esc_attr($code).'_icatch" type="checkbox" value="1" ';
checked(1, get_option('cuerda_'.esc_attr($code).'_icatch'));
echo '>可能なら配信する</label></td>';
echo '<td class="info"><p>チェックすると投稿に紐づけたアイキャッチ画像を配信できます。外部配信先でも画像表示を行える権利をお持ちであればチェックすることをお奨めします。</p></td>';
echo '</tr>';
}

//*************************************************************
// 本文冒頭にアイキャッチ画像を出力する
//*************************************************************
function CFTL_setting_add_icatch($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_add_icatch">本文冒頭にアイキャッチ画像を出力する</label></th>';
echo '<td><label><input name="cuerda_'.esc_attr($code).'_add_icatch" id="cuerda_'.esc_attr($code).'_add_icatch" type="checkbox" value="1" ';
checked(1, get_option('cuerda_'.esc_attr($code).'_add_icatch'));
echo '>可能なら配信する</label></td>';
echo '<td class="info"><p>チェックすると投稿に紐づけたアイキャッチ画像を本文冒頭に設置できます。キャプションまたは出典情報は自動的に配置されます。</p></td>';
echo '</tr>';
}

//*************************************************************
// a タグをアンカーテキストを含め除去する
//*************************************************************
function CFTL_setting_atag($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda'.esc_attr($code).'_atag">a タグを除去する</label></th>';
echo '<td><label><input name="cuerda_'.esc_attr($code).'_atag" id="cuerda_'.esc_attr($code).'_atag" type="checkbox" value="1" ';
checked(1, get_option('cuerda_'.esc_attr($code).'_atag'));
echo '>除去する</label></td>';
echo '<td class="info"><p>チェックすると本文中にある a 開始タグから終了タグまでアンカーテキストを含め除去されます。</p></td>';
echo '</tr>';
}

//*************************************************************
// 投稿に添付された動画メディアの配信
//*************************************************************
function CFTL_setting_video($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_video">投稿に添付された動画メディアの配信</label></th>';
echo '<td><label><input name="cuerda_'.esc_attr($code).'_video" id="cuerda_'.esc_attr($code).'_video" type="checkbox" value="1" ';
checked(1, get_option('cuerda_'.esc_attr($code).'_video'));
echo '>可能なら配信する</label></td>';
echo '<td class="info"><p>チェックすると投稿に紐づけた動画メディアを配信できます。外部配信先でも動画表示を行える権利をお持ちであればチェックすることをお奨めします。</p></td>';
echo '</tr>';
}

//*************************************************************
// 著作者表示用のカスタムフィールド名 OR 画像の出典元情報のカスタムフィールド名
//*************************************************************
function CFTL_setting_cf_creator($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_cf_creator">';
if($code==='ynf'||$code==='yjt'||$code==='gnf'||$code==='goo'||$code==='snf'||$code==='ldn'||$code==='isn'){
echo '著作者表示用のカスタムフィールド名';
}elseif($code==='lnr'||$code==='trl'){
echo '画像の出典元情報のカスタムフィールド名';
}else{
}
echo '</label></th>';
echo '<td><input type="text" id="cuerda_'.esc_attr($code).'_cf_creator" class="fullwidth" name="cuerda_'.esc_attr($code).'_cf_creator" value="';
echo esc_attr( get_option('cuerda_'.esc_attr($code).'_cf_creator') );
echo '" /></td>';
echo '<td class="info">';
if($code==='ynf'||$code==='yjt'||$code==='gnf'||$code==='goo'||$code==='snf'){
echo '<p>投稿画面のカスタムフィールドに著作者表示入力を指定している場合、そのカスタムフィールドの名前を設定してください。投稿の著者を「投稿者」ではなくカスタムフィールドに登録された内容としてフィードできます。</p><p>※ 著作者表示用のカスタムフィールドが無い、または値が空の場合は「このサイトの名称」が表示されます。</p><p>※ 「このサイトの名称」が未入力の場合は投稿の投稿者名が表示されます。</p>';
}elseif($code==='lnr'){
echo '<p>「投稿に添付された画像メディアの配信」をチェックしている場合、併せて画像の出典元情報を定義できます。投稿画面のカスタムフィールドに出典元情報を指定している場合、そのカスタムフィールドの名前を設定してください。何も設定しない場合やカスタムフィールドに出典元情報の入力が無い場合は「このサイトの名称」が出力されます。</p>';
}elseif($code==='trl'){
echo '<p>「アイキャッチに指定した画像メディアの配信」をチェックしている場合、併せて画像の出典元の情報を指定する必要があります。投稿画面のカスタムフィールドに出典元情報を指定している場合、そのカスタムフィールドの名前を設定してください。何も設定しない場合やカスタムフィールドに出典元情報の入力が無い場合は「このサイトの名称」が出力されます。</p>';
}elseif($code==='ynf'){
echo '<p>「アイキャッチに指定した画像メディアの配信」をチェックしている場合、併せて画像のクレジット情報を指定する必要があります。投稿画面のカスタムフィールドにクレジット情報を指定している場合、そのカスタムフィールドの名前を設定してください。何も設定しない場合やカスタムフィールドにクレジット情報の入力が無い場合は「このサイトの名称」が出力されます。</p>';
}else{
}
echo '</td>';
echo '</tr>';
}

//*************************************************************
// 画像の出典元情報のURLカスタムフィールド名
//*************************************************************
function CFTL_setting_cf_creator_url($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_cf_creator_url">';
echo '画像の出典元URLを入力するカスタムフィールド名';
echo '</label></th>';
echo '<td><input type="text" id="cuerda_'.esc_attr($code).'_cf_creator_url" class="fullwidth" name="cuerda_'.esc_attr($code).'_cf_creator_url" value="';
echo esc_attr( get_option('cuerda_'.esc_attr($code).'_cf_creator_url') );
echo '" /></td>';
echo '<td class="info">';
echo '<p>「アイキャッチに指定した画像メディアの配信」をチェックしている場合、併せて画像の出典元のURLを指定する必要があります。投稿画面のカスタムフィールドに画像の出典元URLを指定している場合、そのカスタムフィールドの名前を設定してください。何も設定しない場合やカスタムフィールドに出典元情報の入力が無い場合は配信元の名称が出力されます。</p>';
echo '</td>';
echo '</tr>';
}

//*************************************************************
// YouTube 用のカスタムフィールド名
//*************************************************************
function CFTL_setting_cf_youtube($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_cf_youtube">YouTube 用のカスタムフィールド名</label></th>';
echo '<td><input type="text" id="cuerda_'.esc_attr($code).'_cf_youtube" class="fullwidth" name="cuerda_'.esc_attr($code).'_cf_youtube" value="';
echo esc_attr( get_option('cuerda_'.esc_attr($code).'_cf_youtube') );
echo '" /></td>';
echo '<td class="info"><p>投稿画面のカスタムフィールドに YouTube の埋め込みを指定している場合、そのカスタムフィールドの名前を設定してください。カスタムフィールドに埋め込みタグ又は動画の埋め込みURLのいずれかがセットされていれば、本文冒頭に YouTube 動画を埋め込んで配信されます。</p><p>※ 投稿本文に直接埋め込みタグを記述している場合は、ここの設定に関わらず配信されます。</p><p>※ <a href="https://cuerda.org/spec/total/#all_022" title="投稿に埋め込まれたSNSタグ">配信先別の使用可能なSNS埋め込みはこちら</a>をご参照ください。</p></td>';
echo '</tr>';
}

//*************************************************************
// 当該リソース提供者の copyright
//*************************************************************
function CFTL_setting_copyright($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_copyright">当該リソース提供者の copyright</label></th>';
echo '<td><input type="text" id="cuerda_'.esc_attr($code).'_copyright" class="fullwidth" name="cuerda_'.esc_attr($code).'_copyright" value="';
echo esc_attr( get_option('cuerda_'.esc_attr($code).'_copyright') );
echo '" /></td>';
echo '<td class="info"><p>無指定の場合 copyright は出力されません。</p></td>';
echo '</tr>';
}

//*************************************************************
// table タグを除去する
//*************************************************************
function CFTL_setting_table($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda'.esc_attr($code).'_table">table タグを除去する</label></th>';
echo '<td><label><input name="cuerda_'.esc_attr($code).'_table" id="cuerda_'.esc_attr($code).'_table" type="checkbox" value="1" ';
checked(1, get_option('cuerda_'.esc_attr($code).'_table'));
echo '>除去する</label></td>';
echo '<td class="info"><p>チェックすると本文中にある table 開始タグから終了タグまで除去されます。';
if($code==='dcm'){
echo '<br>ドコモメディアでは table タグは使用可能タグに含まれませんが、本プラグインにて自動でスタイル設定されますので原則除去不要です。';
}else{
}
echo '</p></td>';
echo '</tr>';
}

//*************************************************************
// table タグを p に置換しインライン可する
//*************************************************************
function CFTL_setting_table_inline($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda'.esc_attr($code).'_table_inline">table タグをインライン化する</label></th>';
echo '<td><label><input name="cuerda_'.esc_attr($code).'_table_inline" id="cuerda_'.esc_attr($code).'_table_inline" type="checkbox" value="1" ';
checked(1, get_option('cuerda_'.esc_attr($code).'_table_inline'));
echo '>インライン化する</label></td>';
echo '<td class="info"><p>チェックすると本文中にある table タグの各行を1行にインライン化します。</p></td>';
echo '</tr>';
}
//*************************************************************
// table タグを p に置換しインライン可した時のデリミタ
//*************************************************************
function CFTL_setting_table_inline_delimiter($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_table_inline_delimiter">カラムの区切り文字</label></th>';
echo '<td><input type="text" id="cuerda_'.esc_attr($code).'_table_inline_delimiter" name="cuerda_'.esc_attr($code).'_table_inline_delimiter" value="';
echo esc_attr( get_option('cuerda_'.esc_attr($code).'_table_inline_delimiter') );
echo '" /></td>';
echo '<td class="info"><p>table タグをインライン化した際、各カラムの区切り文字を指定します。例（「：」や「　」など）</p></td>';
echo '</tr>';
}


//*************************************************************
// 配信先での遅延公開
//*************************************************************
function CFTL_setting_publish_delay($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_expire">配信先での遅延公開</label></th>';
echo '<td><input type="number" min="1" max="1440" id="cuerda_'.esc_attr($code).'_publish_delay" name="cuerda_'.esc_attr($code).'_publish_delay" oninput="value = onlyNumbers(value)" value="';
echo esc_attr( get_option('cuerda_'.esc_attr($code).'_publish_delay') );
echo '" /> 分後に公開</td>';
echo '<td class="info"><p>すべての配信対象となる投稿について、自サイトより遅れて配信先で公開させたい場合に指定します。何も設定しなければ初期値は 0 で配信先でもほぼ同時公開されます。投稿の公開日付から分単位で 1 ～ 1440（最長1日） の数値で指定します。</p></td>';
echo '</tr>';
}

//*************************************************************
// 配信先での遅延公開分数カスタムフィールド名
//*************************************************************
function CFTL_setting_cf_publish_delay($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_cf_publish_delay">配信先での遅延公開（分単位の数字）が入力できるカスタムフィールド名</label></th>';
echo '<td><input type="text" id="cuerda_'.esc_attr($code).'_cf_publish_delay" class="fullwidth" name="cuerda_'.esc_attr($code).'_cf_publish_delay" value="';
echo esc_attr( get_option('cuerda_'.esc_attr($code).'_cf_publish_delay') );
echo '" /></td>';
echo '<td class="info"><p>投稿画面のカスタムフィールドに配信先での遅延公開分数を指定している場合、そのカスタムフィールドの名前を設定してください。こちらは「配信先での遅延公開」の値に関わらず投稿毎の設定が優先されます。</p></td>';
echo '</tr>';
}

//*************************************************************
// 記事の有効期限
//*************************************************************
function CFTL_setting_expire($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_expire">配信先での記事公開期限</label></th>';
echo '<td><input type="number" min="1" max="365" id="cuerda_'.esc_attr($code).'_expire" name="cuerda_'.esc_attr($code).'_expire" oninput="value = onlyNumbers(value)" value="';
echo esc_attr( get_option('cuerda_'.esc_attr($code).'_expire') );
echo '" /> 日間</td>';
echo '<td class="info"><p>何も設定しなければ初期値は無期限です。記事の公開日付からの日数 1 ～ 365 の数値で指定します。設定した有効期限を過ぎた記事は、配信先から定期的に削除されます。</p></td>';
echo '</tr>';
}

//*************************************************************
// ロゴ画像のURL
//*************************************************************
function CFTL_setting_logo($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_logo">';
if($code==='gnf'){
echo 'サイトの正方形のロゴ画像のURL（必須）';
}elseif($code==='snf'){
echo 'サイトのロゴ画像URL（必須）';
}else{
}
echo '</label></th>';
echo '<td><input type="url" class="fullwidth" id="cuerda_'.esc_attr($code).'_logo" name="cuerda_'.esc_attr($code).'_logo" value="';
echo esc_url( get_option('cuerda_'.esc_attr($code).'_logo') );
echo '" /></td>';
echo '<td class="info"><p>';
if($code==='gnf'){
echo 'Gunosy 面上部に固定表示するサイトのロゴ画像を指定します。画像サイズは 120☓120px 以上を推奨します。';
}elseif($code==='snf'){
echo 'SmartView面上部に固定表示するサイトのロゴ画像を指定します。画像ファイルについての詳細は<a href="https://publishers.smartnews.com/hc/ja/articles/360015778673">サイトロゴを指定する／SmartNews 媒体運営者サポートサイト</a>を参照してください。';
}else{
}
echo '</p></td>';
echo '</tr>';
}

//*************************************************************
// サイトの横長のロゴ画像のURL
//*************************************************************
function CFTL_setting_wide_logo($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_wide_logo">サイトの横長のロゴ画像のURL</label></th>';
echo '<td><input type="url" class="fullwidth" id="cuerda_'.esc_attr($code).'_wide_logo" name="cuerda_'.esc_attr($code).'_wide_logo" value="';
echo esc_url( get_option('cuerda_'.esc_attr($code).'_wide_logo') );
echo '" /></td>';
echo '<td class="info"><p>Gunosy 面上部に固定表示するためのロゴ画像を指定します。画像サイズは縦44px（必須）、横100〜550px（推奨)とします</p></td>';
echo '</tr>';
}

//*************************************************************
// ダークモードに対応したロゴ画像のURL
//*************************************************************
function CFTL_setting_darkmodelogo($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_darkmodelogo">ダークモードに対応したロゴ画像のURL</label></th>';
echo '<td><input type="url" class="fullwidth" id="cuerda_'.esc_attr($code).'_darkmodelogo" name="cuerda_'.esc_attr($code).'_darkmodelogo" value="';
echo esc_url( get_option('cuerda_'.esc_attr($code).'_darkmodelogo') );
echo '" /></td>';
echo '<td class="info"><p>SmartView面上部に固定表示するためのダークモードに対応したサイトのロゴ画像を指定します。画像ファイルについての詳細は<a href="https://publishers.smartnews.com/hc/ja/articles/360015778673">サイトロゴを指定する／SmartNews 媒体運営者サポートサイト</a>を参照してください。</p></td>';
echo '</tr>';
}

//*************************************************************
// 代替画像のURL
//*************************************************************
function CFTL_setting_thumbnail($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_thumbnail">代替画像のURL</label></th>';
echo '<td><input type="url" class="fullwidth" id="cuerda_'.esc_attr($code).'_thumbnail" name="cuerda_'.esc_attr($code).'_thumbnail" value="';
echo esc_url( get_option('cuerda_'.esc_attr($code).'_thumbnail') );
echo '" /></td>';
echo '<td class="info"><p>投稿に紐づける画像が無い場合に、配信先の記事一覧等に代替表示させる画像の URL を指定してください。（200☓200px以上必須, 400px以上推奨）</p></td>';
echo '</tr>';
}

//*************************************************************
// アクセス解析用コード
//*************************************************************
function CFTL_setting_analytics($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_analytics">';
if($code==='snf'){
echo 'SmartView 上で動作する解析コード';
}elseif($code==='gnf'){
echo '「ニュースパス」用の記事のアクセス解析用コード';
}else{
}
echo '</label></th>';
echo '<td><textarea id="cuerda_'.esc_attr($code).'_analytics" class="fullwidth" name="cuerda_'.esc_attr($code).'_analytics">';
echo esc_attr( get_option('cuerda_'.esc_attr($code).'_analytics') );
echo '</textarea></td>';
echo '<td class="info"><p>';
if($code==='snf'){
echo 'Google アナリティクス等の解析タグを1つまで使用可能です。';
}elseif($code==='gnf'){
echo 'Google アナリティクス等の「ニュースパス」用解析タグを1つまで使用可能です。';
}else{
}
echo '</p></td>';
echo '</tr>';
}

//*************************************************************
// 「グノシー」用の記事のアクセス解析用コード
//*************************************************************
function CFTL_setting_analytics_gn($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_analytics_gn">「グノシー」用の記事のアクセス解析用コード</label></th>';
echo '<td><textarea id="cuerda_'.esc_attr($code).'_analytics_gn" class="fullwidth" name="cuerda_'.esc_attr($code).'_analytics_gn">';
echo esc_attr( get_option('cuerda_'.esc_attr($code).'_analytics_gn') );
echo '</textarea></td>';
echo '<td class="info"><p>Google アナリティクス等の「グノシー」用解析タグを1つまで使用可能です。</p></td>';
echo '</tr>';
}
//*************************************************************
// 「auスマートToday」用の記事のアクセス解析用コード
//*************************************************************
function CFTL_setting_analytics_st($code){
echo '<th><label for="cuerda_'.esc_attr($code).'_analytics_st">「auスマートToday」用の記事のアクセス解析用コード</label></th>';
echo '<td><textarea id="cuerda_'.esc_attr($code).'_analytics_st" class="fullwidth" name="cuerda_'.esc_attr($code).'_analytics_st">';
echo esc_attr( get_option('cuerda_'.esc_attr($code).'_analytics_st') );
echo '</textarea></td>';
echo '<td class="info"><p>Google アナリティクス等の「auスマートToday」用解析タグを1つまで使用可能です。</p></td>';
echo '</tr>';
}


//*************************************************************
// 広告の代替を自動表示
//*************************************************************
function CFTL_setting_rel_ad($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_rel_ad">広告の代替を自動表示</label></th>';
echo '<td><label><input name="cuerda_'.esc_attr($code).'_rel_ad" id="cuerda_'.esc_attr($code).'_rel_ad" type="checkbox" value="1" ';
checked(1, get_option('cuerda_'.esc_attr($code).'_rel_ad'));
echo '>可能なら関連記事リンクを優先表示する</label></td>';
echo '<td class="info"><p>チェックすると広告よりも優先して関連記事リンクが表示されます。関連記事リンクは表示中記事と同一カテゴリの最新記事です。</p></td>';
echo '</tr>';
}

//*************************************************************
// 【広告1本目】リンクURL
//*************************************************************
function CFTL_setting_rel_link1($code){
echo '<tr valign="top">';
echo '<th class="gr1"><label for="cuerda_'.esc_attr($code).'_rel_link1">【広告1本目】リンクURL</label></th>';
echo '<td><input type="url" class="fullwidth" id="cuerda_'.esc_attr($code).'_rel_link1" name="cuerda_'.esc_attr($code).'_rel_link1" value="';
echo esc_url( get_option('cuerda_'.esc_attr($code).'_rel_link1') );
echo '" /></td>';
echo '<td class="info"><p>link に指定する記事の URL は、自社で運営している媒体のドメインに限ります。広告情報についての詳細は<a href="https://publishers.smartnews.com/hc/ja/articles/360021466473">タイアップ記事や自社広告を記事下の枠に挿入する</a>を参照してください。</p></td>';
echo '</tr>';
}
//*************************************************************
// 【広告1本目】記事タイトル
//*************************************************************
function CFTL_setting_rel_title1($code){
echo '<tr valign="top">';
echo '<th class="gr1"><label for="cuerda_'.esc_attr($code).'_rel_title1">【広告1本目】記事タイトル</label></th>';
echo '<td><input type="text" class="fullwidth" id="cuerda_'.esc_attr($code).'_rel_title1" name="cuerda_'.esc_attr($code).'_rel_title1" value="';
echo esc_attr( get_option('cuerda_'.esc_attr($code).'_rel_title1') );
echo '" /></td>';
echo '<td class="info"><p>広告情報についての詳細は<a href="https://publishers.smartnews.com/hc/ja/articles/360021466473">タイアップ記事や自社広告を記事下の枠に挿入する</a>を参照してください。</p></td>';
echo '</tr>';
}

//*************************************************************
// 【広告1本目】サムネイル画像 URL
//*************************************************************
function CFTL_setting_rel_thumbnail1($code){
echo '<tr valign="top">';
echo '<th class="gr1"><label for="cuerda_'.esc_attr($code).'_rel_thumbnail1">【広告1本目】サムネイル画像 URL</label></th>';
echo '<td><input type="url" class="fullwidth" id="cuerda_'.esc_attr($code).'_rel_thumbnail1" name="cuerda_'.esc_attr($code).'_rel_thumbnail1" value="';
echo esc_url( get_option('cuerda_'.esc_attr($code).'_rel_thumbnail1') );
echo '" /></td>';
echo '<td class="info"><p>※必須ではありません<br>記事を代表するサムネイル画像（アスペクト比 4:3 、320 x 240 px を推奨）</p></td>';
echo '</tr>';
}

//*************************************************************
// 【広告1本目】広告主名
//*************************************************************
function CFTL_setting_rel_advertiser1($code){
echo '<tr valign="top">';
echo '<th class="gr1"><label for="cuerda_'.esc_attr($code).'_rel_advertiser1">【広告1本目】広告主名</label></th>';
echo '<td><input type="text" class="fullwidth" id="cuerda_'.esc_attr($code).'_rel_advertiser1" name="cuerda_'.esc_attr($code).'_rel_advertiser1" value="';
echo esc_attr( get_option('cuerda_'.esc_attr($code).'_rel_advertiser1') );
echo '" /></td>';
echo '<td class="info"><p>広告情報についての詳細は<a href="https://publishers.smartnews.com/hc/ja/articles/360021466473">タイアップ記事や自社広告を記事下の枠に挿入する</a>を参照してください。</p></td>';
echo '</tr>';
}

//*************************************************************
// 【広告2本目】リンクURL
//*************************************************************
function CFTL_setting_rel_link2($code){
echo '<tr valign="top">';
echo '<th class="gr2"><label for="cuerda_'.esc_attr($code).'_rel_link2">【広告2本目】リンクURL</label></th>';
echo '<td><input type="url" class="fullwidth" id="cuerda_'.esc_attr($code).'_rel_link2" name="cuerda_'.esc_attr($code).'_rel_link2" value="';
echo esc_url( get_option('cuerda_'.esc_attr($code).'_rel_link2') );
echo '" /></td>';
echo '<td class="info"><p>link に指定する記事の URL は、自社で運営している媒体のドメインに限ります。広告情報についての詳細は<a href="https://publishers.smartnews.com/hc/ja/articles/360021466473">タイアップ記事や自社広告を記事下の枠に挿入する</a>を参照してください。</p></td>';
echo '</tr>';
}

//*************************************************************
// 【広告2本目】記事タイトル
//*************************************************************
function CFTL_setting_rel_title2($code){
echo '<tr valign="top">';
echo '<th class="gr2"><label for="cuerda_'.esc_attr($code).'_rel_title2">【広告2本目】記事タイトル</label></th>';
echo '<td><input type="text" class="fullwidth" id="cuerda_'.esc_attr($code).'_rel_title2" name="cuerda_'.esc_attr($code).'_rel_title2" value="';
echo esc_attr( get_option('cuerda_'.esc_attr($code).'_rel_title2') );
echo '" /></td>';
echo '<td class="info"><p>広告情報についての詳細は<a href="https://publishers.smartnews.com/hc/ja/articles/360021466473">タイアップ記事や自社広告を記事下の枠に挿入する</a>を参照してください。</p></td>';
echo '</tr>';
}

//*************************************************************
// 【広告2本目】サムネイル画像 URL
//*************************************************************
function CFTL_setting_rel_thumbnail2($code){
echo '<tr valign="top">';
echo '<th class="gr2"><label for="cuerda_'.esc_attr($code).'_rel_thumbnail2">【広告2本目】サムネイル画像 URL</label></th>';
echo '<td><input type="url" class="fullwidth" id="cuerda_'.esc_attr($code).'_rel_thumbnail2" name="cuerda_'.esc_attr($code).'_rel_thumbnail2" value="';
echo esc_url( get_option('cuerda_'.esc_attr($code).'_rel_thumbnail2') );
echo '" /></td>';
echo '<td class="info"><p>※必須ではありません<br>記事を代表するサムネイル画像(アスペクト比 4:3 、320 x 240 px を推奨</p></td>';
echo '</tr>';
}

//*************************************************************
// 【広告2本目】広告主名
//*************************************************************
function CFTL_setting_rel_advertiser2($code){
echo '<tr valign="top">';
echo '<th class="gr2"><label for="cuerda_'.esc_attr($code).'_rel_advertiser2">【広告2本目】広告主名</label></th>';
echo '<td><input type="text" class="fullwidth" id="cuerda_'.esc_attr($code).'_rel_advertiser2" name="cuerda_'.esc_attr($code).'_rel_advertiser2" value="';
echo esc_attr( get_option('cuerda_'.esc_attr($code).'_rel_advertiser2') );
echo '" /></td>';
echo '<td class="info"><p>広告情報についての詳細は<a href="https://publishers.smartnews.com/hc/ja/articles/360021466473">タイアップ記事や自社広告を記事下の枠に挿入する</a>を参照してください。</p></td>';
echo '</tr>';
}

//*************************************************************
// Yahoo!ニュースカテゴリーマッピング
//*************************************************************
function CFTL_setting_ynf_category(){
	// インラインスタイルを追加
	$inline_style = "
		table.cat_map, 
		table.cat_map th, 
		table.cat_map td {
			border: none;
		}
		table.cat_map tbody th {
			min-width: 8em;
		}
	";
	wp_register_style('cuerda-cat-map-style', false);
	wp_add_inline_style('cuerda-cat-map-style', $inline_style);
	wp_enqueue_style('cuerda-cat-map-style');
echo '<tr valign="top">';
echo '<td colspan="2">';
echo '<table class="cat_map">';
echo '<thead>';
echo '<tr>';
echo '<th colspan="3" style="">カテゴリーを配信先カテゴリーにマッピング</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';
$args_ynf = array("orderby" => "count","order" => "DESC","hide_empty" => false);
$categories = get_categories( $args_ynf );
foreach( $categories as $category ){
$cat_id = $category->term_id;
$cat_count = intval($category->count);
$cat_name = esc_html($category->name);
$op_name_pre = 'cuerda_ynf_category_';
$op_name = $op_name_pre.$cat_id;

$val_pol = '11000000,pol';
$val_soci = '14000000,soci';
$val_peo = '14024000,peo';
$val_bus_all = '4017000,bus_all';
$val_brf = '4008000,brf';
$val_biz = '4008026,biz';
$val_ind = '4016000,ind';
$val_ent = '1022000,ent';
$val_musi = '1011000,musi';
$val_movi = '1005000,movi';
$val_game = '10900000,game';
$val_asent = '1029000,asent';
$val_spo = '15000000,spo';
$val_base = '15007000,base';
$val_socc = '15054000,socc';
$val_moto = '15901000,moto';
$val_horse = '15030000,horse';
$val_golf = '15027000,golf';
$val_fight = '15900000,fight';
$val_sci = '13000000,sci';
$val_sctch = '13009000,sctch';
$val_prod = '4003000,prod';
$val_int = '91000000,int';
$val_cn = '91000000,cn';
$val_kr = '91000000,kr';
$val_asia = '91001000,asia';
$val_n_ame = '91002000,n_ame';
$val_s_ame = '91003000,s_ame';
$val_eurp = '91004000,eurp';
$val_m_est = '91005000,m_est';
$val_life = '10000000,life';
$val_hlth = '7000000,hlth';
$val_env = '6000000,env';
$val_cul = '1000000,cul';

echo '<tr><th>'.$cat_name.' ('.$cat_count.')';
echo '</th><td class="sep2">⇒</td>';
echo '<td>';
echo '<select class="cat_select" name="cuerda_ynf_category_';
echo $category->term_id;
echo '" id="cuerda_ynf_category_';
echo $category->term_id;
echo '">';
echo '<option value="">配信カテゴリ選択</option>';

echo '<option value="';
echo esc_attr($val_pol);
echo '" ';
selected($val_pol,get_option($op_name));
echo '>国内／政治</option>';
echo '<option value="';
echo esc_attr($val_soci);
echo '" ';
selected($val_soci,get_option($op_name));
echo '>国内／社会</option>';
echo '<option value="';
echo esc_attr($val_peo);
echo '" ';
selected($val_peo,get_option($op_name));
echo '>国内／人</option>';
echo '<option value="';
echo esc_attr($val_bus_all);
echo '" ';
selected($val_bus_all,get_option($op_name));
echo '>経済／経済総合</option>';
echo '<option value="';
echo esc_attr($val_brf);
echo '" ';
selected($val_brf,get_option($op_name));
echo '>経済／市況</option>';
echo '<option value="';
echo esc_attr($val_biz);
echo '" ';
selected($val_biz,get_option($op_name));
echo '>経済／株式</option>';
echo '<option value="';
echo esc_attr($val_ind);
echo '" ';
selected($val_ind,get_option($op_name));
echo '>経済／産業</option>';
echo '<option value="';
echo esc_attr($val_ent);
echo '" ';
selected($val_ent,get_option($op_name));
echo '>エンターテインメント／エンタメ総合</option>';
echo '<option value="';
echo esc_attr($val_musi);
echo '" ';
selected($val_musi,get_option($op_name));
echo '>エンターテインメント／音楽</option>';
echo '<option value="';
echo esc_attr($val_movi);
echo '" ';
selected($val_movi,get_option($op_name));
echo '>エンターテインメント／映画</option>';
echo '<option value="';
echo esc_attr($val_game);
echo '" ';
selected($val_game,get_option($op_name));
echo '>エンターテインメント／ゲーム</option>';
echo '<option value="';
echo esc_attr($val_asent);
echo '" ';
selected($val_asent,get_option($op_name));
echo '>エンターテインメント／アジア・韓流</option>';
echo '<option value="';
echo esc_attr($val_spo);
echo '" ';
selected($val_spo,get_option($op_name));
echo '>スポーツ／スポーツ総合</option>';
echo '<option value="';
echo esc_attr($val_base);
echo '" ';
selected($val_base,get_option($op_name));
echo '>スポーツ／野球</option>';
echo '<option value="';
echo esc_attr($val_socc);
echo '" ';
selected($val_socc,get_option($op_name));
echo '>スポーツ／サッカー</option>';
echo '<option value="';
echo esc_attr($val_moto);
echo '" ';
selected($val_moto,get_option($op_name));
echo '>スポーツ／モータースポーツ</option>';
echo '<option value="';
echo esc_attr($val_horse);
echo '" ';
selected($val_horse,get_option($op_name));
echo '>スポーツ／競馬</option>';
echo '<option value="';
echo esc_attr($val_golf);
echo '" ';
selected($val_golf,get_option($op_name));
echo '>スポーツ／ゴルフ</option>';
echo '<option value="';
echo esc_attr($val_fight);
echo '" ';
selected($val_fight,get_option($op_name));
echo '>スポーツ／格闘技</option>';
echo '<option value="';
echo esc_attr($val_sci);
echo '" ';
selected($val_sci,get_option($op_name));
echo '>IT・科学／IT総合</option>';
echo '<option value="';
echo esc_attr($val_sctch);
echo '" ';
selected($val_sctch,get_option($op_name));
echo '>IT・科学／科学</option>';
echo '<option value="';
echo esc_attr($val_prod);
echo '" ';
selected($val_prod,get_option($op_name));
echo '>IT・科学／製品</option>';
echo '<option value="';
echo esc_attr($val_int);
echo '" ';
selected($val_int,get_option($op_name));
echo '>国際／国際総合</option>';
echo '<option value="';
echo esc_attr($val_cn);
echo '" ';
selected($val_cn,get_option($op_name));
echo '>国際／中国・台湾</option>';
echo '<option value="';
echo esc_attr($val_kr);
echo '" ';
selected($val_kr,get_option($op_name));
echo '>国際／韓国・北朝鮮</option>';
echo '<option value="';
echo esc_attr($val_asia);
echo '" ';
selected($val_asia,get_option($op_name));
echo '>国際／アジア・オセアニア</option>';
echo '<option value="';
echo esc_attr($val_n_ame);
echo '" ';
selected($val_n_ame,get_option($op_name));
echo '>国際／北米</option>';
echo '<option value="';
echo esc_attr($val_s_ame);
echo '" ';
selected($val_s_ame,get_option($op_name));
echo '>国際／中南米</option>';
echo '<option value="';
echo esc_attr($val_eurp);
echo '" ';
selected($val_eurp,get_option($op_name));
echo '>国際／ヨーロッパ</option>';
echo '<option value="';
echo esc_attr($val_m_est);
echo '" ';
selected($val_m_est,get_option($op_name));
echo '>国際／中東・アフリカ</option>';
echo '<option value="';
echo esc_attr($val_life);
echo '" ';
selected($val_life,get_option($op_name));
echo '>ライフ／ライフ総合</option>';
echo '<option value="';
echo esc_attr($val_hlth);
echo '" ';
selected($val_hlth,get_option($op_name));
echo '>ライフ／ヘルス</option>';
echo '<option value="';
echo esc_attr($val_env);
echo '" ';
selected($val_env,get_option($op_name));
echo '>ライフ／環境</option>';
echo '<option value="';
echo esc_attr($val_cul);
echo '" ';
selected($val_cul,get_option($op_name));
echo '>ライフ／文化・アート</option>';

echo '</select>';
echo '</td>';
echo '</tr>';
}
unset($category);
echo '</tbody>';
echo '</table>';
echo '</td>';
echo '<td class="info"><p>サイトのカテゴリーをYahoo!ニュースのカテゴリーに変換します。</p><p>（　）カッコ内の数字は該当する投稿数です。</p></td>';
echo '</tr>';
}
//*************************************************************
// 配信先 FTP サーバーへ記事・写真データをPUTする
//*************************************************************
function CFTL_setting_ftp_put_ynf(){
echo '<tr valign="top">';
echo '<th><label for="cuerda_ynf_ftp_put">FTP サーバーへ配信する</label></th>';
echo '<td><label><input name="cuerda_ynf_ftp_put" id="cuerda_ynf_ftp_put" type="checkbox" value="1" ';
checked(1, get_option('cuerda_ynf_ftp_put'));
echo '>FTP 配信する</label></td>';
echo '<td class="info"><p>チェックすると以下で設定したFTPサーバーに記事・写真データを配信できます。</p></td>';
echo '</tr>';
echo '<tr valign="top">';
echo '<th>FTPサーバーへの最新配信結果</th>';
// ローカルファイルのパス
$file_path = plugin_dir_path(__FILE__) . 'ftp_result_ynf.php';
global $wp_filesystem;
// WP_Filesystemの初期化
if ( ! function_exists( 'WP_Filesystem' ) ) {
require_once( ABSPATH . 'wp-admin/includes/file.php' );
}
$creds = request_filesystem_credentials( site_url() );
// WP_Filesystem の初期化を試みる
if ( ! WP_Filesystem( $creds ) ) {
echo '<td colspan="2"><p>ファイルシステムが初期化できませんでした。FTP設定を確認してください。</p></td>';
echo '</tr>';
return;
}
// 初期化が成功していれば、wp_filesystem を使ってファイルの存在を確認
if ( $wp_filesystem->exists( $file_path ) ) {
$ftp_result_ynf = $wp_filesystem->get_contents( $file_path );
} else {
$ftp_result_ynf = false; // デフォルト値
}
echo '<td colspan="2"><p>';
$ynf_ftp_put_option = get_option('cuerda_ynf_ftp_put',0);
if($ynf_ftp_put_option == ''){$ynf_ftp_put = 0;}else{$ynf_ftp_put = $ynf_ftp_put_option;}
// FTP 配信するにチェックがある場合
if($ynf_ftp_put == 1 && !empty($ftp_result_ynf)){
echo $ftp_result_ynf;
}else{
echo '現在FTP配信していません。';
}
echo '</p></td>';
echo '</tr>';
}
//*************************************************************
// FTP サーバーのホスト名
//*************************************************************
function CFTL_setting_ftp_server($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_ftp_server">FTP ホスト名</label></th>';
echo '<td><input type="text" id="cuerda_'.esc_attr($code).'_ftp_server" class="width50" name="cuerda_'.esc_attr($code).'_ftp_server" value="';
echo esc_attr( get_option('cuerda_'.esc_attr($code).'_ftp_server') );
echo '" /></td>';
echo '<td class="info">配信先にお尋ねください。<br>※設定例 → v2ftp.castle.yahoofs.jp</td>';
echo '</tr>';
}
//*************************************************************
// FTP サーバーのユーザー名
//*************************************************************
function CFTL_setting_ftp_user_name($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_ftp_user_name">FTP ユーザー名</label></th>';
echo '<td><input type="text" id="cuerda_'.esc_attr($code).'_ftp_user_name" class="width50" name="cuerda_'.esc_attr($code).'_ftp_user_name" value="';
echo esc_attr( get_option('cuerda_'.esc_attr($code).'_ftp_user_name') );
echo '" /></td>';
echo '<td class="info">配信先にお尋ねください。</td>';
echo '</tr>';
}
//*************************************************************
// FTP サーバーのパスワード
//*************************************************************
function CFTL_setting_ftp_password($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_ftp_password">FTP パスワード</label></th>';
echo '<td><div id="fieldPassword"><input type="password" id="cuerda_'.esc_attr($code).'_ftp_password" class="width80" name="cuerda_'.esc_attr($code).'_ftp_password" value="';
echo esc_attr( get_option('cuerda_'.esc_attr($code).'_ftp_password') );
echo '" />　<span id="buttonEye" class="fa fa-eye" onclick="pushHideButton()"></span></div></td>';
echo '<td class="info">配信先にお尋ねください。</td>';
echo '</tr>';
}
//*************************************************************
// FTP サーバーのリモートディレクトリ
//*************************************************************
function CFTL_setting_ftp_remote_dir($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_ftp_remote_dir">FTP リモートディレクトリ</label></th>';
echo '<td><input type="text" id="cuerda_'.esc_attr($code).'_ftp_remote_dir" class="width50" name="cuerda_'.esc_attr($code).'_ftp_remote_dir" value="';
echo esc_attr( get_option('cuerda_'.esc_attr($code).'_ftp_remote_dir') );
echo '" /></td>';
echo '<td class="info">配信先にお尋ねください。<br>※設定例（先頭のスラッシュは不要です。） → feed</td>';
echo '</tr>';
}
//*************************************************************
// Yahoo!ニュースの媒体コード
//*************************************************************
function CFTL_setting_ynf_id(){
echo '<tr valign="top">';
echo '<th><label for="cuerda_ynf_id">Yahoo!ニュース媒体コード</label></th>';
echo '<td><input type="text" id="cuerda_ynf_id" class="width50" name="cuerda_ynf_id" value="';
echo esc_attr( get_option('cuerda_ynf_id') );
echo '" /></td>';
echo '<td class="info">配信先にお尋ねください。</td>';
echo '</tr>';
}

//*************************************************************
// RSSフィードのLDAPユーザー名
//*************************************************************
function CFTL_setting_ldap_user($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_ldap_user">ベーシック認証ユーザー名</label></th>';
echo '<td><input type="text" id="cuerda_'.esc_attr($code).'_ldap_user" class="width50" name="cuerda_'.esc_attr($code).'_ldap_user" value="';
echo esc_attr( get_option('cuerda_'.esc_attr($code).'_ldap_user') );
echo '" /></td>';
echo '<td class="info">通常は設定する必要はありません。開発・検証環境等でベーシック認証を設定している場合はユーザー名を入力してください。</td>';
echo '</tr>';
}
//*************************************************************
// RSSフィードのLDAPパスワード
//*************************************************************
function CFTL_setting_ldap_pass($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_ldap_pass">ベーシック認証パスワード</label></th>';
echo '<td><input type="text" id="cuerda_'.esc_attr($code).'_ldap_pass" class="width50" name="cuerda_'.esc_attr($code).'_ldap_pass" value="';
echo esc_attr( get_option('cuerda_'.esc_attr($code).'_ldap_pass') );
echo '" /></td>';
echo '<td class="info">通常は設定する必要はありません。開発・検証環境等でベーシック認証を設定している場合はパスワードを入力してください。</td>';
echo '</tr>';
}
//*************************************************************
// Yahoo!ニュース記事種別
//*************************************************************
function CFTL_setting_articletype(){
echo '<tr valign="top">';
echo '<th><label for="cuerda_ynf_articletype">Yahoo!ニュース記事種別</label></th>';
// テキストニュース
echo '<td><label><input name="cuerda_ynf_articletype" type="radio" value="straight" ';
checked('straight', get_option('cuerda_ynf_articletype'));
echo '>テキストニュースとして契約した</label><br>';
// 雑誌ニュース
echo '<label><input name="cuerda_ynf_articletype" type="radio" value="feature" ';
checked('feature', get_option('cuerda_ynf_articletype'));
echo '>雑誌ニュースとして契約した</label></td>';
echo '<td class="info"><p>記事の種別が不明な場合、配信先にお尋ねください。</p></td>';
echo '</tr>';
}
//*************************************************************
// 記事の要約カスタムフィールド
//*************************************************************
function CFTL_setting_article_summary($code){
echo '<tr valign="top">';
echo '<th><label for="cuerda_'.esc_attr($code).'_article_summary">';
echo '記事の要約分を入力するカスタムフィールド名';
echo '</label></th>';
echo '<td><input type="text" id="cuerda_'.esc_attr($code).'_article_summary" class="fullwidth" name="cuerda_'.esc_attr($code).'_article_summary" value="';
echo esc_attr( get_option('cuerda_'.esc_attr($code).'_article_summary') );
echo '" /></td>';
echo '<td class="info">';
echo '<p>通常は何も設定しませんが、配信先との契約条件等で必要になる場合があります。</p>';
echo '</td>';
echo '</tr>';
}
//*************************************************************
// デバッグモード
//*************************************************************
function CFTL_setting_debug(){
echo '<tr valign="top">';
echo '<th><label for="cuerda_ynf_debug">デバッグモード</label></th>';
echo '<td><label><input name="cuerda_ynf_debug" id="cuerda_ynf_debug" type="checkbox" value="1" ';
checked(1, get_option('cuerda_ynf_debug'));
echo '>オンにする</label></td>';
echo '<td class="info"><p>配信がうまく行かない時、クエルダの担当者から依頼があったらオンにしてください。クエルダの担当者が問題を解決する手助けになります。尚、オンのままでも本番配信に影響はありません。</p></td>';
echo '</tr>';
}
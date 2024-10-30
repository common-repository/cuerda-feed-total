<?php 
// cerda（クエルダ）は本プログラムソースコードの著作権を保有しています。
// Copyright (C) 2020 CUERDA(https://cuerda.org).
if(!defined('ABSPATH')){
die('Forbidden');
}
require 'version.php';
$sanitized_server_name = isset($_SERVER['SERVER_NAME']) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_NAME'] ) ) : '';
$sanitized_user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) ) : '';
$unslashed_remote_addr = isset($_SERVER['REMOTE_ADDR']) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
$sanitized_remote_addr = $unslashed_remote_addr ? filter_var( $unslashed_remote_addr, FILTER_VALIDATE_IP ) : '';
$unslashed_request_uri = isset($_SERVER['REQUEST_URI']) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
$sanitize_request_uri = sanitize_text_field( $unslashed_request_uri );
$header_response      = 'Content-Type: application/rss+xml; charset=utf-8';
$header_expires       = 'Expires: ';
$header_cache_control = 'Cache-Control: private, max-age=';
$timezone             = 'Asia/Tokyo';
$gmdate_format        = DATE_RFC2822;
$url_param            = esc_html($sanitize_request_uri);
$config_version       = 'version.php';
$ini_user             = 'ini_user.php';
$ini_content          = 'ini_content.php';
$func_admin           = 'func_admin.php';
$mod_channel          = 'mod_channel.php';
$mod_item             = 'mod_item.php';
$expires_key          = 'cuerda_total_expires';
$expires_default      = 20;
$expires_option       = get_option($expires_key,$expires_default);
if($expires_option == ''){
$expires              = $expires_default;
}else{
$expires              = $expires_option;
}
$tab1 = "\t";
$tab2 = "\t\t";
$tab3 = "\t\t\t";
$tab4 = "\t\t\t\t";
$tab5 = "\t\t\t\t\t";
$tab6 = "\t\t\t\t\t\t";
$tab7 = "\t\t\t\t\t\t\t";
$documenttype         = '<?xml version="1.0" encoding="utf-8" ?>'.PHP_EOL;
$rss_xmlns_ynf        = '【Yahoo!ニュース】配信結果'.PHP_EOL;
$rss_xmlns_yjt        = 
'<rss version="2.0" xmlns:yj="http://cmspf.yahoo.co.jp/rss" yj:version="1.0">
	<channel>
';
$rss_xmlns_goo        = 
'<rss version="2.0"
 xmlns:content="http://purl.org/rss/1.0/modules/content/"
 xmlns:dc="http://purl.org/dc/elements/1.1/"
 xmlns:goonews="http://news.goo.ne.jp/rss/2.0/news/goonews/"
 xmlns:smp="http://news.goo.ne.jp/rss/2.0/news/smp/"
>
	<channel>
';
$rss_xmlns_dcm        = 
'<rss version="2.0">
	<channel>
';
$rss_xmlns_spb        = 
'<rss version="2.0">
	<channel>
';
$rss_xmlns_lnr        = 
'<rss version="2.0"
 xmlns:oa="http://news.line.me/rss/1.0/oa"
 xmlns:content="http://purl.org/rss/1.0/modules/content/"
 xmlns:wfw="http://wellformedweb.org/CommentAPI/"
 xmlns:dc="http://purl.org/dc/elements/1.1/"
 xmlns:atom="http://www.w3.org/2005/Atom"
>
	<channel>
';
$rss_xmlns_snf        = 
'<rss version="2.0"
 xmlns:content="http://purl.org/rss/1.0/modules/content/"
 xmlns:dc="http://purl.org/dc/elements/1.1/"
 xmlns:media="http://search.yahoo.com/mrss/"
 xmlns:snf="http://www.smartnews.be/snf"
>
	<channel>
';
$rss_xmlns_gnf       = 
'<rss version="2.0"
 xmlns:media="http://search.yahoo.com/mrss/"
 xmlns:content="http://purl.org/rss/1.0/modules/content/"
 xmlns:dc="http://purl.org/dc/elements/1.1/"
 xmlns:gnf="http://assets.gunosy.com/media/gnf"
>
	<channel>
';
$rss_xmlns_ldn       = 
'<rss version="2.0" xmlns:ldnfeed="http://news.livedoor.com/ldnfeed/1.1/" 
xmlns:atom="http://www.w3.org/2005/Atom">
	<channel>
';
$rss_xmlns_isn       = 
'<rss version="2.0">
	<channel>
';
$rss_xmlns_ant       = 
'<rss version="2.0" xmlns:snf="https://antenna.jp/" xmlns:content="http://purl.org/rss/1.0/modules/content/">
	<channel>
';
$rss_xmlns_trl       = 
'<rss version="2.0"
xmlns:content="http://purl.org/rss/1.0/modules/content/"
xmlns:atom="http://www.w3.org/2005/Atom"
xmlns:trill="https://trilltrill.jp/rss-module/">
	<channel>
';

if(strstr($url_param,'ynf')){
$channel_end ='';
}else{
$channel_end ='	</channel>
</rss>
';
}
if(strstr($url_param,'goo')){
$rss_xmlns = $rss_xmlns_goo;
$feed_for = 'goo';
}elseif(strstr($url_param,'ynf')){
$rss_xmlns = $rss_xmlns_ynf;
$feed_for = 'ynf';
}elseif(strstr($url_param,'yjt')){
$rss_xmlns = $rss_xmlns_yjt;
$feed_for = 'yjt';
}elseif(strstr($url_param,'dcm')){
$rss_xmlns = $rss_xmlns_dcm;
$feed_for = 'dcm';
}elseif(strstr($url_param,'spb')){
$rss_xmlns = $rss_xmlns_spb;
$feed_for = 'spb';
}elseif(strstr($url_param,'snf')){
$rss_xmlns = $rss_xmlns_snf;
$feed_for = 'snf';
}elseif(strstr($url_param,'gnf')){
$rss_xmlns = $rss_xmlns_gnf;
$feed_for = 'gnf';
}elseif(strstr($url_param,'lnr')){
$rss_xmlns = $rss_xmlns_lnr;
$feed_for = 'lnr';
}elseif(strstr($url_param,'ldn')){
$rss_xmlns = $rss_xmlns_ldn;
$feed_for = 'ldn';
}elseif(strstr($url_param,'isn')){
$rss_xmlns = $rss_xmlns_isn;
$feed_for = 'isn';
}elseif(strstr($url_param,'ant')){
$rss_xmlns = $rss_xmlns_ant;
$feed_for = 'ant';
}elseif(strstr($url_param,'trl')){
$rss_xmlns = $rss_xmlns_trl;
$feed_for = 'trl';
}else{
};
// HTTP_USER_AGENTが存在するかどうかを確認する
if(isset($_SERVER['HTTP_USER_AGENT'])){
$referer_ua      = esc_html( $sanitized_user_agent );
}else{
$referer_ua      = 'No_USER_AGENT';
}
$feed_to         = $feed_for . ' ';
$modelname       = 'feed_cuerda_' . $feed_for . '.php';
$cuerdaURL       = "https://cuerda.org/feed/";
$userDir         = "user/";
$cuerdaID        = $cuerdaURL . $userDir . esc_html($sanitized_server_name) . "/authentication/" . $modelname;
$referer_ip      = esc_html($sanitized_remote_addr);
$http_user_agent = $referer_ip . " - " . $referer_ua;
$referer         = "Referer: " . $http_user_agent;
if (strstr($url_param, 'admin=true')) {
    $admin_comment = true;
    $useragent     = $feed_to . $version . " by Admin";
} else {
    $admin_comment = false;
    $useragent     = $feed_to . $version . " by User";
}
// リクエストのURL
$base_url = $cuerdaID;

// HTTP APIの引数
$args = array(
    'method'    => 'GET',
    'user-agent' => $useragent,
    'headers'   => array(
        'Referer' => $http_user_agent,
    ),
    'sslverify' => false,  // SSL検証をスキップ (必要に応じてfalseに設定)
);

// リクエストの送信
$response = wp_remote_get($base_url, $args);

// レスポンスのステータスコード取得
if (is_wp_error($response)) {
    $error_message = $response->get_error_message();
    // エラーハンドリング
    echo "Something went wrong: $error_message";
} else {
    $code = wp_remote_retrieve_response_code($response);
}

// 各エラーメッセージ
$cuerda403error    = 'cuerda 認証エラーです。';
$cuerda404error    = 'cuerda 認証キーがありません。';
$cuerda500error    = 'cuerda 認証サーバーの一時的なエラーです。しばらくお待ちください。';
$cuerda_die_error  = 'cuerda 認証サーバーのメンテナンス中です。しばらくお待ちください。';


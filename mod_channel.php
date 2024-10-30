<?php
// cerda（クエルダ）は本プログラムソースコードの著作権を保有しています。
// Copyright (C) 2020 CUERDA(https://cuerda.org).
if(!defined('ABSPATH')){
die('Forbidden');
}

// title 要素の出力
if($feed_for !== 'ynf'){
	echo "\t\t".'<title><![CDATA[';
	if(!empty($channel_title)){
		echo esc_html($channel_title);
	}else{
		echo esc_html(bloginfo('name'));
	}
	echo ']]></title>'.PHP_EOL;
}else{
}
// link 要素の出力
if($feed_for !== 'ynf'){
	echo "\t\t".'<link>'.esc_url(home_url('/')).'</link>'.PHP_EOL;
}else{
}
// description 要素の出力
if($feed_for !== 'ynf'){
	echo "\t\t".'<description><![CDATA[';
	echo esc_html(bloginfo('description'));
	echo ']]></description>'.PHP_EOL;
}else{
}
// language 要素の出力
if($feed_for === 'isn'||$feed_for === 'yjt'||$feed_for === 'ynf'){
}else{
echo "\t\t".'<language>ja</language>'.PHP_EOL;
}
// copyright 要素の出力
if($feed_for === 'gnf'||$feed_for === 'dcm'||$feed_for === 'spb'||$feed_for === 'ant'){
	if(!empty($copyright)){
	echo "\t\t"."<copyright><![CDATA[";
	echo esc_html($copyright);
	echo "]]></copyright>"."\n";
	}else{
	}
}else{
}

// pubDate 要素の出力
if($feed_for === 'snf'||$feed_for === 'dcm'){
echo "\t\t".'<pubDate>';
echo mysql2date(DATE_RFC2822,get_lastpostmodified('blog'),false);
echo '</pubDate>'.PHP_EOL;
}else{
}

// lastBuildDate 要素の出力
if($feed_for === 'yjt'||$feed_for === 'lnr'||$feed_for === 'gnf'||$feed_for === 'isn'||$feed_for === 'ant'||$feed_for === 'spb'){
echo "\t\t".'<lastBuildDate>';
echo mysql2date(DATE_RFC2822,get_lastpostmodified('blog'),false);
echo '</lastBuildDate>'.PHP_EOL;
}else{
}

// ttl 要素の出力
if($feed_for === 'snf'||$feed_for === 'gnf'||$feed_for === 'spb'){
echo "\t\t".'<ttl>';
echo $ttl;
echo '</ttl>'.PHP_EOL;
}else{
}

// snf:logo 要素の出力
if($feed_for === 'snf'&&!empty($logo)){
echo "\t\t".'<snf:logo>'.PHP_EOL;
echo "\t\t\t".'<url>'.esc_url($logo).'</url>'.PHP_EOL;
echo "\t\t".'</snf:logo>'.PHP_EOL;
}else{
}

// snf:darkModelogo 要素の出力
if($feed_for === 'snf'&&!empty($darkmodelogo)){
echo "\t\t".'<snf:darkModelogo>'.PHP_EOL;
echo "\t\t\t".'<url>'.esc_url($darkmodelogo).'</url>'.PHP_EOL;
echo "\t\t".'</snf:darkModelogo>'.PHP_EOL;
}else{
}

// image 要素の出力
if($feed_for === 'gnf'&&!empty($logo)){
echo "\t\t".'<image>'.PHP_EOL;
echo "\t\t\t".'<url>'.$logo.'</url>'.PHP_EOL;
echo "\t\t\t".'<title><![CDATA[';
echo esc_html(bloginfo('name'));
echo ']]></title>'.PHP_EOL;
echo "\t\t\t".'<link>'.esc_url(home_url('/')).'</link>'.PHP_EOL;
echo "\t\t".'</image>'.PHP_EOL;
}else{
}

// image 要素の出力
if($feed_for === 'gnf'&&!empty($wide_logo)){
echo "\t\t".'<gnf:wide_image_link>'.esc_url($wide_logo).'</gnf:wide_image_link>'.PHP_EOL;
}else{
}

/* **************************************************************************
ノアドットの関連リンクを生成
************************************************************************** */
if($rel_nor_set !== 0 && !empty($nordot_unit_id)) {
	// パラメータを設定
	$nordot_unit_id = $nordot_unit_id_option;
	$nordot_cu_id = !empty($nordot_cu_id_option) ? "?c=" . $nordot_cu_id_option : "";
	$nordot_params = array(
		"query"     => "unit_id:" . $nordot_unit_id,
		"limit"     => "6",
		"offset"    => "0",
		"sort"      => "published_at",
		"direction" => "desc",
	);
	$nordot_query_string = http_build_query($nordot_params, '', '&', PHP_QUERY_RFC3986);
	// WordPressのHTTP APIを使用してリクエストを送信
	$nordot_url = "https://api.nordot.jp/v1.0/search/contentsholder/posts.list?" . $nordot_query_string;
	$args = array(
		'headers' => array(
			'Authorization' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpYXQiOjE2Nzg3NzEwNTYsImlzcyI6ImFwaS5ub3Jkb3QuanAiLCJqdGkiOiIxMDA4MjQyOTcwNDkzNzE0NDMyIiwic3ViIjoiMTAwODI0MjM3OTQzMDYwODg5NiIsInR0eSI6ImN1X3VuaXRfaWQifQ.E1OiBPYVH6DSpfSuuY77Lg0OS9DyyN1Jd5p1Bpvo2mg'
		),
		'timeout' => 15,
		'sslverify' => false
	);
	// リクエストを実行
	$response = wp_remote_get($nordot_url, $args);

	// エラーチェック
	if (is_wp_error($response)) {
		echo "\t\t".'<!-- WP Error: '.esc_html($response->get_error_message()).' -->'.PHP_EOL;
		return;
	}

	// レスポンスデータの処理
	$nordot_response_body = wp_remote_retrieve_body($response);
	$nordot_data = json_decode($nordot_response_body, true);

	// エラーレスポンス処理
	$nordot_no_access_token = 'アクセストークンを指定してください。';
	$nordot_invalid_access_token = 'アクセストークンが正しくありません。';
	$nordot_server_error = 'サーバ内部でのシステムエラーです。';
	$nordot_service_unavailable = '只今メンテナンスのため一時的に使用不可です。';

	if (isset($nordot_data['error'])) {
		$nordot_error_reason = $nordot_data['error'];
		switch ($nordot_error_reason) {
			case 'no_access_token':
				echo "\t\t".'<!-- ' . esc_html($nordot_no_access_token) . ' -->'.PHP_EOL;
				break;
			case 'invalid_access_token':
				echo "\t\t".'<!-- ' . esc_html($nordot_invalid_access_token) . ' -->'.PHP_EOL;
				break;
			case 'server_error':
				echo "\t\t".'<!-- ' . esc_html($nordot_server_error) . ' -->'.PHP_EOL;
				break;
			case 'service_unavailable':
				echo "\t\t".'<!-- ' . esc_html($nordot_service_unavailable) . ' -->'.PHP_EOL;
				break;
			default:
				echo "\t\t".'<!-- Unknown error: ' . esc_html($nordot_error_reason) . ' -->'.PHP_EOL;
				break;
		}
	}
}

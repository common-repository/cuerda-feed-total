<?php 
// cerda（クエルダ）は本プログラムソースコードの著作権を保有しています。
// Copyright (C) 2020 CUERDA(https://cuerda.org).
if(!defined('ABSPATH')){
die('Forbidden');
}

// goo
if(strstr($url_param,'goo')){
$isp = 'goo';
$ttl_default = '';
$posts_per_page_default = '100';
$after_modified_default = '2';
$after_modified_default_day = '2';
$after_date_default = '2';
$after_date_default_day = '2';
$rel_count_default = '5';

// ynf
}elseif(strstr($url_param,'ynf')){
$isp = 'ynf';
$ttl_default = '';
$posts_per_page_default = '1';
$after_modified_default = '1';
$after_modified_default_day = '1';
$after_date_default = '1';
$after_date_default_day = '1';
$rel_count_default = '5';

// yjt
}elseif(strstr($url_param,'yjt')){
$isp = 'yjt';
$ttl_default = '';
$posts_per_page_default = '100';
$after_modified_default = '2';
$after_modified_default_day = '2';
$after_date_default = '2';
$after_date_default_day = '2';
$rel_count_default = '5';

// dcm
}elseif(strstr($url_param,'dcm')){
$isp = 'dcm';
$ttl_default = '';
$posts_per_page_default = '50';
$after_modified_default = '2';
$after_modified_default_day = '2';
$after_date_default = '2';
$after_date_default_day = '2';
$rel_count_default = '3';

// spb
}elseif(strstr($url_param,'spb')){
$isp = 'spb';
$ttl_default = '15';
$posts_per_page_default = '50';
$after_modified_default = '2';
$after_modified_default_day = '2';
$after_date_default = '2';
$after_date_default_day = '2';
$rel_count_default = '5';

// snf
}elseif(strstr($url_param,'snf')){
$isp = 'snf';
$ttl_default = '5';
$posts_per_page_default = '100';
$after_modified_default = '14';
$after_modified_default_day = '14';
$after_date_default = '14';
$after_date_default_day = '14';
$rel_count_default = '2';

// gnf
}elseif(strstr($url_param,'gnf')){
$isp = 'gnf';
$ttl_default = '15';
$posts_per_page_default = '100';
$after_modified_default = '3';
$after_modified_default_day = '3';
$after_date_default = '3';
$after_date_default_day = '3';
$rel_count_default = '3';

// lnf
}elseif(strstr($url_param,'lnr')){
$isp = 'lnr';
$ttl_default = '';
$posts_per_page_default = '30';
$after_modified_default = '2';
$after_modified_default_day = '2';
$after_date_default = '2';
$after_date_default_day = '2';
$rel_count_default = '5';

// ldn
}elseif(strstr($url_param,'ldn')){
$isp = 'ldn';
$ttl_default = '';
$posts_per_page_default = '30';
$after_modified_default = '2';
$after_modified_default_day = '2';
$after_date_default = '2';
$after_date_default_day = '2';
$rel_count_default = '3';

// isn
}elseif(strstr($url_param,'isn')){
$isp = 'isn';
$ttl_default = '';
$posts_per_page_default = '30';
$after_modified_default = '2';
$after_modified_default_day = '2';
$after_date_default = '2';
$after_date_default_day = '2';
$rel_count_default = '3';

// ant
}elseif(strstr($url_param,'ant')){
$isp = 'ant';
$ttl_default = '';
$posts_per_page_default = '30';
$after_modified_default = '2';
$after_modified_default_day = '2';
$after_date_default = '2';
$after_date_default_day = '2';

// trl
}elseif(strstr($url_param,'trl')){
$isp = 'trl';
$ttl_default = '';
$posts_per_page_default = '30';
$after_modified_default = '2';
$after_modified_default_day = '2';
$after_date_default = '2';
$after_date_default_day = '2';
$rel_count_default = '3';

}else{
}

	// 公開中を示す記事のステータス
	$publish_status_option = get_option('cuerda_total_publish_status',array('publish'));
	if($publish_status_option == ''){$publish_status = array('publish');}else{$publish_status = $publish_status_option;}

	// 処理する記事のステータス
	if($isp === 'trl'){
		$post_status_option = get_option('cuerda_total_post_status','publish');
		if($post_status_option === ''){$post_status = array('publish');}else{$post_status = explode(",", $post_status_option);}
	}else{
		$post_status_option = get_option('cuerda_total_post_status','publish,future,draft,private,pending,trash');
		if($post_status_option === ''){$post_status = array('publish,future,draft,private,pending,trash');}else{$post_status = explode(",", $post_status_option);}
	}

	// 配信元の名称
	$channel_title = get_option('cuerda_'.$isp.'_title','');

	// ノアドット・コンテンツホルダー・ユニットID
	$nordot_unit_id_option = get_option('cuerda_total_nordot_unit_id','');
	if($nordot_unit_id_option == ''){$nordot_unit_id = '';}else{$nordot_unit_id = $nordot_unit_id_option;}

	// ノアドット・キュレーター・ユニットID
	$nordot_cu_id_option = get_option('cuerda_total_nordot_cu_id','');
	if($nordot_cu_id_option == ''){$nordot_cu_id = '';}else{$nordot_cu_id = $nordot_cu_id_option;}

	// 関連記事リンクに設定する記事URLを特定のパスに置き換える
	$rel_urlpass_option = get_option('cuerda_total_rel_urlpass','');
	if($rel_urlpass_option == ''){$rel_urlpass = '';}else{$rel_urlpass = $rel_urlpass_option;}

	// フィードへのクロール頻度
	$ttl_option = get_option('cuerda_'.$isp.'_ttl',$ttl_default);
	if($ttl_option == ''){$ttl = $ttl_default;}else{$ttl = $ttl_option;}

	// 配信する記事の種類
	$post_type_option = get_option('cuerda_'.$isp.'_post_type','post');
	if($post_type_option == ''){$post_type = array('post');}else{$post_type = explode(",", $post_type_option);}

	// フィード掲載する最大記事件数
	$posts_per_page_option = get_option('cuerda_'.$isp.'_posts_per_page',$posts_per_page_default);
	if($posts_per_page_option == ''){$posts_per_page = $posts_per_page_default;}else{$posts_per_page = $posts_per_page_option;}

	// 配信する著者
	$author__in_option = get_option('cuerda_'.$isp.'_author__in','');
	if($author__in_option == ''){$author__in = array();}else{$author__in = explode(",",$author__in_option);}

	// 配信から除外する著者
	$author__not_in_option = get_option('cuerda_'.$isp.'_author__not_in','');
	if($author__not_in_option == ''){$author__not_in = array();}else{$author__not_in = explode(",",$author__not_in_option);}

	// 配信するカテゴリー
	$category__in_option = get_option('cuerda_'.$isp.'_category__in','');
	$category__in = explode(",", $category__in_option);
	if($category__in_option == ''){$category__in = array();}else{$category__in = explode(",",$category__in_option);}

	// 配信から除外するカテゴリー
	$category__not_in_option = get_option('cuerda_'.$isp.'_category__not_in','');
	$category__not_in = explode(",", $category__not_in_option);

	// 配信するタグ
	$tag__in_option = get_option('cuerda_'.$isp.'_tag__in','');
	$tag__in = explode(",", $tag__in_option);
	if($tag__in_option == ''){$tag__in = array();}else{$tag__in = explode(",",$tag__in_option);}

	// 配信から除外するタグ
	$tag__not_in_option = get_option('cuerda_'.$isp.'_tag__not_in','');
	$tag__not_in = explode(",", $tag__not_in_option);

	// 配信から除外する記事
	$post__not_in_option = get_option('cuerda_'.$isp.'_post__not_in','');
	$post__not_in = explode(",", $post__not_in_option);

	// フィード掲載する記事の更新日
	$after_modified_option = get_option('cuerda_'.$isp.'_after_modified',$after_modified_default);
	if($after_modified_option == ''){$after_modified = $after_modified_default_day;}else{$after_modified = $after_modified_option;}

	// フィード掲載する記事の公開日
	$after_date_option = get_option('cuerda_'.$isp.'_after_date',$after_date_default);
	if($after_date_option == ''){$after_date = $after_date_default_day;}else{$after_date = $after_date_option;}

	// 当該リソース提供者の copyright
	$copyright_option = get_option('cuerda_'.$isp.'_copyright','');
	if($copyright_option == ''){$copyright = '';}else{$copyright = $copyright_option;}

	// ロゴ画像のURL
	$logo_option = get_option('cuerda_'.$isp.'_logo','');
	if($logo_option == ''){$logo = '';}else{$logo = $logo_option;}

	// 著作者表示用のカスタムフィールド名 OR 画像の出典元情報のカスタムフィールド名
	$cf_creator_option = get_option('cuerda_'.$isp.'_cf_creator','');
	if($cf_creator_option == ''){$cf_creator = '';}else{$cf_creator = $cf_creator_option;}

	// 記事の要約カスタムフィールド
	$article_summary_option = get_option('cuerda_'.$isp.'_article_summary','');
	if($article_summary_option == ''){$article_summary = '';}else{$article_summary = $article_summary_option;}

	// 画像の出典元URLのカスタムフィールド名
	$cf_creator_url_option = get_option('cuerda_'.$isp.'_cf_creator_url','');
	if($cf_creator_url_option == ''){$cf_creator_url = '';}else{$cf_creator_url = $cf_creator_url_option;}

	// 先頭に指定するカテゴリ名
	$category__absolute = get_option('cuerda_'.$isp.'_category__absolute','');

	// 標準地域コードを出力するか
	$area_city_option = get_option('cuerda_'.$isp.'_area_city',0);
	if($area_city_option == ''){$area_city = 0;}else{$area_city = $area_city_option;}

	// アクセス解析用コード
	// 標準解析タグ
	$analytics_option = get_option('cuerda_'.$isp.'_analytics','');
	if($analytics_option == ''){$analytics = '';}else{$analytics = $analytics_option;}

	// 記事に添付された動画メディアの配信
	$enc_video_option = get_option('cuerda_'.$isp.'_video',0);
	if($enc_video_option == ''){$enc_video = 0;}else{$enc_video = $enc_video_option;}

	// アイキャッチ画像を出力するか
	$enc_icatch_option = get_option('cuerda_'.$isp.'_icatch',0);
	if($enc_icatch_option == ''){$enc_icatch = 0;}else{$enc_icatch = $enc_icatch_option;}

	// 記事に添付された画像メディアの配信
	$enc_image_option = get_option('cuerda_'.$isp.'_image',0);
	if($enc_image_option == ''){$enc_image = 0;}else{$enc_image = $enc_image_option;}

	// enclosure の alt に代入するキー
	$enclosure_alt_option = get_option('cuerda_'.$isp.'_enclosure_alt',0);
	if($enclosure_alt_option == ''){$enclosure_alt = 0;}else{$enclosure_alt = $enclosure_alt_option;}

	// 関連リンク最大本数 lnr => 外部リンク情報最大本数 snf => 広告の代替関連記事リンク最大本数
	if($isp !== 'ant'){
	$rel_count_option = get_option('cuerda_'.$isp.'_rel_count',$rel_count_default);
	if($rel_count_option == ''){$rel_count = $rel_count_default;}else{if($rel_count_option > $rel_count_default){$rel_count = $rel_count_default;}else{$rel_count = $rel_count_option;}}
	}else{
	}

	// 同一タグから関連リンクを出力する
	$rel_tag_option = get_option('cuerda_'.$isp.'_rel_tag',0);
	if($rel_tag_option == ''){$rel_tag = 0;}else{$rel_tag = $rel_tag_option;}

	// 手動関連リンクを優先出力する
	$rel_manual_option = get_option('cuerda_'.$isp.'_rel_manual','');
	if($rel_manual_option == ''){$rel_manual = '';}else{$rel_manual = $rel_manual_option;}

	// 手動関連リンクURLのカスタムフィールド名
	$cf_rel_feeld1_option = get_option('cuerda_'.$isp.'_rel_feeld1','');
	if($cf_rel_feeld1_option == ''){$cf_rel_feeld1 = '';}else{$cf_rel_feeld1 = $cf_rel_feeld1_option;}

	// 手動関連リンクURLのカスタムフィールド名
	$cf_rel_feeld2_option = get_option('cuerda_'.$isp.'_rel_feeld2','');
	if($cf_rel_feeld2_option == ''){$cf_rel_feeld2 = '';}else{$cf_rel_feeld2 = $cf_rel_feeld2_option;}

	// 手動関連リンクURLのカスタムフィールド名
	$cf_rel_feeld3_option = get_option('cuerda_'.$isp.'_rel_feeld3','');
	if($cf_rel_feeld3_option == ''){$cf_rel_feeld3 = '';}else{$cf_rel_feeld3 = $cf_rel_feeld3_option;}

	// 関連リンクにノアドットをセットする
	$rel_nor_set_option = get_option('cuerda_'.$isp.'_rel_nor_set',0);
	if($rel_nor_set_option == ''){$rel_nor_set = 0;}else{$rel_nor_set = $rel_nor_set_option;}

	// 配信先での遅延公開分数カスタムフィールド名
	$cf_publish_delay_option = get_option('cuerda_'.$isp.'_cf_publish_delay','');
	if($cf_publish_delay_option == ''){$cf_publish_delay = '';}else{$cf_publish_delay = $cf_publish_delay_option;}

	// 配信先での遅延公開
	$publish_delay_option = get_option('cuerda_'.$isp.'_publish_delay',0);
	if($publish_delay_option == ''){$publish_delay = 0;}else{$publish_delay = $publish_delay_option;}

	if($isp === 'lnr'||$isp === 'ant'){
		// 記事の有効期限
		$expire_option = get_option('cuerda_'.$isp.'_expire','');
		if($expire_option == ''){$expire = '';}else{$expire = $expire_option * 86400;}
	}else{
	}

	// Yahoo!ニュースの媒体コード
	$cuerda_ynf_id_option = get_option('cuerda_ynf_id','');
	if($cuerda_ynf_id_option == ''){$cuerda_ynf_id = '';}else{$cuerda_ynf_id = $cuerda_ynf_id_option;}
	// Yahoo!ニュースの記事種別
	$cuerda_ynf_articletype_option = get_option('cuerda_ynf_articletype','');
	if($cuerda_ynf_articletype_option == ''){$cuerda_ynf_articletype = '';}else{$cuerda_ynf_articletype = $cuerda_ynf_articletype_option;}

	if($isp === 'gnf'){
		// サイトの横長のロゴ画像のURL
		$wide_logo_option = get_option('cuerda_gnf_wide_logo','');
		if($wide_logo_option == ''){$wide_logo = '';}else{$wide_logo = $wide_logo_option;}
		// グノシー解析タグ
		$analytics_gn_option = get_option('cuerda_gnf_analytics_gn','');
		if($analytics_gn_option == ''){$analytics_gn = '';}else{$analytics_gn = $analytics_gn_option;}
		// LUCRA解析タグ
//		$analytics_lc_option = get_option('cuerda_gnf_analytics_lc','');
//		if($analytics_lc_option == ''){$analytics_lc = '';}else{$analytics_lc = $analytics_lc_option;}
		// auスマートToday解析タグ
		$analytics_st_option = get_option('cuerda_gnf_analytics_st','');
		if($analytics_st_option == ''){$analytics_st = '';}else{$analytics_st = $analytics_st_option;}
	}else{
	}

	if($isp === 'snf'){
		// ダークモードに対応したロゴ画像のURL
		$darkmodelogo_option = get_option('cuerda_snf_darkmodelogo','');
		if($darkmodelogo_option == ''){$darkmodelogo = '';}else{$darkmodelogo = $darkmodelogo_option;}
		// 代替画像のURL
		$thumbnail_option = get_option('cuerda_snf_thumbnail','');
		if($thumbnail_option == ''){$thumbnail = '';}else{$thumbnail = $thumbnail_option;}
		// 広告の代替を自動表示するか
		$rel_ad_option = get_option('cuerda_snf_rel_ad',0);
		if($rel_ad_option == ''){$rel_ad = 0;}else{$rel_ad = $rel_ad_option;}
		// 【広告1本目】スポンサードリンクの URL
		$rel_link1_option = get_option('cuerda_snf_rel_link1','');
		if($rel_link1_option == ''){$rel_link1 = '';}else{$rel_link1 = $rel_link1_option;}
		// 【広告1本目】スポンサードリンクの記事タイトル
		$rel_title1_option = get_option('cuerda_snf_rel_title1','');
		if($rel_title1_option == ''){$rel_title1 = '';}else{$rel_title1 = $rel_title1_option;}
		// 【広告1本目】スポンサードリンクのサムネイル画像 URL
		$rel_thumbnail1_option = get_option('cuerda_snf_rel_thumbnail1','');
		if($rel_thumbnail1_option == ''){$rel_thumbnail1 = '';}else{$rel_thumbnail1 = $rel_thumbnail1_option;}
		// 【広告1本目】スポンサードリンクの広告主名
		$rel_advertiser1_option = get_option('cuerda_snf_rel_advertiser1','');
		if($rel_advertiser1_option == ''){$rel_advertiser1 = '';}else{$rel_advertiser1 = $rel_advertiser1_option;}
		// 【広告2本目】スポンサードリンクの URL
		$rel_link2_option = get_option('cuerda_snf_rel_link2','');
		if($rel_link2_option == ''){$rel_link2 = '';}else{$rel_link2 = $rel_link2_option;}
		// 【広告2本目】スポンサードリンクの記事タイトル
		$rel_title2_option = get_option('cuerda_snf_rel_title2','');
		if($rel_title2_option == ''){$rel_title2 = '';}else{$rel_title2 = $rel_title2_option;}
		// 【広告2本目】スポンサードリンクのサムネイル画像 URL
		$rel_thumbnail2_option = get_option('cuerda_snf_rel_thumbnail2','');
		if($rel_thumbnail2_option == ''){$rel_thumbnail2 = '';}else{$rel_thumbnail2 = $rel_thumbnail2_option;}
		// 【広告2本目】スポンサードリンクの広告主名
		$rel_advertiser2_option = get_option('cuerda_snf_rel_advertiser2','');
		if($rel_advertiser2_option == ''){$rel_advertiser2 = '';}else{$rel_advertiser2 = $rel_advertiser2_option;}
	}else{
	}

/* ******************************************************************************
ここから content 内の処理に関わる設定
****************************************************************************** */
	// YouTube 用のカスタムフィールド名
	$cf_youtube = get_option('cuerda_total_cf_youtube','');

	// 本文冒頭にアイキャッチ画像を出力する（値1で出力する）
	$add_icatch_option = get_option('cuerda_'.$isp.'_add_icatch',0);
	if($add_icatch_option == ''){$add_icatch = 0;}else{$add_icatch = $add_icatch_option;}

	// a タグをアンカーテキストを含め除去する（値1で除去する）
	$atag_option = get_option('cuerda_'.$isp.'_atag',0);
	if($atag_option == ''){$atag = 0;}else{$atag = $atag_option;}

	// table タグを除去する（値1で除去する）
	$table_option = get_option('cuerda_'.$isp.'_table',0);
	if($table_option == ''){$table = 0;}else{$table = $table_option;}

	// table タグを p に置換しインライン可する（値1でする）
	$table_inline_option = get_option('cuerda_'.$isp.'_table_inline',0);
	if($table_inline_option == ''){$table_inline = 0;}else{$table_inline = $table_inline_option;}

	// table タグを p に置換しインライン可した時のデリミタ
		$table_inline_delimiter_option = get_option('cuerda_'.$isp.'_table_inline_delimiter','');
		if($table_inline_delimiter_option === ''){$table_inline_delimiter= '';}else{$table_inline_delimiter = $table_inline_delimiter_option;}

	// 連想配列に格納された特定の文字列を削除
		$sentence_delete_option = get_option('cuerda_'.$isp.'_sentence_delete','');
		if($sentence_delete_option === ''){$sentence_delete= '';}else{$sentence_delete = explode(",", $sentence_delete_option);}

	// 連想配列に格納された特定の正規表現を削除
		$regular_expression_delete_option = get_option('cuerda_'.$isp.'_regular_expression_delete','');
		if($regular_expression_delete_option === ''){$regular_expression_delete= '';}else{$regular_expression_delete = explode(",", $regular_expression_delete_option);}

<?php
// cerda（クエルダ）は本プログラムソースコードの著作権を保有しています。
// Copyright (C) 2020 CUERDA(https://cuerda.org).
if(!defined('ABSPATH')){
die('Forbidden');
}
if($feed_for === 'ynf'){
	$ynf_ftp_put_option = get_option('cuerda_ynf_ftp_put', 0);
	if($ynf_ftp_put_option == ''){$ynf_ftp_put = 0;}else{$ynf_ftp_put = $ynf_ftp_put_option;}
	if($ynf_ftp_put == 1){
	 cuerda_ynf_infomation();
	}else{
	echo '※ cuerda配信設定で「FTP サーバーへ配信する」にチェックがありません。';
	}
	return;
}
// alternate_content_for_the_cuerda_feed.php とは get_the_content() 以外で生成する投稿の代替プログラムファイルです。
$content_manage_filename = get_template_directory( __FILE__ ).'/alternate_content_for_the_cuerda_feed.php';
// 本文を生成する代替プログラムがある場合の定義
if (file_exists($content_manage_filename)){
$tani = 'minutes';
$mod = '20';
$dat = '20';
}else{
$tani = 'day';
$mod = $after_modified;
$dat = $after_date;
}
if(!empty($author__in)){
$author = $author__in;
}else{
$author = array_map(function($value) { return $value * -1; }, $author__not_in);
}
if(!empty($category__in)){
$args_category = 'category__in';
$category = $category__in;
}else{
$args_category = 'category__not_in';
$category = $category__not_in;
}
if(!empty($tag__in)){
$args_tag = 'tag__in';
$tag = $tag__in;
}else{
$args_tag = 'tag__not_in';
$tag = $tag__not_in;
}
$args_all = Array(
'post_type' => $post_type,
'orderby' => 'modified',
'post_status' => $post_status,
'has_password' => false,
'posts_per_page' => $posts_per_page,
'author' => implode(',', $author),
$args_category => $category,
$args_tag => $tag,
'post__not_in' => $post__not_in,
'date_query' => 
	array(
		'relation' => 'OR',
		array(
		'after' => current_time("Y-m-d H:i:s", strtotime('-'.$mod.$tani)),
		'inclusive' => true,
		'column' => 'post_modified'
		),
		array(
		'after' => current_time("Y-m-d H:i:s", strtotime('-'.$dat.$tani)),
		'inclusive' => true,
		'column' => 'post_date'
		)
	)
);
$wp_query = new WP_Query($args_all);
$q = new WP_Query($args_all);
if(!empty($q->have_posts())):while($q->have_posts()):$q->the_post();
$status = get_post_status( );
$publish = implode(',',$publish_status);
if($status === $publish||$status === 'future'||$status === 'private'||$status === 'trash'||$status === 'draft'||$status !== 'auto-draft'){
echo $tab2.'<item>'.PHP_EOL;

/** GUID *****************************************/
if($feed_for !== 'ant'){
	if($feed_for === 'ldn'){
	echo $tab3.'<guid isPermaLink="true">';
	echo esc_url(get_the_permalink());
	echo '</guid>'.PHP_EOL;
	}else{
	echo $tab3.'<guid isPermaLink="false">';
	echo get_the_ID();
	echo '</guid>'.PHP_EOL;
	}
}else{
}

/** TITLE *****************************************/
if($feed_for === 'goo' && $status === 'future' || $feed_for === 'goo' && $status === 'private' || $feed_for === 'goo' && $status === 'trash' || $feed_for === 'goo' && $status === 'draft'){
}else{
echo $tab3.'<title><![CDATA[';
echo esc_html(get_the_title());
echo ']]></title>'.PHP_EOL;
}

/** LINK *****************************************/
if($feed_for === 'goo' && $status === 'future' || $feed_for === 'goo' && $status === 'private' || $feed_for === 'goo' && $status === 'trash' || $feed_for === 'goo' && $status === 'draft'|| $feed_for === 'isn'){
}else{
echo $tab3.'<link>';
if(!empty($rel_urlpass)){
$post_id = get_the_ID();
$rel_url = $rel_urlpass.$post_id;
}else{
$rel_url = esc_url(get_the_permalink());
}
echo $rel_url;
echo '</link>'.PHP_EOL;
}

/** PUBDATE **************************************/
if($feed_for === 'goo' && $status === 'future' || $feed_for === 'goo' && $status === 'private' || $feed_for === 'goo' && $status === 'trash' || $feed_for === 'goo' && $status === 'draft'){
}elseif($feed_for === 'yjt' && $status === 'future' || $feed_for === 'yjt' && $status === 'private' || $feed_for === 'yjt' && $status === 'trash' || $feed_for === 'yjt' && $status === 'draft'){
	echo $tab3.'<pubDate></pubDate>'.PHP_EOL;
}elseif($feed_for === 'yjt' && $status === $publish){
	echo $tab3.'<pubDate>';
	echo get_post_modified_time(DATE_RFC2822);
	echo '</pubDate>'.PHP_EOL;
}else{
	echo $tab3.'<pubDate>';
	$post_date = get_post_time(DATE_RFC2822);
	$cf_delay = get_post_meta(get_the_ID(),$cf_publish_delay,true);
		if(!empty($cf_delay) && !empty($cf_publish_delay)){
			$pubDate = current_time(DATE_RFC2822, strtotime($post_date .'+'.$cf_delay.'minutes'));
			echo $pubDate;
		}elseif(!empty($publish_delay)){
			$pubDate = current_time(DATE_RFC2822, strtotime($post_date .'+'.$publish_delay.'minutes'));
			echo $pubDate;
		}else{
			$pubDate = $post_date;
			echo $pubDate;
		}
	echo '</pubDate>'.PHP_EOL;
}

/** MODIFIED *************************************/
if($status === $publish || $status === 'future' || $status === 'private' || $status === 'trash' || $status === 'draft'){
	if($feed_for === 'goo' && $status !== 'future' && $status !== 'private' && $status !== 'trash' && $status !== 'draft'){
	echo $tab3.'<goonews:modified>';
	echo get_post_modified_time(DATE_RFC2822);
	echo '</goonews:modified>'.PHP_EOL;
	}elseif($feed_for === 'gnf'){
	echo $tab3.'<gnf:modified>';
	echo get_post_modified_time(DATE_RFC2822);
	echo '</gnf:modified>'.PHP_EOL;
	}elseif($feed_for === 'lnr'){
	echo $tab3.'<oa:lastPubDate>';
	echo get_post_modified_time(DATE_RFC2822);
	echo '</oa:lastPubDate>'.PHP_EOL;
	}elseif($feed_for === 'dcm'){
	echo $tab3.'<modifiedDate>';
	echo get_post_modified_time(DATE_RFC2822);
	echo '</modifiedDate>'.PHP_EOL;
	}elseif($feed_for === 'spb'){
	echo $tab3.'<lastUpdate>';
	echo get_post_modified_time(DATE_RFC2822);
	echo '</lastUpdate>'.PHP_EOL;
	}elseif($feed_for === 'ldn'||$feed_for === 'isn'){
	echo $tab3.'<lastpubDate>';
	echo get_post_modified_time(DATE_RFC2822);
	echo '</lastpubDate>'.PHP_EOL;
	}elseif($feed_for === 'trl'){
	echo $tab3.'<atom:updated>';
	echo get_post_modified_time(DATE_ATOM);
	echo '</atom:updated>'.PHP_EOL;
	}else{
	}
}else{
}

/** EXPIRE ******************************/
if($feed_for === 'lnr'||$feed_for === 'ant' && $status === $publish){
	if(!empty($expire)){
		$str_pubdate = strtotime($pubDate);
		$str_period = $str_pubdate+$expire;
		$period_date = strtotime(DATE_RFC2822,$str_period);
		$period_date = current_time(DATE_RFC2822,$str_period);
		if($feed_for === 'lnr'){
		echo $tab3.'<oa:expireDate>';
		echo $period_date;
		echo '</oa:expireDate>'.PHP_EOL;
		}elseif($feed_for === 'ant'){
		echo $tab3.'<endDate>';
		echo $period_date;
		echo '</endDate>'.PHP_EOL;
		}
	}else{
	}
}else{
}

/** DELETE ***************************************/
if($feed_for === 'goo' && $status === 'future' || $feed_for === 'goo' && $status === 'private' || $feed_for === 'goo' && $status === 'trash' || $feed_for === 'goo' && $status === 'draft'){
echo $tab3.'<goonews:delete>1</goonews:delete>'.PHP_EOL;
}elseif($feed_for === 'snf' && $status === 'future' || $feed_for === 'snf' && $status === 'private' || $feed_for === 'snf' && $status === 'trash' || $feed_for === 'snf' && $status === 'draft'){
echo $tab3.'<media:status>deleted</media:status>'.PHP_EOL;
}elseif($feed_for === 'gnf' && $status === 'future' || $feed_for === 'gnf' && $status === 'private' || $feed_for === 'gnf' && $status === 'trash' || $feed_for === 'gnf' && $status === 'draft'){
echo $tab3.'<media:status state="deleted" />'.PHP_EOL;
}elseif($feed_for === 'lnr' && $status === 'future' || $feed_for === 'lnr' && $status === 'private' || $feed_for === 'lnr' && $status === 'trash' || $feed_for === 'lnr' && $status === 'draft'){
echo $tab3.'<oa:delStatus>1</oa:delStatus>'.PHP_EOL;
}elseif($feed_for === 'dcm' && $status === 'future' || $feed_for === 'dcm' && $status === 'private' || $feed_for === 'dcm' && $status === 'trash' || $feed_for === 'dcm' && $status === 'draft'){
echo $tab3.'<delete>1</delete>'.PHP_EOL;
}elseif($feed_for === 'spb' && $status === 'future' || $feed_for === 'spb' && $status === 'private' || $feed_for === 'spb' && $status === 'trash' || $feed_for === 'spb' && $status === 'draft'){
echo $tab3.'<status>0</status>'.PHP_EOL;
}elseif($feed_for === 'spb' && $status === 'future' || $feed_for === 'spb' && $status === 'private' || $feed_for === 'spb' && $status === 'trash' || $feed_for === 'spb' && $status === 'draft'){
echo $tab3.'<delete>1</delete>'.PHP_EOL;
}elseif($feed_for === 'ldn' && $status === 'future' || $feed_for === 'ldn' && $status === 'private' || $feed_for === 'ldn' && $status === 'trash' || $feed_for === 'ldn' && $status === 'draft'){
echo $tab3.'<status>0</status>'.PHP_EOL;
}elseif($feed_for === 'isn' && $status === 'future' || $feed_for === 'isn' && $status === 'private' || $feed_for === 'isn' && $status === 'trash' || $feed_for === 'isn' && $status === 'draft'){
echo $tab3.'<status>delete</status>'.PHP_EOL;
}elseif($feed_for === 'ant' && $status === 'future' || $feed_for === 'ant' && $status === 'private' || $feed_for === 'ant' && $status === 'trash' || $feed_for === 'ant' && $status === 'draft'){
echo $tab3.'<endDate>'.get_post_modified_time(DATE_RFC2822).'</endDate>'.PHP_EOL;
}else{
}
/** REASON FOR DELETION ***************************************/
	if($status === 'future'){
	echo $tab3.'<!-- This item has been changed to a future date. -->'.PHP_EOL;
	}elseif($status === 'private'){
	echo $tab3.'<!-- This item has been changed to private. -->'.PHP_EOL;
	}elseif($status === 'trash'){
	echo $tab3.'<!-- This item has been moved to the trash. -->'.PHP_EOL;
	}elseif($status === 'draft'){
	echo $tab3.'<!-- This item has been changed to draft status. -->'.PHP_EOL;
	}else{
	}

/** ACTIVE ***************************************/
if($feed_for !== 'goo' && $feed_for !== 'yjt'){
	$post_id = get_the_ID(); // 投稿IDを取得
	$post_date = get_post_time('U', false, $post_id); // UNIXタイムスタンプ形式で取得
	$post_modified = get_post_modified_time('U', false, $post_id); // UNIXタイムスタンプ形式で取得
	if($feed_for === 'snf' && $status === $publish){
	echo $tab3.'<media:status>active</media:status>'.PHP_EOL;
	}elseif($feed_for === 'gnf' && $status === $publish){
	echo $tab3.'<media:status state="active" />'.PHP_EOL;
	}elseif($feed_for === 'spb' && $status === $publish){
	echo $tab3.'<status>1</status>'.PHP_EOL;
	}elseif($feed_for === 'ldn' && $status === $publish){
		if($post_date === $post_modified){
			echo $tab3.'<status>1</status>'.PHP_EOL;
		}else{
			echo $tab3.'<status>2</status>'.PHP_EOL;
		}
	}elseif($feed_for === 'isn' && $status === $publish){
		if($post_date === $post_modified){
			echo $tab3.'<status>create</status>'.PHP_EOL;
		}else{
			echo $tab3.'<status>update</status>'.PHP_EOL;
		}
	}else{
	}
}else{
}

/** DC:CREATOR ***********************************/
if($feed_for === 'goo' && $status === 'future' || $feed_for === 'goo' && $status === 'private' || $feed_for === 'goo' && $status === 'trash' || $feed_for === 'goo' && $status === 'draft' || $feed_for === 'yjt' && $status === 'private' || $feed_for === 'yjt' && $status === 'trash' || $feed_for === 'yjt' && $status === 'draft'){
}elseif($feed_for === 'dcm'||$feed_for === 'spb'||$feed_for === 'ldn'||$feed_for === 'isn'||$feed_for === 'ant'||$feed_for === 'trl'){
}elseif($feed_for === 'lnr'){
	if(!empty($cf_creator)){
	$cf3 = get_post_meta(get_the_ID(),$cf_creator,true);
		if($cf3){
		echo $tab3.'<oa:imgAuthor>'.PHP_EOL;
		echo $tab4.'<oa:authorName><![CDATA[';
		echo esc_html($cf3);
		echo ']]></oa:authorName>'.PHP_EOL;
		echo $tab3.'</oa:imgAuthor>'.PHP_EOL;
		}else{
			echo $tab3.'<oa:imgAuthor>'.PHP_EOL;
			echo $tab4.'<oa:authorName><![CDATA[';
				if(!empty($lnr_title)){
				echo esc_html($lnr_title);
				}else{
				echo esc_html(bloginfo('name'));
				}
			echo ']]></oa:authorName>'.PHP_EOL;
			echo $tab3.'</oa:imgAuthor>'.PHP_EOL;
		}
	}
}elseif($feed_for === 'yjt'){
	echo $tab3.'<author><![CDATA[';
		if(!empty($cf_creator)){
		$cf = get_post_meta(get_the_ID(),$cf_creator,true);
		echo esc_html($cf);
		}elseif(!empty($channel_title)){
		echo esc_html($channel_title);
		}else{
		the_author();
		}
	echo ']]></author>'.PHP_EOL;
}else{
echo $tab3.'<dc:creator><![CDATA[';
	if(!empty($cf_creator)){
	$cf = get_post_meta(get_the_ID(),$cf_creator,true);
		if(!empty($cf)){
		echo esc_html($cf);
		}else{
			if(!empty($channel_title)){
			echo esc_html($channel_title);
			}else{
			}
		}
	}else{
	the_author();
	}
echo ']]></dc:creator>'.PHP_EOL;
}

/** CATEGORY ***********************************/
if($feed_for === 'goo' && $status === 'future' || $feed_for === 'goo' && $status === 'private' || $feed_for === 'goo' && $status === 'trash' || $feed_for === 'goo' && $status === 'draft'){
}elseif($feed_for === 'goo' || $feed_for === 'dcm'){
	if(!empty($category__absolute)){
	echo $tab3.'<category><![CDATA[';
	echo esc_attr($category__absolute);
	echo ']]></category>'.PHP_EOL;
	}else{
	}
}else{
}
if($feed_for === 'goo' && $status === 'future' || $feed_for === 'goo' && $status === 'private' || $feed_for === 'goo' && $status === 'trash' || $feed_for === 'goo' && $status === 'draft' || $feed_for === 'trl'){
}elseif($feed_for === 'ldn'||$feed_for === 'isn'||$feed_for === 'goo'){
	$cat = get_the_category();
	if(!empty($cat)){
	$category_name = $cat[0]->name;
	echo $tab3.'<category><![CDATA[';
	echo esc_attr($category_name);
	echo ']]></category>'.PHP_EOL;
	}else{
	echo $tab3.'<category><![CDATA[Uncategorized]]></category>'.PHP_EOL;
	}
}elseif($feed_for === 'ant'){
$cat = get_the_category();
$category_names = array();
	foreach($cat as $category){
	$category_names[] = $category->name;
	}
	if(!empty($cat && !is_wp_error($cat))){
	echo $tab3.'<category><![CDATA[';
	echo implode( ',', $category_names );
	echo ']]></category>'.PHP_EOL;
	}else{
	}
}elseif($feed_for === 'yjt'){
echo $tab3.'<category><![CDATA[trend]]></category>'.PHP_EOL;
}elseif($feed_for === 'spb'){
$catgory = get_the_category();
$term_id = $catgory[0]->term_id;
$term_name = $catgory[0]->name;
$op_name_pre = 'cuerda_spb_category_';
$op_name = $op_name_pre.$term_id;
$cat_id = get_option($op_name);
	if(!empty($cat_id)){
	echo $tab3.'<category><![CDATA[';
	echo $cat_id;
	echo ']]></category>'.PHP_EOL;
	echo $tab3.'<!-- オリジナルカテゴリは「';
	echo $term_name;
	echo '」 -->'.PHP_EOL;
	}else{
	}
}elseif($feed_for !== 'gnf'){
$cat = get_the_category();
	if(!empty($cat && !is_wp_error($cat))):
	foreach($cat as $item):
	echo $tab3.'<category><![CDATA[';
	echo esc_attr($item->name);
	echo ']]></category>'.PHP_EOL;
	endforeach;
	else:endif;
echo $tab3.'<category><![CDATA[Uncategorized]]></category>'.PHP_EOL;
}else{
$catgory = get_the_category();
$term_id = $catgory[0]->term_id;
$term_name = $catgory[0]->name;
$op_name_pre = 'cuerda_gnf_category_';
$op_name = $op_name_pre.$term_id;
$cat_id = get_option($op_name);
	if(!empty($cat_id)){
	echo $tab3.'<gnf:category><![CDATA[';
	echo $cat_id;
	echo ']]></gnf:category>'.PHP_EOL;
	echo $tab3.'<!-- オリジナルカテゴリは「';
	echo $term_name;
	echo '」 -->'.PHP_EOL;
	}else{
	echo $tab3.'<gnf:category><![CDATA[column]]></gnf:category>'.PHP_EOL;
	echo $tab3.'<!-- カテゴリ未指定またはマッピング未指定のためデフォルトカテゴリ -->'.PHP_EOL;
	}
}

/** AREACODE *************************************/
if($feed_for === 'goo' && $status === 'future' || $feed_for === 'goo' && $status === 'private' || $feed_for === 'goo' && $status === 'trash' || $feed_for === 'goo' && $status === 'draft'){
}elseif($feed_for === 'goo'||$feed_for === 'lnr'){
	if($area_city == 1){
	$postcontent = get_the_content();
	$city_data = 'pref_city.php';
	require($city_data);
	}else{
	}
}elseif($feed_for === 'spb'){
	if($area_city == 1){
	$postcontent = get_the_content();
	$city_data = 'pref_spb.php';
	// 入力文字列
	ob_start();
	require($city_data);
	$city_data_output = ob_get_clean();
		if(empty($city_data_output)){
		}else{
		// 地域と都道府県名の対応表
		$regionTable = [
			"北海道" => "北海道",
			"青森県" => "東北",
			"岩手県" => "東北",
			"宮城県" => "東北",
			"秋田県" => "東北",
			"山形県" => "東北",
			"福島県" => "東北",
			"茨城県" => "関東",
			"栃木県" => "関東",
			"群馬県" => "関東",
			"埼玉県" => "関東",
			"千葉県" => "関東",
			"東京都" => "関東",
			"神奈川県" => "関東",
			"新潟県" => "北陸・甲信越",
			"富山県" => "北陸・甲信越",
			"石川県" => "北陸・甲信越",
			"福井県" => "北陸・甲信越",
			"山梨県" => "北陸・甲信越",
			"長野県" => "北陸・甲信越",
			"岐阜県" => "東海",
			"静岡県" => "東海",
			"愛知県" => "東海",
			"三重県" => "関西",
			"滋賀県" => "関西",
			"京都府" => "関西",
			"大阪府" => "関西",
			"兵庫県" => "関西",
			"奈良県" => "関西",
			"和歌山県" => "関西",
			"鳥取県" => "中国",
			"島根県" => "中国",
			"岡山県" => "中国",
			"広島県" => "中国",
			"山口県" => "中国",
			"徳島県" => "四国",
			"香川県" => "四国",
			"愛媛県" => "四国",
			"高知県" => "四国",
			"福岡県" => "九州・沖縄",
			"佐賀県" => "九州・沖縄",
			"長崎県" => "九州・沖縄",
			"熊本県" => "九州・沖縄",
			"大分県" => "九州・沖縄",
			"宮崎県" => "九州・沖縄",
			"鹿児島県" => "九州・沖縄",
			"沖縄県" => "九州・沖縄",
		];
		// 提供された文字列を都道府県の配列に分割
		$prefectures = explode("\n", trim($city_data_output));
		// 最初の地域を取得
		$firstRegion = '';
		foreach ($prefectures as $prefecture) {
			$region = $regionTable[$prefecture];
			if ($region) {
				$firstRegion = $region;
				break;
			}
		}
		// 最初の地域に属する都道府県名を取得
		$prefecturesInFirstRegion = [];
		foreach ($prefectures as $prefecture) {
			$region = $regionTable[$prefecture];
			if ($region === $firstRegion) {
				$prefecturesInFirstRegion[] = $prefecture;
			}
		}
		// 出力
		echo $tab3."<area><![CDATA[$firstRegion]]></area>\n";
		echo $tab3."<pref><![CDATA[" . implode(",", $prefecturesInFirstRegion) . "]]></pref>\n";
		}
	}else{
	}
}

/** KEYWORD FOR GNF ******************************/
if($feed_for !== 'gnf'){
}else{
	$tags = get_the_tags();
	if($tags && !is_wp_error($tags)){
	echo $tab3.'<gnf:keyword><![CDATA[';
	$count=count($tags);
	$loop=0;
	foreach($tags as $item):
	$loop++;
		if($loop > 10){
		break;
		}elseif($count==$loop || $loop==10){
		echo $item->name.'';
		}else{
		echo $item->name.',';
		}
	endforeach;
	echo ']]></gnf:keyword>'.PHP_EOL;
	}else{
	}
}

/** KEYWORD FOR SPB ******************************/
if($feed_for !== 'spb'){
}else{
	$tags = get_the_tags();
	if($tags && !is_wp_error($tags)){
	echo $tab3.'<keyword><![CDATA[';
	$count=count($tags);
	$loop=0;
	foreach($tags as $item):
	$loop++;
		if($count==$loop){
		echo $item->name.'';
		}else{
		echo $item->name.',';
		}
	endforeach;
	echo ']]></keyword>'.PHP_EOL;
	}else{
	}
}

/** DESCRIPTION **********************************/
if($feed_for === 'gnf'||$feed_for === 'dcm'||$feed_for === 'ant'||$feed_for === 'trl'){
	if($feed_for === 'gnf'){
	$text_count = '50';
	}elseif($feed_for === 'dcm'){
	$text_count = '120';
	}elseif($feed_for === 'ant'){
	$text_count = '200';
	}elseif($feed_for === 'trl'){
	$text_count = '50';
	}
	echo $tab3.'<description><![CDATA[';
	$remove_array = ["\r\n","\r","\n"," ","&nbsp;","　"];
	$excerpt = strip_shortcodes(get_the_content());
	$excerpt = preg_replace('/&lt;!--[\s\S]*?--&gt;/imsu', '', $excerpt);
	$description = wp_trim_words($excerpt,$text_count,'…' );
	$description = str_replace($remove_array,'', $description);
	if($description == ''){
	echo 'ご指定の本文はありません。';
	}else{
	echo esc_html($description);
	}
	echo ']]></description>'.PHP_EOL;
}else{
}

/** CONTENT **********************************/
if($feed_for === 'goo' && $status === 'future' || $feed_for === 'goo' && $status === 'private' || $feed_for === 'goo' && $status === 'trash' || $feed_for === 'goo' && $status === 'draft'){
}elseif($feed_for === 'yjt' && $status === 'future' || $feed_for === 'yjt' && $status === 'private' || $feed_for === 'yjt' && $status === 'trash' || $feed_for === 'yjt' && $status === 'draft'){
	echo $tab3.'<description><![CDATA[[削除]]></description>'.PHP_EOL;
}else{
	if($feed_for === 'gnf'||$feed_for === 'snf'||$feed_for === 'trl'||$feed_for === 'ant'){
	$content_element = 'content:encoded';
	}elseif($feed_for === 'dcm'){
	$content_element = 'encoded';
	}elseif($feed_for === 'yjt'||$feed_for === 'goo'||$feed_for === 'lnr'||$feed_for === 'ldn'||$feed_for === 'isn'||$feed_for === 'spb'){
	$content_element = 'description';
	}
	echo $tab3.'<'.$content_element.'><![CDATA['.PHP_EOL;

	// ここからiCatch画像を本文冒頭に出力する機能
	if($feed_for === 'trl' && $add_icatch == 1){
		if ( has_post_thumbnail() ) {
			// 画像出典情報カスタムフィールドありの場合の値取得
			$trl_url = get_post_meta(get_the_ID(),$cf_creator_url,true);
			$trl_cop = get_post_meta(get_the_ID(),$cf_creator,true);
			// 配信元の名称指定有無
			if(!empty($channel_title)){
				$my_cop = $channel_title;
			}else{
				$my_cop = esc_html(get_bloginfo('name'));
			}
			$my_url = home_url('/');
			// 画像の出典元情報のカスタムフィールド名指定あり＆投稿のCFにデータあり
			if(!empty($trl_cop) && !empty($cf_creator) && !empty($trl_url) && !empty($cf_creator_url)){
				$copyright_url  = $trl_url;
				$copyright_text = $trl_cop;
			}else{
				$copyright_url  = $my_url;
				$copyright_text = $my_cop;
			}

			// アイキャッチ画像のIDを取得
			$thumbnail_id = get_post_thumbnail_id( get_the_ID() );
			// アイキャッチ画像のURL、幅、高さを取得
			$thumbnail = wp_get_attachment_image_src( $thumbnail_id, 'full' );
			// URL, 幅, 高さ
			$thumbnail_url = $thumbnail[0];
			$thumbnail_width = $thumbnail[1];
			$thumbnail_height = $thumbnail[2];
			// アイキャッチ画像のポストオブジェクトを取得
			$attachment_post = get_post( $thumbnail_id );
			// タイトル、キャプション、説明を取得
			$image_title = $attachment_post->post_title;
			$image_caption = $attachment_post->post_excerpt;
			$img_url = $thumbnail_url;
			// 相対パスを絶対パスに変換する
			if (strpos($img_url, 'http') !== 0) {
				$site_url = esc_url(home_url()); // サイトのFQDNを取得
				$img_url = $site_url . '/' . ltrim($img_url, '/');
			}
			// START $enclosure_alt オプション
			if($enclosure_alt == 1){
				$alt_caption = esc_attr($image_title);
			}else{
				$alt_caption = esc_attr($image_caption);
			}
			// END $enclosure_alt
			if(!empty($copyright_url) && !empty($copyright_text)){
				$figcaption = '<a href="'.esc_url($copyright_url).'">'.esc_html($copyright_text).'</a> ： '.$alt_caption;
			}else{
				$figcaption = $my_cop.' ： '.$alt_caption;
			}
			echo '<figure>'.PHP_EOL;
			echo $tab1.'<img src="';
			echo esc_url($thumbnail_url);
			echo '" alt="'.$alt_caption.'"';
			echo ' width="'.esc_attr($thumbnail_width).'"';
			echo ' height="'.esc_attr($thumbnail_height).'"';
			echo ' />'.PHP_EOL;
			echo $tab1.'<figcaption>';
			echo $figcaption;
			echo '</figcaption>'.PHP_EOL;
			echo '</figure>'.PHP_EOL;
		}
	}

	// ここまでiCatch画像を本文冒頭に出力する機能
	require($ini_content);
	if($content == ''){
	echo '<p>ご指定の本文はありません。</p>'.PHP_EOL;
	}else{
	echo $content.PHP_EOL;
	}
	echo $tab3.']]></'.$content_element.'>'.PHP_EOL;
}

/** ANALYTICS ************************************/
if($feed_for === 'snf'){
	if(!empty($analytics)){
		echo $tab3.'<snf:analytics><![CDATA['.PHP_EOL;
		echo $analytics.PHP_EOL;
		echo $tab3.']]></snf:analytics>'.PHP_EOL;
	}else{
	}
}else{
}
if($feed_for === 'gnf'){
	if(!empty($analytics)){
		echo $tab3.'<gnf:analytics><![CDATA['.PHP_EOL;
		echo $analytics.PHP_EOL;
		echo $tab3.']]></gnf:analytics>'.PHP_EOL;
	}else{
	}
	if(!empty($analytics_gn)){
		echo $tab3.'<gnf:analytics_gn><![CDATA['.PHP_EOL;
		echo $analytics_gn.PHP_EOL;
		echo $tab3.']]></gnf:analytics_gn>'.PHP_EOL;
	}else{
	}
//	if(!empty($analytics_lc)){
//		echo $tab3.'<gnf:analytics_lc><![CDATA['.PHP_EOL;
//		echo $analytics_lc.PHP_EOL;
//		echo $tab3.']]></gnf:analytics_lc>'.PHP_EOL;
//	}else{
//	}
	if(!empty($analytics_st)){
		echo $tab3.'<gnf:analytics_st><![CDATA['.PHP_EOL;
		echo $analytics_st.PHP_EOL;
		echo $tab3.']]></gnf:analytics_st>'.PHP_EOL;
	}else{
	}
}else{
}

/** VIDEO ****************************************/
if (
	($feed_for !== 'snr' && $feed_for !== 'lnr' && $feed_for !== 'goo') || 
	($feed_for === 'goo' && ($status === 'future' || $status === 'private' || $status === 'trash' || $status === 'draft'))
) {
	// 条件に一致しない場合は何もしない
} else {
	if ($enc_video == 1) {
		$videos = get_attached_media('video', get_the_ID());
		if (!empty($videos)) {
			foreach ($videos as $video) {
				// WordPressのHTTP APIを使用してヘッダーのみのリクエストを送信
				$response = wp_remote_head(esc_url_raw($video->guid), array('timeout' => 15, 'sslverify' => false));

				// リクエストが成功したかどうかを確認
				if (is_wp_error($response)) {
					continue;  // エラーの場合は次の動画へ
				}

				$size = wp_remote_retrieve_header($response, 'content-length');
				$video_id = attachment_url_to_postid($video->guid);
				$v_type = esc_attr($video->post_mime_type);
				$post_thumbnail_id = get_post_thumbnail_id($video_id);
				$thumbnail = get_post($post_thumbnail_id);
				$t_type = esc_attr($thumbnail->post_mime_type);
				$thumb = esc_url($thumbnail->guid);
				$rev = mysql2date('YmdHis', $video->post_modified);
				$url = esc_url($video->guid);
				$alt = esc_attr($video->post_excerpt);

				if (!empty($post_thumbnail_id) && $feed_for === 'lnr') {
					echo $tab3 . '<!-- video thumbnail -->' . PHP_EOL;
					echo $tab3 . '<enclosure type="' . $t_type . '" url="' . $thumb . '" />' . PHP_EOL;
				}

				echo $tab3 . '<!-- video -->' . PHP_EOL;

				if ($feed_for === 'goo') {
					echo $tab3 . '<enclosure type="' . $v_type . '" rev="' . $rev . '" length="' . $size . '" url="' . $url . '"';
					if (!empty($alt)) {
						echo ' alt="' . $alt . '"';
					}
					if (!empty($thumb)) {
						echo ' thumb="' . $thumb . '"';
					}
					echo ' />' . PHP_EOL;
				}

				if ($feed_for === 'lnr') {
					echo $tab3 . '<enclosure type="' . $v_type . '" length="' . $size . '" url="' . $url . '" />' . PHP_EOL;
				}

				if ($feed_for === 'snf') {
					echo $tab3 . '<snf:video url="' . $url . '"';
					if (!empty($alt)) {
						echo ' caption="' . $alt . '"';
					}
					echo ' />' . PHP_EOL;
				}
			}
		}
	}
}

/** ICATCH ****************************************/
if($feed_for === 'goo' && $status === 'future' || $feed_for === 'goo' && $status === 'private' || $feed_for === 'goo' && $status === 'trash' || $feed_for === 'goo' && $status === 'draft'||$feed_for === 'yjt' && $status === 'future' || $feed_for === 'yjt' && $status === 'private' || $feed_for === 'yjt' && $status === 'trash' || $feed_for === 'yjt' && $status === 'draft'){
}else{
	if($enc_icatch == 1){
	$post_id = get_the_ID();
	$key = '_thumbnail_id';
	$post_thumbnail_id = get_post_meta($post_id,$key,true);
		if(empty($post_thumbnail_id)){
		}else{
		$img_url = wp_get_attachment_url($post_thumbnail_id);
		// 相対パスを絶対パスに変換する
		if (strpos($img_url, 'http') !== 0) {
			$site_url = esc_url(home_url()); // サイトのFQDNを取得
			$img_url = $site_url . '/' . ltrim($img_url, '/');
		}
		$type = get_post_mime_type($post_thumbnail_id);
		if($feed_for !== 'snf'||$feed_for !== 'dcm'||$feed_for !== 'spb'||$feed_for !== 'lnr'||$feed_for !== 'trl'||$feed_for !== 'ant'){
			$thumb_title = get_post($post_thumbnail_id)->post_title;
			$thumb_alt = get_post_meta($post_thumbnail_id,'_wp_attachment_image_alt',true);
			$thumb_caption = get_post($post_thumbnail_id)->post_excerpt;
			$file_path = str_replace(esc_url(site_url('/')), ABSPATH, $img_url);
			$file_size = filesize($file_path);
				// START $enclosure_alt
				if($enclosure_alt == 1){
				$alt_caption = $thumb_title;
				}else{
				$alt_caption = $thumb_caption;
				}
				// END $enclosure_alt
		}else{
		}
		echo $tab3.'<!-- icatch -->'.PHP_EOL;
		if($feed_for === 'snf'){
			echo $tab3.'<media:thumbnail url="';
			echo esc_url($img_url);
			echo '" />'.PHP_EOL;
		}elseif($feed_for === 'gnf'){
			echo $tab3.'<enclosure type="';
			echo esc_attr($type);
			echo '"';
			echo ' url="';
			echo esc_url($img_url);
			echo '"';
			echo ' length="';
			echo $file_size;
			echo '"';
			if(!empty($alt_caption)){
			echo ' caption="';
			echo esc_attr($alt_caption);
			if(!empty($cf_creator)){
			$cf3 = get_post_meta(get_the_ID(),$cf_creator,true);
				if($cf3){
				echo '（画像出典：'.esc_html($cf3).'）';
				}else{
				}
			}
			echo '"';
			}else{
			}
			echo ' />'.PHP_EOL;
		}elseif($feed_for === 'yjt'){
			echo $tab3.'<enclosure type="';
			echo esc_attr($type);
			echo '"';
			echo ' url="';
			echo esc_url($img_url);
			echo '"';
			echo ' length="';
			echo $file_size;
			echo '"';
			if(!empty($alt_caption)){
			echo ' yj:caption="';
			echo esc_attr($alt_caption);
			if(!empty($cf_creator)){
			$cf3 = get_post_meta(get_the_ID(),$cf_creator,true);
				if($cf3){
				echo '（画像出典：'.esc_html($cf3).'）';
				}else{
				}
			}
			echo '"';
			}else{
			}
			echo ' />'.PHP_EOL;
		}elseif($feed_for === 'dcm'){
			echo $tab3.'<enclosure img="';
			echo esc_url($img_url);
			echo '" />'.PHP_EOL;
		}elseif($feed_for === 'lnr'){
			echo $tab3.'<enclosure type="';
			echo esc_attr($type);
			echo '" url="';
			echo esc_url($img_url);
			echo '" />'.PHP_EOL;
		}elseif($feed_for === 'ant'){
			echo $tab3.'<enclosure type="';
			echo esc_attr($type);
			echo '" url="';
			echo esc_url($img_url);
			echo '"></enclosure>'.PHP_EOL;
		}elseif($feed_for === 'ldn'){
			echo $tab3.'<ldnfeed:image>'.PHP_EOL;
			echo $tab4.'<ldnfeed:image_link>';
			echo esc_url($img_url);
			echo '</ldnfeed:image_link>'.PHP_EOL;
			if(!empty($alt_caption)||!empty($cf_creator)){
			echo $tab4.'<ldnfeed:image_subject><![CDATA[';
				if(!empty($cf_creator)){
				$cf3 = get_post_meta(get_the_ID(),$cf_creator,true);
					if($cf3){
					echo '画像出典：'.esc_html($cf3);
					}else{
					}
				}else{
				echo esc_attr($alt_caption);
				}
			echo ']]></ldnfeed:image_subject>'.PHP_EOL;
			}else{
			}
			echo $tab3.'</ldnfeed:image>'.PHP_EOL;
		}elseif($feed_for === 'isn'){
			echo $tab3.'<image>'.PHP_EOL;
			echo $tab4.'<url>';
			echo esc_url($img_url);
			echo '</url>'.PHP_EOL;
			if(!empty($alt_caption)||!empty($cf_creator)){
			echo $tab4.'<caption><![CDATA[';
				if(!empty($cf_creator)){
				$cf3 = get_post_meta(get_the_ID(),$cf_creator,true);
					if($cf3){
					echo '画像出典：'.esc_html($cf3);
					}else{
					}
				}else{
				echo esc_attr($alt_caption);
				}
			echo ']]></caption>'.PHP_EOL;
			}else{
			}
			echo $tab3.'</image>'.PHP_EOL;

		}elseif($feed_for === 'trl'){
			$image_url = esc_url($img_url);
			$trl_url = get_post_meta(get_the_ID(),$cf_creator_url,true);
			$trl_cop = get_post_meta(get_the_ID(),$cf_creator,true);
			$my_url = home_url('/');
			// 配信元の名称が指定されている場合
			if(!empty($channel_title)){
			$my_cop = $channel_title;
			}else{
			$my_cop = esc_html(get_bloginfo('name'));
			}
			// 画像の出典元情報のカスタムフィールド名指定あり＆投稿のCFにデータあり
			if(!empty($trl_cop) && !empty($cf_creator) && !empty($trl_url) && !empty($cf_creator_url)){
			$copyright_url  = $trl_url;
			$copyright_text = $trl_cop;
			}else{
			$copyright_url  = $my_url;
			$copyright_text = $my_cop;
			}
			echo $tab3.'<trill:image url="';
			echo $image_url;
			echo '">'.PHP_EOL;
			echo $tab4.'<trill:copyright url="';
			echo $copyright_url;
			echo '">'.PHP_EOL;
			echo $copyright_text.PHP_EOL;
			echo $tab4.'</trill:copyright>'.PHP_EOL;
			echo $tab3.'</trill:image>'.PHP_EOL;
		}elseif($feed_for === 'goo'||$feed_for === 'spb'){
			echo $tab3.'<enclosure type="';
			echo esc_attr($type);
			echo '"';
			echo ' url="';
			echo esc_url($img_url);
			echo '"';
			if(!empty($alt_caption)){
				if($feed_for === 'goo'){
					echo ' alt="';
				}elseif($feed_for === 'spb'){
					echo ' caption="';
				}
			echo esc_attr($alt_caption);
			if(!empty($cf_creator)){
			$cf3 = get_post_meta(get_the_ID(),$cf_creator,true);
				if($cf3){
				echo '（画像出典：'.esc_html($cf3).'）';
				}else{
				}
			}
			echo '"';
			}else{
			}
			echo ' />'.PHP_EOL;
		}//!empty($post_thumbnail_id)
		}
	}else{
	}//$enc_icatch == 1
}

/** ATTACHED MEDIA ****************************************/
if (
	($feed_for === 'goo' && in_array($status, ['future', 'private', 'trash', 'draft'])) || 
	($feed_for === 'yjt' && in_array($status, ['future', 'private', 'trash', 'draft']))
) {
	// 条件に一致しない場合は何もしない
} else {
	if ($enc_image == 1) {
		$images_enc = get_attached_media('image', get_the_ID());
		if (!empty($images_enc)) {
			foreach ($images_enc as $image) {
				// HTTP APIを使用してヘッダーのみのリクエストを送信
				$image_url_enc = esc_url_raw($image->guid);
				$response = wp_remote_head($image_url_enc, array('timeout' => 15, 'sslverify' => false));

				// リクエストが成功したかどうかを確認
				if (is_wp_error($response)) {
					continue;  // エラーが発生した場合、次の画像へ
				}

				$image_type_enc = $image->post_mime_type;
				$alt_caption_enc = $enclosure_alt == 1 ? $image->post_title : $image->post_excerpt;

				if ($feed_for === 'gnf' || $feed_for === 'yjt') {
					$file_path_enc = str_replace(esc_url(site_url('/')), ABSPATH, $image_url_enc);
					$file_size_enc = filesize($file_path_enc);
				}

				if (!empty($img_url) && ($image_url_enc === $img_url)) {
					continue;  // 同じ画像の場合はスキップ
				}

				echo $tab3 . '<!-- attached -->' . PHP_EOL;

				switch ($feed_for) {
					case 'goo':
						echo $tab3 . '<enclosure type="' . esc_attr($image_type_enc) . '" url="' . esc_url($image_url_enc) . '"';
						if (!empty($alt_caption_enc)) {
							echo ' alt="' . esc_attr($alt_caption_enc) . '"';
						}
						echo ' />' . PHP_EOL;
						break;

					case 'ldn':
						echo $tab3 . '<ldnfeed:image>' . PHP_EOL;
						echo $tab4 . '<ldnfeed:image_link>' . esc_url($image_url_enc) . '</ldnfeed:image_link>' . PHP_EOL;
						if (!empty($alt_caption_enc)) {
							echo $tab4 . '<ldnfeed:image_subject><![CDATA[' . esc_attr($alt_caption_enc) . ']]></ldnfeed:image_subject>' . PHP_EOL;
						}
						echo $tab3 . '</ldnfeed:image>' . PHP_EOL;
						break;

					case 'snf':
						echo $tab3 . '<media:thumbnail url="' . esc_url($image_url_enc) . '" />' . PHP_EOL;
						break;

					case 'gnf':
						echo $tab3 . '<enclosure type="' . esc_attr($image_type_enc) . '" url="' . esc_url($image_url_enc) . '" length="' . esc_attr($file_size_enc) . '"';
						if (!empty($alt_caption_enc)) {
							echo ' caption="' . esc_attr($alt_caption_enc) . '"';
						}
						echo ' />' . PHP_EOL;
						break;

					case 'yjt':
						echo $tab3 . '<enclosure type="' . esc_attr($image_type_enc) . '" url="' . esc_url($image_url_enc) . '" length="' . esc_attr($file_size_enc) . '"';
						if (!empty($alt_caption_enc)) {
							echo ' yj:caption="' . esc_attr($alt_caption_enc) . '"';
						}
						echo ' />' . PHP_EOL;
						break;

					case 'lnr':
						echo $tab3 . '<enclosure type="' . esc_attr($image_type_enc) . '" url="' . esc_url($image_url_enc) . '" />' . PHP_EOL;
						break;

					case 'dcm':
						echo $tab3 . '<enclosure type="' . esc_attr($image_type_enc) . '" img="' . esc_url($image_url_enc) . '" />' . PHP_EOL;
						break;

					default:
						// 特定のfeed_forがない場合は何もしない
						break;
				}
			}
		}
	}
}

/** ALTERNATE FOR SNF ******************************/
if($feed_for === 'snf'){
	if(empty($post_thumbnail_id) && empty($images_enc) && !empty($thumbnail)){
		echo $tab3.'<!-- alternate -->'.PHP_EOL;
		echo $tab3.'<media:thumbnail url="';
		echo esc_url($thumbnail);
		echo '" />'.PHP_EOL;
	}else{
	}
}else{
}

/** NORDOT ********************************/
if($feed_for === 'goo' && $status === 'future' || $feed_for === 'goo' && $status === 'private' || $feed_for === 'goo' && $status === 'trash' || $feed_for === 'goo' && $status === 'draft' || $feed_for === 'ant'||$feed_for === 'yjt' && $status === 'future' || $feed_for === 'yjt' && $status === 'private' || $feed_for === 'yjt' && $status === 'trash' || $feed_for === 'yjt' && $status === 'draft'){
}else{
	if($rel_nor_set === 0 || empty($nordot_unit_id)){
	}else{
		// 親要素が必要な場合の開始タグ
		if($feed_for === 'snf' && $rel_ad == 1){
		echo $tab3.'<snf:advertisement>'.PHP_EOL;
		}elseif($feed_for === 'isn'){
		echo $tab3.'<relatedLinks>'.PHP_EOL;
		}elseif($feed_for === 'yjt'){
		echo $tab3.'<yj:related>'.PHP_EOL;
		}else{}
		// エラーでない場合 JSON データを連想配列に変換して要素出力
		if(empty($nordot_error_reason)&&!empty($nordot_data['posts'])){
		$nordot_data = json_decode($nordot_response, true);
		$i = 0;
		foreach ($nordot_data['posts'] as $nordot_post) {
			$origin_title = esc_html(get_the_title());
			$nordot_title = $nordot_post['title'];
			$nordot_url = $nordot_post['url'];
			$nordot_thumb_360 = $nordot_post['images'][0]['thumb_360'];
			if($origin_title === $nordot_title){
			continue;
			}else{
			if($feed_for === 'goo'){
					echo $tab3.'<smp:relation>'.PHP_EOL;
					echo $tab4.'<smp:caption><![CDATA[';
					echo wp_strip_all_tags($nordot_title);
					echo ']]></smp:caption>'.PHP_EOL;
					echo $tab4.'<smp:url>';
					echo esc_url($nordot_url.$nordot_cu_id);
					echo '</smp:url>'.PHP_EOL;
					//if(!empty(has_post_thumbnail())){
					//echo $tab4.'<smp:img>'.esc_url(the_post_thumbnail_url('thumbnail')).'</smp:img>'.PHP_EOL;
					//}else{}
					echo $tab3.'</smp:relation>'.PHP_EOL;

					echo $tab3.'<goonews:relation>'.PHP_EOL;
					echo $tab4.'<goonews:caption><![CDATA[';
					echo wp_strip_all_tags($nordot_title);
					echo ']]></goonews:caption>'.PHP_EOL;
					echo $tab4.'<goonews:url>';
					echo esc_url($nordot_url.$nordot_cu_id);
					echo '</goonews:url>'.PHP_EOL;
					//if(!empty(has_post_thumbnail())){
					//echo $tab4,'<goonews:img>'.esc_url(the_post_thumbnail_url('thumbnail')).'</goonews:img>'.PHP_EOL;
					//}else{}
					echo $tab3.'</goonews:relation>'.PHP_EOL;
			}elseif($feed_for === 'gnf'){
					echo $tab3.'<gnf:relatedLink title="';
					echo wp_strip_all_tags($nordot_title);
					echo '" link="';
					echo esc_url($nordot_url.$nordot_cu_id);
					echo '"';
						if(!empty($nordot_thumb_360)){
						echo ' thumbnail="';
						echo esc_url($nordot_thumb_360);
						echo '"';
						}else{}
					echo ' />'.PHP_EOL;
			}elseif($feed_for === 'snf' && $rel_ad == 1){
					echo $tab4.'<snf:sponsoredLink link="';
					echo esc_url($nordot_url.$nordot_cu_id);
					echo '"';
						if(!empty(esc_url($nordot_thumb_360))){
							echo ' thumbnail="';
							echo esc_url($nordot_thumb_360);
							echo '"';
						}else{}
					echo ' title="';
					echo wp_strip_all_tags($nordot_title);
					echo '"';
					echo ' advertiser="';
					if($channel_title !== ''){
						echo esc_attr($channel_title);
					}else{
						echo esc_attr(bloginfo('name'));
					}
					echo '"';
					echo ' />'.PHP_EOL;
			}elseif($feed_for === 'dcm'||$feed_for === 'spb'){
					echo $tab3.'<relatedLink title="';
					echo wp_strip_all_tags($nordot_title);
					echo '" link="';
					echo esc_url($nordot_url.$nordot_cu_id);
					echo '"';
						if(!empty(esc_url($nordot_thumb_360))){
						echo ' thumbnail="';
						echo esc_url($nordot_thumb_360);
						echo '"';
						}else{}
					echo ' />'.PHP_EOL;
			}elseif($feed_for === 'lnr'){
					echo $tab3.'<oa:reflink>'.PHP_EOL;
					echo $tab4.'<oa:refTitle><![CDATA[';
					echo wp_strip_all_tags($nordot_title);
					echo ']]></oa:refTitle>'.PHP_EOL;
					echo $tab4.'<oa:refUrl>';
					echo esc_url($nordot_url.$nordot_cu_id);
					echo '</oa:refUrl>'.PHP_EOL;
					echo $tab3.'</oa:reflink>'.PHP_EOL;
			}elseif($feed_for === 'ldn'){
					echo $tab3.'<ldnfeed:rel>'.PHP_EOL;
					echo $tab4.'<ldnfeed:rel_subject><![CDATA[';
					echo wp_strip_all_tags($nordot_title);
					echo ']]></ldnfeed:rel_subject>'.PHP_EOL;
					echo $tab4.'<ldnfeed:rel_link>';
					echo esc_url($nordot_url.$nordot_cu_id);
					echo '</ldnfeed:rel_link>'.PHP_EOL;
					echo $tab3.'</ldnfeed:rel>'.PHP_EOL;
			}elseif($feed_for === 'isn'){
					echo $tab4.'<relatedLink>'.PHP_EOL;
					echo $tab5.'<title><![CDATA[';
					echo wp_strip_all_tags($nordot_title);
					echo ']]></title>'.PHP_EOL;
					echo $tab5.'<url>';
					echo esc_url($nordot_url.$nordot_cu_id);
					echo '</url>'.PHP_EOL;
					echo $tab4.'</relatedLink>'.PHP_EOL;
			}elseif($feed_for === 'trl'){
					echo $tab3.'<trill:relatedItem>'.PHP_EOL;
					echo $tab4.'<trill:title><![CDATA[';
					echo wp_strip_all_tags($nordot_title);
					echo ']]></trill:title>'.PHP_EOL;
					echo $tab4.'<trill:link>';
					echo esc_url($nordot_url.$nordot_cu_id);
					echo '</trill:link>'.PHP_EOL;
					echo $tab3.'</trill:relatedItem>'.PHP_EOL;
			}elseif($feed_for === 'yjt'){
					echo $tab3.'<yj:link yj:url="';
					echo esc_url($nordot_url.$nordot_cu_id);
					echo '"><![CDATA[';
					echo wp_strip_all_tags($nordot_title);
					echo ']]></yj:link>'.PHP_EOL;
			}else{
			}
		$i++;
		if ($i >= $rel_count) {
			break;
		}//end foreach
		}// エラーでない場合 JSON データを連想配列に変換して要素出力の終了
			}
		}else{
		}
		// 親要素が必要な場合の終了タグ
		if($feed_for === 'snf' && $rel_ad == 1){
		echo $tab3.'</snf:advertisement>'.PHP_EOL;
		}elseif($feed_for === 'isn'){
		echo $tab3.'</relatedLinks>'.PHP_EOL;
		}elseif($feed_for === 'yjt'){
		echo $tab3.'</yj:related>'.PHP_EOL;
		}else{
		}
	}
}
/** RELATION ******************************/
if($feed_for === 'goo' && $status === 'future' || $feed_for === 'goo' && $status === 'private' || $feed_for === 'goo' && $status === 'trash' || $feed_for === 'goo' && $status === 'draft' || $feed_for === 'ant'||$feed_for === 'yjt' && $status === 'future' || $feed_for === 'yjt' && $status === 'private' || $feed_for === 'yjt' && $status === 'trash' || $feed_for === 'yjt' && $status === 'draft'){
}else{
	if($rel_count > 0){
				$feeld_count = '0';
				if($rel_manual === '1'){
					if(!empty($cf_rel_feeld1)){
						$cf1 = get_post_meta(get_the_ID(),$cf_rel_feeld1,true);
						if(!empty($cf1)){
							$post_id1 = url_to_postid( $cf1 );
							$post1 = get_post( $post_id1 );
							$post_title1 = $post1->post_title;
							$feeld_count++;
						}
					}
					if(!empty($cf_rel_feeld2)){
						$cf2 = get_post_meta(get_the_ID(),$cf_rel_feeld2,true);
						if(!empty($cf2)){
							$post_id2 = url_to_postid( $cf2 );
							$post2 = get_post( $post_id2 );
							$post_title2 = $post2->post_title;
							$feeld_count++;
						}
					}
					if(!empty($cf_rel_feeld3)){
						$cf3 = get_post_meta(get_the_ID(),$cf_rel_feeld3,true);
						if(!empty($cf3)){
							$post_id3 = url_to_postid( $cf3 );
							$post3 = get_post( $post_id3 );
							$post_title3 = $post3->post_title;
							$feeld_count++;
						}
					}
				}
				if(!empty(has_category())||!empty(has_tag())){
					if($rel_tag === '1' && !empty(has_tag())){
						$post_tags = get_the_tags();
						$tag_term_ids = array();
						foreach ($post_tags as $tag){
						$tag_term_ids[] = $tag->term_id;
						}
					}else{
						$categories = get_the_category();
						$cat_term_ids = array();
						foreach($categories as $category){
						$cat_term_ids[] = $category->term_id;
						}
					}
					if($rel_tag === '1' && !empty(has_tag())){
						$relargs = array(
							'post_type' => $post_type,
							'post_status' => $publish,
							'posts_per_page' => $rel_count - $feeld_count,
							'ignore_sticky_posts' => true,
							'post__not_in' => array($post->ID),
							'tag__in' => $tag_term_ids, // カテゴリからタグに変更
							'orderby' => 'date'
						);
					}else{
						$relargs = array(
							'post_type' => $post_type,
							'post_status' => $publish,
							'posts_per_page' => $rel_count - $feeld_count,
							'ignore_sticky_posts' => true,
							'post__not_in' => array($post->ID),
							'category__in' => $cat_term_ids,
							'orderby' => 'date'
						);
					}
					$the_query = new WP_Query($relargs);
			if(!empty($the_query->post_count > 0)){
				if($feed_for === 'goo'){
					if($rel_nor_set === '1' && !empty($nordot_unit_id)){
					}else{

					// ここからgoo手動関連記事リンク
					if($rel_manual === '1'){
						if(!empty($cf1)){
							echo $tab3.'<smp:relation>'.PHP_EOL;
							echo $tab4.'<smp:caption><![CDATA[';
							echo $post_title1;
							echo ']]></smp:caption>'.PHP_EOL;
							echo $tab4.'<smp:url>';
							echo $cf1;
							echo '</smp:url>'.PHP_EOL;
							echo $tab3.'</smp:relation>'.PHP_EOL;
						}
						if(!empty($cf2)){
							echo $tab3.'<smp:relation>'.PHP_EOL;
							echo $tab4.'<smp:caption><![CDATA[';
							echo $post_title2;
							echo ']]></smp:caption>'.PHP_EOL;
							echo $tab4.'<smp:url>';
							echo $cf2;
							echo '</smp:url>'.PHP_EOL;
							echo $tab3.'</smp:relation>'.PHP_EOL;
						}
						if(!empty($cf3)){
							echo $tab3.'<smp:relation>'.PHP_EOL;
							echo $tab4.'<smp:caption><![CDATA[';
							echo $post_title3;
							echo ']]></smp:caption>'.PHP_EOL;
							echo $tab4.'<smp:url>';
							echo $cf3;
							echo '</smp:url>'.PHP_EOL;
							echo $tab3.'</smp:relation>'.PHP_EOL;
						}
					}
					// ここまでgoo手動関連記事リンク

					while($the_query->have_posts()):
						$the_query->the_post();
						echo $tab3.'<smp:relation>'.PHP_EOL;
						echo $tab4.'<smp:caption><![CDATA[';
						echo wp_strip_all_tags(get_the_title());
						echo ']]></smp:caption>'.PHP_EOL;
						echo $tab4.'<smp:url>';
						if(!empty($rel_urlpass)){
						$post_id = get_the_ID();
						$rel_url = $rel_urlpass.$post_id;
						}else{
						$rel_url = esc_url(get_the_permalink());
						}
						echo $rel_url;
						echo '</smp:url>'.PHP_EOL;
						//if(!empty(has_post_thumbnail())){
						//echo $tab4.'<smp:img>'.esc_url(the_post_thumbnail_url('thumbnail')).'</smp:img>'.PHP_EOL;
						//}else{}
						echo $tab3.'</smp:relation>'.PHP_EOL;
					endwhile;

					// ここからgoo手動関連記事リンク
					if($rel_manual === '1'){
						if(!empty($cf1)){
							echo $tab3.'<goonews:relation>'.PHP_EOL;
							echo $tab4.'<goonews:caption><![CDATA[';
							echo $post_title1;
							echo ']]></goonews:caption>'.PHP_EOL;
							echo $tab4.'<goonews:url>';
							echo $cf1;
							echo '</goonews:url>'.PHP_EOL;
							echo $tab3.'</goonews:relation>'.PHP_EOL;
						}
						if(!empty($cf2)){
							echo $tab3.'<goonews:relation>'.PHP_EOL;
							echo $tab4.'<goonews:caption><![CDATA[';
							echo $post_title2;
							echo ']]></goonews:caption>'.PHP_EOL;
							echo $tab4.'<goonews:url>';
							echo $cf2;
							echo '</goonews:url>'.PHP_EOL;
							echo $tab3.'</goonews:relation>'.PHP_EOL;
						}
						if(!empty($cf3)){
							echo $tab3.'<goonews:relation>'.PHP_EOL;
							echo $tab4.'<goonews:caption><![CDATA[';
							echo $post_title3;
							echo ']]></goonews:caption>'.PHP_EOL;
							echo $tab4.'<goonews:url>';
							echo $cf3;
							echo '</goonews:url>'.PHP_EOL;
							echo $tab3.'</goonews:relation>'.PHP_EOL;
						}
					}
					// ここまでgoo手動関連記事リンク

					while($the_query->have_posts()):
					$the_query->the_post();
						echo $tab3.'<goonews:relation>'.PHP_EOL;
						echo $tab4.'<goonews:caption><![CDATA[';
						echo wp_strip_all_tags(get_the_title());
						echo ']]></goonews:caption>'.PHP_EOL;
						echo $tab4.'<goonews:url>';
						if(!empty($rel_urlpass)){
						$post_id = get_the_ID();
						$rel_url = $rel_urlpass.$post_id;
						}else{
						$rel_url = esc_url(get_the_permalink());
						}
						echo $rel_url;
						echo '</goonews:url>'.PHP_EOL;
						//if(!empty(has_post_thumbnail())){
						//echo $tab4,'<goonews:img>'.esc_url(the_post_thumbnail_url('thumbnail')).'</goonews:img>'.PHP_EOL;
						//}else{}
						echo $tab3.'</goonews:relation>'.PHP_EOL;
					endwhile;
					}
				}elseif($feed_for === 'gnf'){
					if($rel_nor_set === '1' && !empty($nordot_unit_id)){
					}else{
					while($the_query->have_posts()):
					$the_query->the_post();
						echo $tab3.'<gnf:relatedLink title="';
						echo wp_strip_all_tags(get_the_title());
						echo '" link="';
						if(!empty($rel_urlpass)){
						$post_id = get_the_ID();
						$rel_url = $rel_urlpass.$post_id;
						}else{
						$rel_url = esc_url(get_the_permalink());
						}
						echo $rel_url;
						echo '"';
							if(!empty(has_post_thumbnail())){
							echo ' thumbnail="';
							echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'));
							echo '"';
							}else{}
						echo ' />'.PHP_EOL;
					endwhile;
					}
				}elseif($feed_for === 'snf' && $rel_ad == 1){
					if($rel_nor_set === '1' && !empty($nordot_unit_id)){
					}else{
						echo $tab3.'<snf:advertisement>'.PHP_EOL;
					while($the_query->have_posts()):
					$the_query->the_post();
						echo $tab4.'<snf:sponsoredLink link="';
						if(!empty($rel_urlpass)){
						$post_id = get_the_ID();
						$rel_url = $rel_urlpass.$post_id;
						}else{
						$rel_url = esc_url(get_the_permalink());
						}
						echo $rel_url;
						echo '"';
							if(!empty(has_post_thumbnail())){
								echo ' thumbnail="';
								echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'));
								echo '"';
							}else{}
						echo ' title="';
						echo wp_strip_all_tags(get_the_title());
						echo '"';
						echo ' advertiser="';
						if($channel_title !== ''){
							echo esc_attr($channel_title);
						}else{
							echo esc_attr(bloginfo('name'));
						}
						echo '"';
						echo ' />'.PHP_EOL;
					endwhile;
						echo $tab3.'</snf:advertisement>'.PHP_EOL;
					}
				}elseif($feed_for === 'dcm'||$feed_for === 'spb'){
					if($rel_nor_set === '1' && !empty($nordot_unit_id)){
					}else{
					while($the_query->have_posts()):
					$the_query->the_post();
						echo $tab3.'<relatedLink title="';
						echo wp_strip_all_tags(get_the_title());
						if($feed_for === 'dcm'){
							echo '" link="';
						}elseif($feed_for === 'spb'){
							echo '" url="';
						}
						if(!empty($rel_urlpass)){
						$post_id = get_the_ID();
						$rel_url = $rel_urlpass.$post_id;
						}else{
						$rel_url = esc_url(get_the_permalink());
						}
						echo $rel_url;
						echo '"';
						if($feed_for === 'dcm'){
							if(!empty(has_post_thumbnail())){
							echo ' thumbnail="';
							echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'));
							echo '"';
							}else{
							}
						}
						echo ' />'.PHP_EOL;
					endwhile;
					}
				}elseif($feed_for === 'lnr'){
					if($rel_nor_set === '1' && !empty($nordot_unit_id)){
					}else{
					while($the_query->have_posts()):
					$the_query->the_post();
						echo $tab3.'<oa:reflink>'.PHP_EOL;
						echo $tab4.'<oa:refTitle><![CDATA[';
						echo wp_strip_all_tags(get_the_title());
						echo ']]></oa:refTitle>'.PHP_EOL;
						echo $tab4.'<oa:refUrl>';
						if(!empty($rel_urlpass)){
						$post_id = get_the_ID();
						$rel_url = $rel_urlpass.$post_id;
						}else{
						$rel_url = esc_url(get_the_permalink());
						}
						echo $rel_url;
						echo '</oa:refUrl>'.PHP_EOL;
						echo $tab3.'</oa:reflink>'.PHP_EOL;
					endwhile;
					}
				}elseif($feed_for === 'ldn'){
					if($rel_nor_set === '1' && !empty($nordot_unit_id)){
					}else{
					while($the_query->have_posts()):
					$the_query->the_post();
						echo $tab3.'<ldnfeed:rel>'.PHP_EOL;
						echo $tab4.'<ldnfeed:rel_subject><![CDATA[';
						echo wp_strip_all_tags(get_the_title());
						echo ']]></ldnfeed:rel_subject>'.PHP_EOL;
						echo $tab4.'<ldnfeed:rel_link>';
						if(!empty($rel_urlpass)){
						$post_id = get_the_ID();
						$rel_url = $rel_urlpass.$post_id;
						}else{
						$rel_url = esc_url(get_the_permalink());
						}
						echo $rel_url;
						echo '</ldnfeed:rel_link>'.PHP_EOL;
						echo $tab3.'</ldnfeed:rel>'.PHP_EOL;
					endwhile;
					}
				}elseif($feed_for === 'isn'){
					if($rel_nor_set === '1' && !empty($nordot_unit_id)){
					}else{
						echo $tab3.'<relatedLinks>'.PHP_EOL;
					while($the_query->have_posts()):
					$the_query->the_post();
						echo $tab4.'<relatedLink>'.PHP_EOL;
						echo $tab5.'<title><![CDATA[';
						echo wp_strip_all_tags(get_the_title());
						echo ']]></title>'.PHP_EOL;
						echo $tab5.'<url>';
						if(!empty($rel_urlpass)){
						$post_id = get_the_ID();
						$rel_url = $rel_urlpass.$post_id;
						}else{
						$rel_url = esc_url(get_the_permalink());
						}
						echo $rel_url;
						echo '</url>'.PHP_EOL;
						echo $tab4.'</relatedLink>'.PHP_EOL;
					endwhile;
						echo $tab3.'</relatedLinks>'.PHP_EOL;
					}

				}elseif($feed_for === 'yjt'){
					if($rel_nor_set === '1' && !empty($nordot_unit_id)){
					}else{
						echo $tab3.'<yj:related>'.PHP_EOL;
					while($the_query->have_posts()):
					$the_query->the_post();
						echo $tab4.'<yj:link yj:url="';
						if(!empty($rel_urlpass)){
						$post_id = get_the_ID();
						$rel_url = $rel_urlpass.$post_id;
						}else{
						$rel_url = esc_url(get_the_permalink());
						}
						echo $rel_url;
						echo '"><![CDATA[';
						echo wp_strip_all_tags(get_the_title());
						echo ']]></yj:link>'.PHP_EOL;
					endwhile;
						echo $tab3.'</yj:related>'.PHP_EOL;
					}
				}elseif($feed_for === 'trl'){
					if($rel_nor_set === '1' && !empty($nordot_unit_id)){
					}else{
					while($the_query->have_posts()):
					$the_query->the_post();
						echo $tab3.'<trill:relatedItem>'.PHP_EOL;
						echo $tab4.'<trill:title><![CDATA[';
						echo wp_strip_all_tags(get_the_title());
						echo ']]></trill:title>'.PHP_EOL;
						echo $tab4.'<trill:link>';
						if(!empty($rel_urlpass)){
						$post_id = get_the_ID();
						$rel_url = $rel_urlpass.$post_id;
						}else{
						$rel_url = esc_url(get_the_permalink());
						}
						echo $rel_url;
						echo '</trill:link>'.PHP_EOL;
						echo $tab3.'</trill:relatedItem>'.PHP_EOL;
					endwhile;
					}
				}else{
				}
			}else{
			}
		}else{
		}
	}else{
	}
}

/** SNF:ADVERTISEMENT ******************************/
if($feed_for === 'snf' && $rel_ad == 0 && $rel_link1 !== "" && $rel_advertiser1 !== ""||$feed_for === 'snf' && $rel_ad == 0 && $rel_link2 !== "" && $rel_advertiser2 !== ""){
	echo $tab3.'<snf:advertisement>'.PHP_EOL;
	if($rel_link1 !== ""){
		echo $tab4.'<snf:sponsoredLink link="';
		echo esc_url($rel_link1);
		echo '"';
		if(!empty($rel_thumbnail1)){
			echo ' thumbnail="';
			echo esc_url($rel_thumbnail1);
			echo '"';
		}else{}
		if(!empty($rel_title1)){
			echo ' title="';
			echo esc_attr($rel_title1);
			echo '"';
		}else{}
		echo ' advertiser="';
		echo esc_attr($rel_advertiser1);
		echo '" />'.PHP_EOL;
		echo $tab3.'</snf:advertisement>'.PHP_EOL;
	}else{}
	if($rel_link2 !== ""){
		echo $tab4.'<snf:sponsoredLink link="';
		echo esc_url($rel_link2);
		echo '"';
		if(!empty($rel_thumbnail2)){
			echo ' thumbnail="';
			echo esc_url($rel_thumbnail2);
			echo '"';
		}else{}
		if(!empty($rel_title2)){
			echo ' title="';
			echo esc_attr($rel_title2);
			echo '"';
		}else{}
		echo ' advertiser="';
		echo esc_attr($rel_advertiser2);
		echo '" />'.PHP_EOL;
		echo $tab3.'</snf:advertisement>'.PHP_EOL;
	}else{}
}else{
}
echo $tab2.'</item>'.PHP_EOL;

}else{
}
endwhile;
endif;
wp_reset_postdata();

function  cuerda_ynf_infomation(){
	$ynf_date = isset($_GET['ynf_date']) ? sanitize_text_field( wp_unslash( $_GET['ynf_date'] ) ) : '';
	if(!$ynf_date){$ynf_date = current_time('Ymd');}
	// 接続情報
	$ftp_server = get_option('cuerda_ynf_ftp_server','');
	$ftp_user_name = get_option('cuerda_ynf_ftp_user_name','');
	$ftp_user_pass = get_option('cuerda_ynf_ftp_password','');
	$ftp_remote_dir = get_option('cuerda_ynf_ftp_remote_dir','');
	$ftp_remote_dir_done = '/done-'.$ynf_date;
	$ftp_remote_dir_ng = '/done-ng';
	$ftp_remote_dir_feed = $ftp_remote_dir;

	// FTPサーバーに接続
	$conn_id = ftp_ssl_connect($ftp_server);

	if (!$conn_id) {
		die("FTPサーバーへの接続に失敗しました");
	}
	// ユーザー名とパスワードでログイン
	$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
	if(!$login_result){
		die("FTPサーバーへのログインに失敗しました");
	}

	// パッシブモードを有効にする
	ftp_pasv($conn_id, true);

	// ディレクトリを変更
	if(ftp_chdir($conn_id, $ftp_remote_dir_feed)){
		// ファイル一覧を取得
		$files = ftp_nlist($conn_id, ".");
		// 結果を表示
		if ($files !== false) {
			echo "\n".'▼ 配信ディレクトリ '.$ftp_remote_dir_feed. ' 内のファイル一覧'."\n";
			foreach ($files as $file) {
				echo $file . "\n";
			}
		}else{
			echo "\n".$ftp_remote_dir_feed.' ファイル一覧の取得に失敗しました'."\n";
			$error = error_get_last();
			echo "Error details: " . $error['message'] . "\n";
		}
	}else{
		echo $ftp_remote_dir_feed.' ディレクトリの指定に失敗しました'."\n";
	}

	// ディレクトリを変更
	if(ftp_chdir($conn_id, $ftp_remote_dir_ng)){
		// ファイル一覧を取得
		$files = ftp_nlist($conn_id, ".");
		// 結果を表示
		if ($files !== false) {
			echo "\n".'▼ 失敗ディレクトリ '.$ftp_remote_dir_ng. ' 内のファイル一覧'."\n";
			foreach ($files as $file) {
				echo $file . "\n";
			}
		}else{
			echo "\n".$ftp_remote_dir_ng.' ファイル一覧の取得に失敗しました'."\n";
			$error = error_get_last();
			echo "Error details: " . $error['message'] . "\n";
		}
	}else{
		echo $ftp_remote_dir_ng.' ディレクトリの指定に失敗しました'."\n";
	}

	$files = ftp_nlist($conn_id, $ftp_remote_dir_done);
	if ($files !== false) {
		// ディレクトリが存在する場合の処理
		if (count($files) > 0) {
			if (ftp_chdir($conn_id, $ftp_remote_dir_done)) {
				$files = ftp_nlist($conn_id, ".");
				if ($files !== false) {
					echo "\n" . '▼ 成功ディレクトリ '. $ftp_remote_dir_done . ' 内のファイル一覧' . "\n";
					echo '&ynf_date=Ymd パラメータで指定可能です。' . "\n";
					foreach ($files as $file) {
						echo $file . "\n";
					}
				}else{
					echo "\n" . $ftp_remote_dir_done . ' ファイル一覧の取得に失敗しました' . "\n";
					$error = error_get_last();
					echo "Error details: " . $error['message'] . "\n";
				}
			}else{
				echo "\n" . '成功ディレクトリ '.$ftp_remote_dir_done . ' は只今存在しません。' . "\n";
			}
		}else{
			// ディレクトリは存在するが中身が空の場合の処理
			echo "\n" . '▼ 成功ディレクトリ '.$ftp_remote_dir_done . ' は存在しますが、中身が空です。' . "\n";
		}
	}else{
		// ディレクトリが存在しない場合の処理
		echo "\n" . '▼ 成功ディレクトリ '.$ftp_remote_dir_done . ' はまだ存在しません。' . "\n";
	}

	// 接続を閉じる
	ftp_close($conn_id);
}

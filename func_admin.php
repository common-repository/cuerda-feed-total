<?php 
// cerda（クエルダ）は本プログラムソースコードの著作権を保有しています。
// Copyright (C) 2020 CUERDA(https://cuerda.org).
if(!defined('ABSPATH')){
die('Forbidden');
}
if($admin_comment == true){
echo PHP_EOL.'<!-- '.PHP_EOL;
echo 'Version：'.$version.PHP_EOL;
echo PHP_EOL.'[Categories]'.PHP_EOL;
	if(strstr($url_param,'cat=true')){
	$args1 = array('orderby' => 'count','order' => 'DSC','hide_empty' => false);
	$categories = get_categories($args1);
		foreach($categories as $category){
		echo get_category_link( $category->term_id )."\t"." => "."\t".$category->name."\t"."（term_id=".$category->term_id."）".PHP_EOL;
		}
	}else{
	echo '&cat=true'.PHP_EOL;
	}
echo PHP_EOL.'[Tags]'.PHP_EOL;
	if(strstr($url_param,'tag=true')){
	$args2 = array('orderby' => 'count','order' => 'DSC','hide_empty' => false);
	$posttags = get_tags($args2);
		if (!empty($posttags)){
			foreach($posttags as $tag){
			echo get_tag_link($tag->term_id)."\t"." => "."\t".$tag->name."\t"."（term_id=".$tag->term_id."）".PHP_EOL;
			}
		}else{
		}
	}else{
	echo '&tag=true'.PHP_EOL;
	}
	echo PHP_EOL.'[Option]'.PHP_EOL;
	echo 'channel_title           => '.$channel_title.PHP_EOL;
	if($feed_for === 'snf'||$feed_for === 'gnf'){
		echo 'ttl                     => '.$ttl.PHP_EOL;
	}else{}
	echo 'cuerda_total_choice_ynf => '.get_option('cuerda_total_choice_ynf','').PHP_EOL;
	echo 'cuerda_total_choice_yjt => '.get_option('cuerda_total_choice_yjt','').PHP_EOL;
	echo 'cuerda_total_choice_goo => '.get_option('cuerda_total_choice_goo','').PHP_EOL;
	echo 'cuerda_total_choice_snf => '.get_option('cuerda_total_choice_snf','').PHP_EOL;
	echo 'cuerda_total_choice_gnf => '.get_option('cuerda_total_choice_gnf','').PHP_EOL;
	echo 'cuerda_total_choice_lnr => '.get_option('cuerda_total_choice_lnr','').PHP_EOL;
	echo 'cuerda_total_choice_dcm => '.get_option('cuerda_total_choice_dcm','').PHP_EOL;
	echo 'cuerda_total_choice_spb => '.get_option('cuerda_total_choice_spb','').PHP_EOL;
	echo 'cuerda_total_choice_ldn => '.get_option('cuerda_total_choice_ldn','').PHP_EOL;
	echo 'cuerda_total_choice_isn => '.get_option('cuerda_total_choice_isn','').PHP_EOL;
	echo 'cuerda_total_choice_trl => '.get_option('cuerda_total_choice_trl','').PHP_EOL;
	echo 'cuerda_total_choice_ant => '.get_option('cuerda_total_choice_ant','').PHP_EOL;
	echo 'rel_urlpass             => '.get_option('cuerda_total_rel_urlpass','').PHP_EOL;
	echo 'post_type               => '.implode(',',$post_type).PHP_EOL;
	echo 'post_status             => '.implode(',',$post_status).PHP_EOL;
	echo 'publish_status          => '.implode(',',$publish_status).PHP_EOL;
	echo 'posts_per_page          => '.$posts_per_page.PHP_EOL;
	echo 'author__in              => '.implode(',',$author__in).PHP_EOL;
	echo 'author__not_in          => '.implode(',',$author__not_in).PHP_EOL;
	echo 'category__in            => '.implode(',',$category__in).PHP_EOL;
	echo 'category__not_in        => '.implode(',',$category__not_in).PHP_EOL;
	echo 'tag__in                 => '.implode(',',$tag__in).PHP_EOL;
	echo 'tag__not_in             => '.implode(',',$tag__not_in).PHP_EOL;
	echo 'post__not_in            => '.implode(',',$post__not_in).PHP_EOL;
	echo 'after_modified          => '.$after_modified.PHP_EOL;
	echo 'after_date              => '.$after_date.PHP_EOL;
	echo 'publish_delay           => '.$publish_delay.PHP_EOL;
	echo 'cf_publish_delay        => '.$cf_publish_delay.PHP_EOL;
	if($feed_for === 'lnr'){
		echo 'expire                  => '.$expire.PHP_EOL;
	}else{}
	if($feed_for === 'gnf'||$feed_for === 'snf'){
		echo 'logo                    => '.$logo.PHP_EOL;
	}else{}
	if($feed_for === 'snf'){
		echo 'darkmodelogo            => '.$darkmodelogo.PHP_EOL;
	}else{}
	if($feed_for === 'gnf'){
		echo 'wide_logo               => '.$wide_logo.PHP_EOL;
	}else{}
	if($feed_for === 'gnf'||$feed_for === 'dcm'||$feed_for === 'spb'||$feed_for === 'ant'){
		echo 'copyright               => '.$copyright.PHP_EOL;
	}else{}
	if($feed_for === 'goo'||$feed_for === 'dcm'){
		echo 'category__absolute      => '.$category__absolute.PHP_EOL;
	}else{}
	echo 'cf_creator              => '.$cf_creator.PHP_EOL;
	if($feed_for === 'goo'||$feed_for === 'lnr'){
		echo 'enc_video               => '.$enc_video.PHP_EOL;
	}else{}
	echo 'enc_icatch              => '.$enc_icatch.PHP_EOL;
	echo 'enc_image               => '.$enc_image.PHP_EOL;
	echo 'add_icatch              => '.$add_icatch.PHP_EOL;
	echo 'atag                    => '.$atag.PHP_EOL;
	if($feed_for === 'snf'){
		echo 'thumbnail               => '.$thumbnail.PHP_EOL;
		echo 'rel_ad                  => '.$rel_ad.PHP_EOL;
		echo 'rel_link1               => '.$rel_link1.PHP_EOL;
		echo 'rel_title1              => '.$rel_title1.PHP_EOL;
		echo 'rel_thumbnail1          => '.$rel_thumbnail1.PHP_EOL;
		echo 'rel_advertiser1         => '.$rel_advertiser1.PHP_EOL;
		echo 'rel_link2               => '.$rel_link2.PHP_EOL;
		echo 'rel_title2              => '.$rel_title2.PHP_EOL;
		echo 'rel_thumbnail2          => '.$rel_thumbnail2.PHP_EOL;
		echo 'rel_advertiser2         => '.$rel_advertiser2.PHP_EOL;
	}else{}
	echo 'enclosure_alt           => '.$enclosure_alt.PHP_EOL;
	if($feed_for !== 'ant'){
	echo 'rel_count               => '.$rel_count.PHP_EOL;
	echo 'rel_tag                 => '.$rel_tag.PHP_EOL;
	echo 'rel_manual              => '.$rel_manual.PHP_EOL;
	echo 'nordot_unit_id          => '.$nordot_unit_id.PHP_EOL;
	echo 'nordot_cu_id            => '.$nordot_cu_id.PHP_EOL;
	}else{}
	echo 'cf_youtube              => '.$cf_youtube.PHP_EOL;
	if($feed_for === 'ynf'||$feed_for === 'lnr'||$feed_for === 'goo'){
		echo 'area_city               => '.$area_city.PHP_EOL;
	}else{}
	if($feed_for === 'yjt'||$feed_for === 'lnr'||$feed_for === 'dcm'||$feed_for === 'spb'||$feed_for === 'trl'){
		echo 'table                   => '.$table.PHP_EOL;
		echo 'table_inline            => '.$table_inline.PHP_EOL;
		echo 'table_inline_delimiter  => '.$table_inline_delimiter.PHP_EOL;
	}else{}
	if(!empty($sentence_delete)){
	echo 'sentence_delete         => '.implode(',',$sentence_delete).PHP_EOL;
	}else{}
	if($feed_for !== 'ynf'){
		if(!empty($regular_expression_delete)){
		echo 'expression_delete       => '.implode(',',$regular_expression_delete).PHP_EOL;
		}
	}else{}
	if($feed_for === 'ynf'){
		$ynf_ftp_put = get_option('cuerda_ynf_ftp_put',0);
		$ynf_ftp_server = get_option('cuerda_ynf_ftp_server','');
		$ynf_ftp_user_name = get_option('cuerda_ynf_ftp_user_name','');
		$ynf_ftp_password = get_option('cuerda_ynf_ftp_password','');
		$ynf_ftp_remote_dir = get_option('cuerda_ynf_ftp_remote_dir','');
		$ynf_ldap_user = get_option('cuerda_ynf_ldap_user','');
		$ynf_ldap_pass = get_option('cuerda_ynf_ldap_pass','');
		$ynf_id = get_option('cuerda_ynf_id','');
		$ynf_articletype = get_option('cuerda_ynf_articletype','');
		$ynf_article_summary = get_option('cuerda_ynf_article_summary','');
		echo 'ynf_ftp_put             => '.$ynf_ftp_put.PHP_EOL;
		echo 'ynf_ftp_server          => '.$ynf_ftp_server.PHP_EOL;
		echo 'ynf_ftp_user_name       => '.$ynf_ftp_user_name.PHP_EOL;
		echo 'ynf_ftp_password        => '.$ynf_ftp_password.PHP_EOL;
		echo 'ynf_ftp_remote_dir      => '.$ynf_ftp_remote_dir.PHP_EOL;
		echo 'ynf_id                  => '.$ynf_id.PHP_EOL;
		echo 'ynf_ldap_user           => '.$ynf_ldap_user.PHP_EOL;
		echo 'ynf_ldap_pass           => '.$ynf_ldap_pass.PHP_EOL;
		echo 'ynf_articletype         => '.$ynf_articletype.PHP_EOL;
		echo 'ynf_article_summary     => '.$ynf_article_summary.PHP_EOL;
		$debug_file_path = plugin_dir_path(__FILE__) . 'debug.php';
		global $wp_filesystem;
		// WP_Filesystemの初期化
		if ( ! function_exists( 'WP_Filesystem' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
		}
		WP_Filesystem(); // 初期化
		if ( $wp_filesystem->exists( $debug_file_path ) ) {
			$debug_content = $wp_filesystem->get_contents( $debug_file_path );
			echo 'debug  ↓ ' . PHP_EOL . PHP_EOL . $debug_content . PHP_EOL . PHP_EOL;
		}
	}else{}
	$size_in_bytes = memory_get_usage();
	$size_in_mb = $size_in_bytes/1024/1024;
	$rounded = round($size_in_mb,2);
	echo 'mem_usage               => '.$rounded.'MB'.PHP_EOL;
	$size_in_bytes_peak = memory_get_peak_usage();
	$size_in_mb_peak = $size_in_bytes_peak/1024/1024;
	$rounded_peak = round($size_in_mb_peak,2);
	echo 'peak_mem_usage          => '.$rounded_peak.'MB'.PHP_EOL;
	echo ' -->'.PHP_EOL;
}else{
}

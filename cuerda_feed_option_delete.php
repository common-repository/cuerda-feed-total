<?php
// cerda（クエルダ）は本プログラムソースコードの著作権を保有しています。
// Copyright (C) 2020 CUERDA(https://cuerda.org).
if(!defined('ABSPATH')){
die('Forbidden');
}

/* *************************************************************
 オプションキーの削除
************************************************************* */
function cuerda_uninstall_hook_feed_cuerda_total(){
	// 基本設定に表示させるタブ選択
	delete_option('cuerda_total_choice_ynf');
	delete_option('cuerda_total_choice_yjt');
	delete_option('cuerda_total_choice_goo');
	delete_option('cuerda_total_choice_dcm');
	delete_option('cuerda_total_choice_spb');
	delete_option('cuerda_total_choice_snf');
	delete_option('cuerda_total_choice_gnf');
	delete_option('cuerda_total_choice_lnr');
	delete_option('cuerda_total_choice_ldn');
	delete_option('cuerda_total_choice_isn');
	delete_option('cuerda_total_choice_ant');
	delete_option('cuerda_total_choice_trl');
	// フィードのブラウザキャッシュ
	delete_option('cuerda_total_expires');
	delete_option('cuerda_ynf_expires');
	delete_option('cuerda_yjt_expires');
	delete_option('cuerda_goo_expires');
	delete_option('cuerda_dcm_expires');
	delete_option('cuerda_spb_expires');
	delete_option('cuerda_snf_expires');
	delete_option('cuerda_gnf_expires');
	delete_option('cuerda_lnr_expires');
	delete_option('cuerda_ldn_expires');
	delete_option('cuerda_isn_expires');
	delete_option('cuerda_ant_expires');
	delete_option('cuerda_trl_expires');
	// ノアドット・コンテンツホルダー・ユニットID nordot_unit_id
	delete_option('cuerda_total_nordot_unit_id');
	delete_option('cuerda_ynf_nordot_unit_id');
	delete_option('cuerda_yjt_nordot_unit_id');
	delete_option('cuerda_goo_nordot_unit_id');
	delete_option('cuerda_dcm_nordot_unit_id');
	delete_option('cuerda_spb_nordot_unit_id');
	delete_option('cuerda_snf_nordot_unit_id');
	delete_option('cuerda_gnf_nordot_unit_id');
	delete_option('cuerda_lnr_nordot_unit_id');
	delete_option('cuerda_ldn_nordot_unit_id');
	delete_option('cuerda_isn_nordot_unit_id');
	delete_option('cuerda_ant_nordot_unit_id');
	delete_option('cuerda_trl_nordot_unit_id');
	// ノアドット・キュレーター・ユニットID nordot_cu_id
	delete_option('cuerda_total_nordot_cu_id');
	delete_option('cuerda_ynf_nordot_cu_id');
	delete_option('cuerda_yjt_nordot_cu_id');
	delete_option('cuerda_goo_nordot_cu_id');
	delete_option('cuerda_dcm_nordot_cu_id');
	delete_option('cuerda_spb_nordot_cu_id');
	delete_option('cuerda_snf_nordot_cu_id');
	delete_option('cuerda_gnf_nordot_cu_id');
	delete_option('cuerda_lnr_nordot_cu_id');
	delete_option('cuerda_ldn_nordot_cu_id');
	delete_option('cuerda_isn_nordot_cu_id');
	delete_option('cuerda_ant_nordot_cu_id');
	delete_option('cuerda_trl_nordot_cu_id');
	// 関連記事リンクに設定する記事URLを特定のパスに置き換える
	delete_option('cuerda_total_rel_urlpass');
	delete_option('cuerda_ynf_rel_urlpass');
	delete_option('cuerda_yjt_rel_urlpass');
	delete_option('cuerda_goo_rel_urlpass');
	delete_option('cuerda_dcm_rel_urlpass');
	delete_option('cuerda_spb_rel_urlpass');
	delete_option('cuerda_snf_rel_urlpass');
	delete_option('cuerda_gnf_rel_urlpass');
	delete_option('cuerda_lnr_rel_urlpass');
	delete_option('cuerda_ldn_rel_urlpass');
	delete_option('cuerda_isn_rel_urlpass');
	delete_option('cuerda_ant_rel_urlpass');
	delete_option('cuerda_trl_rel_urlpass');
	// 配信元の名称
	delete_option('cuerda_total_title');
	delete_option('cuerda_ynf_title');
	delete_option('cuerda_yjt_title');
	delete_option('cuerda_goo_title');
	delete_option('cuerda_dcm_title');
	delete_option('cuerda_spb_title');
	delete_option('cuerda_snf_title');
	delete_option('cuerda_gnf_title');
	delete_option('cuerda_lnr_title');
	delete_option('cuerda_ldn_title');
	delete_option('cuerda_isn_title');
	delete_option('cuerda_ant_title');
	delete_option('cuerda_trl_title');
	// フィードへのクロール頻度
	delete_option('cuerda_total_ttl');
	delete_option('cuerda_ynf_ttl');
	delete_option('cuerda_yjt_ttl');
	delete_option('cuerda_goo_ttl');
	delete_option('cuerda_dcm_ttl');
	delete_option('cuerda_spb_ttl');
	delete_option('cuerda_snf_ttl');
	delete_option('cuerda_gnf_ttl');
	delete_option('cuerda_lnr_ttl');
	delete_option('cuerda_ldn_ttl');
	delete_option('cuerda_isn_ttl');
	delete_option('cuerda_ant_ttl');
	delete_option('cuerda_trl_ttl');
	// 配信する記事の種類
	delete_option('cuerda_total_post_type');
	delete_option('cuerda_ynf_post_type');
	delete_option('cuerda_yjt_post_type');
	delete_option('cuerda_goo_post_type');
	delete_option('cuerda_dcm_post_type');
	delete_option('cuerda_spb_post_type');
	delete_option('cuerda_snf_post_type');
	delete_option('cuerda_gnf_post_type');
	delete_option('cuerda_lnr_post_type');
	delete_option('cuerda_ldn_type');
	delete_option('cuerda_isn_type');
	delete_option('cuerda_ant_type');
	delete_option('cuerda_trl_type');
	// フィード掲載する記事の公開日
	delete_option('cuerda_total_after_modified');
	delete_option('cuerda_ynf_after_modified');
	delete_option('cuerda_yjt_after_modified');
	delete_option('cuerda_goo_after_modified');
	delete_option('cuerda_dcm_after_modified');
	delete_option('cuerda_spb_after_modified');
	delete_option('cuerda_snf_after_modified');
	delete_option('cuerda_gnf_after_modified');
	delete_option('cuerda_lnr_after_modified');
	delete_option('cuerda_ldn_after_modified');
	delete_option('cuerda_isn_after_modified');
	delete_option('cuerda_ant_after_modified');
	delete_option('cuerda_trl_after_modified');
	// フィード掲載する記事の更新日
	delete_option('cuerda_total_after_date');
	delete_option('cuerda_ynf_after_date');
	delete_option('cuerda_yjt_after_date');
	delete_option('cuerda_goo_after_date');
	delete_option('cuerda_dcm_after_date');
	delete_option('cuerda_spb_after_date');
	delete_option('cuerda_snf_after_date');
	delete_option('cuerda_gnf_after_date');
	delete_option('cuerda_lnr_after_date');
	delete_option('cuerda_ldn_after_date');
	delete_option('cuerda_isn_after_date');
	delete_option('cuerda_ant_after_date');
	delete_option('cuerda_trl_after_date');
	// フィード掲載する最大記事件数
	delete_option('cuerda_total_posts_per_page');
	delete_option('cuerda_ynf_posts_per_page');
	delete_option('cuerda_yjt_posts_per_page');
	delete_option('cuerda_goo_posts_per_page');
	delete_option('cuerda_dcm_posts_per_page');
	delete_option('cuerda_spb_posts_per_page');
	delete_option('cuerda_snf_posts_per_page');
	delete_option('cuerda_gnf_posts_per_page');
	delete_option('cuerda_lnr_posts_per_page');
	delete_option('cuerda_ldn_posts_per_page');
	delete_option('cuerda_isn_posts_per_page');
	delete_option('cuerda_ant_posts_per_page');
	delete_option('cuerda_trl_posts_per_page');
	// 処理する記事のステータス
	delete_option('cuerda_total_post_status');
	delete_option('cuerda_ynf_post_status');
	delete_option('cuerda_yjt_post_status');
	delete_option('cuerda_goo_post_status');
	delete_option('cuerda_dcm_post_status');
	delete_option('cuerda_spb_post_status');
	delete_option('cuerda_snf_post_status');
	delete_option('cuerda_gnf_post_status');
	delete_option('cuerda_lnr_post_status');
	delete_option('cuerda_ldn_post_status');
	delete_option('cuerda_isn_post_status');
	delete_option('cuerda_ant_post_status');
	delete_option('cuerda_trl_post_status');
	// 連想配列に格納された特定の文字列を削除
	delete_option('cuerda_total_sentence_delete');
	delete_option('cuerda_ynf_sentence_delete');
	delete_option('cuerda_yjt_sentence_delete');
	delete_option('cuerda_goo_sentence_delete');
	delete_option('cuerda_dcm_sentence_delete');
	delete_option('cuerda_spb_sentence_delete');
	delete_option('cuerda_snf_sentence_delete');
	delete_option('cuerda_gnf_sentence_delete');
	delete_option('cuerda_lnr_sentence_delete');
	delete_option('cuerda_ldn_sentence_delete');
	delete_option('cuerda_isn_sentence_delete');
	delete_option('cuerda_ant_sentence_delete');
	delete_option('cuerda_trl_sentence_delete');
	// 連想配列に格納された特定の正規表現を削除
	delete_option('cuerda_total_regular_expression_delete');
	delete_option('cuerda_ynf_regular_expression_delete');
	delete_option('cuerda_yjt_regular_expression_delete');
	delete_option('cuerda_goo_regular_expression_delete');
	delete_option('cuerda_dcm_regular_expression_delete');
	delete_option('cuerda_spb_regular_expression_delete');
	delete_option('cuerda_snf_regular_expression_delete');
	delete_option('cuerda_gnf_regular_expression_delete');
	delete_option('cuerda_lnr_regular_expression_delete');
	delete_option('cuerda_ldn_regular_expression_delete');
	delete_option('cuerda_isn_regular_expression_delete');
	delete_option('cuerda_ant_regular_expression_delete');
	delete_option('cuerda_trl_regular_expression_delete');
	// 配信する著者
	delete_option('cuerda_total_author__in');
	delete_option('cuerda_ynf_author__in');
	delete_option('cuerda_yjt_author__in');
	delete_option('cuerda_goo_author__in');
	delete_option('cuerda_dcm_author__in');
	delete_option('cuerda_spb_author__in');
	delete_option('cuerda_snf_author__in');
	delete_option('cuerda_gnf_author__in');
	delete_option('cuerda_lnr_author__in');
	delete_option('cuerda_ldn_author__in');
	delete_option('cuerda_isn_author__in');
	delete_option('cuerda_ant_author__in');
	delete_option('cuerda_trl_author__in');
	// 配信から除外する著者
	delete_option('cuerda_total_author__not_in');
	delete_option('cuerda_ynf_author__not_in');
	delete_option('cuerda_yjt_author__not_in');
	delete_option('cuerda_goo_author__not_in');
	delete_option('cuerda_dcm_author__not_in');
	delete_option('cuerda_spb_author__not_in');
	delete_option('cuerda_snf_author__not_in');
	delete_option('cuerda_gnf_author__not_in');
	delete_option('cuerda_lnr_author__not_in');
	delete_option('cuerda_ldn_author__not_in');
	delete_option('cuerda_isn_author__not_in');
	delete_option('cuerda_ant_author__not_in');
	delete_option('cuerda_trl_author__not_in');
	// 先頭に指定するカテゴリ名
	delete_option('cuerda_total_category__absolute');
	delete_option('cuerda_ynf_category__absolute');
	delete_option('cuerda_yjt_category__absolute');
	delete_option('cuerda_goo_category__absolute');
	delete_option('cuerda_dcm_category__absolute');
	delete_option('cuerda_spb_category__absolute');
	delete_option('cuerda_snf_category__absolute');
	delete_option('cuerda_gnf_category__absolute');
	delete_option('cuerda_lnr_category__absolute');
	delete_option('cuerda_ldn_category__absolute');
	delete_option('cuerda_isn_category__absolute');
	delete_option('cuerda_ant_category__absolute');
	delete_option('cuerda_trl_category__absolute');
	// 配信から除外するカテゴリー
	delete_option('cuerda_total_category__not_in');
	delete_option('cuerda_ynf_category__not_in');
	delete_option('cuerda_yjt_category__not_in');
	delete_option('cuerda_goo_category__not_in');
	delete_option('cuerda_dcm_category__not_in');
	delete_option('cuerda_spb_category__not_in');
	delete_option('cuerda_snf_category__not_in');
	delete_option('cuerda_gnf_category__not_in');
	delete_option('cuerda_lnr_category__not_in');
	delete_option('cuerda_ldn_category__not_in');
	delete_option('cuerda_isn_category__not_in');
	delete_option('cuerda_ant_category__not_in');
	delete_option('cuerda_trl_category__not_in');
	// 配信するカテゴリー
	delete_option('cuerda_total_category__in');
	delete_option('cuerda_ynf_category__in');
	delete_option('cuerda_yjt_category__in');
	delete_option('cuerda_goo_category__in');
	delete_option('cuerda_dcm_category__in');
	delete_option('cuerda_spb_category__in');
	delete_option('cuerda_snf_category__in');
	delete_option('cuerda_gnf_category__in');
	delete_option('cuerda_lnr_category__in');
	delete_option('cuerda_ldn_category__in');
	delete_option('cuerda_isn_category__in');
	delete_option('cuerda_ant_category__in');
	delete_option('cuerda_trl_category__in');
	// 配信から除外するタグ
	delete_option('cuerda_total_tag__not_in');
	delete_option('cuerda_ynf_tag__not_in');
	delete_option('cuerda_yjt_tag__not_in');
	delete_option('cuerda_goo_tag__not_in');
	delete_option('cuerda_dcm_tag__not_in');
	delete_option('cuerda_spb_tag__not_in');
	delete_option('cuerda_snf_tag__not_in');
	delete_option('cuerda_gnf_tag__not_in');
	delete_option('cuerda_lnr_tag__not_in');
	delete_option('cuerda_ldn_tag__not_in');
	delete_option('cuerda_isn_tag__not_in');
	delete_option('cuerda_ant_tag__not_in');
	delete_option('cuerda_trl_tag__not_in');
	// 配信するタグ
	delete_option('cuerda_total_tag__in');
	delete_option('cuerda_ynf_tag__in');
	delete_option('cuerda_yjt_tag__in');
	delete_option('cuerda_goo_tag__in');
	delete_option('cuerda_dcm_tag__in');
	delete_option('cuerda_spb_tag__in');
	delete_option('cuerda_snf_tag__in');
	delete_option('cuerda_gnf_tag__in');
	delete_option('cuerda_lnr_tag__in');
	delete_option('cuerda_ldn_tag__in');
	delete_option('cuerda_isn_tag__in');
	delete_option('cuerda_ant_tag__in');
	delete_option('cuerda_trl_tag__in');
	// 配信から除外する記事
	delete_option('cuerda_total_post__not_in');
	delete_option('cuerda_ynf_post__not_in');
	delete_option('cuerda_yjt_post__not_in');
	delete_option('cuerda_goo_post__not_in');
	delete_option('cuerda_dcm_post__not_in');
	delete_option('cuerda_spb_post__not_in');
	delete_option('cuerda_snf_post__not_in');
	delete_option('cuerda_gnf_post__not_in');
	delete_option('cuerda_lnr_post__not_in');
	delete_option('cuerda_ldn_post__not_in');
	delete_option('cuerda_isn_post__not_in');
	delete_option('cuerda_ant_post__not_in');
	delete_option('cuerda_trl_post__not_in');
	// 関連リンク最大本数 lnr => 外部リンク情報最大本数 snf => 広告の代替関連記事リンク最大本数
	delete_option('cuerda_total_rel_count');
	delete_option('cuerda_ynf_rel_count');
	delete_option('cuerda_yjt_rel_count');
	delete_option('cuerda_goo_rel_count');
	delete_option('cuerda_dcm_rel_count');
	delete_option('cuerda_spb_rel_count');
	delete_option('cuerda_snf_rel_count');
	delete_option('cuerda_gnf_rel_count');
	delete_option('cuerda_lnr_rel_count');
	delete_option('cuerda_ldn_rel_count');
	delete_option('cuerda_isn_rel_count');
	delete_option('cuerda_ant_rel_count');
	delete_option('cuerda_trl_rel_count');
	// 同一タグから関連リンクを出力する
	delete_option('cuerda_total_rel_tag');
	delete_option('cuerda_ynf_rel_tag');
	delete_option('cuerda_yjt_rel_tag');
	delete_option('cuerda_goo_rel_tag');
	delete_option('cuerda_dcm_rel_tag');
	delete_option('cuerda_spb_rel_tag');
	delete_option('cuerda_snf_rel_tag');
	delete_option('cuerda_gnf_rel_tag');
	delete_option('cuerda_lnr_rel_tag');
	delete_option('cuerda_ldn_rel_tag');
	delete_option('cuerda_isn_rel_tag');
	delete_option('cuerda_ant_rel_tag');
	delete_option('cuerda_trl_rel_tag');
	// 公開中を示す記事のステータス
	delete_option('cuerda_total_publish_status');
	delete_option('cuerda_ynf_publish_status');
	delete_option('cuerda_yjt_publish_status');
	delete_option('cuerda_goo_publish_status');
	delete_option('cuerda_dcm_publish_status');
	delete_option('cuerda_spb_publish_status');
	delete_option('cuerda_snf_publish_status');
	delete_option('cuerda_gnf_publish_status');
	delete_option('cuerda_lnr_publish_status');
	delete_option('cuerda_ldn_publish_status');
	delete_option('cuerda_isn_publish_status');
	delete_option('cuerda_ant_publish_status');
	delete_option('cuerda_trl_publish_status');
	// 関連リンクにノアドットを優先する
	delete_option('cuerda_total_rel_nor_set');
	delete_option('cuerda_ynf_rel_nor_set');
	delete_option('cuerda_yjt_rel_nor_set');
	delete_option('cuerda_goo_rel_nor_set');
	delete_option('cuerda_dcm_rel_nor_set');
	delete_option('cuerda_spb_rel_nor_set');
	delete_option('cuerda_snf_rel_nor_set');
	delete_option('cuerda_gnf_rel_nor_set');
	delete_option('cuerda_lnr_rel_nor_set');
	delete_option('cuerda_ldn_rel_nor_set');
	delete_option('cuerda_isn_rel_nor_set');
	delete_option('cuerda_ant_rel_nor_set');
	delete_option('cuerda_trl_rel_nor_set');
	// 手動関連リンクを優先出力する
	delete_option('cuerda_ynf_rel_manual');
	delete_option('cuerda_yjt_rel_manual');
	delete_option('cuerda_goo_rel_manual');
	delete_option('cuerda_dcm_rel_manual');
	delete_option('cuerda_spb_rel_manual');
	delete_option('cuerda_snf_rel_manual');
	delete_option('cuerda_gnf_rel_manual');
	delete_option('cuerda_lnr_rel_manual');
	delete_option('cuerda_ldn_rel_manual');
	delete_option('cuerda_isn_rel_manual');
	delete_option('cuerda_ant_rel_manual');
	delete_option('cuerda_trl_rel_manual');
	// 優先的に表示する手動関連リンクURLのカスタムフィールド名1
	delete_option('cuerda_ynf_rel_feeld1');
	delete_option('cuerda_yjt_rel_feeld1');
	delete_option('cuerda_goo_rel_feeld1');
	delete_option('cuerda_dcm_rel_feeld1');
	delete_option('cuerda_spb_rel_feeld1');
	delete_option('cuerda_snf_rel_feeld1');
	delete_option('cuerda_gnf_rel_feeld1');
	delete_option('cuerda_lnr_rel_feeld1');
	delete_option('cuerda_ldn_rel_feeld1');
	delete_option('cuerda_isn_rel_feeld1');
	delete_option('cuerda_ant_rel_feeld1');
	delete_option('cuerda_trl_rel_feeld1');
	// 優先的に表示する手動関連リンクURLのカスタムフィールド名2
	delete_option('cuerda_ynf_rel_feeld2');
	delete_option('cuerda_yjt_rel_feeld2');
	delete_option('cuerda_goo_rel_feeld2');
	delete_option('cuerda_dcm_rel_feeld2');
	delete_option('cuerda_spb_rel_feeld2');
	delete_option('cuerda_snf_rel_feeld2');
	delete_option('cuerda_gnf_rel_feeld2');
	delete_option('cuerda_lnr_rel_feeld2');
	delete_option('cuerda_ldn_rel_feeld2');
	delete_option('cuerda_isn_rel_feeld2');
	delete_option('cuerda_ant_rel_feeld2');
	delete_option('cuerda_trl_rel_feeld2');
	// 優先的に表示する手動関連リンクURLのカスタムフィールド名3
	delete_option('cuerda_ynf_rel_feeld3');
	delete_option('cuerda_yjt_rel_feeld3');
	delete_option('cuerda_goo_rel_feeld3');
	delete_option('cuerda_dcm_rel_feeld3');
	delete_option('cuerda_spb_rel_feeld3');
	delete_option('cuerda_snf_rel_feeld3');
	delete_option('cuerda_gnf_rel_feeld3');
	delete_option('cuerda_lnr_rel_feeld3');
	delete_option('cuerda_ldn_rel_feeld3');
	delete_option('cuerda_isn_rel_feeld3');
	delete_option('cuerda_ant_rel_feeld3');
	delete_option('cuerda_trl_rel_feeld3');
	// 記事取り下げを示す記事のステータス
	delete_option('cuerda_total_delete_status');
	delete_option('cuerda_ynf_delete_status');
	delete_option('cuerda_yjt_delete_status');
	delete_option('cuerda_goo_delete_status');
	delete_option('cuerda_dcm_delete_status');
	delete_option('cuerda_spb_delete_status');
	delete_option('cuerda_snf_delete_status');
	delete_option('cuerda_gnf_delete_status');
	delete_option('cuerda_lnr_delete_status');
	delete_option('cuerda_ldn_delete_status');
	delete_option('cuerda_isn_delete_status');
	delete_option('cuerda_ant_delete_status');
	delete_option('cuerda_trl_delete_status');
	// 画像のキャプション
	delete_option('cuerda_total_enclosure_alt');
	delete_option('cuerda_ynf_enclosure_alt');
	delete_option('cuerda_yjt_enclosure_alt');
	delete_option('cuerda_goo_enclosure_alt');
	delete_option('cuerda_dcm_enclosure_alt');
	delete_option('cuerda_spb_enclosure_alt');
	delete_option('cuerda_snf_enclosure_alt');
	delete_option('cuerda_gnf_enclosure_alt');
	delete_option('cuerda_lnr_enclosure_alt');
	delete_option('cuerda_ldn_enclosure_alt');
	delete_option('cuerda_isn_enclosure_alt');
	delete_option('cuerda_ant_enclosure_alt');
	delete_option('cuerda_trl_enclosure_alt');
	// 記事に添付された画像メディアの配信
	delete_option('cuerda_total_image');
	delete_option('cuerda_ynf_image');
	delete_option('cuerda_yjt_image');
	delete_option('cuerda_goo_image');
	delete_option('cuerda_dcm_image');
	delete_option('cuerda_spb_image');
	delete_option('cuerda_snf_image');
	delete_option('cuerda_gnf_image');
	delete_option('cuerda_lnr_image');
	delete_option('cuerda_ldn_image');
	delete_option('cuerda_isn_image');
	delete_option('cuerda_ant_image');
	delete_option('cuerda_trl_image');
	// アイキャッチに指定した画像メディアの配信
	delete_option('cuerda_total_icatch');
	delete_option('cuerda_ynf_icatch');
	delete_option('cuerda_yjt_icatch');
	delete_option('cuerda_goo_icatch');
	delete_option('cuerda_dcm_icatch');
	delete_option('cuerda_spb_icatch');
	delete_option('cuerda_snf_icatch');
	delete_option('cuerda_gnf_icatch');
	delete_option('cuerda_lnr_icatch');
	delete_option('cuerda_ldn_icatch');
	delete_option('cuerda_isn_icatch');
	delete_option('cuerda_ant_icatch');
	delete_option('cuerda_trl_icatch');
	// 本文冒頭にアイキャッチ画像を出力する
	delete_option('cuerda_total_add_icatch');
	delete_option('cuerda_ynf_add_icatch');
	delete_option('cuerda_yjt_add_icatch');
	delete_option('cuerda_goo_add_icatch');
	delete_option('cuerda_dcm_add_icatch');
	delete_option('cuerda_spb_add_icatch');
	delete_option('cuerda_snf_add_icatch');
	delete_option('cuerda_gnf_add_icatch');
	delete_option('cuerda_lnr_add_icatch');
	delete_option('cuerda_ldn_add_icatch');
	delete_option('cuerda_isn_add_icatch');
	delete_option('cuerda_ant_add_icatch');
	delete_option('cuerda_trl_add_icatch');
	// 記事に添付された動画メディアの配信
	delete_option('cuerda_total_video');
	delete_option('cuerda_ynf_video');
	delete_option('cuerda_yjt_video');
	delete_option('cuerda_goo_video');
	delete_option('cuerda_dcm_video');
	delete_option('cuerda_spb_video');
	delete_option('cuerda_snf_video');
	delete_option('cuerda_gnf_video');
	delete_option('cuerda_lnr_video');
	delete_option('cuerda_ldn_video');
	delete_option('cuerda_isn_video');
	delete_option('cuerda_ant_video');
	delete_option('cuerda_trl_video');
	// 著作者表示用のカスタムフィールド名 OR 画像の出典元情報のカスタムフィールド名
	delete_option('cuerda_total_cf_creator');
	delete_option('cuerda_ynf_cf_creator');
	delete_option('cuerda_yjt_cf_creator');
	delete_option('cuerda_goo_cf_creator');
	delete_option('cuerda_dcm_cf_creator');
	delete_option('cuerda_spb_cf_creator');
	delete_option('cuerda_snf_cf_creator');
	delete_option('cuerda_gnf_cf_creator');
	delete_option('cuerda_lnr_cf_creator');
	delete_option('cuerda_ldn_cf_creator');
	delete_option('cuerda_isn_cf_creator');
	delete_option('cuerda_ant_cf_creator');
	delete_option('cuerda_trl_cf_creator');
	// 画像の出典元情報のURLカスタムフィールド名
	delete_option('cuerda_total_cf_creator_url');
	delete_option('cuerda_ynf_cf_creator_url');
	delete_option('cuerda_yjt_cf_creator_url');
	delete_option('cuerda_goo_cf_creator_url');
	delete_option('cuerda_dcm_cf_creator_url');
	delete_option('cuerda_spb_cf_creator_url');
	delete_option('cuerda_snf_cf_creator_url');
	delete_option('cuerda_gnf_cf_creator_url');
	delete_option('cuerda_lnr_cf_creator_url');
	delete_option('cuerda_ldn_cf_creator_url');
	delete_option('cuerda_isn_cf_creator_url');
	delete_option('cuerda_ant_cf_creator_url');
	delete_option('cuerda_trl_cf_creator_url');
	// YouTube 用のカスタムフィールド名
	delete_option('cuerda_total_cf_youtube');
	delete_option('cuerda_ynf_cf_youtube');
	delete_option('cuerda_yjt_cf_youtube');
	delete_option('cuerda_goo_cf_youtube');
	delete_option('cuerda_dcm_cf_youtube');
	delete_option('cuerda_spb_cf_youtube');
	delete_option('cuerda_snf_cf_youtube');
	delete_option('cuerda_gnf_cf_youtube');
	delete_option('cuerda_lnr_cf_youtube');
	delete_option('cuerda_ldn_cf_youtube');
	delete_option('cuerda_isn_cf_youtube');
	delete_option('cuerda_ant_cf_youtube');
	delete_option('cuerda_trl_cf_youtube');
	// 標準地域コードの自動配信
	delete_option('cuerda_total_area_city');
	delete_option('cuerda_ynf_area_city');
	delete_option('cuerda_yjt_area_city');
	delete_option('cuerda_goo_area_city');
	delete_option('cuerda_dcm_area_city');
	delete_option('cuerda_spb_area_city');
	delete_option('cuerda_snf_area_city');
	delete_option('cuerda_gnf_area_city');
	delete_option('cuerda_lnr_area_city');
	delete_option('cuerda_ldn_area_city');
	delete_option('cuerda_isn_area_city');
	delete_option('cuerda_ant_area_city');
	delete_option('cuerda_trl_area_city');
	// 当該リソース提供者の copyright
	delete_option('cuerda_total_copyright');
	delete_option('cuerda_ynf_copyright');
	delete_option('cuerda_yjt_copyright');
	delete_option('cuerda_goo_copyright');
	delete_option('cuerda_dcm_copyright');
	delete_option('cuerda_spb_copyright');
	delete_option('cuerda_snf_copyright');
	delete_option('cuerda_gnf_copyright');
	delete_option('cuerda_lnr_copyright');
	delete_option('cuerda_ldn_copyright');
	delete_option('cuerda_isn_copyright');
	delete_option('cuerda_ant_copyright');
	delete_option('cuerda_trl_copyright');
	// a タグをアンカーテキストを含め除去する
	delete_option('cuerda_total_atag');
	delete_option('cuerda_ynf_atag');
	delete_option('cuerda_yjt_atag');
	delete_option('cuerda_goo_atag');
	delete_option('cuerda_dcm_atag');
	delete_option('cuerda_spb_atag');
	delete_option('cuerda_snf_atag');
	delete_option('cuerda_gnf_atag');
	delete_option('cuerda_lnr_atag');
	delete_option('cuerda_ldn_atag');
	delete_option('cuerda_isn_atag');
	delete_option('cuerda_ant_atag');
	delete_option('cuerda_trl_atag');
	// table タグを除去する
	delete_option('cuerda_total_table');
	delete_option('cuerda_ynf_table');
	delete_option('cuerda_yjt_table');
	delete_option('cuerda_goo_table');
	delete_option('cuerda_dcm_table');
	delete_option('cuerda_spb_table');
	delete_option('cuerda_snf_table');
	delete_option('cuerda_gnf_table');
	delete_option('cuerda_lnr_table');
	delete_option('cuerda_ldn_table');
	delete_option('cuerda_isn_table');
	delete_option('cuerda_ant_table');
	delete_option('cuerda_trl_table');
	// table タグを p に置換しインライン可する
	delete_option('cuerda_total_table_inline');
	delete_option('cuerda_ynf_table_inline');
	delete_option('cuerda_yjt_table_inline');
	delete_option('cuerda_goo_table_inline');
	delete_option('cuerda_dcm_table_inline');
	delete_option('cuerda_spb_table_inline');
	delete_option('cuerda_snf_table_inline');
	delete_option('cuerda_gnf_table_inline');
	delete_option('cuerda_lnr_table_inline');
	delete_option('cuerda_ldn_table_inline');
	delete_option('cuerda_isn_table_inline');
	delete_option('cuerda_ant_table_inline');
	delete_option('cuerda_trl_table_inline');
	// table タグを p に置換しインライン可した時のデリミタ
	delete_option('cuerda_total_table_inline_delimiter');
	delete_option('cuerda_ynf_table_inline_delimiter');
	delete_option('cuerda_yjt_table_inline_delimiter');
	delete_option('cuerda_goo_table_inline_delimiter');
	delete_option('cuerda_dcm_table_inline_delimiter');
	delete_option('cuerda_spb_table_inline_delimiter');
	delete_option('cuerda_snf_table_inline_delimiter');
	delete_option('cuerda_gnf_table_inline_delimiter');
	delete_option('cuerda_lnr_table_inline_delimiter');
	delete_option('cuerda_ldn_table_inline_delimiter');
	delete_option('cuerda_isn_table_inline_delimiter');
	delete_option('cuerda_ant_table_inline_delimiter');
	delete_option('cuerda_trl_table_inline_delimiter');
	// 配信先での遅延公開分数カスタムフィールド名
	delete_option('cuerda_total_cf_publish_delay');
	delete_option('cuerda_ynf_cf_publish_delay');
	delete_option('cuerda_yjt_cf_publish_delay');
	delete_option('cuerda_goo_cf_publish_delay');
	delete_option('cuerda_dcm_cf_publish_delay');
	delete_option('cuerda_spb_cf_publish_delay');
	delete_option('cuerda_snf_cf_publish_delay');
	delete_option('cuerda_gnf_cf_publish_delay');
	delete_option('cuerda_lnr_cf_publish_delay');
	delete_option('cuerda_ldn_cf_publish_delay');
	delete_option('cuerda_isn_cf_publish_delay');
	delete_option('cuerda_ant_cf_publish_delay');
	delete_option('cuerda_trl_cf_publish_delay');
	// 配信先での遅延公開
	delete_option('cuerda_total_publish_delay');
	delete_option('cuerda_ynf_publish_delay');
	delete_option('cuerda_yjt_publish_delay');
	delete_option('cuerda_goo_publish_delay');
	delete_option('cuerda_dcm_publish_delay');
	delete_option('cuerda_spb_publish_delay');
	delete_option('cuerda_snf_publish_delay');
	delete_option('cuerda_gnf_publish_delay');
	delete_option('cuerda_lnr_publish_delay');
	delete_option('cuerda_ldn_publish_delay');
	delete_option('cuerda_isn_publish_delay');
	delete_option('cuerda_ant_publish_delay');
	delete_option('cuerda_trl_publish_delay');
	// 記事の有効期限
	delete_option('cuerda_total_expire');
	delete_option('cuerda_ynf_expire');
	delete_option('cuerda_yjt_expire');
	delete_option('cuerda_goo_expire');
	delete_option('cuerda_dcm_expire');
	delete_option('cuerda_spb_expire');
	delete_option('cuerda_snf_expire');
	delete_option('cuerda_gnf_expire');
	delete_option('cuerda_lnr_expire');
	delete_option('cuerda_ldn_expire');
	delete_option('cuerda_isn_expire');
	delete_option('cuerda_ant_expire');
	delete_option('cuerda_trl_expire');
	// ロゴ画像のURL
	delete_option('cuerda_total_logo');
	delete_option('cuerda_ynf_logo');
	delete_option('cuerda_yjt_logo');
	delete_option('cuerda_goo_logo');
	delete_option('cuerda_dcm_logo');
	delete_option('cuerda_spb_logo');
	delete_option('cuerda_snf_logo');
	delete_option('cuerda_gnf_logo');
	delete_option('cuerda_lnr_logo');
	delete_option('cuerda_ldn_logo');
	delete_option('cuerda_isn_logo');
	delete_option('cuerda_ant_logo');
	delete_option('cuerda_trl_logo');
	// サイトの横長のロゴ画像のURL
	delete_option('cuerda_total_wide_logo');
	delete_option('cuerda_ynf_wide_logo');
	delete_option('cuerda_yjt_wide_logo');
	delete_option('cuerda_goo_wide_logo');
	delete_option('cuerda_dcm_wide_logo');
	delete_option('cuerda_spb_wide_logo');
	delete_option('cuerda_snf_wide_logo');
	delete_option('cuerda_gnf_wide_logo');
	delete_option('cuerda_lnr_wide_logo');
	delete_option('cuerda_ldn_wide_logo');
	delete_option('cuerda_isn_wide_logo');
	delete_option('cuerda_ant_wide_logo');
	delete_option('cuerda_trl_wide_logo');
	// ダークモードに対応したロゴ画像のURL
	delete_option('cuerda_total_darkmodelogo');
	delete_option('cuerda_ynf_darkmodelogo');
	delete_option('cuerda_yjt_darkmodelogo');
	delete_option('cuerda_goo_darkmodelogo');
	delete_option('cuerda_dcm_darkmodelogo');
	delete_option('cuerda_spb_darkmodelogo');
	delete_option('cuerda_snf_darkmodelogo');
	delete_option('cuerda_gnf_darkmodelogo');
	delete_option('cuerda_lnr_darkmodelogo');
	delete_option('cuerda_ldn_darkmodelogo');
	delete_option('cuerda_isn_darkmodelogo');
	delete_option('cuerda_ant_darkmodelogo');
	delete_option('cuerda_trl_darkmodelogo');
	// 代替画像のURL
	delete_option('cuerda_total_thumbnail');
	delete_option('cuerda_ynf_thumbnail');
	delete_option('cuerda_yjt_thumbnail');
	delete_option('cuerda_goo_thumbnail');
	delete_option('cuerda_dcm_thumbnail');
	delete_option('cuerda_spb_thumbnail');
	delete_option('cuerda_snf_thumbnail');
	delete_option('cuerda_gnf_thumbnail');
	delete_option('cuerda_lnr_thumbnail');
	delete_option('cuerda_ldn_thumbnail');
	delete_option('cuerda_isn_thumbnail');
	delete_option('cuerda_ant_thumbnail');
	delete_option('cuerda_trl_thumbnail');
	// アクセス解析用コード
	delete_option('cuerda_total_analytics');
	delete_option('cuerda_ynf_analytics');
	delete_option('cuerda_yjt_analytics');
	delete_option('cuerda_goo_analytics');
	delete_option('cuerda_dcm_analytics');
	delete_option('cuerda_spb_analytics');
	delete_option('cuerda_snf_analytics');
	delete_option('cuerda_gnf_analytics');
	delete_option('cuerda_gnf_analytics_gn');
	delete_option('cuerda_gnf_analytics_lc');
	delete_option('cuerda_gnf_analytics_st');
	delete_option('cuerda_lnr_analytics');
	delete_option('cuerda_ldn_analytics');
	delete_option('cuerda_isn_analytics');
	delete_option('cuerda_ant_analytics');
	delete_option('cuerda_trl_analytics');
	// 配信先 FTP サーバーへRSSフィードをPUTする
	delete_option('cuerda_ynf_ftp_put');
	// FTP サーバーのホスト名
	delete_option('cuerda_ynf_ftp_server');
	// FTP サーバーのユーザー名
	delete_option('cuerda_ynf_ftp_user_name');
	// FTP サーバーのパスワード
	delete_option('cuerda_ynf_ftp_password');
	// FTP サーバーのリモートディレクトリ
	delete_option('cuerda_ynf_ftp_remote_dir');
	// Yahoo!ニュースの媒体コード
	delete_option('cuerda_ynf_id');
	// RSSフィードのLDAPユーザー名
	delete_option('cuerda_ynf_ldap_user');
	// RSSフィードのLDAPパスワード
	delete_option('cuerda_ynf_ldap_pass');
	// デバッグモード
	delete_option('cuerda_ynf_debug');
	// Yahoo!ニュース記事種別
	delete_option('cuerda_ynf_articletype');
	// 記事の要約カスタムフィールド
	delete_option('cuerda_ynf_article_summary');
	// 広告の代替を自動表示
	delete_option('cuerda_snf_rel_ad');
	// 【広告1本目】リンクURL
	delete_option('cuerda_snf_rel_link1');
	// 【広告1本目】記事タイトル
	delete_option('cuerda_snf_rel_title1');
	// 【広告1本目】サムネイル画像 URL
	delete_option('cuerda_snf_rel_thumbnail1');
	// 【広告1本目】広告主名
	delete_option('cuerda_snf_rel_advertiser1');
	// 【広告2本目】リンクURL
	delete_option('cuerda_snf_rel_link2');
	// 【広告2本目】記事タイトル
	delete_option('cuerda_snf_rel_title2');
	// 【広告2本目】サムネイル画像 URL
	delete_option('cuerda_snf_rel_thumbnail2');
	// 【広告2本目】広告主名
	delete_option('cuerda_snf_rel_advertiser2');
}
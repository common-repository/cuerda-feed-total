<?php
// cerda（クエルダ）は本プログラムソースコードの著作権を保有しています。
// Copyright (C) 2020 CUERDA(https://cuerda.org).
if(!defined('ABSPATH')){
die('Forbidden');
}

//*************************************************************
// オプションキーのグループ化
//*************************************************************
function  cuerda_register_cuerda_total(){
	// 基本設定に表示させるタブ選択
	register_setting( 'option-settings-group_total', 'cuerda_total_choice_ynf' );
	register_setting( 'option-settings-group_total', 'cuerda_total_choice_yjt' );
	register_setting( 'option-settings-group_total', 'cuerda_total_choice_goo' );
	register_setting( 'option-settings-group_total', 'cuerda_total_choice_dcm' );
	register_setting( 'option-settings-group_total', 'cuerda_total_choice_spb' );
	register_setting( 'option-settings-group_total', 'cuerda_total_choice_snf' );
	register_setting( 'option-settings-group_total', 'cuerda_total_choice_gnf' );
	register_setting( 'option-settings-group_total', 'cuerda_total_choice_lnr' );
	register_setting( 'option-settings-group_total', 'cuerda_total_choice_ldn' );
	register_setting( 'option-settings-group_total', 'cuerda_total_choice_isn' );
	register_setting( 'option-settings-group_total', 'cuerda_total_choice_ant' );
	register_setting( 'option-settings-group_total', 'cuerda_total_choice_trl' );
	// フィードのブラウザキャッシュ
	register_setting( 'option-settings-group_total', 'cuerda_total_expires' );
	// ノアドット・コンテンツホルダー・ユニットID nordot_unit_id
	register_setting( 'option-settings-group_total', 'cuerda_total_nordot_unit_id' );
	// ノアドット・キュレーター・ユニットID nordot_cu_id
	register_setting( 'option-settings-group_total', 'cuerda_total_nordot_cu_id' );
	// 関連記事リンクに設定する記事URLを特定のパスに置き換える
	register_setting( 'option-settings-group_total', 'cuerda_total_rel_urlpass' );
	// 配信元の名称
	register_setting( 'option-settings-group_total', 'cuerda_ynf_title' );
	register_setting( 'option-settings-group_total', 'cuerda_yjt_title' );
	register_setting( 'option-settings-group_total', 'cuerda_goo_title' );
	register_setting( 'option-settings-group_total', 'cuerda_dcm_title' );
	register_setting( 'option-settings-group_total', 'cuerda_spb_title' );
	register_setting( 'option-settings-group_total', 'cuerda_snf_title' );
	register_setting( 'option-settings-group_total', 'cuerda_gnf_title' );
	register_setting( 'option-settings-group_total', 'cuerda_lnr_title' );
	register_setting( 'option-settings-group_total', 'cuerda_ldn_title' );
	register_setting( 'option-settings-group_total', 'cuerda_isn_title' );
	register_setting( 'option-settings-group_total', 'cuerda_ant_title' );
	register_setting( 'option-settings-group_total', 'cuerda_trl_title' );
	// フィードへのクロール頻度
	register_setting( 'option-settings-group_total', 'cuerda_snf_ttl' );
	register_setting( 'option-settings-group_total', 'cuerda_gnf_ttl' );
	register_setting( 'option-settings-group_total', 'cuerda_spb_ttl' );
	// 配信する記事の種類
	register_setting( 'option-settings-group_total', 'cuerda_total_post_type' );
	// フィード掲載する記事の更新日
	register_setting( 'option-settings-group_total', 'cuerda_yjt_after_modified' );
	register_setting( 'option-settings-group_total', 'cuerda_goo_after_modified' );
	register_setting( 'option-settings-group_total', 'cuerda_dcm_after_modified' );
	register_setting( 'option-settings-group_total', 'cuerda_spb_after_modified' );
	register_setting( 'option-settings-group_total', 'cuerda_snf_after_modified' );
	register_setting( 'option-settings-group_total', 'cuerda_gnf_after_modified' );
	register_setting( 'option-settings-group_total', 'cuerda_lnr_after_modified' );
	register_setting( 'option-settings-group_total', 'cuerda_ldn_after_modified' );
	register_setting( 'option-settings-group_total', 'cuerda_isn_after_modified' );
	register_setting( 'option-settings-group_total', 'cuerda_ant_after_modified' );
	register_setting( 'option-settings-group_total', 'cuerda_trl_after_modified' );
	// フィード掲載する記事の公開日
	register_setting( 'option-settings-group_total', 'cuerda_yjt_after_date' );
	register_setting( 'option-settings-group_total', 'cuerda_goo_after_date' );
	register_setting( 'option-settings-group_total', 'cuerda_dcm_after_date' );
	register_setting( 'option-settings-group_total', 'cuerda_spb_after_date' );
	register_setting( 'option-settings-group_total', 'cuerda_snf_after_date' );
	register_setting( 'option-settings-group_total', 'cuerda_gnf_after_date' );
	register_setting( 'option-settings-group_total', 'cuerda_lnr_after_date' );
	register_setting( 'option-settings-group_total', 'cuerda_ldn_after_date' );
	register_setting( 'option-settings-group_total', 'cuerda_isn_after_date' );
	register_setting( 'option-settings-group_total', 'cuerda_ant_after_date' );
	register_setting( 'option-settings-group_total', 'cuerda_trl_after_date' );
	// フィード掲載する最大記事件数
	register_setting( 'option-settings-group_total', 'cuerda_yjt_posts_per_page' );
	register_setting( 'option-settings-group_total', 'cuerda_goo_posts_per_page' );
	register_setting( 'option-settings-group_total', 'cuerda_dcm_posts_per_page' );
	register_setting( 'option-settings-group_total', 'cuerda_spb_posts_per_page' );
	register_setting( 'option-settings-group_total', 'cuerda_snf_posts_per_page' );
	register_setting( 'option-settings-group_total', 'cuerda_gnf_posts_per_page' );
	register_setting( 'option-settings-group_total', 'cuerda_lnr_posts_per_page' );
	register_setting( 'option-settings-group_total', 'cuerda_ldn_posts_per_page' );
	register_setting( 'option-settings-group_total', 'cuerda_isn_posts_per_page' );
	register_setting( 'option-settings-group_total', 'cuerda_ant_posts_per_page' );
	register_setting( 'option-settings-group_total', 'cuerda_trl_posts_per_page' );
	// 処理する記事のステータス
	register_setting( 'option-settings-group_total', 'cuerda_total_post_status' );
	// 連想配列に格納された特定の文字列を削除
	register_setting( 'option-settings-group_total', 'cuerda_ynf_sentence_delete' );
	register_setting( 'option-settings-group_total', 'cuerda_yjt_sentence_delete' );
	register_setting( 'option-settings-group_total', 'cuerda_goo_sentence_delete' );
	register_setting( 'option-settings-group_total', 'cuerda_dcm_sentence_delete' );
	register_setting( 'option-settings-group_total', 'cuerda_spb_sentence_delete' );
	register_setting( 'option-settings-group_total', 'cuerda_snf_sentence_delete' );
	register_setting( 'option-settings-group_total', 'cuerda_gnf_sentence_delete' );
	register_setting( 'option-settings-group_total', 'cuerda_lnr_sentence_delete' );
	register_setting( 'option-settings-group_total', 'cuerda_ldn_sentence_delete' );
	register_setting( 'option-settings-group_total', 'cuerda_isn_sentence_delete' );
	register_setting( 'option-settings-group_total', 'cuerda_ant_sentence_delete' );
	register_setting( 'option-settings-group_total', 'cuerda_trl_sentence_delete' );
	// 連想配列に格納された特定の正規表現を削除
	register_setting( 'option-settings-group_total', 'cuerda_ynf_regular_expression_delete' );
	register_setting( 'option-settings-group_total', 'cuerda_yjt_regular_expression_delete' );
	register_setting( 'option-settings-group_total', 'cuerda_goo_regular_expression_delete' );
	register_setting( 'option-settings-group_total', 'cuerda_dcm_regular_expression_delete' );
	register_setting( 'option-settings-group_total', 'cuerda_spb_regular_expression_delete' );
	register_setting( 'option-settings-group_total', 'cuerda_snf_regular_expression_delete' );
	register_setting( 'option-settings-group_total', 'cuerda_gnf_regular_expression_delete' );
	register_setting( 'option-settings-group_total', 'cuerda_lnr_regular_expression_delete' );
	register_setting( 'option-settings-group_total', 'cuerda_ldn_regular_expression_delete' );
	register_setting( 'option-settings-group_total', 'cuerda_isn_regular_expression_delete' );
	register_setting( 'option-settings-group_total', 'cuerda_ant_regular_expression_delete' );
	register_setting( 'option-settings-group_total', 'cuerda_trl_regular_expression_delete' );
	// 配信する著者
	register_setting( 'option-settings-group_total', 'cuerda_ynf_author__in' );
	register_setting( 'option-settings-group_total', 'cuerda_yjt_author__in' );
	register_setting( 'option-settings-group_total', 'cuerda_goo_author__in' );
	register_setting( 'option-settings-group_total', 'cuerda_dcm_author__in' );
	register_setting( 'option-settings-group_total', 'cuerda_spb_author__in' );
	register_setting( 'option-settings-group_total', 'cuerda_snf_author__in' );
	register_setting( 'option-settings-group_total', 'cuerda_gnf_author__in' );
	register_setting( 'option-settings-group_total', 'cuerda_lnr_author__in' );
	register_setting( 'option-settings-group_total', 'cuerda_ldn_author__in' );
	register_setting( 'option-settings-group_total', 'cuerda_isn_author__in' );
	register_setting( 'option-settings-group_total', 'cuerda_ant_author__in' );
	register_setting( 'option-settings-group_total', 'cuerda_trl_author__in' );
	// 配信から除外する著者
	register_setting( 'option-settings-group_total', 'cuerda_ynf_author__not_in' );
	register_setting( 'option-settings-group_total', 'cuerda_yjt_author__not_in' );
	register_setting( 'option-settings-group_total', 'cuerda_goo_author__not_in' );
	register_setting( 'option-settings-group_total', 'cuerda_dcm_author__not_in' );
	register_setting( 'option-settings-group_total', 'cuerda_spb_author__not_in' );
	register_setting( 'option-settings-group_total', 'cuerda_snf_author__not_in' );
	register_setting( 'option-settings-group_total', 'cuerda_gnf_author__not_in' );
	register_setting( 'option-settings-group_total', 'cuerda_lnr_author__not_in' );
	register_setting( 'option-settings-group_total', 'cuerda_ldn_author__not_in' );
	register_setting( 'option-settings-group_total', 'cuerda_isn_author__not_in' );
	register_setting( 'option-settings-group_total', 'cuerda_ant_author__not_in' );
	register_setting( 'option-settings-group_total', 'cuerda_trl_author__not_in' );
	// 先頭に指定するカテゴリ名
	register_setting( 'option-settings-group_total', 'cuerda_goo_category__absolute' );
	register_setting( 'option-settings-group_total', 'cuerda_dcm_category__absolute' );
	// 配信から除外するカテゴリー
	register_setting( 'option-settings-group_total', 'cuerda_ynf_category__not_in' );
	register_setting( 'option-settings-group_total', 'cuerda_yjt_category__not_in' );
	register_setting( 'option-settings-group_total', 'cuerda_goo_category__not_in' );
	register_setting( 'option-settings-group_total', 'cuerda_dcm_category__not_in' );
	register_setting( 'option-settings-group_total', 'cuerda_spb_category__not_in' );
	register_setting( 'option-settings-group_total', 'cuerda_snf_category__not_in' );
	register_setting( 'option-settings-group_total', 'cuerda_gnf_category__not_in' );
	register_setting( 'option-settings-group_total', 'cuerda_lnr_category__not_in' );
	register_setting( 'option-settings-group_total', 'cuerda_ldn_category__not_in' );
	register_setting( 'option-settings-group_total', 'cuerda_isn_category__not_in' );
	register_setting( 'option-settings-group_total', 'cuerda_ant_category__not_in' );
	register_setting( 'option-settings-group_total', 'cuerda_trl_category__not_in' );
	// 配信するカテゴリー
	register_setting( 'option-settings-group_total', 'cuerda_ynf_category__in' );
	register_setting( 'option-settings-group_total', 'cuerda_yjt_category__in' );
	register_setting( 'option-settings-group_total', 'cuerda_goo_category__in' );
	register_setting( 'option-settings-group_total', 'cuerda_dcm_category__in' );
	register_setting( 'option-settings-group_total', 'cuerda_spb_category__in' );
	register_setting( 'option-settings-group_total', 'cuerda_snf_category__in' );
	register_setting( 'option-settings-group_total', 'cuerda_gnf_category__in' );
	register_setting( 'option-settings-group_total', 'cuerda_lnr_category__in' );
	register_setting( 'option-settings-group_total', 'cuerda_ldn_category__in' );
	register_setting( 'option-settings-group_total', 'cuerda_isn_category__in' );
	register_setting( 'option-settings-group_total', 'cuerda_ant_category__in' );
	register_setting( 'option-settings-group_total', 'cuerda_trl_category__in' );
	// 配信から除外するタグ
	register_setting( 'option-settings-group_total', 'cuerda_ynf_tag__not_in' );
	register_setting( 'option-settings-group_total', 'cuerda_yjt_tag__not_in' );
	register_setting( 'option-settings-group_total', 'cuerda_goo_tag__not_in' );
	register_setting( 'option-settings-group_total', 'cuerda_dcm_tag__not_in' );
	register_setting( 'option-settings-group_total', 'cuerda_spb_tag__not_in' );
	register_setting( 'option-settings-group_total', 'cuerda_snf_tag__not_in' );
	register_setting( 'option-settings-group_total', 'cuerda_gnf_tag__not_in' );
	register_setting( 'option-settings-group_total', 'cuerda_lnr_tag__not_in' );
	register_setting( 'option-settings-group_total', 'cuerda_ldn_tag__not_in' );
	register_setting( 'option-settings-group_total', 'cuerda_isn_tag__not_in' );
	register_setting( 'option-settings-group_total', 'cuerda_ant_tag__not_in' );
	register_setting( 'option-settings-group_total', 'cuerda_trl_tag__not_in' );
	// 配信するタグ
	register_setting( 'option-settings-group_total', 'cuerda_ynf_tag__in' );
	register_setting( 'option-settings-group_total', 'cuerda_yjt_tag__in' );
	register_setting( 'option-settings-group_total', 'cuerda_goo_tag__in' );
	register_setting( 'option-settings-group_total', 'cuerda_dcm_tag__in' );
	register_setting( 'option-settings-group_total', 'cuerda_spb_tag__in' );
	register_setting( 'option-settings-group_total', 'cuerda_snf_tag__in' );
	register_setting( 'option-settings-group_total', 'cuerda_gnf_tag__in' );
	register_setting( 'option-settings-group_total', 'cuerda_lnr_tag__in' );
	register_setting( 'option-settings-group_total', 'cuerda_ldn_tag__in' );
	register_setting( 'option-settings-group_total', 'cuerda_isn_tag__in' );
	register_setting( 'option-settings-group_total', 'cuerda_ant_tag__in' );
	register_setting( 'option-settings-group_total', 'cuerda_trl_tag__in' );
	// 配信から除外する記事
	register_setting( 'option-settings-group_total', 'cuerda_ynf_post__not_in' );
	register_setting( 'option-settings-group_total', 'cuerda_yjt_post__not_in' );
	register_setting( 'option-settings-group_total', 'cuerda_goo_post__not_in' );
	register_setting( 'option-settings-group_total', 'cuerda_dcm_post__not_in' );
	register_setting( 'option-settings-group_total', 'cuerda_spb_post__not_in' );
	register_setting( 'option-settings-group_total', 'cuerda_snf_post__not_in' );
	register_setting( 'option-settings-group_total', 'cuerda_gnf_post__not_in' );
	register_setting( 'option-settings-group_total', 'cuerda_lnr_post__not_in' );
	register_setting( 'option-settings-group_total', 'cuerda_ldn_post__not_in' );
	register_setting( 'option-settings-group_total', 'cuerda_isn_post__not_in' );
	register_setting( 'option-settings-group_total', 'cuerda_ant_post__not_in' );
	register_setting( 'option-settings-group_total', 'cuerda_trl_post__not_in' );
	// 関連リンク最大本数 lnr => 外部リンク情報最大本数 snf => 広告の代替関連記事リンク最大本数
	register_setting( 'option-settings-group_total', 'cuerda_ynf_rel_count' );
	register_setting( 'option-settings-group_total', 'cuerda_yjt_rel_count' );
	register_setting( 'option-settings-group_total', 'cuerda_goo_rel_count' );
	register_setting( 'option-settings-group_total', 'cuerda_dcm_rel_count' );
	register_setting( 'option-settings-group_total', 'cuerda_spb_rel_count' );
	register_setting( 'option-settings-group_total', 'cuerda_snf_rel_count' );
	register_setting( 'option-settings-group_total', 'cuerda_gnf_rel_count' );
	register_setting( 'option-settings-group_total', 'cuerda_lnr_rel_count' );
	register_setting( 'option-settings-group_total', 'cuerda_ldn_rel_count' );
	register_setting( 'option-settings-group_total', 'cuerda_isn_rel_count' );
	register_setting( 'option-settings-group_total', 'cuerda_ant_rel_count' );
	register_setting( 'option-settings-group_total', 'cuerda_trl_rel_count' );
	// 同一タグから関連リンクを出力する
	register_setting( 'option-settings-group_total', 'cuerda_ynf_rel_tag' );
	register_setting( 'option-settings-group_total', 'cuerda_yjt_rel_tag' );
	register_setting( 'option-settings-group_total', 'cuerda_goo_rel_tag' );
	register_setting( 'option-settings-group_total', 'cuerda_dcm_rel_tag' );
	register_setting( 'option-settings-group_total', 'cuerda_spb_rel_tag' );
	register_setting( 'option-settings-group_total', 'cuerda_snf_rel_tag' );
	register_setting( 'option-settings-group_total', 'cuerda_gnf_rel_tag' );
	register_setting( 'option-settings-group_total', 'cuerda_lnr_rel_tag' );
	register_setting( 'option-settings-group_total', 'cuerda_ldn_rel_tag' );
	register_setting( 'option-settings-group_total', 'cuerda_isn_rel_tag' );
	register_setting( 'option-settings-group_total', 'cuerda_trl_rel_tag' );
	// 手動関連リンクを優先出力する
	register_setting( 'option-settings-group_total', 'cuerda_ynf_rel_manual' );
	register_setting( 'option-settings-group_total', 'cuerda_yjt_rel_manual' );
	register_setting( 'option-settings-group_total', 'cuerda_goo_rel_manual' );
	register_setting( 'option-settings-group_total', 'cuerda_dcm_rel_manual' );
	register_setting( 'option-settings-group_total', 'cuerda_spb_rel_manual' );
	register_setting( 'option-settings-group_total', 'cuerda_snf_rel_manual' );
	register_setting( 'option-settings-group_total', 'cuerda_gnf_rel_manual' );
	register_setting( 'option-settings-group_total', 'cuerda_lnr_rel_manual' );
	register_setting( 'option-settings-group_total', 'cuerda_ldn_rel_manual' );
	register_setting( 'option-settings-group_total', 'cuerda_isn_rel_manual' );
	register_setting( 'option-settings-group_total', 'cuerda_ant_rel_manual' );
	register_setting( 'option-settings-group_total', 'cuerda_trl_rel_manual' );
	// 優先的に表示する手動関連リンクURLのカスタムフィールド名1
	register_setting( 'option-settings-group_total', 'cuerda_ynf_rel_feeld1' );
	register_setting( 'option-settings-group_total', 'cuerda_yjt_rel_feeld1' );
	register_setting( 'option-settings-group_total', 'cuerda_goo_rel_feeld1' );
	register_setting( 'option-settings-group_total', 'cuerda_dcm_rel_feeld1' );
	register_setting( 'option-settings-group_total', 'cuerda_spb_rel_feeld1' );
	register_setting( 'option-settings-group_total', 'cuerda_snf_rel_feeld1' );
	register_setting( 'option-settings-group_total', 'cuerda_gnf_rel_feeld1' );
	register_setting( 'option-settings-group_total', 'cuerda_lnr_rel_feeld1' );
	register_setting( 'option-settings-group_total', 'cuerda_ldn_rel_feeld1' );
	register_setting( 'option-settings-group_total', 'cuerda_isn_rel_feeld1' );
	register_setting( 'option-settings-group_total', 'cuerda_ant_rel_feeld1' );
	register_setting( 'option-settings-group_total', 'cuerda_trl_rel_feeld1' );
	// 優先的に表示する手動関連リンクURLのカスタムフィールド名2
	register_setting( 'option-settings-group_total', 'cuerda_ynf_rel_feeld2' );
	register_setting( 'option-settings-group_total', 'cuerda_yjt_rel_feeld2' );
	register_setting( 'option-settings-group_total', 'cuerda_goo_rel_feeld2' );
	register_setting( 'option-settings-group_total', 'cuerda_dcm_rel_feeld2' );
	register_setting( 'option-settings-group_total', 'cuerda_spb_rel_feeld2' );
	register_setting( 'option-settings-group_total', 'cuerda_snf_rel_feeld2' );
	register_setting( 'option-settings-group_total', 'cuerda_gnf_rel_feeld2' );
	register_setting( 'option-settings-group_total', 'cuerda_lnr_rel_feeld2' );
	register_setting( 'option-settings-group_total', 'cuerda_ldn_rel_feeld2' );
	register_setting( 'option-settings-group_total', 'cuerda_isn_rel_feeld2' );
	register_setting( 'option-settings-group_total', 'cuerda_ant_rel_feeld2' );
	register_setting( 'option-settings-group_total', 'cuerda_trl_rel_feeld2' );
	// 優先的に表示する手動関連リンクURLのカスタムフィールド名3
	register_setting( 'option-settings-group_total', 'cuerda_ynf_rel_feeld3' );
	register_setting( 'option-settings-group_total', 'cuerda_yjt_rel_feeld3' );
	register_setting( 'option-settings-group_total', 'cuerda_goo_rel_feeld3' );
	register_setting( 'option-settings-group_total', 'cuerda_dcm_rel_feeld3' );
	register_setting( 'option-settings-group_total', 'cuerda_spb_rel_feeld3' );
	register_setting( 'option-settings-group_total', 'cuerda_snf_rel_feeld3' );
	register_setting( 'option-settings-group_total', 'cuerda_gnf_rel_feeld3' );
	register_setting( 'option-settings-group_total', 'cuerda_lnr_rel_feeld3' );
	register_setting( 'option-settings-group_total', 'cuerda_ldn_rel_feeld3' );
	register_setting( 'option-settings-group_total', 'cuerda_isn_rel_feeld3' );
	register_setting( 'option-settings-group_total', 'cuerda_ant_rel_feeld3' );
	register_setting( 'option-settings-group_total', 'cuerda_trl_rel_feeld3' );
	// 公開中を示す記事のステータス
	register_setting( 'option-settings-group_total', 'cuerda_total_publish_status' );
	// 関連リンクにノアドットを優先する
	register_setting( 'option-settings-group_total', 'cuerda_yjt_rel_nor_set' );
	register_setting( 'option-settings-group_total', 'cuerda_goo_rel_nor_set' );
	register_setting( 'option-settings-group_total', 'cuerda_dcm_rel_nor_set' );
	register_setting( 'option-settings-group_total', 'cuerda_spb_rel_nor_set' );
	register_setting( 'option-settings-group_total', 'cuerda_snf_rel_nor_set' );
	register_setting( 'option-settings-group_total', 'cuerda_gnf_rel_nor_set' );
	register_setting( 'option-settings-group_total', 'cuerda_lnr_rel_nor_set' );
	register_setting( 'option-settings-group_total', 'cuerda_ldn_rel_nor_set' );
	register_setting( 'option-settings-group_total', 'cuerda_isn_rel_nor_set' );
	register_setting( 'option-settings-group_total', 'cuerda_trl_rel_nor_set' );
	// 画像のキャプション
	register_setting( 'option-settings-group_total', 'cuerda_ynf_enclosure_alt' );
	register_setting( 'option-settings-group_total', 'cuerda_yjt_enclosure_alt' );
	register_setting( 'option-settings-group_total', 'cuerda_goo_enclosure_alt' );
	register_setting( 'option-settings-group_total', 'cuerda_gnf_enclosure_alt' );
	register_setting( 'option-settings-group_total', 'cuerda_ldn_enclosure_alt' );
	register_setting( 'option-settings-group_total', 'cuerda_isn_enclosure_alt' );
	register_setting( 'option-settings-group_total', 'cuerda_ant_enclosure_alt' );
	register_setting( 'option-settings-group_total', 'cuerda_trl_enclosure_alt' );
	// 記事に添付された画像メディアの配信
	register_setting( 'option-settings-group_total', 'cuerda_yjt_image' );
	register_setting( 'option-settings-group_total', 'cuerda_goo_image' );
	register_setting( 'option-settings-group_total', 'cuerda_dcm_image' );
	register_setting( 'option-settings-group_total', 'cuerda_snf_image' );
	register_setting( 'option-settings-group_total', 'cuerda_gnf_image' );
	register_setting( 'option-settings-group_total', 'cuerda_lnr_image' );
	register_setting( 'option-settings-group_total', 'cuerda_ldn_image' );
	register_setting( 'option-settings-group_total', 'cuerda_isn_image' );
	register_setting( 'option-settings-group_total', 'cuerda_ant_image' );
	register_setting( 'option-settings-group_total', 'cuerda_trl_image' );
	// アイキャッチに指定した画像メディアの配信
	register_setting( 'option-settings-group_total', 'cuerda_ynf_icatch' );
	register_setting( 'option-settings-group_total', 'cuerda_yjt_icatch' );
	register_setting( 'option-settings-group_total', 'cuerda_goo_icatch' );
	register_setting( 'option-settings-group_total', 'cuerda_dcm_icatch' );
	register_setting( 'option-settings-group_total', 'cuerda_spb_icatch' );
	register_setting( 'option-settings-group_total', 'cuerda_snf_icatch' );
	register_setting( 'option-settings-group_total', 'cuerda_gnf_icatch' );
	register_setting( 'option-settings-group_total', 'cuerda_lnr_icatch' );
	register_setting( 'option-settings-group_total', 'cuerda_ldn_icatch' );
	register_setting( 'option-settings-group_total', 'cuerda_isn_icatch' );
	register_setting( 'option-settings-group_total', 'cuerda_ant_icatch' );
	register_setting( 'option-settings-group_total', 'cuerda_trl_icatch' );
	// 本文冒頭にアイキャッチ画像を出力する
	register_setting( 'option-settings-group_total', 'cuerda_ynf_add_icatch' );
	register_setting( 'option-settings-group_total', 'cuerda_yjt_add_icatch' );
	register_setting( 'option-settings-group_total', 'cuerda_goo_add_icatch' );
	register_setting( 'option-settings-group_total', 'cuerda_dcm_add_icatch' );
	register_setting( 'option-settings-group_total', 'cuerda_spb_add_icatch' );
	register_setting( 'option-settings-group_total', 'cuerda_snf_add_icatch' );
	register_setting( 'option-settings-group_total', 'cuerda_gnf_add_icatch' );
	register_setting( 'option-settings-group_total', 'cuerda_lnr_add_icatch' );
	register_setting( 'option-settings-group_total', 'cuerda_ldn_add_icatch' );
	register_setting( 'option-settings-group_total', 'cuerda_isn_add_icatch' );
	register_setting( 'option-settings-group_total', 'cuerda_ant_add_icatch' );
	register_setting( 'option-settings-group_total', 'cuerda_trl_add_icatch' );
	// 記事に添付された動画メディアの配信
	register_setting( 'option-settings-group_total', 'cuerda_goo_video' );
	register_setting( 'option-settings-group_total', 'cuerda_snf_video' );
	register_setting( 'option-settings-group_total', 'cuerda_lnr_video' );
	// 著作者表示用のカスタムフィールド名 OR 画像の出典元情報のカスタムフィールド名
	register_setting( 'option-settings-group_total', 'cuerda_ynf_cf_creator' );
	register_setting( 'option-settings-group_total', 'cuerda_yjt_cf_creator' );
	register_setting( 'option-settings-group_total', 'cuerda_goo_cf_creator' );
	register_setting( 'option-settings-group_total', 'cuerda_snf_cf_creator' );
	register_setting( 'option-settings-group_total', 'cuerda_gnf_cf_creator' );
	register_setting( 'option-settings-group_total', 'cuerda_lnr_cf_creator' );
	register_setting( 'option-settings-group_total', 'cuerda_ldn_cf_creator' );
	register_setting( 'option-settings-group_total', 'cuerda_isn_cf_creator' );
	register_setting( 'option-settings-group_total', 'cuerda_ant_cf_creator' );
	register_setting( 'option-settings-group_total', 'cuerda_trl_cf_creator' );
	// 画像の出典元情報のURLカスタムフィールド名
	register_setting( 'option-settings-group_total', 'cuerda_trl_cf_creator_url' );
	// YouTube 用のカスタムフィールド名
	register_setting( 'option-settings-group_total', 'cuerda_total_cf_youtube' );
	// 標準地域コードの自動配信
	register_setting( 'option-settings-group_total', 'cuerda_ynf_area_city' );
	register_setting( 'option-settings-group_total', 'cuerda_goo_area_city' );
	register_setting( 'option-settings-group_total', 'cuerda_lnr_area_city' );
	register_setting( 'option-settings-group_total', 'cuerda_spb_area_city' );
	// 当該リソース提供者の copyright
	register_setting( 'option-settings-group_total', 'cuerda_dcm_copyright' );
	register_setting( 'option-settings-group_total', 'cuerda_spb_copyright' );
	register_setting( 'option-settings-group_total', 'cuerda_gnf_copyright' );
	register_setting( 'option-settings-group_total', 'cuerda_ldn_copyright' );
	register_setting( 'option-settings-group_total', 'cuerda_isn_copyright' );
	register_setting( 'option-settings-group_total', 'cuerda_ant_copyright' );
	register_setting( 'option-settings-group_total', 'cuerda_trl_copyright' );
	// a タグをアンカーテキストを含め除去する
	register_setting( 'option-settings-group_total', 'cuerda_yjt_atag' );
	register_setting( 'option-settings-group_total', 'cuerda_dcm_atag' );
	register_setting( 'option-settings-group_total', 'cuerda_spb_atag' );
	register_setting( 'option-settings-group_total', 'cuerda_lnr_atag' );
	register_setting( 'option-settings-group_total', 'cuerda_ldn_atag' );
	register_setting( 'option-settings-group_total', 'cuerda_isn_atag' );
	register_setting( 'option-settings-group_total', 'cuerda_ant_atag' );
	register_setting( 'option-settings-group_total', 'cuerda_trl_atag' );
	// table タグを除去する
	register_setting( 'option-settings-group_total', 'cuerda_yjt_table' );
	register_setting( 'option-settings-group_total', 'cuerda_dcm_table' );
	register_setting( 'option-settings-group_total', 'cuerda_spb_table' );
	register_setting( 'option-settings-group_total', 'cuerda_lnr_table' );
	register_setting( 'option-settings-group_total', 'cuerda_ldn_table' );
	register_setting( 'option-settings-group_total', 'cuerda_isn_table' );
	register_setting( 'option-settings-group_total', 'cuerda_ant_table' );
	register_setting( 'option-settings-group_total', 'cuerda_trl_table' );
	// table タグを p に置換しインライン可する
	register_setting( 'option-settings-group_total', 'cuerda_yjt_table_inline' );
	register_setting( 'option-settings-group_total', 'cuerda_trl_table_inline' );
	// table タグを p に置換しインライン可した時のデリミタ
	register_setting( 'option-settings-group_total', 'cuerda_yjt_table_inline_delimiter' );
	register_setting( 'option-settings-group_total', 'cuerda_trl_table_inline_delimiter' );
	// 配信先での遅延公開分数カスタムフィールド名
	register_setting( 'option-settings-group_total', 'cuerda_goo_cf_publish_delay' );
	register_setting( 'option-settings-group_total', 'cuerda_dcm_cf_publish_delay' );
	register_setting( 'option-settings-group_total', 'cuerda_snf_cf_publish_delay' );
	register_setting( 'option-settings-group_total', 'cuerda_gnf_cf_publish_delay' );
	register_setting( 'option-settings-group_total', 'cuerda_lnr_cf_publish_delay' );
	register_setting( 'option-settings-group_total', 'cuerda_ldn_cf_publish_delay' );
	register_setting( 'option-settings-group_total', 'cuerda_isn_cf_publish_delay' );
	register_setting( 'option-settings-group_total', 'cuerda_ant_cf_publish_delay' );
	register_setting( 'option-settings-group_total', 'cuerda_trl_cf_publish_delay' );
	// 配信先での遅延公開
	register_setting( 'option-settings-group_total', 'cuerda_goo_publish_delay' );
	register_setting( 'option-settings-group_total', 'cuerda_dcm_publish_delay' );
	register_setting( 'option-settings-group_total', 'cuerda_snf_publish_delay' );
	register_setting( 'option-settings-group_total', 'cuerda_gnf_publish_delay' );
	register_setting( 'option-settings-group_total', 'cuerda_lnr_publish_delay' );
	register_setting( 'option-settings-group_total', 'cuerda_ldn_publish_delay' );
	register_setting( 'option-settings-group_total', 'cuerda_isn_publish_delay' );
	register_setting( 'option-settings-group_total', 'cuerda_ant_publish_delay' );
	register_setting( 'option-settings-group_total', 'cuerda_trl_publish_delay' );
	// 記事の有効期限
	register_setting( 'option-settings-group_total', 'cuerda_lnr_expire' );
	register_setting( 'option-settings-group_total', 'cuerda_ant_expire' );
	// ロゴ画像のURL
	register_setting( 'option-settings-group_total', 'cuerda_snf_logo' );
	register_setting( 'option-settings-group_total', 'cuerda_gnf_logo' );
	// サイトの横長のロゴ画像のURL
	register_setting( 'option-settings-group_total', 'cuerda_gnf_wide_logo' );
	// ダークモードに対応したロゴ画像のURL
	register_setting( 'option-settings-group_total', 'cuerda_snf_darkmodelogo' );
	// 代替画像のURL
	register_setting( 'option-settings-group_total', 'cuerda_snf_thumbnail' );
	// アクセス解析用コード
	register_setting( 'option-settings-group_total', 'cuerda_snf_analytics' );
	register_setting( 'option-settings-group_total', 'cuerda_gnf_analytics' );
	register_setting( 'option-settings-group_total', 'cuerda_gnf_analytics_gn' );
	register_setting( 'option-settings-group_total', 'cuerda_gnf_analytics_st' );
	// 配信先 FTP サーバーへRSSフィードをPUTする
	register_setting( 'option-settings-group_total', 'cuerda_ynf_ftp_put' );
	// FTP サーバーのホスト名
	register_setting( 'option-settings-group_total', 'cuerda_ynf_ftp_server' );
	// FTP サーバーのユーザー名
	register_setting( 'option-settings-group_total', 'cuerda_ynf_ftp_user_name' );
	// FTP サーバーのパスワード
	register_setting( 'option-settings-group_total', 'cuerda_ynf_ftp_password' );
	// FTP サーバーのリモートディレクトリ
	register_setting( 'option-settings-group_total', 'cuerda_ynf_ftp_remote_dir' );
	// Yahoo!ニュースの媒体コード
	register_setting( 'option-settings-group_total', 'cuerda_ynf_id' );
	// RSSフィードのLDAPユーザー名
	register_setting( 'option-settings-group_total', 'cuerda_ynf_ldap_user' );
	// RSSフィードのLDAPパスワード
	register_setting( 'option-settings-group_total', 'cuerda_ynf_ldap_pass' );
	// デバッグモード
	register_setting( 'option-settings-group_total', 'cuerda_ynf_debug' );
	// Yahoo!ニュース記事種別
	register_setting( 'option-settings-group_total', 'cuerda_ynf_articletype' );
	// 記事の要約カスタムフィールド
//	register_setting( 'option-settings-group_total', 'cuerda_ynf_article_summary' );
	// 広告の代替を自動表示
	register_setting( 'option-settings-group_total', 'cuerda_snf_rel_ad' );
	// 【広告1本目】リンクURL
	register_setting( 'option-settings-group_total', 'cuerda_snf_rel_link1' );
	// 【広告1本目】記事タイトル
	register_setting( 'option-settings-group_total', 'cuerda_snf_rel_title1' );
	// 【広告1本目】サムネイル画像 URL
	register_setting( 'option-settings-group_total', 'cuerda_snf_rel_thumbnail1' );
	// 【広告1本目】広告主名
	register_setting( 'option-settings-group_total', 'cuerda_snf_rel_advertiser1' );
	// 【広告2本目】リンクURL
	register_setting( 'option-settings-group_total', 'cuerda_snf_rel_link2' );
	// 【広告2本目】記事タイトル
	register_setting( 'option-settings-group_total', 'cuerda_snf_rel_title2' );
	// 【広告2本目】サムネイル画像 URL
	register_setting( 'option-settings-group_total', 'cuerda_snf_rel_thumbnail2' );
	// 【広告2本目】広告主名
	register_setting( 'option-settings-group_total', 'cuerda_snf_rel_advertiser2' );
	// Yahoo!ニュースカテゴリマッピング
	$args2 = array("orderby" => "count","order" => "DSC","hide_empty" => false);
	$categories = get_categories( $args2 );
	foreach( $categories as $category ){
	 $option_name_sufix = $category->term_id;
	 $option_name = "cuerda_ynf_category_";
	 $option_name .= $option_name_sufix;
	 register_setting( 'option-settings-group_total', $option_name );
	 } unset($category);
	// グノシーカテゴリマッピング
	$args1 = array("orderby" => "count","order" => "DSC","hide_empty" => false);
	$categories = get_categories( $args1 );
	foreach( $categories as $category ){
	 $option_name_sufix = $category->term_id;
	 $option_name = "cuerda_gnf_category_";
	 $option_name .= $option_name_sufix;
	 register_setting( 'option-settings-group_total', $option_name );
	 } unset($category);
	// SPORTS BULL カテゴリマッピング
	$args3 = array("orderby" => "count","order" => "DSC","hide_empty" => false);
	$categories = get_categories( $args3 );
	foreach( $categories as $category ){
	 $option_name_sufix = $category->term_id;
	 $option_name = "cuerda_spb_category_";
	 $option_name .= $option_name_sufix;
	 register_setting( 'option-settings-group_total', $option_name );
	 } unset($category);
}

<?php 
// cerda（クエルダ）は本プログラムソースコードの著作権を保有しています。
// Copyright (C) 2020 CUERDA(https://cuerda.org).
if(!defined('ABSPATH')){
die('Forbidden');
}
// wp_kses 除外対象要素
/* ***** ynf ********************************************************* */
if($feed_for === 'ynf'){
	$allowed_html = array(
	'table' => array(),
	'p' => array(),
	'iframe' => array(),
	'script' => array(),
	'style' => array()
	);
	// 投稿の全内容を取得
	global $post;
	$content_manage = $post->post_content;
	$deny_html = '(<\s*iframe(\s+|>)[\s\S]*?<\s*\/iframe\s*>|<\s*script(\s+|>)[\s\S]*?<\s*\/script\s*>|<\s*style(\s+|>)[\s\S]*?<\s*\/style\s*>)';
	$content = wp_kses(do_shortcode($content_manage), $allowed_html);
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
	// 連想配列に格納された特定の正規表現を削除

	$content = preg_replace('/&lt;!--[\s\S]*?--&gt;/imsu', '<!-- Comment Out -->', $content);
	$content = preg_replace('/<!--\s*[\s\S]*?--\s*>/imsu', '', $content);
	htmlspecialchars($content, ENT_QUOTES|ENT_HTML5, "UTF-8");
	$pattern = '/\n{3,}/';
	$content = preg_replace($pattern, "\n", $content);
	$content = preg_replace('/<\s*\/p\s*>\n<\s*p\s*>/imsu', "\n\n", $content);
	$content = preg_replace('/<\s*\/?p\s*>/imsu', "", $content);
	return;
}else{
}

/* ***** goo ********************************************************* */
if($feed_for === 'goo'){
$allowed_html = array(
'a' => array('href' => array(),'name' => array(),'rel' => array(),'target' => array(),'title' => array()),
'abbr' => array(),
//'acronym' => array(),
'address' => array(),
//'applet' => array(),
//'area' => array(),
'article' => array(),
//'aside' => array(),
//'audio' => array(),
'b' => array(),
//'base' => array(),
//'basefont' => array(),
//'bdi' => array(),
'bdo' => array(),
//'bgsound' => array(),
'big' => array(),
'blink' => array(),
'blockquote' => array('title' => array(),'class' => array(),'data-lang' => array(),'cite' => array(),'data-dnt' => array(),'data-video-id' => array(),'data-instgrm-captioned' => array(),'data-instgrm-permalink' => array(),'data-instgrm-version' => array()),
//'body' => array(),
'br' => array(),
//'button' => array(),
//'canvas' => array(),
'caption' => array(),
//'center' => array(),
'cite' => array(),
'code' => array(),
'col' => array(),
'colgroup' => array(),
//'comment' => array(),
//'content' => array(),
//'data' => array(),
//'datalist' => array(),
'dd' => array(),
'del' => array(),
//'details' => array(),
'dfn' => array(),
//'dialog' => array(),
//'dir' => array(),
'div' => array('id' => array(),'class' => array(),'data-href' => array(),'data-width' => array(),'data-show-text' => array()),
'dl' => array(),
'dt' => array(),
'em' => array(),
//'embed' => array(),
//'fieldset' => array(),
'figcaption' => array(),
'figure' => array(),
//'font' => array(),
//'footer' => array(),
//'form' => array(),
//'frame' => array(),
//'frameset' => array(),
'h1' => array(),
'h2' => array(),
'h3' => array(),
'h4' => array(),
'h5' => array(),
'h6' => array(),
//'head' => array(),
//'header' => array(),
//'hgroup' => array(),
'hr' => array(),
//'html' => array(),
'i' => array(),
'iframe' => array('width' => array(),'height' => array(),'frameborder' => array(),'allow' => array(),'allowfullscreen' => array(),'webkitallowfullscreen' => array(),'mozallowfullscreen' => array(),'loading' => array(),'referrerpolicy' => array(),'title' => array(),'src' => array()),
//'image' => array(),
'img' => array('src' => array(),'data-src' => array(),'data-caption' => array(),'alt' => array()),
//'input' => array('*' => array()),
'ins' => array(),
//'isindex' => array(),
'kbd' => array(),
//'keygen' => array(),
//'label' => array(),
//'legend' => array(),
'li' => array(),
//'link' => array(),
'listing' => array(),
'main' => array(),
//'map' => array(),
'mark' => array(),
'marquee' => array(),
//'menu' => array(),
//'menuitem' => array(),
//'meta' => array(),
//'meter' => array(),
//'nav' => array(),
//'nobr' => array(),
//'noembed' => array(),
//'noframes' => array(),
'noscript' => array(),
//'object' => array(),
'ol' => array(),
//'optgroup' => array(),
//'option' => array(),
//'output' => array(),
'p' => array('lang' => array(),'dir' => array()),
//'param' => array(),
//'picture' => array(),
//'plaintext' => array(),
//'portal' => array(),
'pre' => array(),
//'progress' => array(),
'q' => array(),
//'rb' => array(),
'rp' => array(),
'rt' => array(),
//'rtc' => array(),
'ruby' => array(),
's' => array(),
'samp' => array(),
'script' => array('charset' => array(),'async' => array(),'defer' => array(),'crossorigin' => array(),'src' => array(),'nonce' => array()),
'section' => array(),
//'select' => array(),
//'shadow' => array(),
//'slot' => array(),
'small' => array(),
//'source' => array('type' => array(),'src' => array(),'srcset' => array()),
//'spacer' => array(),
'span' => array(),
//'strike' => array(),
'strong' => array(),
'style' => array(),
'sub' => array(),
//'summary' => array(),
'sup' => array(),
'table' => array(),
'tbody' => array(),
'td' => array('colspan' => array(),'rowspan' => array()),
//'template' => array(),
'textarea' => array(),
'tfoot' => array(),
'th' => array('colspan' => array(),'rowspan' => array()),
'thead' => array(),
'time' => array(),
//'title' => array(),
'tr' => array(),
//'track' => array(),
//'tt' => array(),
//'u' => array(),
'ul' => array(),
'var' => array()
//'video' => array('width' => array(),'height' => array()),
//'wbr' => array(),
//'xmp' => array()
);
}else{
}

/* ***** lnr ********************************************************* */
if($feed_for === 'lnr'){
$allowed_html = array(
'a' => array('href' => array(),'name' => array(),'rel' => array(),'target' => array(),'title' => array()),
//'abbr' => array(),
//'acronym' => array(),
'address' => array(),
//'applet' => array(),
//'area' => array(),
//'article' => array(),
//'aside' => array(),
//'audio' => array(),
'b' => array(),
//'base' => array(),
//'basefont' => array(),
//'bdi' => array(),
//'bdo' => array(),
//'bgsound' => array(),
'big' => array(),
'blink' => array(),
'blockquote' => array('title' => array(),'class' => array(),'data-lang' => array(),'cite' => array(),'data-dnt' => array(),'data-video-id' => array(),'data-instgrm-captioned' => array(),'data-instgrm-permalink' => array(),'data-instgrm-version' => array()),
//'body' => array(),
'br' => array(),
//'button' => array(),
//'canvas' => array(),
//'caption' => array(),
//'center' => array(),
'cite' => array(),
//'code' => array(),
//'col' => array(),
//'colgroup' => array(),
//'comment' => array(),
//'content' => array(),
//'data' => array(),
//'datalist' => array(),
'dd' => array(),
'del' => array(),
//'details' => array(),
//'dfn' => array(),
//'dialog' => array(),
//'dir' => array(),
'div' => array('id' => array(),'class' => array(),'data-href' => array(),'data-width' => array(),'data-show-text' => array()),
//'dl' => array(),
'dt' => array(),
'em' => array(),
//'embed' => array(),
//'fieldset' => array(),
'figcaption' => array(),
//'figure' => array(),
//'font' => array(),
//'footer' => array(),
//'form' => array(),
//'frame' => array(),
//'frameset' => array(),
'h1' => array(),
'h2' => array(),
'h3' => array(),
'h4' => array(),
'h5' => array(),
'h6' => array(),
//'head' => array(),
//'header' => array(),
//'hgroup' => array(),
'hr' => array(),
//'html' => array(),
//'i' => array(),
'iframe' => array('width' => array(),'height' => array(),'frameborder' => array(),'allow' => array(),'allowfullscreen' => array(),'webkitallowfullscreen' => array(),'mozallowfullscreen' => array(),'loading' => array(),'referrerpolicy' => array(),'title' => array(),'src' => array()),
//'image' => array(),
'img' => array('src' => array(),'data-src' => array(),'data-caption' => array(),'alt' => array()),
//'input' => array('*' => array()),
//'ins' => array(),
//'isindex' => array(),
//'kbd' => array(),
//'keygen' => array(),
//'label' => array(),
//'legend' => array(),
'li' => array(),
//'link' => array(),
'listing' => array(),
//'main' => array(),
//'map' => array(),
//'mark' => array(),
'marquee' => array(),
//'menu' => array(),
//'menuitem' => array(),
//'meta' => array(),
//'meter' => array(),
//'nav' => array(),
//'nobr' => array(),
//'noembed' => array(),
//'noframes' => array(),
//'noscript' => array(),
//'object' => array(),
'ol' => array(),
//'optgroup' => array(),
//'option' => array(),
//'output' => array(),
'p' => array('lang' => array(),'dir' => array()),
//'param' => array(),
//'picture' => array(),
//'plaintext' => array(),
//'portal' => array(),
'pre' => array(),
//'progress' => array(),
//'q' => array(),
//'rb' => array(),
//'rp' => array(),
//'rt' => array(),
//'rtc' => array(),
//'ruby' => array(),
//'s' => array(),
//'samp' => array(),
'script' => array('charset' => array(),'async' => array(),'defer' => array(),'crossorigin' => array(),'src' => array(),'nonce' => array()),
//'section' => array(),
//'select' => array(),
//'shadow' => array(),
//'slot' => array(),
//'small' => array(),
//'source' => array('type' => array(),'src' => array(),'srcset' => array()),
//'spacer' => array(),
//'span' => array(),
//'strike' => array(),
'strong' => array(),
'style' => array(),
//'sub' => array(),
//'summary' => array(),
//'sup' => array(),
//'table' => array(),
//'tbody' => array(),
//'td' => array('colspan' => array(),'rowspan' => array()),
//'template' => array(),
'textarea' => array(),
//'tfoot' => array(),
//'th' => array('colspan' => array(),'rowspan' => array()),
//'thead' => array(),
//'time' => array(),
//'title' => array(),
//'tr' => array(),
//'track' => array(),
//'tt' => array(),
//'u' => array(),
'ul' => array()
//'var' => array(),
//'video' => array('width' => array(),'height' => array()),
//'wbr' => array(),
//'xmp' => array()
);
}else{
}

/* ***** dcm ********************************************************* */
if($feed_for === 'dcm'){
$allowed_html = array(
'a' => array('href' => array(),'name' => array(),'rel' => array(),'target' => array(),'title' => array()),
//'abbr' => array(),
//'acronym' => array(),
'address' => array(),
//'applet' => array(),
//'area' => array(),
//'article' => array(),
//'aside' => array(),
//'audio' => array(),
'b' => array(),
//'base' => array(),
//'basefont' => array(),
//'bdi' => array(),
//'bdo' => array(),
//'bgsound' => array(),
'big' => array(),
'blink' => array(),
'blockquote' => array('title' => array(),'class' => array(),'data-lang' => array(),'cite' => array(),'data-dnt' => array(),'data-video-id' => array(),'data-instgrm-captioned' => array(),'data-instgrm-permalink' => array(),'data-instgrm-version' => array()),
//'body' => array(),
'br' => array(),
//'button' => array(),
//'canvas' => array(),
'caption' => array(),
//'center' => array(),
'cite' => array(),
//'code' => array(),
//'col' => array(),
//'colgroup' => array(),
//'comment' => array(),
//'content' => array(),
//'data' => array(),
//'datalist' => array(),
'dd' => array(),
'del' => array(),
//'details' => array(),
//'dfn' => array(),
//'dialog' => array(),
//'dir' => array(),
'div' => array('id' => array(),'class' => array(),'data-href' => array(),'data-width' => array(),'data-show-text' => array()),
//'dl' => array(),
'dt' => array(),
'em' => array(),
//'embed' => array(),
//'fieldset' => array(),
'figcaption' => array(),
//'figure' => array(),
//'font' => array(),
//'footer' => array(),
//'form' => array(),
//'frame' => array(),
//'frameset' => array(),
'h1' => array(),
'h2' => array(),
'h3' => array(),
'h4' => array(),
'h5' => array(),
'h6' => array(),
//'head' => array(),
//'header' => array(),
//'hgroup' => array(),
//'hr' => array(),
//'html' => array(),
//'i' => array(),
'iframe' => array('width' => array(),'height' => array(),'frameborder' => array(),'allow' => array(),'allowfullscreen' => array(),'webkitallowfullscreen' => array(),'mozallowfullscreen' => array(),'loading' => array(),'referrerpolicy' => array(),'title' => array(),'src' => array()),
//'image' => array(),
'img' => array('src' => array(),'data-src' => array(),'data-caption' => array(),'alt' => array()),
//'input' => array('*' => array()),
//'ins' => array(),
//'isindex' => array(),
//'kbd' => array(),
//'keygen' => array(),
//'label' => array(),
//'legend' => array(),
'li' => array(),
//'link' => array(),
'listing' => array(),
//'main' => array(),
//'map' => array(),
//'mark' => array(),
'marquee' => array(),
//'menu' => array(),
//'menuitem' => array(),
//'meta' => array(),
//'meter' => array(),
//'nav' => array(),
//'nobr' => array(),
//'noembed' => array(),
//'noframes' => array(),
//'noscript' => array(),
//'object' => array(),
//'ol' => array(),
//'optgroup' => array(),
//'option' => array(),
//'output' => array(),
'p' => array('lang' => array(),'dir' => array()),
//'param' => array(),
//'picture' => array(),
//'plaintext' => array(),
//'portal' => array(),
'pre' => array(),
//'progress' => array(),
//'q' => array(),
//'rb' => array(),
//'rp' => array(),
//'rt' => array(),
//'rtc' => array(),
//'ruby' => array(),
//'s' => array(),
//'samp' => array(),
'script' => array('charset' => array(),'async' => array(),'defer' => array(),'crossorigin' => array(),'src' => array(),'nonce' => array()),
//'section' => array(),
//'select' => array(),
//'shadow' => array(),
//'slot' => array(),
'small' => array(),
//'source' => array('type' => array(),'src' => array(),'srcset' => array()),
//'spacer' => array(),
//'span' => array(),
//'strike' => array(),
'strong' => array(),
'style' => array(),
//'sub' => array(),
//'summary' => array(),
//'sup' => array(),
'table' => array(),
'tbody' => array(),
'td' => array('colspan' => array(),'rowspan' => array()),
//'template' => array(),
'textarea' => array(),
'tfoot' => array(),
'th' => array('colspan' => array(),'rowspan' => array()),
'thead' => array(),
//'time' => array(),
//'title' => array(),
'tr' => array()
//'track' => array(),
//'tt' => array(),
//'u' => array(),
//'ul' => array(),
//'var' => array(),
//'video' => array('width' => array(),'height' => array()),
//'wbr' => array(),
//'xmp' => array()
);
}else{
}

/* ***** spb ********************************************************* */
if($feed_for === 'spb'){
$allowed_html = array(
'a' => array('href' => array(),'name' => array(),'rel' => array(),'target' => array(),'title' => array()),
//'abbr' => array(),
//'acronym' => array(),
'address' => array(),
//'applet' => array(),
//'area' => array(),
//'article' => array(),
//'aside' => array(),
//'audio' => array(),
'b' => array(),
//'base' => array(),
//'basefont' => array(),
//'bdi' => array(),
//'bdo' => array(),
//'bgsound' => array(),
'big' => array(),
'blink' => array(),
//'blockquote' => array('title' => array(),'class' => array(),'data-lang' => array(),'cite' => array(),'data-dnt' => array(),'data-video-id' => array(),'data-instgrm-captioned' => array(),'data-instgrm-permalink' => array(),'data-instgrm-version' => array()),
//'body' => array(),
'br' => array(),
//'button' => array(),
//'canvas' => array(),
'caption' => array(),
//'center' => array(),
'cite' => array(),
//'code' => array(),
//'col' => array(),
//'colgroup' => array(),
//'comment' => array(),
//'content' => array(),
//'data' => array(),
//'datalist' => array(),
'dd' => array(),
'del' => array(),
//'details' => array(),
//'dfn' => array(),
//'dialog' => array(),
//'dir' => array(),
'div' => array(),
//'dl' => array(),
'dt' => array(),
'em' => array(),
//'embed' => array(),
//'fieldset' => array(),
'figcaption' => array(),
//'figure' => array(),
//'font' => array(),
//'footer' => array(),
//'form' => array(),
//'frame' => array(),
//'frameset' => array(),
'h1' => array(),
'h2' => array(),
'h3' => array(),
'h4' => array(),
'h5' => array(),
'h6' => array(),
//'head' => array(),
//'header' => array(),
//'hgroup' => array(),
//'hr' => array(),
//'html' => array(),
//'i' => array(),
'iframe' => array('width' => array(),'height' => array(),'frameborder' => array(),'allow' => array(),'allowfullscreen' => array(),'webkitallowfullscreen' => array(),'mozallowfullscreen' => array(),'loading' => array(),'referrerpolicy' => array(),'title' => array(),'src' => array()),
//'image' => array(),
'img' => array('src' => array(),'data-src' => array(),'data-caption' => array(),'alt' => array()),
//'input' => array('*' => array()),
//'ins' => array(),
//'isindex' => array(),
//'kbd' => array(),
//'keygen' => array(),
//'label' => array(),
//'legend' => array(),
'li' => array(),
//'link' => array(),
'listing' => array(),
//'main' => array(),
//'map' => array(),
//'mark' => array(),
'marquee' => array(),
//'menu' => array(),
//'menuitem' => array(),
//'meta' => array(),
//'meter' => array(),
//'nav' => array(),
//'nobr' => array(),
//'noembed' => array(),
//'noframes' => array(),
//'noscript' => array(),
//'object' => array(),
//'ol' => array(),
//'optgroup' => array(),
//'option' => array(),
//'output' => array(),
'p' => array(),
//'param' => array(),
//'picture' => array(),
//'plaintext' => array(),
//'portal' => array(),
'pre' => array(),
//'progress' => array(),
//'q' => array(),
//'rb' => array(),
//'rp' => array(),
//'rt' => array(),
//'rtc' => array(),
//'ruby' => array(),
//'s' => array(),
//'samp' => array(),
'script' => array('charset' => array(),'async' => array(),'defer' => array(),'crossorigin' => array(),'src' => array(),'nonce' => array()),
//'section' => array(),
//'select' => array(),
//'shadow' => array(),
//'slot' => array(),
//'small' => array(),
//'source' => array('type' => array(),'src' => array(),'srcset' => array()),
//'spacer' => array(),
//'span' => array(),
//'strike' => array(),
//'strong' => array(),
'style' => array(),
//'sub' => array(),
//'summary' => array(),
//'sup' => array(),
'table' => array(),
'tbody' => array(),
'td' => array('colspan' => array(),'rowspan' => array()),
//'template' => array(),
'textarea' => array(),
'tfoot' => array(),
'th' => array('colspan' => array(),'rowspan' => array()),
'thead' => array(),
//'time' => array(),
//'title' => array(),
'tr' => array()
//'track' => array(),
//'tt' => array(),
//'u' => array(),
//'ul' => array(),
//'var' => array(),
//'video' => array('width' => array(),'height' => array()),
//'wbr' => array(),
//'xmp' => array()
);
}else{
}

/* ***** gnf ********************************************************* */
if($feed_for === 'gnf'){
$allowed_html = array(
'a' => array('href' => array(),'name' => array(),'rel' => array(),'target' => array(),'title' => array()),
'abbr' => array(),
'acronym' => array(),
'address' => array(),
//'applet' => array(),
'area' => array(),
'article' => array(),
'aside' => array(),
'audio' => array(),
'b' => array(),
//'base' => array(),
//'basefont' => array(),
//'bdi' => array(),
//'bdo' => array(),
//'bgsound' => array(),
'big' => array(),
'blink' => array(),
'blockquote' => array('title' => array(),'class' => array(),'data-lang' => array(),'cite' => array(),'data-dnt' => array(),'data-video-id' => array(),'data-instgrm-captioned' => array(),'data-instgrm-permalink' => array(),'data-instgrm-version' => array()),
//'body' => array(),
'br' => array(),
'button' => array(),
'canvas' => array(),
'caption' => array(),
'center' => array(),
'cite' => array(),
'code' => array(),
'col' => array(),
'colgroup' => array(),
//'comment' => array(),
//'content' => array(),
//'data' => array(),
'datalist' => array(),
'dd' => array(),
'del' => array(),
'details' => array(),
'dfn' => array(),
'dialog' => array(),
'dir' => array(),
'div' => array('id' => array(),'class' => array(),'data-href' => array(),'data-width' => array(),'data-show-text' => array()),
'dl' => array(),
'dt' => array(),
'em' => array(),
//'embed' => array(),
'fieldset' => array(),
'figcaption' => array(),
'figure' => array(),
'font' => array(),
'footer' => array(),
'form' => array(),
//'frame' => array(),
//'frameset' => array(),
'h1' => array(),
'h2' => array(),
'h3' => array(),
'h4' => array(),
'h5' => array(),
'h6' => array(),
//'head' => array(),
'header' => array(),
//'hgroup' => array(),
'hr' => array(),
//'html' => array(),
'i' => array(),
'iframe' => array('width' => array(),'height' => array(),'frameborder' => array(),'allow' => array(),'allowfullscreen' => array(),'webkitallowfullscreen' => array(),'mozallowfullscreen' => array(),'loading' => array(),'referrerpolicy' => array(),'title' => array(),'src' => array()),
//'image' => array(),
'img' => array('src' => array(),'data-src' => array(),'data-caption' => array(),'alt' => array()),
'input' => array('*' => array()),
'ins' => array(),
//'isindex' => array(),
'kbd' => array(),
'keygen' => array(),
'label' => array(),
'legend' => array(),
'li' => array(),
//'link' => array(),
'listing' => array(),
//'main' => array(),
'map' => array(),
//'mark' => array(),
'marquee' => array(),
'menu' => array(),
//'menuitem' => array(),
//'meta' => array(),
'meter' => array(),
'nav' => array(),
//'nobr' => array(),
//'noembed' => array(),
//'noframes' => array(),
'noscript' => array(),
//'object' => array(),
'ol' => array(),
'optgroup' => array(),
'option' => array(),
'output' => array(),
'p' => array('lang' => array(),'dir' => array()),
//'param' => array(),
//'picture' => array(),
//'plaintext' => array(),
//'portal' => array(),
'pre' => array(),
'progress' => array(),
'q' => array(),
//'rb' => array(),
//'rp' => array(),
//'rt' => array(),
//'rtc' => array(),
//'ruby' => array(),
's' => array(),
'samp' => array(),
'script' => array('charset' => array(),'async' => array(),'defer' => array(),'crossorigin' => array(),'src' => array(),'nonce' => array()),
'section' => array(),
'select' => array(),
//'shadow' => array(),
//'slot' => array(),
'small' => array(),
'source' => array('type' => array(),'src' => array(),'srcset' => array()),
'spacer' => array(),
'span' => array(),
'strike' => array(),
'strong' => array(),
'style' => array(),
'sub' => array(),
//'summary' => array(),
'sup' => array(),
'table' => array(),
'tbody' => array(),
'td' => array('colspan' => array(),'rowspan' => array()),
//'template' => array(),
'textarea' => array(),
'tfoot' => array(),
'th' => array('colspan' => array(),'rowspan' => array()),
'thead' => array(),
'time' => array(),
//'title' => array(),
'tr' => array(),
//'track' => array(),
'tt' => array(),
'u' => array(),
'ul' => array(),
'var' => array()
//'video' => array('width' => array(),'height' => array()),
//'wbr' => array(),
//'xmp' => array()
);
}else{
}

/* ***** snf ********************************************************* */
if($feed_for === 'snf'){
$allowed_html = array(
'a' => array('href' => array(),'name' => array(),'rel' => array(),'target' => array(),'title' => array()),
'abbr' => array(),
'acronym' => array(),
'address' => array(),
//'applet' => array(),
//'area' => array(),
'article' => array(),
'aside' => array(),
//'audio' => array(),
'b' => array(),
'base' => array(),
'basefont' => array(),
'bdi' => array(),
'bdo' => array(),
'bgsound' => array(),
'big' => array(),
'blink' => array(),
'blockquote' => array('title' => array(),'class' => array(),'data-lang' => array(),'cite' => array(),'data-dnt' => array(),'data-video-id' => array(),'data-instgrm-captioned' => array(),'data-instgrm-permalink' => array(),'data-instgrm-version' => array()),
'body' => array(),
'br' => array(),
//'button' => array(),
//'canvas' => array(),
'caption' => array(),
'center' => array(),
'cite' => array(),
'code' => array(),
'col' => array(),
'colgroup' => array(),
//'comment' => array(),
//'content' => array(),
'data' => array(),
'datalist' => array(),
'dd' => array(),
'del' => array(),
'details' => array(),
'dfn' => array(),
//'dialog' => array(),
'dir' => array(),
'div' => array('id' => array(),'class' => array(),'data-href' => array(),'data-width' => array(),'data-show-text' => array()),
'dl' => array(),
'dt' => array(),
'em' => array(),
//'embed' => array(),
'fieldset' => array(),
'figcaption' => array(),
'figure' => array(),
'font' => array(),
'footer' => array(),
'form' => array(),
//'frame' => array(),
//'frameset' => array(),
'h1' => array(),
'h2' => array(),
'h3' => array(),
'h4' => array(),
'h5' => array(),
'h6' => array(),
//'head' => array(),
'header' => array(),
'hgroup' => array(),
'hr' => array(),
'html' => array(),
'i' => array(),
'iframe' => array('width' => array(),'height' => array(),'frameborder' => array(),'allow' => array(),'allowfullscreen' => array(),'webkitallowfullscreen' => array(),'mozallowfullscreen' => array(),'loading' => array(),'referrerpolicy' => array(),'title' => array(),'src' => array()),
//'image' => array(),
'img' => array('src' => array(),'data-src' => array(),'data-caption' => array(),'alt' => array()),
//'input' => array('*' => array()),
'ins' => array(),
//'isindex' => array(),
'kbd' => array(),
//'keygen' => array(),
'label' => array(),
'legend' => array(),
'li' => array(),
//'link' => array(),
'listing' => array(),
'main' => array(),
//'map' => array(),
'mark' => array(),
'marquee' => array(),
'menu' => array(),
//'menuitem' => array(),
//'meta' => array(),
'meter' => array(),
'nav' => array(),
'nobr' => array(),
//'noembed' => array(),
//'noframes' => array(),
//'noscript' => array(),
//'object' => array(),
'ol' => array(),
//'optgroup' => array(),
//'option' => array(),
//'output' => array(),
'p' => array('lang' => array(),'dir' => array()),
//'param' => array(),
//'picture' => array(),
'plaintext' => array(),
//'portal' => array(),
'pre' => array(),
//'progress' => array(),
'q' => array(),
'rb' => array(),
'rp' => array(),
'rt' => array(),
//'rtc' => array(),
'ruby' => array(),
's' => array(),
'samp' => array(),
'script' => array('charset' => array(),'async' => array(),'defer' => array(),'crossorigin' => array(),'src' => array(),'nonce' => array()),
'section' => array(),
//'select' => array(),
//'shadow' => array(),
//'slot' => array(),
'small' => array(),
//'source' => array('type' => array(),'src' => array(),'srcset' => array()),
'spacer' => array(),
'span' => array(),
'strike' => array(),
'strong' => array(),
'style' => array(),
'sub' => array(),
'summary' => array(),
'sup' => array(),
'table' => array(),
'tbody' => array(),
'td' => array('colspan' => array(),'rowspan' => array()),
//'template' => array(),
'textarea' => array(),
'tfoot' => array(),
'th' => array('colspan' => array(),'rowspan' => array()),
'thead' => array(),
'time' => array(),
//'title' => array(),
'tr' => array(),
//'track' => array(),
'tt' => array(),
'u' => array(),
'ul' => array(),
'var' => array(),
//'video' => array('width' => array(),'height' => array()),
'wbr' => array(),
'xmp' => array()
);
}else{
}

/* ***** ldn ********************************************************* */
if($feed_for === 'ldn'){
$allowed_html = array(
'a' => array('href' => array(),'name' => array(),'rel' => array(),'target' => array(),'title' => array()),
//'abbr' => array(),
//'acronym' => array(),
'address' => array(),
//'applet' => array(),
//'area' => array(),
//'article' => array(),
//'aside' => array(),
//'audio' => array(),
//'b' => array(),
//'base' => array(),
//'basefont' => array(),
//'bdi' => array(),
//'bdo' => array(),
//'bgsound' => array(),
//'big' => array(),
'blink' => array(),
'blockquote' => array('title' => array(),'class' => array(),'data-lang' => array(),'cite' => array(),'data-dnt' => array(),'data-video-id' => array(),'data-instgrm-captioned' => array(),'data-instgrm-permalink' => array(),'data-instgrm-version' => array()),
//'body' => array(),
'br' => array(),
//'button' => array(),
//'canvas' => array(),
//'caption' => array(),
//'center' => array(),
//'cite' => array(),
//'code' => array(),
//'col' => array(),
//'colgroup' => array(),
//'comment' => array(),
//'content' => array(),
//'data' => array(),
//'datalist' => array(),
'dd' => array(),
'del' => array(),
//'details' => array(),
//'dfn' => array(),
//'dialog' => array(),
//'dir' => array(),
//'div' => array('id' => array(),'class' => array(),'data-href' => array(),'data-width' => array(),'data-show-text' => array()),
//'dl' => array(),
'dt' => array(),
'em' => array(),
//'embed' => array(),
//'fieldset' => array(),
'figcaption' => array(),
//'figure' => array(),
//'font' => array(),
//'footer' => array(),
//'form' => array(),
//'frame' => array(),
//'frameset' => array(),
'h1' => array(),
'h2' => array(),
'h3' => array(),
'h4' => array(),
'h5' => array(),
'h6' => array(),
//'head' => array(),
//'header' => array(),
//'hgroup' => array(),
//'hr' => array(),
//'html' => array(),
//'i' => array(),
'iframe' => array('width' => array(),'height' => array(),'frameborder' => array(),'allow' => array(),'allowfullscreen' => array(),'webkitallowfullscreen' => array(),'mozallowfullscreen' => array(),'loading' => array(),'referrerpolicy' => array(),'title' => array(),'src' => array()),
//'image' => array(),
'img' => array('src' => array(),'data-src' => array(),'data-caption' => array(),'alt' => array()),
//'input' => array('*' => array()),
//'ins' => array(),
//'isindex' => array(),
//'kbd' => array(),
//'keygen' => array(),
//'label' => array(),
//'legend' => array(),
'li' => array(),
//'link' => array(),
'listing' => array(),
//'main' => array(),
//'map' => array(),
//'mark' => array(),
//'marquee' => array(),
//'menu' => array(),
//'menuitem' => array(),
//'meta' => array(),
//'meter' => array(),
//'nav' => array(),
//'nobr' => array(),
//'noembed' => array(),
//'noframes' => array(),
//'noscript' => array(),
//'object' => array(),
//'ol' => array(),
//'optgroup' => array(),
//'option' => array(),
//'output' => array(),
'p' => array('lang' => array(),'dir' => array()),
//'param' => array(),
//'picture' => array(),
//'plaintext' => array(),
//'portal' => array(),
//'pre' => array(),
//'progress' => array(),
//'q' => array(),
//'rb' => array(),
//'rp' => array(),
//'rt' => array(),
//'rtc' => array(),
//'ruby' => array(),
//'s' => array(),
//'samp' => array(),
'script' => array('charset' => array(),'async' => array(),'defer' => array(),'crossorigin' => array(),'src' => array(),'nonce' => array()),
//'section' => array(),
//'select' => array(),
//'shadow' => array(),
//'slot' => array(),
//'small' => array(),
//'source' => array('type' => array(),'src' => array(),'srcset' => array()),
//'spacer' => array(),
//'span' => array(),
//'strike' => array(),
//'strong' => array(),
'style' => array(),
//'sub' => array(),
//'summary' => array(),
//'sup' => array(),
'table' => array(),
//'tbody' => array(),
//'td' => array('colspan' => array(),'rowspan' => array()),
//'template' => array(),
'textarea' => array()
//'tfoot' => array(),
//'th' => array('colspan' => array(),'rowspan' => array()),
//'thead' => array(),
//'time' => array(),
//'title' => array(),
//'tr' => array(),
//'track' => array(),
//'tt' => array(),
//'u' => array(),
//'ul' => array(),
//'var' => array(),
//'video' => array('width' => array(),'height' => array()),
//'wbr' => array(),
//'xmp' => array()
);
}else{
}

/* ***** isn ********************************************************* */
if($feed_for === 'isn'){
$allowed_html = array(
//'a' => array('href' => array(),'name' => array(),'rel' => array(),'target' => array(),'title' => array()),
//'abbr' => array(),
//'acronym' => array(),
'address' => array(),
//'applet' => array(),
//'area' => array(),
//'article' => array(),
//'aside' => array(),
//'audio' => array(),
//'b' => array(),
//'base' => array(),
//'basefont' => array(),
//'bdi' => array(),
//'bdo' => array(),
//'bgsound' => array(),
//'big' => array(),
'blink' => array(),
//'blockquote' => array('title' => array(),'class' => array(),'data-lang' => array(),'cite' => array(),'data-dnt' => array(),'data-video-id' => array(),'data-instgrm-captioned' => array(),'data-instgrm-permalink' => array(),'data-instgrm-version' => array()),
//'body' => array(),
'br' => array(),
//'button' => array(),
//'canvas' => array(),
//'caption' => array(),
//'center' => array(),
//'cite' => array(),
//'code' => array(),
//'col' => array(),
//'colgroup' => array(),
//'comment' => array(),
//'content' => array(),
//'data' => array(),
//'datalist' => array(),
'dd' => array(),
'del' => array(),
//'details' => array(),
//'dfn' => array(),
//'dialog' => array(),
//'dir' => array(),
//'div' => array('id' => array(),'class' => array(),'data-href' => array(),'data-width' => array(),'data-show-text' => array()),
//'dl' => array(),
'dt' => array(),
//'em' => array(),
//'embed' => array(),
//'fieldset' => array(),
'figcaption' => array(),
//'figure' => array(),
//'font' => array(),
//'footer' => array(),
//'form' => array(),
//'frame' => array(),
//'frameset' => array(),
'h1' => array(),
'h2' => array(),
'h3' => array(),
'h4' => array(),
'h5' => array(),
'h6' => array(),
//'head' => array(),
//'header' => array(),
//'hgroup' => array(),
//'hr' => array(),
//'html' => array(),
//'i' => array(),
//'iframe' => array('width' => array(),'height' => array(),'frameborder' => array(),'allow' => array(),'allowfullscreen' => array(),'webkitallowfullscreen' => array(),'mozallowfullscreen' => array(),'loading' => array(),'referrerpolicy' => array(),'title' => array(),'src' => array()),
//'image' => array(),
'img' => array('src' => array(),'data-src' => array(),'data-caption' => array(),'alt' => array()),
//'input' => array('*' => array()),
//'ins' => array(),
//'isindex' => array(),
//'kbd' => array(),
//'keygen' => array(),
//'label' => array(),
//'legend' => array(),
'li' => array(),
//'link' => array(),
'listing' => array(),
//'main' => array(),
//'map' => array(),
//'mark' => array(),
//'marquee' => array(),
//'menu' => array(),
//'menuitem' => array(),
//'meta' => array(),
//'meter' => array(),
//'nav' => array(),
//'nobr' => array(),
//'noembed' => array(),
//'noframes' => array(),
//'noscript' => array(),
//'object' => array(),
//'ol' => array(),
//'optgroup' => array(),
//'option' => array(),
//'output' => array(),
'p' => array('lang' => array(),'dir' => array()),
//'param' => array(),
//'picture' => array(),
//'plaintext' => array(),
//'portal' => array(),
'pre' => array(),
//'progress' => array(),
//'q' => array(),
//'rb' => array(),
//'rp' => array(),
//'rt' => array(),
//'rtc' => array(),
//'ruby' => array(),
//'s' => array(),
//'samp' => array(),
'script' => array('charset' => array(),'async' => array(),'defer' => array(),'crossorigin' => array(),'src' => array(),'nonce' => array()),
//'section' => array(),
//'select' => array(),
//'shadow' => array(),
//'slot' => array(),
//'small' => array(),
//'source' => array('type' => array(),'src' => array(),'srcset' => array()),
//'spacer' => array(),
'span' => array(),
//'strike' => array(),
//'strong' => array(),
'style' => array(),
//'sub' => array(),
//'summary' => array(),
//'sup' => array(),
//'table' => array(),
//'tbody' => array(),
//'td' => array('colspan' => array(),'rowspan' => array()),
//'template' => array(),
'textarea' => array()
//'tfoot' => array(),
//'th' => array('colspan' => array(),'rowspan' => array()),
//'thead' => array(),
//'time' => array(),
//'title' => array(),
//'tr' => array(),
//'track' => array(),
//'tt' => array(),
//'u' => array(),
//'ul' => array(),
//'var' => array(),
//'video' => array('width' => array(),'height' => array()),
//'wbr' => array(),
//'xmp' => array()
);
}else{
}

/* ***** ant ********************************************************* */
if($feed_for === 'ant'){
$allowed_html = array(
//'a' => array('href' => array(),'name' => array(),'rel' => array(),'target' => array(),'title' => array()),
//'abbr' => array(),
//'acronym' => array(),
'address' => array(),
//'applet' => array(),
//'area' => array(),
//'article' => array(),
//'aside' => array(),
//'audio' => array(),
//'b' => array(),
//'base' => array(),
//'basefont' => array(),
//'bdi' => array(),
//'bdo' => array(),
//'bgsound' => array(),
//'big' => array(),
'blink' => array(),
//'blockquote' => array('title' => array(),'class' => array(),'data-lang' => array(),'cite' => array(),'data-dnt' => array(),'data-video-id' => array(),'data-instgrm-captioned' => array(),'data-instgrm-permalink' => array(),'data-instgrm-version' => array()),
//'body' => array(),
'br' => array(),
//'button' => array(),
//'canvas' => array(),
//'caption' => array(),
//'center' => array(),
//'cite' => array(),
//'code' => array(),
//'col' => array(),
//'colgroup' => array(),
//'comment' => array(),
//'content' => array(),
//'data' => array(),
//'datalist' => array(),
'dd' => array(),
'del' => array(),
//'details' => array(),
//'dfn' => array(),
//'dialog' => array(),
//'dir' => array(),
//'div' => array('id' => array(),'class' => array(),'data-href' => array(),'data-width' => array(),'data-show-text' => array()),
//'dl' => array(),
'dt' => array(),
//'em' => array(),
//'embed' => array(),
//'fieldset' => array(),
'figcaption' => array(),
//'figure' => array(),
//'font' => array(),
//'footer' => array(),
//'form' => array(),
//'frame' => array(),
//'frameset' => array(),
'h1' => array(),
'h2' => array(),
'h3' => array(),
'h4' => array(),
'h5' => array(),
'h6' => array(),
//'head' => array(),
//'header' => array(),
//'hgroup' => array(),
//'hr' => array(),
//'html' => array(),
//'i' => array(),
//'iframe' => array('width' => array(),'height' => array(),'frameborder' => array(),'allow' => array(),'allowfullscreen' => array(),'webkitallowfullscreen' => array(),'mozallowfullscreen' => array(),'loading' => array(),'referrerpolicy' => array(),'title' => array(),'src' => array()),
//'image' => array(),
//'img' => array('src' => array(),'data-src' => array(),'data-caption' => array(),'alt' => array()),
//'input' => array('*' => array()),
//'ins' => array(),
//'isindex' => array(),
//'kbd' => array(),
//'keygen' => array(),
//'label' => array(),
//'legend' => array(),
'li' => array(),
//'link' => array(),
'listing' => array(),
//'main' => array(),
//'map' => array(),
//'mark' => array(),
//'marquee' => array(),
//'menu' => array(),
//'menuitem' => array(),
//'meta' => array(),
//'meter' => array(),
//'nav' => array(),
//'nobr' => array(),
//'noembed' => array(),
//'noframes' => array(),
//'noscript' => array(),
//'object' => array(),
//'ol' => array(),
//'optgroup' => array(),
//'option' => array(),
//'output' => array(),
'p' => array('lang' => array(),'dir' => array()),
//'param' => array(),
//'picture' => array(),
//'plaintext' => array(),
//'portal' => array(),
'pre' => array(),
//'progress' => array(),
//'q' => array(),
//'rb' => array(),
//'rp' => array(),
//'rt' => array(),
//'rtc' => array(),
//'ruby' => array(),
//'s' => array(),
//'samp' => array(),
'script' => array('charset' => array(),'async' => array(),'defer' => array(),'crossorigin' => array(),'src' => array(),'nonce' => array()),
//'section' => array(),
//'select' => array(),
//'shadow' => array(),
//'slot' => array(),
//'small' => array(),
//'source' => array('type' => array(),'src' => array(),'srcset' => array()),
//'spacer' => array(),
//'span' => array(),
//'strike' => array(),
//'strong' => array(),
'style' => array(),
//'sub' => array(),
//'summary' => array(),
//'sup' => array(),
//'table' => array(),
//'tbody' => array(),
//'td' => array('colspan' => array(),'rowspan' => array()),
//'template' => array(),
'textarea' => array()
//'tfoot' => array(),
//'th' => array('colspan' => array(),'rowspan' => array()),
//'thead' => array(),
//'time' => array(),
//'title' => array(),
//'tr' => array(),
//'track' => array(),
//'tt' => array(),
//'u' => array(),
//'ul' => array(),
//'var' => array(),
//'video' => array('width' => array(),'height' => array()),
//'wbr' => array(),
//'xmp' => array()
);
}else{
}

/* ***** trl ********************************************************* */
if($feed_for === 'trl'){
$allowed_html = array(
'a' => array('href' => array(),'name' => array(),'rel' => array(),'target' => array(),'title' => array()),
//'abbr' => array(),
//'acronym' => array(),
'address' => array(),
//'applet' => array(),
//'area' => array(),
//'article' => array(),
//'aside' => array(),
//'audio' => array(),
'b' => array(),
//'base' => array(),
//'basefont' => array(),
//'bdi' => array(),
//'bdo' => array(),
//'bgsound' => array(),
//'big' => array(),
'blink' => array(),
'blockquote' => array('title' => array(),'class' => array(),'data-lang' => array(),'cite' => array(),'data-dnt' => array(),'data-video-id' => array(),'data-instgrm-captioned' => array(),'data-instgrm-permalink' => array(),'data-instgrm-version' => array()),
//'body' => array(),
//'br' => array(),
//'button' => array(),
//'canvas' => array(),
'caption' => array(),
//'center' => array(),
'cite' => array(),
//'code' => array(),
//'col' => array(),
//'colgroup' => array(),
//'comment' => array(),
//'content' => array(),
//'data' => array(),
//'datalist' => array(),
'dd' => array(),
'del' => array(),
//'details' => array(),
//'dfn' => array(),
//'dialog' => array(),
//'dir' => array(),
'div' => array('id' => array(),'class' => array(),'data-href' => array(),'data-width' => array(),'data-show-text' => array()),
//'dl' => array(),
'dt' => array(),
'em' => array(),
//'embed' => array(),
//'fieldset' => array(),
'figcaption' => array(),
'figure' => array(),
//'font' => array(),
//'footer' => array(),
//'form' => array(),
//'frame' => array(),
//'frameset' => array(),
'h1' => array(),
'h2' => array(),
'h3' => array(),
'h4' => array(),
'h5' => array(),
'h6' => array(),
//'head' => array(),
//'header' => array(),
//'hgroup' => array(),
'hr' => array(),
//'html' => array(),
'i' => array(),
'iframe' => array('width' => array(),'height' => array(),'frameborder' => array(),'allow' => array(),'allowfullscreen' => array(),'webkitallowfullscreen' => array(),'mozallowfullscreen' => array(),'loading' => array(),'referrerpolicy' => array(),'title' => array(),'src' => array()),
//'image' => array(),
'img' => array('src' => array(),'data-src' => array(),'data-caption' => array(),'width' => array(),'height' => array(),'alt' => array()),
//'input' => array('*' => array()),
//'ins' => array(),
//'isindex' => array(),
//'kbd' => array(),
//'keygen' => array(),
//'label' => array(),
//'legend' => array(),
'li' => array(),
//'link' => array(),
'listing' => array(),
//'main' => array(),
//'map' => array(),
//'mark' => array(),
//'marquee' => array(),
//'menu' => array(),
//'menuitem' => array(),
//'meta' => array(),
//'meter' => array(),
//'nav' => array(),
//'nobr' => array(),
//'noembed' => array(),
//'noframes' => array(),
//'noscript' => array(),
//'object' => array(),
'ol' => array(),
//'optgroup' => array(),
//'option' => array(),
//'output' => array(),
'p' => array('lang' => array(),'dir' => array()),
//'param' => array(),
//'picture' => array(),
//'plaintext' => array(),
//'portal' => array(),
'pre' => array(),
//'progress' => array(),
//'q' => array(),
//'rb' => array(),
//'rp' => array(),
//'rt' => array(),
//'rtc' => array(),
//'ruby' => array(),
//'s' => array(),
//'samp' => array(),
'script' => array('charset' => array(),'async' => array(),'defer' => array(),'crossorigin' => array(),'src' => array(),'nonce' => array()),
//'section' => array(),
//'select' => array(),
//'shadow' => array(),
//'slot' => array(),
//'small' => array(),
'source' => array('type' => array(),'src' => array(),'srcset' => array()),
//'spacer' => array(),
//'span' => array(),
//'strike' => array(),
'strong' => array(),
'style' => array(),
//'sub' => array(),
//'summary' => array(),
//'sup' => array(),
'table' => array(),
//'tbody' => array(),
'td' => array('colspan' => array(),'rowspan' => array()),
//'template' => array(),
'textarea' => array(),
//'tfoot' => array(),
'th' => array('colspan' => array(),'rowspan' => array()),
//'thead' => array(),
//'time' => array(),
//'title' => array(),
'tr' => array(),
//'track' => array(),
//'tt' => array(),
//'u' => array(),
'ul' => array(),
//'var' => array(),
'video' => array('width' => array(),'height' => array(),'src' => array()),
//'wbr' => array(),
//'xmp' => array()
);
}else{
}

/* ***** yjt ********************************************************* */
if($feed_for === 'yjt'){
$allowed_html = array(
//'a' => array('href' => array(),'name' => array(),'rel' => array(),'target' => array(),'title' => array()),
//'abbr' => array(),
//'acronym' => array(),
'address' => array(),
//'applet' => array(),
//'area' => array(),
//'article' => array(),
//'aside' => array(),
//'audio' => array(),
//'b' => array(),
//'base' => array(),
//'basefont' => array(),
//'bdi' => array(),
//'bdo' => array(),
//'bgsound' => array(),
//'big' => array(),
'blink' => array(),
'blockquote' => array('class' => array(),'data-lang' => array()),
//'body' => array(),
//'br' => array(),
//'button' => array(),
//'canvas' => array(),
'caption' => array(),
//'center' => array(),
'cite' => array(),
//'code' => array(),
//'col' => array(),
//'colgroup' => array(),
//'comment' => array(),
//'content' => array(),
//'data' => array(),
//'datalist' => array(),
'dd' => array(),
'del' => array(),
//'details' => array(),
//'dfn' => array(),
//'dialog' => array(),
//'dir' => array(),
//'div' => array('id' => array(),'class' => array(),'data-href' => array(),'data-width' => array(),'data-show-text' => array()),
//'dl' => array(),
'dt' => array(),
'em' => array(),
//'embed' => array(),
//'fieldset' => array(),
'figcaption' => array(),
'figure' => array(),
//'font' => array(),
//'footer' => array(),
//'form' => array(),
//'frame' => array(),
//'frameset' => array(),
'h1' => array(),
'h2' => array(),
'h3' => array(),
'h4' => array(),
'h5' => array(),
'h6' => array(),
//'head' => array(),
//'header' => array(),
//'hgroup' => array(),
'hr' => array(),
//'html' => array(),
//'i' => array(),
'iframe' => array('width' => array(),'height' => array(),'frameborder' => array(),'allow' => array(),'allowfullscreen' => array(),'webkitallowfullscreen' => array(),'mozallowfullscreen' => array(),'loading' => array(),'referrerpolicy' => array(),'title' => array(),'src' => array()),
//'image' => array(),
'img' => array('src' => array(),'data-src' => array(),'data-caption' => array(),'width' => array(),'height' => array(),'alt' => array()),
//'input' => array('*' => array()),
//'ins' => array(),
//'isindex' => array(),
//'kbd' => array(),
//'keygen' => array(),
//'label' => array(),
//'legend' => array(),
'li' => array(),
//'link' => array(),
'listing' => array(),
//'main' => array(),
//'map' => array(),
//'mark' => array(),
//'marquee' => array(),
//'menu' => array(),
//'menuitem' => array(),
//'meta' => array(),
//'meter' => array(),
//'nav' => array(),
//'nobr' => array(),
//'noembed' => array(),
//'noframes' => array(),
//'noscript' => array(),
//'object' => array(),
'ol' => array(),
//'optgroup' => array(),
//'option' => array(),
//'output' => array(),
'p' => array('lang' => array(),'dir' => array()),
//'param' => array(),
//'picture' => array(),
//'plaintext' => array(),
//'portal' => array(),
'pre' => array(),
//'progress' => array(),
//'q' => array(),
//'rb' => array(),
//'rp' => array(),
//'rt' => array(),
//'rtc' => array(),
//'ruby' => array(),
//'s' => array(),
//'samp' => array(),
'script' => array('charset' => array(),'async' => array(),'defer' => array(),'crossorigin' => array(),'src' => array(),'nonce' => array()),
//'section' => array(),
//'select' => array(),
//'shadow' => array(),
//'slot' => array(),
//'small' => array(),
//'source' => array('type' => array(),'src' => array(),'srcset' => array()),
//'spacer' => array(),
//'span' => array(),
//'strike' => array(),
'strong' => array(),
'style' => array(),
//'sub' => array(),
//'summary' => array(),
//'sup' => array(),
'table' => array(),
//'tbody' => array(),
'td' => array(),
//'template' => array(),
'textarea' => array(),
//'tfoot' => array(),
'th' => array(),
//'thead' => array(),
//'time' => array(),
//'title' => array(),
'tr' => array(),
//'track' => array(),
//'tt' => array(),
//'u' => array(),
'ul' => array(),
//'var' => array(),
//'video' => array('width' => array(),'height' => array(),'src' => array()),
//'wbr' => array(),
//'xmp' => array()
);
}else{
}

// 禁止された要素
$deny_html = '(<\s*iframe(\s+|>)[\s\S]*?<\s*\/iframe\s*>|<\s*script(\s+|>)[\s\S]*?<\s*\/script\s*>|<\s*style(\s+|>)[\s\S]*?<\s*\/style\s*>)';

// 禁止された属性
if($feed_for === 'yjt'){
	$deny_attr = "(class|style|id|srcset|sizes|background|bgcolor|border)";
}elseif($feed_for === 'goo'){
	$deny_attr = '(class|style|id|background|bgcolor|border)';
}elseif($feed_for === 'snf'||$feed_for === 'gnf'){
	$deny_attr = "(class|style|id|width|height|sizes|background|bgcolor|border)";
}elseif($feed_for === 'dcm'||$feed_for === 'spb'||$feed_for === 'lnr'||$feed_for === 'ant'||$feed_for === 'isn'||$feed_for === 'ldn'){
	$deny_attr = "(class|style|id|width|height|srcset|sizes|background|bgcolor|border)";
}elseif($feed_for === 'trl'){
	$deny_attr = "(class|style|id|srcset|sizes|background|bgcolor|border)";

}else{
}
// YouTube タグがセットされている場合のカスタムフィード呼び出しとタグの整形
if($feed_for === 'yjt'||$feed_for === 'goo'||$feed_for === 'lnr'||$feed_for === 'dcm'||$feed_for === 'spb'||$feed_for === 'snf'||$feed_for === 'gnf'||$feed_for === 'ldn'||$feed_for === 'trl'){
	if(!empty($cf_youtube)){
	$cf1 = get_post_meta(get_the_ID(),$cf_youtube,true);
		if($cf1){
			$cf1 = preg_replace('/^[\s\S]*?www\.youtube\.com\/embed\/(.*?)\/".*?><\/iframe>($|[\s\S]*?>)/im' , '<iframe src="https://www.youtube.com/embed/'.'$1'.'?autoplay=0&controls=1&disablekb=0&enablejsapi=0&fs=0&iv_load_policy=3&loop=0&rel=0"></iframe>'."\n" , $cf1);
			$cf1 = preg_replace('/^[\s\S]*?www\.youtube\.com\/embed\/(.*?)".*?><\/iframe>($|[\s\S]*?>)/im' , '<iframe src="https://www.youtube.com/embed/'.'$1'.'?autoplay=0&controls=1&disablekb=0&enablejsapi=0&fs=0&iv_load_policy=3&loop=0&rel=0"></iframe>'."\n" , $cf1);
			$cf1 = preg_replace('/^(https?:\/\/|)www\.youtube\.com\/embed\/(.*?)($|\/$)/im' , '<iframe src="https://www.youtube.com/embed/'.'$2'.'?autoplay=0&controls=1&disablekb=0&enablejsapi=0&fs=0&iv_load_policy=3&loop=0&rel=0"></iframe>'."\n" , $cf1);
			$cf1 = preg_replace('/^(?!<iframe ).*$/im' , '', $cf1);
			$cf1 = preg_replace('/^(?!.*<\/iframe>$).*$/im' , '', $cf1);
			echo $cf1;
		}else{
		}
	}else{
	}
}else{
}

if ($feed_for !== 'ynf'){
	// alternate_content_for_the_cuerda_feed.php とは get_the_content() 以外で生成する投稿の代替プログラムファイルです。
	$content_manage_filename = get_template_directory( __FILE__ ).'/alternate_content_for_the_cuerda_feed.php';
	// 本文を生成する代替プログラムがある場合の定義
	if (file_exists($content_manage_filename)){
		ob_start();
		require($content_manage_filename);
		$content = ob_get_clean();
		$content = wp_kses(do_shortcode($content), $allowed_html);
	}else{
		// 投稿の全内容を取得
		global $post;
		$content_manage = $post->post_content;
		$content = wp_kses(do_shortcode($content_manage), $allowed_html);
	}
	/* *************** ここより本文の整形開始 ******************* */
	// 制御コードを削除
	$content = str_replace(array("[\x00-\x09\x0B\x0C\x0E-\x1F\x7F]"), '', $content);
	// 不正なシングルクォートをダブルクォートに置換
	$content = preg_replace('/\s*([^=]+)=\'(.*?)\'/ims', ' $1="$2"', $content);
	// TAB 削除
	$content = str_replace(array("\t"), "",$content);
	// 改行コードを LF に統一
	$content = str_replace(array("\r\n", "\r"), "\n",$content);
	// タグ前後の不正な半角スペースを削除
	$content = preg_replace("/>( |　)+<\//ims","></", $content);
}

// TRILL 特有の処理開始
if($feed_for === 'trl'){
	// a タグをアンカーテキストを含め除去する
	if($atag == 1){
	$content = preg_replace('/<\s*a [\s\S]*?\/a\s*>/im', '', $content);
	}
// NG（figcaption 要素がない）
$channel_title = get_option('cuerda_trl_title','');
if(!empty($channel_title)){
	$figcaption = esc_html($channel_title);
}else{
	$figcaption = esc_html(get_bloginfo('name'));
}
$content = preg_replace('/<\s*figure\s*>[\s\S]*?<img ([\s\S]*?)src="(.+?)"([\s\S]*?)>[\s\S]*?<\/figure>/imsu', '<figure><img $1src="$2"$3><figcaption>'.$figcaption.'</figcaption></figure>', $content);
$content = preg_replace('/<\s*figure\s*><img ([\s\S]*?)src="(.+?)"([\s\S]*?)>[\s\S]*?<\/figure>/imsu', '<figure><img $1src="$2"$3><figcaption>'.$figcaption.'</figcaption></figure>', $content);
$content = preg_replace('/<\s*figure\s*><video([\s\S]*?)src="(.+?)"([\s\S]*?)><\/video>[\s\S]*?<\/figure>/imsu', '<figure><video$1 $3><source src="$2" type="video/mp4"></video><figcaption>'.$figcaption.'</figcaption></figure>', $content);
// figure img の名前退避
$content = preg_replace('/<\s*figure\s*>[\s\S]*?<(video|img) ([\s\S]*?)>([\s\S]*?)<\/figure>/imsu', '<figure_tmp><$1_tmp $2>$3</figure_tmp>', $content);
// figure ではない img の削除
$content = preg_replace('/<\s*img .*?>/imsu', '', $content);
// パターンに当てはまらなかったfigure要素を p 等に置換
$content = preg_replace('/<(|\/)figure>/imsu', '', $content);
// 退避してない figure を削除
$content = preg_replace('/<(|\/)figure>/imsu', '', $content);
// tmp名を figure に戻して完了
$content = preg_replace('/_tmp/imsu', '', $content);

// ul タグで囲われていない li を是正するための正規表現パターンを設定
$pattern = '/(<li>[^<]*<\/li>)(<li>[^<]*<\/li>)+/is';
// 置換する内容を設定
$replacement = '<ul>$0</ul>';
// preg_replaceで置換
$content = preg_replace('/(|\n)<\s*(|\/)li\s*>\n/ims', '<$2li>', $content);
// 正規表現を使って置換するコールバック関数を直接渡す
$content = preg_replace_callback($pattern, function ($matches) {
	return '<ul>' . $matches[0] . '</ul>';
}, $content);

// table 要素の除去
$table_option = get_option('cuerda_trl_table',0);
	if($table_option == 1){
	$content = preg_replace('/<\s*table[\s\S]*?\/table\s*>/im', '', $content);
}
// table 要素を利用可能要素に置き換え
	$content = preg_replace('/<caption>/imsu', '<h3>', $content);
	$content = preg_replace('/<\/caption>/imsu', '</h3>', $content);
	if($table_inline == 1){
	$content = preg_replace('/<tr>/imsu', '<p>', $content);
	$content = preg_replace('/<\/tr>/imsu', '</p>'."\n", $content);
	$content = preg_replace('/<th>/imsu', '<strong>', $content);
	$content = preg_replace('/<\/th>/imsu', '</strong>', $content);
	$content = preg_replace('/<\/td>\s*<td>/imsu', $table_inline_delimiter, $content);
	$content = preg_replace('/<\/strong>\s*<td>/imsu', '</strong>'.$table_inline_delimiter, $content);
	$content = preg_replace('/<(\/|)td>/imsu', '', $content);
	$content = preg_replace('/<(\/|)table>/imsu', '', $content);
	}else{
	$content = preg_replace('/<(\/|)tr>/imsu', '', $content);
	$content = preg_replace('/<th>/imsu', '<p><strong>', $content);
	$content = preg_replace('/<\/th>/imsu', '</strong></p>', $content);
	$content = preg_replace('/<td>/imsu', '<p>', $content);
	$content = preg_replace('/<\/td>/imsu', '</p>', $content);
	$content = preg_replace('/<(\/|)table>/imsu', '', $content);
	}
}else{
}// TRILL 特有の処理終了

// YJT 特有の処理開始
if($feed_for === 'yjt'){
// table 要素を利用可能要素に置き換え
$content = preg_replace('/<caption>/imsu', '<h3>', $content);
$content = preg_replace('/<\/caption>/imsu', '</h3>', $content);
	if($table_inline == 1){
	$content = preg_replace('/<tr>/imsu', '<p>', $content);
	$content = preg_replace('/<\/tr>/imsu', '</p>'."\n", $content);
	$content = preg_replace('/<th>/imsu', '<strong>', $content);
	$content = preg_replace('/<\/th>/imsu', '</strong>', $content);
	$content = preg_replace('/<\/td>\s*<td>/imsu', $table_inline_delimiter, $content);
	$content = preg_replace('/<\/strong>\s*<td>/imsu', '</strong>'.$table_inline_delimiter, $content);
	$content = preg_replace('/<(\/|)td>/imsu', '', $content);
	$content = preg_replace('/<(\/|)table>/imsu', '', $content);
	}else{
	$content = preg_replace('/<(\/|)tr>/imsu', '', $content);
	$content = preg_replace('/<th>/imsu', '<p><strong>', $content);
	$content = preg_replace('/<\/th>/imsu', '</strong></p>', $content);
	$content = preg_replace('/<td>/imsu', '<p>', $content);
	$content = preg_replace('/<\/td>/imsu', '</p>', $content);
	$content = preg_replace('/<(\/|)table>/imsu', '', $content);
	}
}else{
}// YJT 特有の処理終了

// LDN 特有の処理
if($feed_for === 'ldn'){
	$content = preg_replace('/<\s*a[\s\S]*?\/a\s*>/im', '', $content);
	$content = preg_replace('/<\s*table[\s\S]*?\/table\s*>/im', '', $content);
}else{
}// LDN 特有の処理終了

// YouTube の iframe を退避

if($feed_for !== 'ynf'||$feed_for !== 'spb'){
	$content = preg_replace('/<iframe\s*(.*?)src="\s*(https?:|)\/\/www\.youtube\.com\/embed\/(.*?)\s*<\/iframe>/im','<iframe_tmp $1src="https://www.youtube.com/embed/$3</iframe_tmp>'."\n", $content);
	// Twitter の 退避
	$content = preg_replace('/<blockquote\s*class="twitter-tweet"\s*>([\s\S]*?)<\/blockquote>/im','<blockquote_twtmp class_twtmp="twitter-tweet">$1</blockquote_twtmp>', $content);
	// Instagram の 退避
	if($feed_for !== 'yjt'){
	$content = preg_replace('/<blockquote\s*(.*?)class="instagram-media"\s*(.*?)>([\s\S]*?)<\/blockquote>/im','<blockquote_istmp $1class_istmp="instagram-media" $2>$3</blockquote_istmp>', $content);
	}else{
	}
}else{
}

if($feed_for === 'spb'){
// YouTube の iframe を退避
$content = preg_replace('/<iframe\s*(.*?)src="\s*(https?:|)\/\/www\.youtube\.com\/embed\/(.*?)\s*<\/iframe>/im','<iframe_tmp $1src="https://www.youtube.com/embed/$3</iframe_tmp>'."\n", $content);
// Facebook の iframe 版を退避
$content = preg_replace('/<iframe\s*(.*?)src="\s*(https?:|)\/\/www\.facebook\.com\/(.*?)\s*<\/iframe>/im','<iframe_tmp $1src="https://www.facebook.com/$3</iframe_tmp>'."\n", $content);
// GoogleMap の iframe を退避
$content = preg_replace('/<iframe\s*(.*?)src="\s*(https?:|)\/\/www\.google\.com\/maps\/(.*?)\s*<\/iframe>/im','<iframe_tmp $1src="https://www.google.com/maps/$3</iframe_tmp>'."\n", $content);
// Vimeo の iframe を退避
$content = preg_replace('/<iframe\s*(.*?)src="\s*(https?:|)\/\/player\.vimeo\.com\/video\/(.*?)\s*<\/iframe>/im','<iframe_tmp $1src="https://player.vimeo.com/video/$3</iframe_tmp>'."\n", $content);
// Vine の iframe を退避
$content = preg_replace('/<iframe\s*(.*?)src="\s*(https?:|)\/\/vine\.co\/v\/(.*?)\s*<\/iframe>/im','<iframe_tmp $1src="https://vine.co/v/$3</iframe_tmp>'."\n", $content);
// brightcove の iframe を退避
$content = preg_replace('/<iframe\s*(.*?)src="\s*(https?:|)\/\/players\.brightcove\.net\/(.*?)\s*<\/iframe>/im','<iframe_tmp $1src="https://players.brightcove.net/$3</iframe_tmp>'."\n", $content);
}else{
}

if($feed_for === 'goo'||$feed_for === 'dcm'||$feed_for === 'trl'){
// Facebook の iframe 版を退避
$content = preg_replace('/<iframe\s*(.*?)src="\s*(https?:|)\/\/www\.facebook\.com\/(.*?)\s*<\/iframe>/im','<iframe_tmp $1src="https://www.facebook.com/$3</iframe_tmp>'."\n", $content);
// Facebook の JavaScript SDK 版 blockquote を退避
$content = preg_replace('/<div class="fb-post"(.*?)>\s*<blockquote\s*(.*?)class="fb-xfbml-parse-ignore"\s*>([\s\S]*?)<\/blockquote>\s*<\/div>/im','<div_fbtmp class_fbtmp="fb-post"$1><blockquote_fbtmp $2class_fbtmp="fb-xfbml-parse-ignore">$3</blockquote_fbtmp></div_fbtmp>', $content);
$content = preg_replace('/<div class="fb-video"(.*?)>\s*<blockquote\s*(.*?)class="fb-xfbml-parse-ignore"\s*>([\s\S]*?)<\/blockquote>\s*<\/div>/im','<div_fbtmp class_fbtmp="fb-video"$1><blockquote_fbtmp $2class_fbtmp="fb-xfbml-parse-ignore">$3</blockquote_fbtmp></div_fbtmp>', $content);
// Facebook の JavaScript 版 div を退避
$content = preg_replace('/<div id="fb-root"(.*?)>\s*<\/div>/im','<div_fbtmp id_fbtmp="fb-root"$1></div_fbtmp>', $content);
// Facebook の JavaScript 版 blockquote を退避
$content = preg_replace('/<div class="fb-post"(.*?)>\s*<\/div>/im','<div_fbtmp class_fbtmp="fb-post"$1></div_fbtmp>', $content);
$content = preg_replace('/<div class="fb-video"(.*?)>\s*<\/div>/im','<div_fbtmp class_fbtmp="fb-video"$1></div_fbtmp>', $content);

// Facebook の JavaScript 版 script を退避
$content = preg_replace('/<script\s*(.*?)src="\s*(https?:|)\/\/connect\.facebook\.net\/(.*?)>\s*<\/script>/im','<script_fbtmp $1src="https://connect.facebook.net/$3></script_fbtmp>', $content);
}else{
}

if($feed_for === 'goo'){
// GoogleMap の iframe を退避
$content = preg_replace('/<iframe\s*(.*?)src="\s*(https?:|)\/\/www\.google\.com\/maps\/(.*?)\s*<\/iframe>/im','<iframe_tmp $1src="https://www.google.com/maps/$3</iframe_tmp>'."\n", $content);
// TikTok の 退避
$content = preg_replace('/<blockquote\s*(.*?)class="tiktok-embed"\s*(.*?)>([\s\S]*?)<\/blockquote>/im','<blockquote_tttmp $1class_tttmp="tiktok-embed" $2>$3</blockquote_tttmp>', $content);
}else{
}

if($feed_for === 'snf'||$feed_for === 'gnf'){
// Vimeo の iframe を退避
$content = preg_replace('/<iframe\s*(.*?)src="\s*(https?:|)\/\/player\.vimeo\.com\/video\/(.*?)\s*<\/iframe>/im','<iframe_tmp $1src="https://player.vimeo.com/video/$3</iframe_tmp>'."\n", $content);
// Vine の iframe を退避
$content = preg_replace('/<iframe\s*(.*?)src="\s*(https?:|)\/\/vine\.co\/v\/(.*?)\s*<\/iframe>/im','<iframe_tmp $1src="https://vine.co/v/$3</iframe_tmp>'."\n", $content);
// brightcove の iframe を退避
$content = preg_replace('/<iframe\s*(.*?)src="\s*(https?:|)\/\/players\.brightcove\.net\/(.*?)\s*<\/iframe>/im','<iframe_tmp $1src="https://players.brightcove.net/$3</iframe_tmp>'."\n", $content);
}else{
}

// 連想配列に格納された特定の正規表現を削除
if(!empty($regular_expression_delete)){
$pattern = '/' . implode('|', $regular_expression_delete) . '/im';
$content = preg_replace($pattern, '', $content);
}else{
}
// Documenttype に相違する改行タグ文法変更
$content = preg_replace('/<(|\/|\/ )br(|\/| \/)>/im', '<br>', $content);
// 2つ以上連続するスペースを1個分のスペースに置き換える
$content = preg_replace("/ {2,}/"," ", $content);
$content = preg_replace("/^\n{2,3,4,5,6}/ims","\n", $content);
// リンク先が空の a 要素を削除
$content = preg_replace('/<a\s*(|(.*?))(href|name)="\s*"(|(.*?))\s*>(\s*|(.*?))<\/a>/im', '$6', $content);
// ページ内 a リンクや tel リンクをプレーンテキストに変換する
$content = preg_replace('/<a\s*(.*?)(href|name)="(#|tel:)(.*?)>(\s*|(.*?))<\/a>/im', '$5', $content);
// 明示的に禁止されたタグの削除
$content = preg_replace("/$deny_html/im", "", $content);
// 明示的に禁止された属性の削除
$content = preg_replace("/\s+$deny_attr=\".*?\"/im", "", $content);
// 不要な要素の削除
$content = preg_replace("/<(|\/)div>/im", "", $content);

if($feed_for === 'yjt'||$feed_for === 'lnr'||$feed_for === 'dcm'||$feed_for === 'goo'||$feed_for === 'trl'){
// Twitter に script を返却
$content = preg_replace('/<\/blockquote_twtmp>/im', '</blockquote_twtmp>'."\n".'<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>', $content);
// Instagram に script を返却
$content = preg_replace('/<\/blockquote_istmp>/im', '</blockquote_istmp>'."\n".'<script async src="//www.instagram.com/embed.js"></script>', $content);
}else{
}

if($feed_for === 'goo'){
// TikTok に script を返却
$content = preg_replace('/<\/blockquote_tttmp>/im', '</blockquote_tttmp>'."\n".'<script async src="https://www.tiktok.com/embed.js"></script>', $content);
}else{
}

if($feed_for !== 'ynf'){
// 退避のプレフィックスを削除
$content = preg_replace('/<(iframe|\/iframe)_tmp(>| )/imsu', '<$1$2', $content);
$content = preg_replace('/<(blockquote|\/blockquote)_twtmp(>| )/imsu', '<$1$2', $content);
$content = preg_replace('/<(blockquote|\/blockquote)_istmp(>| )/imsu', '<$1$2', $content);
$content = preg_replace('/( class)_twtmp="/imsu', '$1="', $content);
$content = preg_replace('/( class)_istmp="/imsu', '$1="', $content);
$content = preg_replace('/<(a|\/a)_tmp(>| )/imsu', '<$1$2', $content);
}else{
}

if($feed_for === 'ynf'){
// 退避のプレフィックスを削除
$content = preg_replace('/<(iframe|\/iframe)_tmp(>| )/imsu', '<$1$2', $content);
}else{
}

if($feed_for !== 'lnr'){
$content = preg_replace('/<(div|\/div)_fbtmp(>| )/imsu', '<$1$2', $content);
$content = preg_replace('/<(blockquote|\/blockquote)_fbtmp(>| )/imsu', '<$1$2', $content);
$content = preg_replace('/( class| id)_fbtmp="/imsu', '$1="', $content);
}else{
}

if($feed_for === 'yjt'||$feed_for === 'goo'||$feed_for === 'dcm'||$feed_for === 'trl'){
$content = preg_replace('/<script_fbtmp /imsu', '<script ', $content);
$content = preg_replace('/<\/script_fbtmp>/imsu', '</script>', $content);
}else{
}

if($feed_for === 'yjt'||$feed_for === 'goo'){
$content = preg_replace('/<(blockquote|\/blockquote)_tttmp(>| )/imsu', '<$1$2', $content);
$content = preg_replace('/( class)_tttmp="/imsu', '$1="', $content);
}else{
}

if($feed_for === 'dcm'){
// table タグの除去をしない場合はスタイル設定
$content = preg_replace('/<\s*table\s*.*?>/ims', '<table style="border-collapse:collapse;width:100%;border-right:1px solid #ccc;border-bottom:1px solid #ccc">', $content);
$content = preg_replace('/<\s*td\s*.*?>/ims', '<td style="border-left:1px solid #ccc;border-top:1px solid #ccc;padding:0.5em 0.5em">', $content);
$content = preg_replace('/<\s*th\s*.*?>/ims', '<th style="border-left:1px solid #ccc;border-top:1px solid #ccc;padding:0.5em 0.5em;background:#eee;text-align:center">', $content);
}else{
}

// 連想配列に格納された特定の文字列を削除
if(!empty($sentence_delete)){
$object = $sentence_delete;
$escaped_object = array_map('preg_quote', $object); // 各要素をエスケープ
$pattern = '/' . implode('|', $escaped_object) . '/im';
$content = preg_replace($pattern, '', $content);
}else{
}

if ($feed_for !== 'ynf'){
	// 画像が相対パスの場合、サイトFQDNを補って絶対パスにする
	$content = preg_replace('/\s+src="\/([\w]+[\s\S]*?)"/im', ' src="'.esc_url(home_url()).'/$1"', $content);
	// 画像パスが不正な場合コメントアウトする
	$content = preg_replace('/<img\s+([^>]*\s+)?src="((?!http[s]?:|\/).+?)"([^>]*)>/im', '', $content);
	// リンクが相対パスの場合、サイトFQDNを補って絶対パスにする
	$content = preg_replace('/\s+href="\/([\w]+[\s\S]*?)"/im', ' href="'.esc_url(home_url()).'/$1"', $content);
	//リンクパスが不正な場合aタグを削除する
	$content = preg_replace('/<a\s+[^>]*?\bhref="((?!http[s]?:|\/).+?)"[^>]*>(.*?)<\/a>/im', '$2', $content);
	//リンクパスが非httpsの場合強制的にhttpsに変換する
	$content = preg_replace('/(<a\s+[^>]*?\bhref=")http:\/\//im', '$1https://', $content);
	// 空の alt に記事のタイトルを補う
	$content = preg_replace('/\s+alt=""/im', ' alt="' . esc_attr(get_the_title()) . '"', $content);
	// 内容が空の p,h,span要素を削除
	$content = preg_replace('/<(p|h[1-6]|span|i|ins|figure)>(&nbsp;| |)<\/(p|h[1-6]|span|i|ins|figure)>/imsu', '', $content);
	// 3個以上連続した br 要素を2個にまとめる
	$content = preg_replace('/(<br\s*\/?>){3,}/ims', '<br><br>', $content);
	// 終了タグ直後の br 要素を削除
	$content = preg_replace('/<\/(\w+)>\s*<br\s*\/?>/ims', '</$1>', $content);
	// アンカーテキストの無い a 要素を削除
	$content = preg_replace('/<a\s+([^>])*><\s*\/a\s*>/imsu', '', $content);
	// 意図せずエスケープされたコメントタグをデコードしコメント内容が表示されないようにする
	$content = preg_replace('/&lt;!--[\s\S]*?--&gt;/imsu', '<!-- Comment Out -->', $content);
	$content = preg_replace('/-->\s*<br\s*\/?>/ims', '-->', $content);
	// data-src を使用した img 要素を修正
	$content = preg_replace('/<img[^>]*data-src="([^"]*)"\s*[^>]*>/imsu', '<img src="$1">', $content);
}

/* ***** yjt ********************************************************* */
if($feed_for === 'yjt'){
$content = preg_replace('/<!--\s*[\s\S]*?--\s*>/imsu', '', $content);
$content = preg_replace('/<\s*address\s*>([\s\S]*?)<\s*\/address\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*blink\s*>([\s\S]*?)<\s*\/blink\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*dd\s*>([\s\S]*?)<\s*\/dd\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*del\s*>([\s\S]*?)<\s*\/del\s*>/imsu', '（ここから文削除→ $1 ←ここまで文削除）', $content);
$content = preg_replace('/<\s*dt\s*>([\s\S]*?)<\s*\/dt\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*b\s*>([\s\S]*?)<\s*\/b\s*>/imsu', '<strong>$1</strong>', $content);
$content = preg_replace('/<\s*em\s*>([\s\S]*?)<\s*\/em\s*>/imsu', '<strong>$1</strong>', $content);
$content = preg_replace('/<\s*figure\s*>([\s\S]*?)<\s*\/figure\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*figcaption\s*>([\s\S]*?)<\s*\/figcaption\s*>/imsu', '<cite>$1</cite>', $content);
$content = preg_replace('/<\s*h1\s*>([\s\S]*?)<\s*\/h1\s*>/imsu', '<h2>$1</h2>', $content);
$content = preg_replace('/<\s*h4\s*>([\s\S]*?)<\s*\/h4\s*>/imsu', '<h3>$1</h3>', $content);
$content = preg_replace('/<\s*h5\s*>([\s\S]*?)<\s*\/h5\s*>/imsu', '<h3>$1</h3>', $content);
$content = preg_replace('/<\s*h6\s*>([\s\S]*?)<\s*\/h6\s*>/imsu', '<h3>$1</h3>', $content);
$content = preg_replace('/<\s*li\s*>([\s\S]*?)<\s*\/li\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*listing\s*>([\s\S]*?)<\s*\/listing\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*ol\s*>([\s\S]*?)<\s*\/ol\s*>/imsu', '$1', $content);
$content = preg_replace('/<\s*ul\s*>([\s\S]*?)<\s*\/ul\s*>/imsu', '$1', $content);
$content = preg_replace('/<\s*pre\s*>([\s\S]*?)<\s*\/pre\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*textarea\s*>([\s\S]*?)<\s*\/textarea\s*>/imsu', '<p>$1</p>', $content);
}else{
}

/* ***** goo ********************************************************* */
if($feed_for === 'goo'){
$content = preg_replace('/<!--\s*[\s\S]*?--\s*>/imsu', '', $content);
$content = preg_replace('/<\s*address\s*>([\s\S]*?)<\s*\/address\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*b\s*>([\s\S]*?)<\s*\/b\s*>/imsu', '<strong>$1</strong>', $content);
$content = preg_replace('/<\s*big\s*>([\s\S]*?)<\s*\/big\s*>/imsu', '<strong>$1</strong>', $content);
$content = preg_replace('/<\s*blink\s*>([\s\S]*?)<\s*\/blink\s*>/imsu', '<p><em>$1</em></p>', $content);
$content = preg_replace('/<\s*listing\s*>([\s\S]*?)<\s*\/listing\s*>/imsu', '<pre>$1</pre>', $content);
$content = preg_replace('/<\s*marquee\s*>([\s\S]*?)<\s*\/marquee\s*>/imsu', '<em>$1</em>', $content);
$content = preg_replace('/<\s*textarea\s*>([\s\S]*?)<\s*\/textarea\s*>/imsu', '<p>$1</p>', $content);
}else{
}


/* ***** lnr ********************************************************* */
if($feed_for === 'lnr'){
$content = preg_replace('/<!--\s*[\s\S]*?--\s*>/imsu', '', $content);
$content = preg_replace('/<\s*address\s*>([\s\S]*?)<\s*\/address\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*b\s*>([\s\S]*?)<\s*\/b\s*>/imsu', '<strong>$1</strong>', $content);
$content = preg_replace('/<\s*big\s*>([\s\S]*?)<\s*\/big\s*>/imsu', '<strong>$1</strong>', $content);
$content = preg_replace('/<\s*blink\s*>([\s\S]*?)<\s*\/blink\s*>/imsu', '<p><strong>$1</strong></p>', $content);
$content = preg_replace('/<\s*dd\s*>([\s\S]*?)<\s*\/dd\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*del\s*>([\s\S]*?)<\s*\/del\s*>/imsu', '（ここから文削除→ $1 ←ここまで文削除）', $content);
$content = preg_replace('/<\s*dt\s*>([\s\S]*?)<\s*\/dt\s*>/imsu', '<p><strong>$1</strong></p>', $content);
$content = preg_replace('/<\s*em\s*>([\s\S]*?)<\s*\/em\s*>/imsu', '<strong>$1</strong>', $content);
$content = preg_replace('/<\s*figcaption\s*>([\s\S]*?)<\s*\/figcaption\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*h3\s*>([\s\S]*?)<\s*\/h3\s*>/imsu', '<h2>$1</h2>', $content);
$content = preg_replace('/<\s*h4\s*>([\s\S]*?)<\s*\/h4\s*>/imsu', '<h2>$1</h2>', $content);
$content = preg_replace('/<\s*h5\s*>([\s\S]*?)<\s*\/h5\s*>/imsu', '<h2>$1</h2>', $content);
$content = preg_replace('/<\s*h6\s*>([\s\S]*?)<\s*\/h6\s*>/imsu', '<h2>$1</h2>', $content);
$content = preg_replace('/<\s*listing\s*>([\s\S]*?)<\s*\/listing\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*marquee\s*>([\s\S]*?)<\s*\/marquee\s*>/imsu', '<strong>$1</strong>', $content);
$content = preg_replace('/<\s*pre\s*>([\s\S]*?)<\s*\/pre\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*textarea\s*>([\s\S]*?)<\s*\/textarea\s*>/imsu', '<p>$1</p>', $content);
}else{
}

/* ***** dcm ********************************************************* */
if($feed_for === 'dcm'){
$content = preg_replace('/<!--\s*[\s\S]*?--\s*>/imsu', '', $content);
$content = preg_replace('/<\s*address\s*>([\s\S]*?)<\s*\/address\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*b\s*>([\s\S]*?)<\s*\/b\s*>/imsu', '<strong>$1</strong>', $content);
$content = preg_replace('/<\s*big\s*>([\s\S]*?)<\s*\/big\s*>/imsu', '<strong>$1</strong>', $content);
$content = preg_replace('/<\s*blink\s*>([\s\S]*?)<\s*\/blink\s*>/imsu', '<p><strong>$1</strong></p>', $content);
$content = preg_replace('/<\s*dd\s*>([\s\S]*?)<\s*\/dd\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*del\s*>([\s\S]*?)<\s*\/del\s*>/imsu', '（ここから文削除→ $1 ←ここまで文削除）', $content);
$content = preg_replace('/<\s*dt\s*>([\s\S]*?)<\s*\/dt\s*>/imsu', '<p><strong>$1</strong></p>', $content);
$content = preg_replace('/<\s*em\s*>([\s\S]*?)<\s*\/em\s*>/imsu', '<strong>$1</strong>', $content);
$content = preg_replace('/<\s*figcaption\s*>([\s\S]*?)<\s*\/figcaption\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*h1\s*>([\s\S]*?)<\s*\/h1\s*>/imsu', '<h2>$1</h2>', $content);
$content = preg_replace('/<\s*h4\s*>([\s\S]*?)<\s*\/h4\s*>/imsu', '<h3>$1</h3>', $content);
$content = preg_replace('/<\s*h5\s*>([\s\S]*?)<\s*\/h5\s*>/imsu', '<h3>$1</h3>', $content);
$content = preg_replace('/<\s*h6\s*>([\s\S]*?)<\s*\/h6\s*>/imsu', '<h3>$1</h3>', $content);
$content = preg_replace('/<\s*li\s*>([\s\S]*?)<\s*\/li\s*>/imsu', '<p>・$1</p>', $content);
$content = preg_replace('/<\s*listing\s*>([\s\S]*?)<\s*\/listing\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*marquee\s*>([\s\S]*?)<\s*\/marquee\s*>/imsu', '<strong>$1</strong>', $content);
$content = preg_replace('/<\s*pre\s*>([\s\S]*?)<\s*\/pre\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*textarea\s*>([\s\S]*?)<\s*\/textarea\s*>/imsu', '<p>$1</p>', $content);
}else{
}

/* ***** spb ********************************************************* */
if($feed_for === 'spb'){
$content = preg_replace('/<!--\s*[\s\S]*?--\s*>/imsu', '', $content);
$content = preg_replace('/<\s*address\s*>([\s\S]*?)<\s*\/address\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*b\s*>([\s\S]*?)<\s*\/b\s*>/imsu', '$1', $content);
$content = preg_replace('/<\s*big\s*>([\s\S]*?)<\s*\/big\s*>/imsu', '$1', $content);
$content = preg_replace('/<\s*div\s*>([\s\S]*?)<\s*\/div\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*blink\s*>([\s\S]*?)<\s*\/blink\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*dd\s*>([\s\S]*?)<\s*\/dd\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*del\s*>([\s\S]*?)<\s*\/del\s*>/imsu', '（ここから文削除→ $1 ←ここまで文削除）', $content);
$content = preg_replace('/<\s*dt\s*>([\s\S]*?)<\s*\/dt\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*em\s*>([\s\S]*?)<\s*\/em\s*>/imsu', '$1', $content);
$content = preg_replace('/<\s*figcaption\s*>([\s\S]*?)<\s*\/figcaption\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*h1\s*>([\s\S]*?)<\s*\/h1\s*>/imsu', '<h2>$1</h2>', $content);
$content = preg_replace('/<\s*h3\s*>([\s\S]*?)<\s*\/h3\s*>/imsu', '<h2>$1</h2>', $content);
$content = preg_replace('/<\s*h4\s*>([\s\S]*?)<\s*\/h4\s*>/imsu', '<h2>$1</h2>', $content);
$content = preg_replace('/<\s*h5\s*>([\s\S]*?)<\s*\/h5\s*>/imsu', '<h2>$1</h2>', $content);
$content = preg_replace('/<\s*h6\s*>([\s\S]*?)<\s*\/h6\s*>/imsu', '<h2>$1</h2>', $content);
$content = preg_replace('/<\s*li\s*>([\s\S]*?)<\s*\/li\s*>/imsu', '<p>・$1</p>', $content);
$content = preg_replace('/<\s*listing\s*>([\s\S]*?)<\s*\/listing\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*marquee\s*>([\s\S]*?)<\s*\/marquee\s*>/imsu', '$1', $content);
$content = preg_replace('/<\s*pre\s*>([\s\S]*?)<\s*\/pre\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*textarea\s*>([\s\S]*?)<\s*\/textarea\s*>/imsu', '<p>$1</p>', $content);
}else{
}

/* ***** gnf ********************************************************* */
if($feed_for === 'gnf'){
$content = preg_replace('/<!--\s*[\s\S]*?--\s*>/imsu', '', $content);
$content = preg_replace('/<\s*blink\s*>([\s\S]*?)<\s*\/blink\s*>/imsu', '<p><strong>$1</strong></p>', $content);
$content = preg_replace('/<\s*h1\s*>([\s\S]*?)<\s*\/h1\s*>/imsu', '<h2>$1</h2>', $content);
$content = preg_replace('/<\s*h6\s*>([\s\S]*?)<\s*\/h6\s*>/imsu', '<h5>$1</h5>', $content);
$content = preg_replace('/<\s*listing\s*>([\s\S]*?)<\s*\/listing\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*marquee\s*>([\s\S]*?)<\s*\/marquee\s*>/imsu', '<strong>$1</strong>', $content);
}else{
}

/* ***** snf ********************************************************* */
if($feed_for === 'snf'){
$content = preg_replace('/<!--\s*[\s\S]*?--\s*>/imsu', '', $content);
$content = preg_replace('/<\s*textarea\s*>([\s\S]*?)<\s*\/textarea\s*>/imsu', '<p>$1</p>', $content);
}else{
}

/* ***** ldn ********************************************************* */
if($feed_for === 'ldn'){
$content = preg_replace('/<!--\s*[\s\S]*?--\s*>/imsu', '', $content);
$content = preg_replace('/<\s*address\s*>([\s\S]*?)<\s*\/address\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*blink\s*>([\s\S]*?)<\s*\/blink\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<blockquote\s*(.*?)class="instagram-media"\s*(.*?)>[\s\S]*?<\/blockquote>/im','', $content);
$content = preg_replace('/<blockquote\s*(.*?)class="fb-xfbml-parse-ignore"\s*>[\s\S]*?<\/blockquote>/im','', $content);
$content = preg_replace('/<blockquote\s*(.*?)class="tiktok-embed"\s*(.*?)>[\s\S]*?<\/blockquote>/im','', $content);
$content = preg_replace('/<blockquote\s*(.*?)class="twitter-tweet">\s*(.*?)>[\s\S]*?<\/blockquote>/im','', $content);
$content = preg_replace('/<blockquote cite="https:\/\/www\.facebook\.com\/[\s\S]*?<\/blockquote>/im','', $content);
$content = preg_replace('/<blockquote cite="https:\/\/ja-jp\.facebook\.com\/[\s\S]*?<\/blockquote>/im','', $content);
$content = preg_replace('/<blockquote cite="https:\/\/www\.tiktok\.com\/[\s\S]*?<\/blockquote>/im','', $content);
$content = preg_replace('/<\s*dd\s*>([\s\S]*?)<\s*\/dd\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*del\s*>([\s\S]*?)<\s*\/del\s*>/imsu', '（ここから文削除→ $1 ←ここまで文削除）', $content);
$content = preg_replace('/<\s*dt\s*>([\s\S]*?)<\s*\/dt\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*figcaption\s*>([\s\S]*?)<\s*\/figcaption\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*h1\s*>([\s\S]*?)<\s*\/h1\s*>/imsu', '<h3>$1</h3>', $content);
$content = preg_replace('/<\s*h2\s*>([\s\S]*?)<\s*\/h2\s*>/imsu', '<h3>$1</h3>', $content);
$content = preg_replace('/<\s*h4\s*>([\s\S]*?)<\s*\/h4\s*>/imsu', '<h3>$1</h3>', $content);
$content = preg_replace('/<\s*h5\s*>([\s\S]*?)<\s*\/h5\s*>/imsu', '<h3>$1</h3>', $content);
$content = preg_replace('/<\s*h6\s*>([\s\S]*?)<\s*\/h6\s*>/imsu', '<h3>$1</h3>', $content);
$content = preg_replace('/<\s*li\s*>([\s\S]*?)<\s*\/li\s*>/imsu', '・$1<br>', $content);
$content = preg_replace('/<\s*listing\s*>([\s\S]*?)<\s*\/listing\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*pre\s*>([\s\S]*?)<\s*\/pre\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*textarea\s*>([\s\S]*?)<\s*\/textarea\s*>/imsu', '<p>$1</p>', $content);
}else{
}

/* ***** isn ********************************************************* */
if($feed_for === 'isn'){
$content = preg_replace('/<!--\s*[\s\S]*?--\s*>/imsu', '', $content);
$content = preg_replace('/<\s*address\s*>([\s\S]*?)<\s*\/address\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*blink\s*>([\s\S]*?)<\s*\/blink\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*dd\s*>([\s\S]*?)<\s*\/dd\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*dt\s*>([\s\S]*?)<\s*\/dt\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*del\s*>([\s\S]*?)<\s*\/del\s*>/imsu', '（ここから文削除→ $1 ←ここまで文削除）', $content);
$content = preg_replace('/<\s*figcaption\s*>([\s\S]*?)<\s*\/figcaption\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*h1\s*>([\s\S]*?)<\s*\/h1\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*h2\s*>([\s\S]*?)<\s*\/h2\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*h3\s*>([\s\S]*?)<\s*\/h3\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*h4\s*>([\s\S]*?)<\s*\/h4\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*h5\s*>([\s\S]*?)<\s*\/h5\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*h6\s*>([\s\S]*?)<\s*\/h6\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*li\s*>([\s\S]*?)<\s*\/li\s*>/imsu', '・$1<br>', $content);
$content = preg_replace('/<\s*listing\s*>([\s\S]*?)<\s*\/listing\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*pre\s*>([\s\S]*?)<\s*\/pre\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*textarea\s*>([\s\S]*?)<\s*\/textarea\s*>/imsu', '<p>$1</p>', $content);
}else{
}

/* ***** ant ********************************************************* */
if($feed_for === 'ant'){
$content = preg_replace('/<!--\s*[\s\S]*?--\s*>/imsu', '', $content);
$content = preg_replace('/<\s*address\s*>([\s\S]*?)<\s*\/address\s*>/imsu', '$1<br>', $content);
$content = preg_replace('/<\s*blink\s*>([\s\S]*?)<\s*\/blink\s*>/imsu', '$1<br><br>', $content);
$content = preg_replace('/<\s*dd\s*>([\s\S]*?)<\s*\/dd\s*>/imsu', '$1<br><br>', $content);
$content = preg_replace('/<\s*del\s*>([\s\S]*?)<\s*\/del\s*>/imsu', '（ここから文削除→ $1 ←ここまで文削除）', $content);
$content = preg_replace('/<\s*dt\s*>([\s\S]*?)<\s*\/dt\s*>/imsu', '$1<br><br>', $content);
$content = preg_replace('/<\s*figcaption\s*>([\s\S]*?)<\s*\/figcaption\s*>/imsu', '$1<br><br>', $content);
$content = preg_replace('/<\s*h1\s*>([\s\S]*?)<\s*\/h1\s*>/imsu', '$1<br><br>', $content);
$content = preg_replace('/<\s*h2\s*>([\s\S]*?)<\s*\/h2\s*>/imsu', '$1<br><br>', $content);
$content = preg_replace('/<\s*h3\s*>([\s\S]*?)<\s*\/h3\s*>/imsu', '$1<br><br>', $content);
$content = preg_replace('/<\s*h4\s*>([\s\S]*?)<\s*\/h4\s*>/imsu', '$1<br><br>', $content);
$content = preg_replace('/<\s*h5\s*>([\s\S]*?)<\s*\/h5\s*>/imsu', '$1<br><br>', $content);
$content = preg_replace('/<\s*h6\s*>([\s\S]*?)<\s*\/h6\s*>/imsu', '$1<br><br>', $content);
$content = preg_replace('/<\s*li\s*>([\s\S]*?)<\s*\/li\s*>/imsu', '・$1<br>', $content);
$content = preg_replace('/<\s*listing\s*>([\s\S]*?)<\s*\/listing\s*>/imsu', '$1<br><br>', $content);
$content = preg_replace('/<\s*p(| .*?)>([\s\S]*?)<\s*\/p\s*>/imsu', '$2<br><br>', $content);
$content = preg_replace('/<\s*pre\s*>([\s\S]*?)<\s*\/pre\s*>/imsu', '$1<br><br>', $content);
$content = preg_replace('/<\s*textarea\s*>([\s\S]*?)<\s*\/textarea\s*>/imsu', '$1<br><br>', $content);
}else{
}

/* ***** trl ********************************************************* */
if($feed_for === 'trl'){
$content = preg_replace('/<!--\s*[\s\S]*?--\s*>/imsu', '', $content);
$content = preg_replace('/<\s*address\s*>([\s\S]*?)<\s*\/address\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*blink\s*>([\s\S]*?)<\s*\/blink\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*dd\s*>([\s\S]*?)<\s*\/dd\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*del\s*>([\s\S]*?)<\s*\/del\s*>/imsu', '（ここから文削除→ $1 ←ここまで文削除）', $content);
$content = preg_replace('/<\s*dt\s*>([\s\S]*?)<\s*\/dt\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*h4\s*>([\s\S]*?)<\s*\/h4\s*>/imsu', '<h3>$1</h3>', $content);
$content = preg_replace('/<\s*h5\s*>([\s\S]*?)<\s*\/h5\s*>/imsu', '<h3>$1</h3>', $content);
$content = preg_replace('/<\s*h6\s*>([\s\S]*?)<\s*\/h6\s*>/imsu', '<h3>$1</h3>', $content);
$content = preg_replace('/<\s*listing\s*>([\s\S]*?)<\s*\/listing\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*pre\s*>([\s\S]*?)<\s*\/pre\s*>/imsu', '<p>$1</p>', $content);
$content = preg_replace('/<\s*textarea\s*>([\s\S]*?)<\s*\/textarea\s*>/imsu', '<p>$1</p>', $content);
}else{
}

if($feed_for !== 'ynf'){
// 改行タグを補う
$content = preg_replace('/^(.+?)(?<!>)+\n/m', '$1<br>'."\n", $content);
// 空行削除
$content = preg_replace('/^( |)<br>(\s*|<br>)\n^( |)<br>(\s*|<br>)\n/ims', '<br>'."\n", $content);
$content = preg_replace('/^\n/imsu', '', $content);
}else{
}

if($feed_for === 'trl'){
// ブロック要素で囲われていない br を p に変換
//$content = preg_replace('/^(.*?)<br>$/im', '<p>\\1</p>', $content);
// 内容が空の p,h,span要素を削除
$content = preg_replace('/<p>(&nbsp;| |'.$table_inline_delimiter.'|)<\/p>$\n/im', '', $content);
// li の子要素にできない p 要素を削除
$content = preg_replace('/<li>(\n|)<p>(.*?)<\/p>(\n|)<\/li>$\n/im', '<li>\\2</li>'."\n", $content);
}else{
}

if($feed_for === 'yjt'){
// 内容が空の p,h,span要素を削除
$content = preg_replace('/<p>(&nbsp;| |'.$table_inline_delimiter.'|)<\/p>$\n/im', '', $content);
//$content = preg_replace('/<p><img([^>]*alt="([^"]*)"\s*[^>]*)><\/p>/imsu', '<p><img$1><cite>$2</cite></p>', $content);
}else{
}

if($feed_for === 'spb'){
	$table_option = get_option('cuerda_spb_table',0);
	if($table_option == 1){
	$content = preg_replace('/<\s*table[\s\S]*?\/table\s*>/im', '', $content);
	}
}

if($feed_for !== 'ant' && $feed_for !== 'ynf'){
	$content = preg_replace('/<br>\n/im', '<br>', $content);
	$content = preg_replace('/<br></im', '<br>'."\n".'<', $content);
	//空行以外の行の先頭がHTMLタグではない、又は下記 $block_elements に該当しない要素タイプのタグから始まる場合、その行の先頭に p タグを、その行の末尾に p 終了タグをマークアップする。
	$content = preg_replace('/^\s*<br>$/im', '', $content);
	$content = preg_replace('/^\s*(.+?)$/im', '$1', $content);
	$block_elements = array(
	'address','area', 'article', 'aside', 'button', 'blockquote', 'col', 'colgroup', 'dd',
	'datalist','details', 'dialog', 'div', 'dl', 'dt', 'fieldset',
	'figcaption', 'figure', 'footer', 'form',
	'h1', 'h2', 'h3', 'h4', 'h5', 'h6','iframe','input',
	'header', 'hgroup', 'hr', 'li', 'legend', 'label', 'main','map', 'nav', 'noscript',
	'optgroup', 'option','ol', 'p', 'q', 'pre', 'ruby', 'rb', 'rt', 'select', 'section', 'script', 'table', 'ul',
	'caption', 'thead', 'tbody', 'tfoot', 'tr', 'td', 'th'
	);
	// ブロック要素のタグを正規表現パターンに追加
	$block_tags_pattern = implode('|', $block_elements);

	// 各行を配列に分割
	$lines = explode("\n", $content);
	$elem = 'p';

	// 空行以外の各行を処理
	foreach ($lines as &$line) {
		// 空行でない場合
		if (trim($line) !== '') {
			// 行の先頭がHTMLタグでないか、ブロック要素で始まっていない場合、pタグでマークアップ
			if (!preg_match("/^<($block_tags_pattern)\b|^<\/($block_tags_pattern)\b/i", $line)) {
				$line = '<'.$elem.'>' . $line . '</'.$elem.'>';
			}
		}
	}
	// 配列から改行を含めて文字列に戻す
	$content = implode("\n", $lines);
	$content = preg_replace('/<br><\/'.$elem.'>$/im', '</'.$elem.'>', $content);
	$content = preg_replace('/^(.*?)<br>\n/im', '$1<br>', $content);
	$content = preg_replace('/^<p>(.*?)<p>(.*?)<\/p><\/p>$/im', '<p>$1$2</p>', $content);
	$content = preg_replace('/^<p><br>/im', '<p>', $content);
	$content = preg_replace('/^<p>\n<\/p>\n/im', '', $content);

	if($feed_for === 'dcm'||$feed_for === 'spb'){
		$content = preg_replace('/^<p><\s*a\s*(.+?)><\/p>\n<p><\s*img\s*(.+?)><\/p>\n<p>(.+?)<\/p>\n<p><\/a><\/p>/im', '<p><a $1><img $2><br>$3</a></p>', $content);
		$content = preg_replace('/<br><\/a>/im', '</a>', $content);
	}

	if($feed_for === 'lnr'){
		$content = preg_replace('/^<p><\s*a\s*(.+?)><\/p>\n<p><\s*img\s*(.+?)><\/p>\n<p>(.+?)<\/p>\n<p><\/a><\/p>/im', '<p><a $1><img $2 data-caption="$3"></a></p>', $content);
		$content = preg_replace('/<br>"><\/a>/im', '"></a>', $content);
	}

	if($feed_for === 'yjt'){
		$content = preg_replace('/<p>\n<p><\s*img\s*(.+?)><\/p>\n<p><cite>(.+?)<\/p>\n<p><\/cite><\/p>\n<\/p>/im', '<p><img $1></p>'."\n".'<p><cite>$2</cite></p>', $content);
	}

	if($feed_for === 'goo'||$feed_for === 'snf'||$feed_for === 'gnf'){
		$content = preg_replace('/^<p><\s*a\s*(.+?)><\/p>\n<figure>\n<p><\s*img\s*(.+?)><\/p>\n<figcaption>(.+?)<\/figcaption>\n<\/figure>\n<p><\/a><\/p>/im', '<p><a $1>'."\n".'<figure>'."\n".'<img $2>'."\n".'<figcaption>$3</figcaption>'."\n".'</figure>'."\n".'</a></p>', $content);
		$content = preg_replace('/<br><\/figcaption>/im', '</figcaption>', $content);
	}

	if($feed_for === 'trl'){
		$content = preg_replace('/^<p><\s*a\s*(.+?)><\/p>\n<figure><\s*img\s*(.+?)><figcaption>(.+?)<\/figcaption><\/figure>\n<p><\/a><\/p>/im', '<p><a $1>'."\n".'<figure>'."\n".'<img $2>'."\n".'<figcaption>$3</figcaption>'."\n".'</figure>'."\n".'</a></p>', $content);
	}

}

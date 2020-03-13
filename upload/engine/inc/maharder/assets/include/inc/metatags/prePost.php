<?php
////////////////////////////////////////////////////////////
// =======================================================
// Mod: MaHarder Assets
// File: prePost.php
// Path: /engine/inc/maharder/assets/include/inc/metatags/prePost.php
// =======================================================
// Author: Maxim Harder (c) 2020
// Website: https://maxim-harder.de / https://devcraft.club
// Telegram: http://t.me/MaHarder
// =======================================================
// Do not change anything!
// =======================================================
////////////////////////////////////////////////////////////

if( !defined( 'DATALIFEENGINE' ) ) {
	header( "HTTP/1.1 403 Forbidden" );
	header ( 'Location: ../../../../../../' );
	die( "Hacking attempt!" );
}

$titleLang = [];
$descriptionLang = [];
$headersLang = [];

function create_metatags_lang($story, $lang, $ajax = false) {
	global $config, $db;

	$keyword_count = 20;
	$newarr = array ();
	$headers = array ();
	$quotes = array ("\x22", "\x60", "\t", '\n', '\r', "\n", "\r", "\\", ",", ".", "/", "#", ";", ":", "@", "~", "[", "]", "{", "}", "=", "-", "+", ")", "(", "*", "^", "%", "$", "<", ">", "?", "!", '"');
	$fastquotes = array ("\x22", "\x60", "\t", "\n", "\r", '"', '\r', '\n', "$", "{", "}", "[", "]", "<", ">", "\\");

	$story = preg_replace( "#\[hide(.*?)\](.+?)\[/hide\]#is", "", $story );
	$story = preg_replace( "'\[attachment=(.*?)\]'si", "", $story );
	$story = preg_replace( "'\[page=(.*?)\](.*?)\[/page\]'si", "", $story );
	$story = str_replace( "{PAGEBREAK}", "", $story );
	$story = str_replace( "&nbsp;", " ", $story );

	$story = str_replace( '<br />', ' ', $story );
	$story = str_replace( '<br>', ' ', $story );
	$story = strip_tags( $story );
	$story = preg_replace( "#&(.+?);#", "", $story );
	$story = trim(str_replace( " ,", "", $story ));

	if( trim( $_REQUEST['meta_title'] ) ) {

		$headers['title'] = trim( htmlspecialchars( strip_tags( stripslashes($_REQUEST['meta_title_' . $lang] ) ),
			ENT_COMPAT, $config['charset'] ) );
		$headers['title'] = $db->safesql(str_replace( $fastquotes, '', $headers['title'] ));

	} else $headers['title'] = "";

	if( trim( $_REQUEST['descr'] ) ) {

		$headers['description'] = trim(strip_tags( stripslashes( $_REQUEST['descr_' . $lang] ) ) );

		if( dle_strlen( $headers['description'], $config['charset'] ) > 300 ) {

			$headers['description'] = dle_substr( $headers['description'], 0, 300, $config['charset'] );

			if( ($temp_dmax = dle_strrpos( $headers['description'], ' ', $config['charset'] )) ) $headers['description'] = dle_substr( $headers['description'], 0, $temp_dmax, $config['charset'] );

		}

		$headers['description'] = $db->safesql( str_replace( $fastquotes, '', $headers['description'] ));

	} elseif($config['create_metatags'] OR $ajax) {

		$story = str_replace( $fastquotes, '', $story );

		$headers['description'] = stripslashes($story);

		if( dle_strlen( $headers['description'], $config['charset'] ) > 300 ) {

			$headers['description'] = dle_substr( $headers['description'], 0, 300, $config['charset'] );

			if( ($temp_dmax = dle_strrpos( $headers['description'], ' ', $config['charset'] )) ) $headers['description'] = dle_substr( $headers['description'], 0, $temp_dmax, $config['charset'] );

		}

		$headers['description'] = $db->safesql( $headers['description'] );

	} else {

		$headers['description'] = '';

	}

	if( trim( $_REQUEST['keywords_' . $lang] ) ) {

		$arr = explode( ",", $_REQUEST['keywords_' . $lang] );
		$newarr = array();

		foreach ( $arr as $word ) {
			$newarr[] = trim($word);
		}

		$_REQUEST['keywords_' . $lang] = implode( ", ", $newarr );

		$headers['keywords'] = $db->safesql( str_replace( $fastquotes, " ", strip_tags( stripslashes( $_REQUEST['keywords_' . $lang] ) ) ) );

	} elseif( $config['create_metatags'] OR $ajax) {

		$story = str_replace( $quotes, ' ', $story );

		$arr = explode( " ", $story );

		foreach ( $arr as $word ) {
			if( dle_strlen( $word, $config['charset'] ) > 4 ) $newarr[] = $word;
		}

		$arr = array_count_values( $newarr );
		arsort( $arr );

		$arr = array_keys( $arr );

		$total = count( $arr );

		$offset = 0;

		$arr = array_slice( $arr, $offset, $keyword_count );

		$headers['keywords'] = $db->safesql( implode( ", ", $arr ) );
	} else {

		$headers['keywords'] = '';

	}

	return $headers;
}

foreach ($i18n_lang['active'] as $code => $lang_ar) {
	$iso = $lang_ar['iso2'];
	if ($i18n->getLocale() == $code) {
		$titleLang[$iso] = $db->safesql(  htmlspecialchars( strip_tags( stripslashes($_POST['page_title'] ) ), ENT_QUOTES, $config['charset']) );
		$descriptionLang[$iso] = $db->safesql( $parse->BB_Parse( $parse->process( $_POST['page_description'] ), false ) );
		$headersLang[$iso]= create_metatags('');
	} else {
		$titleLang[$iso] = $db->safesql(  htmlspecialchars( strip_tags( stripslashes($_POST['page_title_' . $iso] ) ),
			ENT_QUOTES, $config['charset']) );
		$descriptionLang[$iso] = $db->safesql( $parse->BB_Parse( $parse->process( $_POST['page_description_' . $iso] ),
			false ) );
		$headersLang[$iso]= create_metatags_lang('', $iso);
	}
}

$metatagsAll = [];
foreach($titleLang as $lng => $inh) {
	$metatagsAll[] = "page_title_{$lng} = '{$inh}'";
}
foreach($descriptionLang as $lng => $inh) {
	$metatagsAll[] = "page_description_{$lng} = '{$inh}'";
}
foreach($headersLang as $lng => $inh) {
	$metatagsAll[] = "description_{$lng} = '{$metatagsLang[$lng]['description']}'";
	$metatagsAll[] = "keywords_{$lng} = '{$metatagsLang[$lng]['keywords']}'";
	$metatagsAll[] = "title_{$lng} = '{$metatagsLang[$lng]['title']}'";
}
$metatagsAll =      implode(', ', $metatagsAll);

$dle_prefix = PREFIX;
$thisID = $db->insert_id();
if ($_POST['action'] == "edit") {
	$thisID = $id;
}
$db->query("UPDATE {$dle_prefix}_metatags SET {$metatagsAll} where id = {$thisID}" );
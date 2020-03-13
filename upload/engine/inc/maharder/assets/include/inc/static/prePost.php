<?php
//===============================================================
// Mod: MaHarder Assets                                         =
// File: prePost.php                                            =
// Path: /engine/inc/maharder/assets/include/inc/static/prePost.php
// ============================================================ =
// Author: Maxim Harder (c) 2020                                =
// Website: https://maxim-harder.de / https://devcraft.club     =
// Telegram: http://t.me/MaHarder                               =
// ============================================================ =
// Do not change anything!                                      =
//===============================================================

if( !defined( 'DATALIFEENGINE' ) ) {
	header( "HTTP/1.1 403 Forbidden" );
	header ( 'Location: ../../../../../../' );
	die( "Hacking attempt!" );
}

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

$templatesLang = [];
$metTagsLang = [];
$descrLang = [];

foreach ($i18n_lang['active'] as $code => $lang_ar) {
	$iso = $lang_ar['iso2'];
	if ($i18n->getLocale() == $code) {
		if ($allow_br == 2) {
			$_POST['template_' . $iso] = trim( addslashes( $_POST['template'] ) );
		} else {
			if ( $config['allow_static_wysiwyg'] ) $parse->allow_code = false;
			$_POST['template_' . $iso] = $parse->process( $_POST['template'] );
			if( $config['allow_static_wysiwyg'] or $allow_br != '1' ) {
				$_POST['template_' . $iso] = $parse->BB_Parse( $_POST['template_' . $iso] );
			} else {
				$_POST['template_' . $iso] = $parse->BB_Parse( $_POST['template_' . $iso], false );
			}
		}

		$_POST['description_' . $iso] = $_POST['description'];
	} else {
		if ($allow_br == 2) {
			$_POST['template_' . $iso] = trim( addslashes( $_POST['template_' . $iso] ) );
		} else {
			if ( $config['allow_static_wysiwyg'] ) $parse->allow_code = false;
			$_POST['template_' . $iso] = $parse->process( $_POST['template_' . $iso] );
			if( $config['allow_static_wysiwyg'] or $allow_br != '1' ) {
				$_POST['template_' . $iso] = $parse->BB_Parse( $_POST['template_' . $iso] );
			} else {
				$_POST['template_' . $iso] = $parse->BB_Parse( $_POST['template_' . $iso], false );
			}
		}

	}

	$_POST['description_' . $iso] = $db->safesql( htmlspecialchars( strip_tags(trim($_POST['description_' . $iso])),ENT_QUOTES, $config['charset'] ) );

	$descrLang[] = "descr_{$iso} = '{$_POST['description_' . $iso]}'";
	$metTagsLang[$iso] = create_metatags_lang( $_POST['template_' . $iso], $iso );
	$_POST['template_' . $iso] = $db->safesql( $_POST['template_' . $iso] );
	$templatesLang[] = "template_{$iso} = '{$_POST['template_' . $iso]}'";

}

$insertLines = [
	implode(', ', $descrLang),
	implode(', ', $templatesLang),
];

foreach($metTagsLang as $lng => $inh) {
	$insertLines[] = "metadescr_{$lng} = '{$metTagsLang[$lng]['description']}'";
	$insertLines[] = "metakeys_{$lng} = '{$metTagsLang[$lng]['keywords']}'";
	$insertLines[] = "metatitle_{$lng} = '{$metTagsLang[$lng]['title']}'";
}
$insertLines = implode(', ', $insertLines);

if ($action == "dosavenew") {
	$insertID = $db->insert_id();
} elseif ($action == "dosaveedit") {
	if( $_GET['page'] == "rules" ) {
		if( $_POST['id'] ) {
			$insertID = (int)$_POST['id'];
		} else {
			$insertID = $db->insert_id();
		}
	} else {
		$insertID = $id;
	}
}

$dle_prefix = PREFIX;

$db->query("UPDATE {$dle_prefix}_static SET {$insertLines} where id = {$insertID}" );
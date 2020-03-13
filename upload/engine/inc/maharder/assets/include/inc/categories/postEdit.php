<?php
////////////////////////////////////////////////////////////
// =======================================================
// Mod: MaHarder Assets
// File: postEdit.php
// Path: /engine/inc/maharder/assets/include/inc/categories/postEdit.php
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

$nameLang = [];
$descrLang = [];
$metaTitleLang = [];
$fullDescrLang = [];
$keywordsLang = [];

foreach ($i18n_lang['active'] as $code => $lang_ar) {
	if ($i18n->getLocale() == $code) {
		$nameLang[$lang_ar['iso2']] = $db->safesql(  htmlspecialchars( strip_tags( stripslashes($_POST['cat_name'] ) ), ENT_QUOTES, $config['charset']) );
		$fullDescrLang[$lang_ar['iso2']] = $db->safesql( $parse->BB_Parse( $parse->process( $_POST['fulldescr'] ), false ) );
		$metaTitleLang[$lang_ar['iso2']] = $db->safesql( htmlspecialchars ( strip_tags( stripslashes( $_POST['meta_title'] ) ), ENT_QUOTES, $config['charset'] ) );
		$descrLang[$lang_ar['iso2']] = $db->safesql( dle_substr( strip_tags( stripslashes( $_POST['descr'] ) ), 0, 300, $config['charset'] ) );
		$keywordsLang[$lang_ar['iso2']] =  $db->safesql( str_replace( $quotes, " ", strip_tags( stripslashes( $_POST['keywords'] ) ) ) );
	} else {
		$nameLang[$lang_ar['iso2']]        = $db->safesql(htmlspecialchars(strip_tags(stripslashes($_POST['cat_name_'.$lang_ar['iso2']])), ENT_QUOTES, $config['charset']));
		$fullDescrLang[$lang_ar['iso2']]       = $db->safesql($parse->BB_Parse($parse->process($_POST['fulldescr_'.$lang_ar['iso2']]), false));
		$metaTitleLang[$lang_ar['iso2']]   = $db->safesql(htmlspecialchars(strip_tags(stripslashes($_POST['meta_title_'.$lang_ar['iso2']])), ENT_QUOTES, $config['charset']));
		$descrLang[$lang_ar['iso2']] = $db->safesql(dle_substr(strip_tags(stripslashes($_POST['descr_'.$lang_ar['iso2']])), 0, 300, $config['charset']));
		$keywordsLang[$lang_ar['iso2']]    = $db->safesql(str_replace($quotes, " ", strip_tags(stripslashes($_POST['keywords_'.$lang_ar['iso2']]))));
	}

}

$catAll = [];
foreach ($i18n_lang['active'] as $code => $lang_ar) {
	$iso = $lang_ar['iso2'];
	$catAll[] = "name_{$iso} = '{$nameLang[$iso]}'";
	$catAll[] = "descr_{$iso} = '{$descrLang[$iso]}'";
	$catAll[] = "metatitle_{$iso} = '{$metaTitleLang[$iso]}'";
	$catAll[] = "fulldescr_{$iso} = '{$fullDescrLang[$iso]}'";
	$catAll[] = "keywords_{$iso} = '{$keywordsLang[$iso]}'";
}
$catAll = implode(', ', $catAll);

$dle_prefix = PREFIX;

$db->query("UPDATE {$dle_prefix}_category SET {$catAll} where id = {$catid}" );
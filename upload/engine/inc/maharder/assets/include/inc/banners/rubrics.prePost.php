<?php
////////////////////////////////////////////////////////////
// =======================================================
// Mod: MaHarder Assets
// File: rubrics.prePost.php
// Path: /engine/inc/maharder/assets/include/inc/banners/rubrics.prePost.php
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
$descrLang = [];

foreach ($i18n_lang['active'] as $code => $lang_ar) {
	if ($i18n->getLocale() == $code) {
		$descrLang[$lang_ar['iso2']] = $db->safesql( htmlspecialchars( strip_tags( stripslashes($_POST['description'] )), ENT_QUOTES, $config['charset']) );
		$titleLang[$lang_ar['iso2']] = $db->safesql( htmlspecialchars(strip_tags(stripslashes($_POST['title'])), ENT_QUOTES, $config['charset']) );
	} else {

		$descrLang[$lang_ar['iso2']] = $db->safesql(htmlspecialchars(strip_tags(stripslashes($_POST['description_'.$lang_ar['iso2']])), ENT_QUOTES, $config['charset']));
		$titleLang[$lang_ar['iso2']] = $db->safesql(htmlspecialchars(strip_tags(stripslashes($_POST['title_'.$lang_ar['iso2']])), ENT_QUOTES, $config['charset']));
	}
}

$updStr = [];
foreach($descrLang as $iso => $descr) {
	$updStr[] = "description_{$iso} = '{$descr}'";
}
foreach($titleLang as $iso => $descr) {
	$updStr[] = "title_{$iso} = '{$descr}'";
}
$updStr = implode(', ', $updStr);

$db->query("UPDATE " . PREFIX . "_banners_rubrics SET {$updStr} WHERE id = {$last_id}");
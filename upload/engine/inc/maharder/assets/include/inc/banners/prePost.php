<?php
////////////////////////////////////////////////////////////
// =======================================================
// Mod: MaHarder Assets
// File: prePost.php
// Path: /engine/inc/maharder/assets/include/inc/banners/prePost.php
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

$descrLang = [];

foreach ($i18n_lang['active'] as $code => $lang_ar) {
	if ($i18n->getLocale() == $code) {
		$descrLang[$lang_ar['iso2']] = $banner_descr;
	} else {
		if( function_exists( "get_magic_quotes_gpc" ) && get_magic_quotes_gpc() ){
			$_POST['banner_descr_' . $lang_ar['iso2']] = stripslashes( $_POST['banner_descr_' . $lang_ar['iso2']] );
			$_POST['banner_code_' . $lang_ar['iso2']] = stripslashes( $_POST['banner_code_'] . $lang_ar['iso2'] );
		}

		$descrLang[$lang_ar['iso2']] = $db->safesql( strip_tags( trim( $_POST['banner_descr_' . $lang_ar['iso2']] ) ) );
	}
}

$updStr = [];
foreach($descrLang as $iso => $descr) {
	$updStr[] = "descr_{$iso} = '{$descr}'";
}
$updStr = implode(', ', $updStr);

$db->query("UPDATE " . PREFIX . "_banners SET {$updStr} WHERE id = {$last_id}");
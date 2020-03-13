<?php
////////////////////////////////////////////////////////////
// =======================================================
// Mod: dle131.test
// File: table.php
// Path: D:/OSPanel/domains/dle131.test/engine/inc/maharder/assets/include/inc/editnews/table.php
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

foreach ($i18n_lang['active'] as $code => $lang_ar) {
	if ($i18n->getLocale() == $code) continue;

	$titleLang = $row['title_' . $lang_ar['iso2']];
	$titleLang = htmlspecialchars( stripslashes( $titleLang ), ENT_QUOTES, $config['charset'] );
	$titleLang = str_replace("&amp;","&", $titleLang );

	if( !empty($titleLang)) $titleStringLang = "<span class=\"text-success text-center\" title='{$titleLang}'><i class=\"fa fa-check-circle\"></i></span>";
	else $titleStringLang = "<span class=\"text-danger text-center\"><i class=\"fa fa-exclamation-circle\"></i></span>";

	$entries .= "<td class=\"hidden-xs hidden-sm text-center\">{$titleStringLang}</td>";
}
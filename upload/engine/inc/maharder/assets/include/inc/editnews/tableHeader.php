<?php
////////////////////////////////////////////////////////////
// =======================================================
// Mod: MaHarder Assets
// File: tableHeader.php
// Path: /engine/inc/maharder/assets/include/inc/editnews/tableHeader.php
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
	$name = "{$i18n_lang['active'][$code]['name']} / {$i18n_lang['active'][$code]['international']}";
	echo "<th class=\"hidden-xs text-center\" style=\"text-align:center;vertical-align: middle;\"><img src='{$i18n_lang['active'][$code]['flag']}' alt='{$name}' title='{$name}' style=\"max-width: 23px;width: 100%;height: auto;\"></th>";
}
<?php
//===============================================================
// Mod: MaHarder Assets                                         =
// File: module.php                                             =
// Path: /engine/inc/maharder/assets/include/modules/language/module.php
// ============================================================ =
// Author: Maxim Harder (c) 2020                                =
// Website: https://maxim-harder.de / https://devcraft.club     =
// Telegram: http://t.me/MaHarder                               =
// ============================================================ =
// Do not change anything!                                      =
//===============================================================

//if( !defined( 'DATALIFEENGINE' ) ) {
//	header( "HTTP/1.1 403 Forbidden" );
//	header ( 'Location: ../../../../../../' );
//	die( "Hacking attempt!" );
//}

global $i18n, $i18n_lang, $languages_config;

if (!isset($_GET['lang'])) {
	die(translate('Hacking attempt!'));
} else {
	if (in_array($_GET['lang'], $i18n_lang['isos'])) {
		$i18n->setLocale($i18n_lang['iso'][$_GET['lang']]['code']);
		$i18n->setCookieName($languages_config['cookieField']);
		header('Location: ' . $_SERVER['REQUEST_URI']);
	}
}
echo "<pre>";
var_dump($_GET);
echo "</pre>";
echo "<pre>";
var_dump($_REQUEST);
echo "</pre>";
echo "<pre>";
var_dump($_SERVER);
echo "</pre>";
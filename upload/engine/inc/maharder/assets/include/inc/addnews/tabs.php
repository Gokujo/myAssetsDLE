<?php
////////////////////////////////////////////////////////////
// =======================================================
// Mod: MaHarder Assets
// File: tabs.php
// Path: /engine/inc/maharder/assets/include/inc/addnews/tabs.php
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
	if($i18n->getLocale() == $code ) continue;
	echo "<li><a href=\"#{$code}\" data-toggle=\"tab\"><img src='{$lang_ar['flag']}' alt='" . translate($lang_ar['name']) . "' class='position-left' style='max-width: 23px;width: 100%;height: auto;'> " . translate($lang_ar['name']) . "</a></li>";
}
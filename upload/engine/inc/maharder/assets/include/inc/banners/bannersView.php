<?php
////////////////////////////////////////////////////////////
// =======================================================
// Mod: MaHarder Assets
// File: bannersView.php
// Path: /engine/inc/maharder/assets/include/inc/banners/bannersView.php
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

$thisLang = $i18n_lang['active'][$i18n->getLocale()];
$thisField = $row['descr_' . $thisLang['iso2']];
if(!empty($thisField)) $banner_descr = htmlspecialchars( $thisField, ENT_QUOTES, $config['charset'] );
<?php
////////////////////////////////////////////////////////////
// =======================================================
// Mod: MaHarder Assets
// File: table.php
// Path: /engine/inc/maharder/assets/include/inc/metatags/table.php
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

$entriesLang = '';
foreach ($i18n_lang['active'] as $code => $lang_ar) {
	$iso = $lang_ar['iso2'];
	if ($i18n->getLocale() == $code) continue;
	$entriesLang .= "<input type=\"hidden\" id=\"title_{$row['id']}_{$iso}\" data-description=\"{$row['description']}\" data-keywords=\"{$row['keywords']}\" data-pagetitle=\"{$row['page_title']}\" value='{$row['title_'. $iso]}'>";
	$entriesLang .= "<textarea id=\"descr_{$row['id']}_{$iso}\" style=\"display:none;\">{$row['page_description_' . $iso]}</textarea>";
}
<?php
//===============================================================
// Mod: MaHarder Assets                                         =
// File: searchField.php                                        =
// Path: /engine/inc/maharder/assets/include/inc/static/searchField.php
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

$searchName = ["name like '%{$search_field}%'"];
$searchTemplate = ["template like '%{$search_field2}%'"];
$searchDescr = ["descr like '%{$search_field}%'"];

foreach ($i18n_lang['active'] as $code => $lang_ar) {
	$iso = $lang_ar['iso2'];
	if ($i18n->getLocale() == $code) continue;
	$searchTemplate[] = "template_{$iso} like '%{$search_field2}%'";
	$searchDescr[] = "descr_{$iso} like '%{$search_field}%'";
}
$searchName = implode(' OR ', $searchName);
$searchTemplate =	implode(' OR ', $searchTemplate);
$searchDescr =	implode(' OR ', $searchDescr);
$searchAll = [
	$searchName,
	$searchTemplate,
	$searchDescr,
];
$searchAll = implode(' OR ', $searchAll);
if(!$_REQUEST['search_area']) {
	$where[] = "({$searchAll})";
} elseif($_REQUEST['search_area'] == 1) {
	$where[] = "name like '%{$search_field}%'";
} elseif($_REQUEST['search_area'] == 2) {
	$where[] = "({$searchDescr})";
} elseif($_REQUEST['search_area'] == 3) {
	$where[] = "({$searchTemplate})";
}
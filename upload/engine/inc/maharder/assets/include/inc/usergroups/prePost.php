<?php
////////////////////////////////////////////////////////////
// =======================================================
// Mod: MaHarder Assets
// File: prePost.php
// Path: D:/OSPanel/domains/dle131.test/engine/inc/maharder/assets/include/inc/usergroups/prePost.php
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

$groupNamesLang = [];

foreach ($i18n_lang['active'] as $code => $lang_ar) {
	$iso = $lang_ar['iso2'];
	if ($i18n->getLocale() == $code) {
		$groupNamesLang[$iso] = $db->safesql( strip_tags( clear_html($_REQUEST['group_name']) ) );
	} else {
		$groupNamesLang[$iso] = $db->safesql( strip_tags( clear_html($_REQUEST['group_name_' . $iso]) ) );
	}

}

if($_GET['action'] == "doadd") {
	$thisID = $db->insert_id();
} else {
	$thisID = $id;
}

$dle_prefix = PREFIX;

$gnAll = [];
foreach ($i18n_lang['active'] as $code => $lang_ar) {
	$iso = $lang_ar['iso2'];
	$gnAll[] = "group_name_{$iso} = '{$groupNamesLang[$iso]}'";
}
$gnAll = implode(', ', $gnAll);

$db->query("UPDATE {$dle_prefix}_usergroups SET {$gnAll} WHERE id = {$thisID}");
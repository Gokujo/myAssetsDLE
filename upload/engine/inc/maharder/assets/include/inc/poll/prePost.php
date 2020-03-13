<?php
////////////////////////////////////////////////////////////
// =======================================================
// Mod: MaHarder Assets
// File: prePost.php
// Path: /engine/inc/maharder/assets/include/inc/poll/prePost.php
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
$bodyLang = [];

foreach ($i18n_lang['active'] as $code => $lang_ar) {
	$iso = $lang_ar['iso2'];

	if ($i18n->getLocale() == $code) {
		$titleLang[$iso] = $db->safesql( $parse->BB_Parse( $parse->process( $_POST['title'] ), false ) );
		$bodyLang[$iso]  = $db->safesql( $parse->BB_Parse( $parse->process( $_POST['body'] ), false ) );
	} else {
		$titleLang[$iso] = $db->safesql( $parse->BB_Parse( $parse->process( $_POST['title_' . $iso] ), false ) );
		$bodyLang[$iso]  = $db->safesql( $parse->BB_Parse( $parse->process( $_POST['body_' . $iso] ), false ) );
	}

}

if($_GET['action'] == "doadd") {
	$thisID = $db->insert_id();
} elseif ($_GET['action'] == "update") {
	$thisID = $id;
}

$dle_prefix = PREFIX;

$voteAll = [];
foreach ($i18n_lang['active'] as $code => $lang_ar) {
	$iso = $lang_ar['iso2'];
	$voteAll[] = "title_{$iso} = '{$titleLang[$iso]}'";
	$voteAll[] = "body_{$iso} = '{$bodyLang[$iso]}'";
}
$voteAll = implode(', ', $voteAll);

$db->query("UPDATE {$dle_prefix}_vote SET {$voteAll} WHERE id = {$thisID}");
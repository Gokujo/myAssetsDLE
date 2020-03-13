<?php
////////////////////////////////////////////////////////////
// =======================================================
// Mod: MaHarder Assets
// File: prePost.php
// Path: /engine/inc/maharder/assets/include/inc/question/prePost.php
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

$questions = [];
$answers = [];

foreach ($i18n_lang['active'] as $code => $lang_ar) {
	$iso = $lang_ar['iso2'];if ($i18n->getLocale() == $code) {
		$questions[$iso] = $db->safesql( strip_tags($_POST['question']) );
		$answers[$iso] = $db->safesql( strip_tags(str_replace( "\r", "", $_POST['answer'] )) );
	} else {
		$questions[$iso] = $db->safesql( strip_tags($_POST['question_' . $iso]) );
		$answers[$iso] = $db->safesql( strip_tags(str_replace( "\r", "", $_POST['answer_' . $iso] )) );
	}

}

if($_POST['action'] === 'addquestion') {
	$thisID = $db->insert_id();
} else {
	$thisID = $id;
}

$dle_prefix = PREFIX;

$qas = [];
foreach ($i18n_lang['active'] as $code => $lang_ar) {
	$iso = $lang_ar['iso2'];
	$qas[] = "question_{$iso} = '{$questions[$iso]}'";
	$qas[] = "answer_{$iso} = '{$answers[$iso]}'";
}
$qas = implode(', ', $qas);

$db->query("UPDATE {$dle_prefix}_question SET {$qas} WHERE id = {$thisID}");
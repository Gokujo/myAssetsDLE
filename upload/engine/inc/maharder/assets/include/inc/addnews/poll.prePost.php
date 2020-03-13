<?php
////////////////////////////////////////////////////////////
// =======================================================
// Mod: MaHarder Assets
// File: poll.prePost.php
// Path: /engine/inc/maharder/assets/include/inc/addnews/poll.prePost.php
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

$voteTitles = [];
$voteFragen = [];
$voteBodies = [];

foreach ($i18n_lang['active'] as $code => $lang_ar) {
	$iso = $lang_ar['iso2'];
	$titleName = "<img src='{$lang_ar['flag']}' alt='{$title}' title='{$title}' style='max-width: 23px;width: 100%;height: auto;'> " . $lang_ar['name'] . ' (' . $lang_ar['international'] . ')';
	if ($i18n->getLocale() == $code) {
		$voteTitles[$iso] = trim( $db->safesql( $parse->process( strip_tags($_POST['vote_title']) ) ) );
		$voteFragen[$iso]  = trim( $db->safesql( $parse->process( strip_tags($_POST['frage']) ) ) );
		$voteBodies[$iso]  = $db->safesql( $parse->BB_Parse( $parse->process( strip_tags($_POST['vote_body']) ), false ) );
	} else {
		$voteTitles[$iso] = trim( $db->safesql( $parse->process( strip_tags($_POST['vote_title_' . $iso]) ) ) );
		$voteFragen[$iso]  = trim( $db->safesql( $parse->process( strip_tags($_POST['frage_' . $iso]) ) ) );
		$voteBodies[$iso]  = $db->safesql( $parse->BB_Parse( $parse->process( strip_tags($_POST['vote_body_' . $iso])
		), false ) );
	}

}

$dle_prefix = PREFIX;

$voteAll = [];
foreach ($i18n_lang['active'] as $code => $lang_ar) {
	$iso = $lang_ar['iso2'];
	$voteAll[] = "title_{$iso} = '{$voteTitles[$iso]}'";
	$voteAll[] = "body_{$iso} = '{$voteBodies[$iso]}'";
	$voteAll[] = "frage_{$iso} = '{$voteFragen[$iso]}'";
}
$voteAll = implode(', ', $voteAll);


if($_GET['action'] != "editnews") {
	$thisID = $db->insert_id();
	$db->query("UPDATE {$dle_prefix}_poll SET {$voteAll} WHERE id = {$thisID}");
} else {
	$count = $db->super_query( "SELECT COUNT(*) as count FROM " . PREFIX . "_poll WHERE news_id = '$item_db[0]'" );

	if( $count['count'] ) {
		$db->query( "UPDATE  " . PREFIX . "_poll set title='$vote_title', frage='$frage', body='$vote_body', multiple='$allow_m_vote' WHERE news_id = '$item_db[0]'" );
		$thisID = $item_db[0];
		$db->query("UPDATE {$dle_prefix}_poll SET {$voteAll} WHERE news_id = {$thisID}");
	} else {
		$db->query( "INSERT INTO " . PREFIX . "_poll (news_id, title, frage, body, votes, multiple, answer) VALUES('$item_db[0]', '$vote_title', '$frage', '$vote_body', 0, '$allow_m_vote', '')" );
		$thisID = $db->insert_id();
		$db->query("UPDATE {$dle_prefix}_poll SET {$voteAll} WHERE id = {$thisID}");
	}
}
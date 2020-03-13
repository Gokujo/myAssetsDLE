<?php
////////////////////////////////////////////////////////////
// =======================================================
// Mod: MaHarder Assets
// File: fullnews.php
// Path: /engine/inc/maharder/assets/include/inc/addnews/fullnews.php
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


if ($mod != "editnews") {
	$row['id'] = "";
	$row['autor'] = $member_id['name'];
}

if (!isset ($row['full_story_' . $langISO])) $row['full_story_' . $langISO] = "";

echo <<<HTML
<div class="editor-panel"><textarea id="full_story_{$langISO}" name="full_story_{$langISO}" class="wysiwygeditor_{$langISO}" style="width:98%;height:300px;">{$row['full_story_' . $langISO]}</textarea></div>
HTML;

?>
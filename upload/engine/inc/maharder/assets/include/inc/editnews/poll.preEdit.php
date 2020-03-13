<?php
////////////////////////////////////////////////////////////
// =======================================================
// Mod: MaHarder Assets
// File: poll.preEdit.php
// Path: /engine/inc/maharder/assets/include/inc/editnews/poll.preEdit.php
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
	$iso = $lang_ar['iso2'];
	if ($i18n->getLocale() == $code) continue;

	$poll['title_' . $iso] = $parse->decodeBBCodes( $poll['title_' . $iso], false );
	$poll['frage_' . $iso] = $parse->decodeBBCodes( $poll['frage_' . $iso], false );
	$poll['body_' . $iso] = $parse->decodeBBCodes( $poll['body_' . $iso], false );

}
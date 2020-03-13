<?php
////////////////////////////////////////////////////////////
// =======================================================
// Mod: MaHarder Assets
// File: tags.php
// Path: /engine/inc/maharder/assets/include/inc/addnews/tags.php
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

if( $_POST['tags'] != "" AND $approve ) {

	$tags = array ();

	foreach ($i18n_lang['active'] as $code => $lang_ar) {
		if ($i18n->getLocale() == $code) {
			$_POST['tags_'.$lang_ar['iso2']] = $_POST['tags'];
		} else {
			$_POST['tags_'.$lang_ar['iso2']] = explode(',', $_POST['tags_'.$lang_ar['iso2']]);
		}
		foreach ( $_POST['tags_'.$lang_ar['iso2']] as $value ) {

			$tags[$lang_ar['iso2']][] = "('" . $id . "', '" . trim( $value ) . "')";
		}

	}

	foreach($tags as $lng => $tag) {
		$tags_lng = implode( ', ', $tags[$lng] );
		$db->query( 'INSERT INTO '. PREFIX . "_tags (news_id, tag_{$lng}) VALUES " . $tags_lng );
	}

}
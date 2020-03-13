<?php
////////////////////////////////////////////////////////////
// =======================================================
// Mod: MaHarder Assets
// File: preEdit.php
// Path: /engine/inc/maharder/assets/include/inc/editnews/preEdit.php
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
	if ($i18n->getLocale() == $code) continue;
	$row['title_' . $lang_ar['iso2']]    = $parse->decodeBBCodes($row['title_' . $lang_ar['iso2']], false);
	$row['title_' . $lang_ar['iso2']]    = str_replace("&amp;", "&", $row['title_' . $lang_ar['iso2']]);
	$row['descr_' . $lang_ar['iso2']]    = $parse->decodeBBCodes($row['descr_' . $lang_ar['iso2']], false);
	$row['keywords_' . $lang_ar['iso2']] = $parse->decodeBBCodes($row['keywords_' . $lang_ar['iso2']], false);

	$row['metatitle_' . $lang_ar['iso2']] = stripslashes($row['metatitle_' . $lang_ar['iso2']]);

	if ($row['allow_br'] != '1' OR $config['allow_admin_wysiwyg']) {
		$row['short_story_' . $lang_ar['iso2']] = $parse->decodeBBCodes($row['short_story_' . $lang_ar['iso2']], true, $config['allow_admin_wysiwyg']);
		$row['full_story_' . $lang_ar['iso2']]  = $parse->decodeBBCodes($row['full_story_' . $lang_ar['iso2']], true, $config['allow_admin_wysiwyg']);
	} else {
		$row['short_story_' . $lang_ar['iso2']] = $parse->decodeBBCodes($row['short_story_' . $lang_ar['iso2']], false);
		$row['full_story_' . $lang_ar['iso2']]  = $parse->decodeBBCodes($row['full_story_' . $lang_ar['iso2']], false);
	}
}
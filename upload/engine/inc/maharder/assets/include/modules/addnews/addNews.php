<?php
////////////////////////////////////////////////////////////
// =======================================================
// Mod: MaHarder Assets
// File: addNews.php
// Path: /engine/inc/maharder/assets/include/modules/addnews/addNews.php
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


if( $config['allow_site_wysiwyg'] ) include_once (DLEPlugins::Check(MH_DIR . '/include/inc/modules/addnews/editor.php'));

foreach ($i18n_lang['active'] as $code => $lang_ar) {
	$iso       = $lang_ar['iso2'];
	$titleName = "<img src='{$lang_ar['flag']}' alt='{$lang_ar['name']}' title='{$lang_ar['name']}' style='max-width: 23px;width: 100%;height: auto;'> ".$lang_ar['name'].' ('.$lang_ar['international'].')';
	$langName = $lang_ar['name'];
	$langNameInt = $lang_ar['international'];
	$langFlag = "<img src='{$lang_ar['flag']}' alt='{$lang_ar['name']}' title='{$lang_ar['name']}' style='max-width: 23px;width: 100%;height: auto;'>";
	$langFlagURL = $lang_ar['flag'];

	if (!$found || $i18n->getLocale() == $code) {

		$tpl->set('{title_' . $iso .'}', '');
		$tpl->set('{short-story_' . $iso .'}', '');
		$tpl->set('{full-story_' . $iso .'}', '');
		$tpl->set('{tags_' . $iso .'}', '');
		$tpl->set('{votetitle_' . $iso .'}', '');
		$tpl->set('{frage_' . $iso .'}', '');
		$tpl->set('{votebody_' . $iso .'}', '');
		$tpl->set('{shortarea_' . $iso .'}', '' );
		$tpl->set('{fullarea_' . $iso .'}', '' );
		$tpl->set('{fulltitle_' . $iso .'}', '' );
		$tpl->set('{langname_' . $iso .'}', '' );
		$tpl->set('{langname-int_' . $iso .'}', '' );
		$tpl->set('{flag_' . $iso .'}', '' );
		$tpl->set('{flag-url_' . $iso .'}', '' );
		$tpl->set('{iso2_' . $iso .'}', '' );

	} else {

		$tpl->set('{fulltitle_' . $iso .'}', $titleName );
		$tpl->set('{langname_' . $iso .'}', $langName );
		$tpl->set('{langname-int_' . $iso .'}', $langNameInt );
		$tpl->set('{flag_' . $iso .'}', $langFlag );
		$tpl->set('{flag-url_' . $iso .'}', $langFlagURL );
		$tpl->set('{iso2_' . $iso .'}', $iso );

		$tpl->set('{title_' . $iso .'}', $parse->decodeBBCodes($row['title_' . $iso], false));

		if ($config['allow_site_wysiwyg'] or $row['allow_br'] != '1') {
			$row['short_story_' . $iso] = $parse->decodeBBCodes($row['short_story_' . $iso], true, $config['allow_site_wysiwyg']);
			$row['full_story_' . $iso]  = $parse->decodeBBCodes($row['full_story_' . $iso], true, $config['allow_site_wysiwyg']);
		} else {
			$row['short_story_' . $iso] = $parse->decodeBBCodes($row['short_story_' . $iso], false);
			$row['full_story_' . $iso]  = $parse->decodeBBCodes($row['full_story_' . $iso], false);
		}

		$tpl->set('{short-story_' . $iso .'}', $row['short_story_' . $iso]);
		$tpl->set('{full-story_' . $iso .'}', $row['full_story_' . $iso]);
		$tpl->set('{tags_' . $iso .'}', $row['tags_' . $iso]);

		if ($row['votes']) {
			$poll['title_' . $iso]    = $parse->decodeBBCodes($poll['title_' . $iso], false);
			$poll['frage_' . $iso]    = $parse->decodeBBCodes($poll['frage_' . $iso], false);
			$poll['body_' . $iso]     = $parse->decodeBBCodes($poll['body_' . $iso], false);

			$tpl->set('{votetitle_' . $iso .'}', $poll['title_' . $iso]);
			$tpl->set('{frage_' . $iso .'}', $poll['frage_' . $iso]);
			$tpl->set('{votebody_' . $iso .'}', $poll['body_' . $iso]);

		} else {
			$tpl->set('{votetitle_' . $iso .'}', '');
			$tpl->set('{frage_' . $iso .'}', '');
			$tpl->set('{votebody_' . $iso .'}', '');
		}

		if( $config['allow_site_wysiwyg'] ) {

			$tpl->set( '{shortarea_' . $iso .'}', insertEditor('short_story', $iso) );
			$tpl->set( '{fullarea_' . $iso .'}', insertEditor('full_story', $iso) );

		}

	}

}
<?php
////////////////////////////////////////////////////////////
// =======================================================
// Mod: MaHarder Assets
// File: updateNews.php
// Path: D:/OSPanel/domains/dle131.test/engine/inc/maharder/assets/include/modules/addnews/updateNews.php
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

global $user_group, $member_id;

$shortStoryLang = [];
$fullStoryLang = [];
$titleLang = [];
$tagsLang = [];

foreach ($i18n_lang['active'] as $code => $lang_ar) {
	if ($i18n->getLocale() == $code) {
		if( $config['allow_site_wysiwyg'] ) {
			$fullStoryLang[$lang_ar['iso2']] = $db->safesql( $parse->BB_Parse( $parse->process( $_POST['full_story'] ) ) );
			$shortStoryLang[$lang_ar['iso2']] = $db->safesql( $parse->BB_Parse( $parse->process( $_POST['short_story'] ) ) );
		} else {
			$fullStoryLang[$lang_ar['iso2']] = $db->safesql( $parse->BB_Parse( $parse->process( $_POST['full_story'] ), false ) );
			$shortStoryLang[$lang_ar['iso2']] = $db->safesql( $parse->BB_Parse( $parse->process( $_POST['short_story'] ), false ) );
		}

		$titleLang[$lang_ar['iso2']] = $db->safesql( $parse->process( trim( strip_tags ($_POST['title']) ) ) );
		$tagsLang[$lang_ar['iso2']] = $db->safesql( $parse->process( trim( strip_tags ($_POST['tags']) ) ) );
	} else {
		if( $config['allow_site_wysiwyg'] ) {
			$fullStoryLang[$lang_ar['iso2']] = $db->safesql( $parse->BB_Parse( $parse->process( $_POST['full_story_' . $lang_ar['iso2']] ) ) );
			$shortStoryLang[$lang_ar['iso2']] = $db->safesql( $parse->BB_Parse( $parse->process( $_POST['short_story_' . $lang_ar['iso2']] ) ) );
		} else {
			$fullStoryLang[$lang_ar['iso2']] = $db->safesql( $parse->BB_Parse( $parse->process( $_POST['full_story_' . $lang_ar['iso2']]
			), false ) );
			$shortStoryLang[$lang_ar['iso2']] = $db->safesql( $parse->BB_Parse( $parse->process( $_POST['short_story_' . $lang_ar['iso2']] ), false ) );
		}

		$titleLang[$lang_ar['iso2']] = $db->safesql( $parse->process( trim( strip_tags ($_POST['title_' . $lang_ar['iso2']]) ) ) );

		if( ! $config['allow_add_tags'] ) $_POST['tags_' . $lang_ar['iso2']] = "";
		elseif( @preg_match( "/[\||\<|\>|\"|\!|\?|\$|\@|\/|\\\|\~\*\+]/", $_POST['tags_' . $lang_ar['iso2']] ) ) $_POST['tags_' . $lang_ar['iso2']] = "";
		else $_POST['tags_' . $lang_ar['iso2']]= @$db->safesql( htmlspecialchars( strip_tags( stripslashes( trim( $_POST['tags_' . $lang_ar['iso2']] ) ) ), ENT_COMPAT, $config['charset'] ) );

		if ( $_POST['tags_' . $lang_ar['iso2']] ) {

			$temp_array = array();
			$tags_array = array();
			$temp_array = explode (",", $_POST['tags_' . $lang_ar['iso2']]);

			if (count($temp_array)) {

				foreach ( $temp_array as $value ) {
					if( trim($value) ) $tags_array[] = trim( $value );
				}

			}

			if ( count($tags_array) ) $_POST['tags_' . $lang_ar['iso2']] = implode(", ", $tags_array); else $_POST['tags_' . $lang_ar['iso2']] = "";

		}
		$tagsLang[$lang_ar['iso2']] = $_POST['tags_' . $lang_ar['iso2']];
	}

}

$newsAll = [];
foreach ($i18n_lang['active'] as $code => $lang_ar) {
	$iso = $lang_ar['iso2'];
	$newsAll[] = "short_story_{$iso} = '{$shortStoryLang[$iso]}'";
	$newsAll[] = "full_story_{$iso} = '{$fullStoryLang[$iso]}'";
	$newsAll[] = "title_{$iso} = '{$titleLang[$iso]}'";
	$newsAll[] = "tags_{$iso} = '{$tagsLang[$iso]}'";
}
$newsAll = implode(', ', $newsAll);

$dle_prefix = PREFIX;

$db->query("UPDATE {$dle_prefix}_post SET {$newsAll} where id = {$id}" );
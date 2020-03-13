<?php
////////////////////////////////////////////////////////////
// =======================================================
// Mod: MaHarder Assets
// File: search_area.php
// Path: /engine/inc/maharder/assets/include/inc/editnews/search_area.php
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

$searchFullStory = [];
$searchShortStory = [];
$searchTitle = [];
$searchTags = [];

foreach ($i18n_lang['active'] as $code => $lang_ar) {
	if ($i18n->getLocale() == $code) {
		$searchFullStory[] = "full_story LIKE '%{$search_field}%'";
		$searchShortStory[] = "short_story LIKE '%{$search_field}%'";
		$searchTitle[] = "title LIKE '%{$search_field}%'";
		$searchTags[] = "tags LIKE '%{$search_field}%'";
	} else {
		$searchFullStory[]  = "full_story_{$lang_ar['iso2']} LIKE '%{$search_field}%'";
		$searchShortStory[] = "short_story_{$lang_ar['iso2']} LIKE '%{$search_field}%'";
		$searchTitle[]      = "title_{$lang_ar['iso2']} LIKE '%{$search_field}%'";
		$searchTags[] = "tags_{$lang_ar['iso2']} LIKE '%{$search_field}%'";
	}
}

$searchFullStory = implode(' OR ', $searchFullStory);
$searchShortStory = implode(' OR ', $searchShortStory);
$searchTitle = implode(' OR ', $searchTitle);
$searchTags = implode(' OR ', $searchTags);

$fullSearchLang = [
	$searchFullStory,
	$searchShortStory,
	$searchTitle,
	$searchTags
];
$fullSearchLang = implode(' OR ', $fullSearchLang);

if(!$_REQUEST['search_area']) {
	$where[] = "({$fullSearchLang} OR xfields like '%{$search_field}%')";
} elseif($_REQUEST['search_area'] == 1) {
	$where[] = "({$searchTitle})";
} elseif($_REQUEST['search_area'] == 2) {
	$where[] = "({$searchShortStory})";
} elseif($_REQUEST['search_area'] == 3) {
	$where[] = "({$searchFullStory})";
} elseif($_REQUEST['search_area'] == 4) {
	$where[] = "xfields like '%{$search_field}%'";
} elseif($_REQUEST['search_area'] == 5) {
	$where[] = "({$searchFullStory})";
}
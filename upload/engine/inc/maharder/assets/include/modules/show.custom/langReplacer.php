<?php
//===============================================================
// Mod: MaHarder Assets                                         =
// File: langReplacer.php                                       =
// Path: /engine/inc/maharder/assets/include/modules/show.custom/langReplacer.php
// ==============================================================
// Author: Maxim Harder (c) 2020                                =
// Website: https://maxim-harder.de / https://devcraft.club     =
// Telegram: http://t.me/MaHarder                               =
// ==============================================================
// Do not change anything!                                      =
//===============================================================

if( !defined( 'DATALIFEENGINE' ) ) {
	header( "HTTP/1.1 403 Forbidden" );
	header ( 'Location: ../../../../../../' );
	die( "Hacking attempt!" );
}

if (!empty($row['title_' . $i18n_lang['active'][$i18n->getLocale()]['iso2']])) {
	$row['title'] = $row['title_' . $i18n_lang['active'][$i18n->getLocale()]['iso2']];
} elseif (!empty($row['title_' . $i18n_lang['active'][$languages_config['fallback_language']]['iso2']])) {
	$row['title'] = $row['title_' . $i18n_lang['active'][$languages_config['fallback_language']]['iso2']];
}
if (!empty($row['short_story_' . $i18n_lang['active'][$i18n->getLocale()]['iso2']])) {
	$row['short_story'] = $row['short_story_' . $i18n_lang['active'][$i18n->getLocale()]['iso2']];
} elseif (!empty($row['short_story_' . $i18n_lang['active'][$languages_config['fallback_language']]['iso2']])) {
	$row['short_story'] = $row['short_story_' . $i18n_lang['active'][$languages_config['fallback_language']]['iso2']];
}
if (!empty($row['full_story_' . $i18n_lang['active'][$i18n->getLocale()]['iso2']])) {
	$row['full_story'] = $row['full_story_' . $i18n_lang['active'][$i18n->getLocale()]['iso2']];
} elseif (!empty($row['short_story_' . $i18n_lang['active'][$languages_config['fallback_language']]['iso2']])) {
	$row['full_story'] = $row['full_story_' . $i18n_lang['active'][$languages_config['fallback_language']]['iso2']];
}
if (!empty($row['description_' . $i18n_lang['active'][$i18n->getLocale()]['iso2']])) {
	$row['description'] = $row['description_' . $i18n_lang['active'][$i18n->getLocale()]['iso2']];
} elseif (!empty($row['short_story_' . $i18n_lang['active'][$languages_config['fallback_language']]['iso2']])) {
	$row['description'] = $row['description_' . $i18n_lang['active'][$languages_config['fallback_language']]['iso2']];
}
if (!empty($row['descr_' . $i18n_lang['active'][$i18n->getLocale()]['iso2']])) {
	$row['descr'] = $row['descr_' . $i18n_lang['active'][$i18n->getLocale()]['iso2']];
} elseif (!empty($row['descr_' . $i18n_lang['active'][$languages_config['fallback_language']]['iso2']])) {
	$row['descr'] = $row['descr_' . $i18n_lang['active'][$languages_config['fallback_language']]['iso2']];
}
if (!empty($row['metatitle_' . $i18n_lang['active'][$i18n->getLocale()]['iso2']])) {
	$row['metatitle'] = $row['metatitle_' . $i18n_lang['active'][$i18n->getLocale()]['iso2']];
} elseif (!empty($row['metatitle_' . $i18n_lang['active'][$languages_config['fallback_language']]['iso2']])) {
	$row['metatitle'] = $row['metatitle_' . $i18n_lang['active'][$languages_config['fallback_language']]['iso2']];
}
if (!empty($row['tags_' . $i18n_lang['active'][$i18n->getLocale()]['iso2']])) {
	$row['tags'] = $row['tags_' . $i18n_lang['active'][$i18n->getLocale()]['iso2']];
} elseif (!empty($row['tags_' . $i18n_lang['active'][$languages_config['fallback_language']]['iso2']])) {
	$row['tags'] = $row['tags_' . $i18n_lang['active'][$languages_config['fallback_language']]['iso2']];
}
if (!empty($row['keywords_' . $i18n_lang['active'][$i18n->getLocale()]['iso2']])) {
	$row['keywords'] = $row['keywords_' . $i18n_lang['active'][$i18n->getLocale()]['iso2']];
} elseif (!empty($row['keywords_' . $i18n_lang['active'][$languages_config['fallback_language']]['iso2']])) {
	$row['keywords'] = $row['keywords_' . $i18n_lang['active'][$languages_config['fallback_language']]['iso2']];
}
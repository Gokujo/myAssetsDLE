<?php
//===============================================================
// Mod: MaHarder Assets                                         =
// File: langReplacerRelated.php                                =
// Path: D:/OSPanel/domains/dle140.local/engine/inc/maharder/assets/include/modules/show.full/langReplacerRelated.php
// ============================================================ =
// Author: Maxim Harder (c) 2020                                =
// Website: https://maxim-harder.de / https://devcraft.club     =
// Telegram: http://t.me/MaHarder                               =
// ============================================================ =
// Do not change anything!                                      =
//===============================================================

if( !defined( 'DATALIFEENGINE' ) ) {
	header( "HTTP/1.1 403 Forbidden" );
	header ( 'Location: ../../../../../../' );
	die( "Hacking attempt!" );
}

if (!empty($related['title_' . $i18n_lang['active'][$i18n->getLocale()]['iso2']])) {
	$related['title'] = $related['title_' . $i18n_lang['active'][$i18n->getLocale()]['iso2']];
} elseif (!empty($related['title_' . $i18n_lang['active'][$languages_config['fallback_language']]['iso2']])) {
	$related['title'] = $related['title_' . $i18n_lang['active'][$languages_config['fallback_language']]['iso2']];
}
if (!empty($related['short_story_' . $i18n_lang['active'][$i18n->getLocale()]['iso2']])) {
	$related['short_story'] = $related['short_story_' . $i18n_lang['active'][$i18n->getLocale()]['iso2']];
} elseif (!empty($related['short_story_' . $i18n_lang['active'][$languages_config['fallback_language']]['iso2']])) {
	$related['short_story'] = $related['short_story_' . $i18n_lang['active'][$languages_config['fallback_language']]['iso2']];
}
if (!empty($related['full_story_' . $i18n_lang['active'][$i18n->getLocale()]['iso2']])) {
	$related['full_story'] = $related['full_story_' . $i18n_lang['active'][$i18n->getLocale()]['iso2']];
} elseif (!empty($related['short_story_' . $i18n_lang['active'][$languages_config['fallback_language']]['iso2']])) {
	$related['full_story'] = $related['full_story_' . $i18n_lang['active'][$languages_config['fallback_language']]['iso2']];
}
if (!empty($related['description_' . $i18n_lang['active'][$i18n->getLocale()]['iso2']])) {
	$related['description'] = $related['description_' . $i18n_lang['active'][$i18n->getLocale()]['iso2']];
} elseif (!empty($related['short_story_' . $i18n_lang['active'][$languages_config['fallback_language']]['iso2']])) {
	$related['description'] = $related['description_' . $i18n_lang['active'][$languages_config['fallback_language']]['iso2']];
}
if (!empty($related['descr_' . $i18n_lang['active'][$i18n->getLocale()]['iso2']])) {
	$related['descr'] = $related['descr_' . $i18n_lang['active'][$i18n->getLocale()]['iso2']];
} elseif (!empty($related['descr_' . $i18n_lang['active'][$languages_config['fallback_language']]['iso2']])) {
	$related['descr'] = $related['descr_' . $i18n_lang['active'][$languages_config['fallback_language']]['iso2']];
}
if (!empty($related['metatitle_' . $i18n_lang['active'][$i18n->getLocale()]['iso2']])) {
	$related['metatitle'] = $related['metatitle_' . $i18n_lang['active'][$i18n->getLocale()]['iso2']];
} elseif (!empty($related['metatitle_' . $i18n_lang['active'][$languages_config['fallback_language']]['iso2']])) {
	$related['metatitle'] = $related['metatitle_' . $i18n_lang['active'][$languages_config['fallback_language']]['iso2']];
}
if (!empty($related['tags_' . $i18n_lang['active'][$i18n->getLocale()]['iso2']])) {
	$related['tags'] = $related['tags_' . $i18n_lang['active'][$i18n->getLocale()]['iso2']];
} elseif (!empty($related['tags_' . $i18n_lang['active'][$languages_config['fallback_language']]['iso2']])) {
	$related['tags'] = $related['tags_' . $i18n_lang['active'][$languages_config['fallback_language']]['iso2']];
}
if (!empty($related['keywords_' . $i18n_lang['active'][$i18n->getLocale()]['iso2']])) {
	$related['keywords'] = $related['keywords_' . $i18n_lang['active'][$i18n->getLocale()]['iso2']];
} elseif (!empty($related['keywords_' . $i18n_lang['active'][$languages_config['fallback_language']]['iso2']])) {
	$related['keywords'] = $related['keywords_' . $i18n_lang['active'][$languages_config['fallback_language']]['iso2']];
}
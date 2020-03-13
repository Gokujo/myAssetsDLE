<?php
//===============================================================
// Mod: MaHarder Assets                                         =
// File: replacer.php                                           =
// Path: /engine/inc/maharder/assets/include/modules/static/replacer.php
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

if (!empty($static_result['template_' . $i18n_lang['active'][$i18n->getLocale()]['iso2']])) {
	$static_result['template'] = $static_result['template_' . $i18n_lang['active'][$i18n->getLocale()]['iso2']];
} elseif (!empty($related['template_' . $i18n_lang['active'][$languages_config['fallback_language']]['iso2']])) {
	$static_result['template'] = $static_result['template_' . $i18n_lang['active'][$languages_config['fallback_language']]['iso2']];
}

if (!empty($static_result['descr_' . $i18n_lang['active'][$i18n->getLocale()]['iso2']])) {
	$static_result['descr'] = $static_result['descr_' . $i18n_lang['active'][$i18n->getLocale()]['iso2']];
} elseif (!empty($related['descr_' . $i18n_lang['active'][$languages_config['fallback_language']]['iso2']])) {
	$static_result['descr'] = $static_result['descr_' . $i18n_lang['active'][$languages_config['fallback_language']]['iso2']];
}

if (!empty($static_result['metadescr_' . $i18n_lang['active'][$i18n->getLocale()]['iso2']])) {
	$static_result['metadescr'] = $static_result['metadescr_' . $i18n_lang['active'][$i18n->getLocale()]['iso2']];
} elseif (!empty($related['metadescr_' . $i18n_lang['active'][$languages_config['fallback_language']]['iso2']])) {
	$static_result['metadescr'] = $static_result['metadescr_' . $i18n_lang['active'][$languages_config['fallback_language']]['iso2']];
}

if (!empty($static_result['metakeys_' . $i18n_lang['active'][$i18n->getLocale()]['iso2']])) {
	$static_result['metakeys'] = $static_result['metakeys_' . $i18n_lang['active'][$i18n->getLocale()]['iso2']];
} elseif (!empty($related['metakeys_' . $i18n_lang['active'][$languages_config['fallback_language']]['iso2']])) {
	$static_result['metakeys'] = $static_result['metakeys_' . $i18n_lang['active'][$languages_config['fallback_language']]['iso2']];
}

if (!empty($static_result['metatitle_' . $i18n_lang['active'][$i18n->getLocale()]['iso2']])) {
	$static_result['metatitle'] = $static_result['metatitle_' . $i18n_lang['active'][$i18n->getLocale()]['iso2']];
} elseif (!empty($related['metatitle_' . $i18n_lang['active'][$languages_config['fallback_language']]['iso2']])) {
	$static_result['metatitle'] = $static_result['metatitle_' . $i18n_lang['active'][$languages_config['fallback_language']]['iso2']];
}
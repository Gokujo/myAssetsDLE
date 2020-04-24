<?php
////////////////////////////////////////////////////////////
// =======================================================
// Модуль: MaHarder Assets
// Файл: languages.php
// Путь: /engine/inc/maharder/assets/languages.php
// =======================================================
// Автор: Maxim Harder (c) 2020
// Сайт: https://maxim-harder.de / https://devcraft.club
// Телеграм: http://t.me/MaHarder
// =======================================================
// Ничего не менять
// =======================================================
////////////////////////////////////////////////////////////

require_once (DLEPlugins::Check(__DIR__ . DIRECTORY_SEPARATOR . 'classes.php'));

if (!defined('MH_DIR')) {
	define('MH_DIR', realpath(__DIR__));
}

$langConfig = '';
$startApp = false;
if(file_exists(ROOT_DIR.'/engine/inc/maharder/config/maharder.json')) {
	$langConfig = json_decode(file_get_contents(DLEPlugins::Check(ROOT_DIR.'/engine/inc/maharder/config/maharder.json')), true);
	$startApp = true;
}

if(!file_exists(ROOT_DIR.'/engine/inc/maharder/config/maharder.json') || empty($langConfig)) {
	$startApp = false;
	if($_GET['mod'] != 'maharder')
		header( "Location: {$_SERVER['PHP_SELF']}?mod=maharder" );
}

if($langConfig['debug']) {
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
}
$db->query('SELECT * FROM ' . PREFIX . '_languages');
$i18n_lang = [
	'names' => [],
	'names_all' => [],
	'active' => [],
	'all' => [],
	'codes' => [],
	'codes_all' => [],
	'iso' => [],
	'iso_all' => [],
];

$count = 0;
while ($lng = $db->get_array()){
	if ($lng['active'] == 1) {
		$i18n_lang['names'][$count]['id'] = (int)$lng['id'];
		$i18n_lang['names'][$count]['name'] = $lng['name'] . ' / ' . $lng['international'] . ' (' . $lng['code'] . ')';
		$i18n_lang['names'][$count]['code'] = $lng['code'];
		$i18n_lang['active'][$lng['code']] = $lng;
		$i18n_lang['iso'][$lng['iso2']] = $lng;
		$i18n_lang['codes'][$count] = $lng['code'];
		$i18n_lang['isos'][$count] = $lng['iso2'];
	}
	$i18n_lang['names_all'][$count]['id'] = (int)$lng['id'];
	$i18n_lang['names_all'][$count]['name'] = $lng['name'] . ' / ' . $lng['international'] . ' (' . $lng['code'] . ')';
	$i18n_lang['all'][$lng['code']] = $lng;
	$i18n_lang['iso_all'][$lng['iso2']] = $lng;
	$i18n_lang['codes_all'][$count] = $lng['code'];
	$i18n_lang['isos_all'][$count] = $lng['iso2'];
	$count++;
}

$languages_config = [
	'languages' => ((count($i18n_lang['codes']) > 0) ? $i18n_lang['codes'] :['ru_RU', 'de_DE', 'en_GB']),
	'fallback_language' => str_replace('-', '_', ($langConfig['fallback_language'] ? $langConfig['fallback_language'] : 'de_DE')),
	'use_language' => str_replace('-', '_', ($_COOKIE[$langConfig['cookieField']] ? $_COOKIE[$langConfig['cookieField']] : 'ru_RU')),
	'default_language' => str_replace('-', '_', ($langConfig['default_language'] ? $langConfig['default_language'] : 'ru_RU')),
	'path' => ROOT_DIR . DIRECTORY_SEPARATOR .  ($langConfig['path'] ? $langConfig['path'] : 'locale'),
	'module' => 'messages',
	'cookieField' => ($langConfig['cookieField'] ? $langConfig['cookieField'] : 'dle_lang'),
];

if($startApp) {


	$langID = [];

	if (isset($_GET['sprache'])) {
		if (in_array($_GET['sprache'], $i18n_lang['isos'][$_GET['sprache']])) {
			$langID = $i18n_lang['iso'][$_GET['sprache']];
		}
	} else {
		if (!isset($_COOKIE[$languages_config['cookieField']])) {
			$langID = $i18n_lang['all'][$languages_config['default_language']];
		} else {
			$langID = $i18n_lang['all'][$languages_config['use_language']];
		}
	}

	$useLang = [
		$langID['code'] => [
			'name' => $i18n_lang['active'][$langID['code']]['international'],
			'short' => $i18n_lang['active'][$langID['code']]['iso2']
		]
	];

	$fallBack = [
		$languages_config['fallback_language'] => [
			'name' => $i18n_lang['active'][$languages_config['fallback_language']]['international'],
			'short' => $i18n_lang['active'][$languages_config['fallback_language']]['iso2']
		]
	];

	$allLangs = [];

	foreach ($i18n_lang['active'] as $lang => $arr) {
		$allLangs[$lang] = [
			'name' => $arr['international'],
			'short' => $arr['iso2']
		];
	}

	$i18n = new langPlugin($useLang, $allLangs, $languages_config['module'], $languages_config['path'], $fallBack, $languages_config['cookieField']);

	if ($i18n->getLocale() == $languages_config['fallback_language']) {
		$languages_config['fallback_language'] = $languages_config['default_language'];
		$fallBack = [
			$languages_config['fallback_language'] => [
				'name' => $i18n_lang['active'][$languages_config['fallback_language']]['international'],
				'short' => $i18n_lang['active'][$languages_config['fallback_language']]['iso2']
			]
		];
		$i18n->setFallBack($fallBack);
	}
	$cookie_lifetime = (24*60*60);
	if(!isset($_COOKIE[$languages_config['cookieField']]) || $_SESSION[$languages_config['cookieField']] != $langID['code']) {

		$i18n->setLocale($useLang);
		$i18n->setCookieName($languages_config['cookieField'], $cookie_lifetime);
		clear_all_caches();

	}
	set_cookie('selected_language', (empty($i18n_lang['active'][$i18n->getLocale()]['dir'])? 'Russian' : $i18n_lang['active'][$i18n->getLocale()]['dir']), $cookie_lifetime);
	$config['langs'] = $i18n_lang['active'][$i18n->getLocale()]['dir'];

}

if (!function_exists('translate')) {
	/**
	 * @param $message
	 *
	 * @return mixed
	 */
	function translate ($message) {
		global $i18n;
		if (empty($i18n)) return $message;
		return $i18n->translate($message);
	}
}
$translator = new translator($langConfig['translateEngine'], $langConfig['transAPI'], $i18n_lang['active'][$i18n->getLocale()]['iso2']);

if (!function_exists('setTranslator')) {
	/**
	 * @param $lang
	 * @param $input
	 *
	 * @return string
	 */
	function setTranslator($lang, $input) {
		global $langConfig, $dle_login_hash;

		if ($langConfig['translator']) {
			return "<br>
					<i class=\"far fa-language\"></i> <a data-action=\"translate\" data-lang=\"{$lang}\" data-input=\"{$input}\" data-hash=\"{$dle_login_hash}\"> " .translate('Перевести') . "</a>";
		}

		return '';
	}
}
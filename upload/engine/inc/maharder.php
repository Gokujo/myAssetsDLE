<?php
////////////////////////////////////////////////////////////
// =======================================================
// Модуль: dle131.test
// Файл: maharder.php
// Путь: D:/OSPanel/domains/dle131.test/engine/inc/maharder.php
// =======================================================
// Автор: Maxim Harder (c) 2020
// Сайт: https://maxim-harder.de / https://devcraft.club
// Телеграм: http://t.me/MaHarder
// =======================================================
// Ничего не менять
// =======================================================
////////////////////////////////////////////////////////////

if (!defined('DATALIFEENGINE')) die("Oh! You little bastard!");


$codename = 'maharder';
require_once (DLEPlugins::Check(__DIR__ . '/maharder/assets/classes.php'));
require_once (DLEPlugins::Check(__DIR__ . '/maharder/assets/functions.php'));
require_once (DLEPlugins::Check(__DIR__ . '/maharder/' . $codename . '/version.php'));

$adminlink = '?mod='.$codename;
$concurrentDirectory = __DIR__.'/maharder/config';
mkdir_p($concurrentDirectory);

$mod_admin = new mhAdmin();
$mod_config = $mod_admin->getConfig($concurrentDirectory, $codename);

switch ($_GET['section']) {

	case 'languages':
		include(DLEPlugins::Check(ENGINE_DIR.'/inc/maharder/'.$codename.'/languages.php'));
		break;

	default:
		require_once (DLEPlugins::Check(ENGINE_DIR.'/inc/maharder/'.$codename.'/default.php'));
		break;
}


echofooter();

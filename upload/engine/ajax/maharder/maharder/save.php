<?php

	//	===============================
	//	Настройки модуля | сохраняем
	//	===============================
	//	Автор: Maxim Harder
	//	Сайт: https://maxim-harder.de
	//	Телеграм: http://t.me/MaHarder
	//	===============================
	//	Ничего не менять
	//	===============================
	if(!defined('DATALIFEENGINE')) {
		header( "HTTP/1.1 403 Forbidden" );
		header ( 'Location: ../../../../' );
		die( "Hacking attempt!" );
	}

	if( !$is_logged ) die('error');

	if( $_REQUEST['user_hash'] == '' OR $_REQUEST['user_hash'] != $dle_login_hash ) {
		die('error');
	}

	$method = $_POST['method'];
	if(!$method) {
		die();
	}
	$save_con = $_POST['data'];

	switch ($method) {

		default:
		case 'settings':
			@mkdir(ENGINE_DIR . '/inc/maharder/config');
			$file = ENGINE_DIR . '/inc/maharder/config/'.$_POST['module'].'.json';
			$arr = array();
			var_dump($file);

			foreach ($save_con as $id => $d) {
				$name = $d['name'];
				$value = $d['value'];
				$value = htmlspecialchars($value);
				$arr[$name] = $value;
			}
			$arr = json_encode($arr);
			file_put_contents($file, $arr);
			clear_cache();

			echo 'ok';

			break;

	}

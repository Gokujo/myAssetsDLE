<?php
////////////////////////////////////////////////////////////
// =======================================================
// Mod: MaHarder Assets
// File: languages.php
// Path: /engine/ajax/maharder/maharder/languages.php
// =======================================================
// Author: Maxim Harder (c) 2020
// Website: https://maxim-harder.de / https://devcraft.club
// Telegram: http://t.me/MaHarder
// =======================================================
// Do not change anything!
// =======================================================
////////////////////////////////////////////////////////////

if(!defined('DATALIFEENGINE')) {
	header( "HTTP/1.1 403 Forbidden" );
	header ( 'Location: ../../../../' );
	die( "Hacking attempt!" );
}

global $i18n;

if( !$is_logged ) die( "error" );

if( $_REQUEST['user_hash'] == '' OR $_REQUEST['user_hash'] != $dle_login_hash ) {
	die('error');
}

$action = $_POST['action'];
if(!$action) {
	die();
}


$code = trim(strip_tags($_POST['code']));
$flag = trim(strip_tags($_POST['flag']));
$name = trim(strip_tags($_POST['name']));

$international = trim(strip_tags($_POST['international']));
$iso2 = strtolower(trim(strip_tags($_POST['iso2'])));
$dir = trim(strip_tags($_POST['dir']));
$active = ($_POST['active'] == 'on' ? true : false);
if (empty($flag)) $flag = '/uploads/maharder/flags/' . $iso2 . '.png';

function deleteTable($table, $column, $lang, $prefix = PREFIX) {
	return "CALL DropColumnIfExists('{$prefix}_{$table}', '{$column}_{$lang}');";
}

function alterTable($table, $column, $lang, $params, $prefix = PREFIX) {
	return "alter table {$prefix}_{$table} add {$column}_{$lang} {$params}";
}

function redoTable($onlyNew = false, $table, $column, $lang, $params = '', $prefix = PREFIX) {
	if ($onlyNew === false || $onlyNew === 0) {
		return [
			deleteTable($table, $column, $lang),
			alterTable($table, $column, $lang, $params)
		];
	}
	return  "CALL RedoColumns('{$prefix}_{$table}', '{$column}_{$lang}', \"{$params}\");";
}

switch ($action) {

	case 'save':

		try {
			$id = (int)$_POST['id'];
			$db->query('UPDATE '. PREFIX . "_languages SET code = '{$code}', flag = '{$flag}', name = '{$name}', iso2 = '{$iso2}', dir = '{$dir}', active = {$active}, international = '{$international}' WHERE id = {$id}");
			$i18n->generatePhrases();
			echo 'ok';
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}

		break;

	case 'delete':

		try {
			$id = (int)$_POST['id'];
			$db->super_query('DELETE FROM '. PREFIX . "_languages WHERE id = {$id}");
			$dbChanges = [
				deleteTable('banners', 'descr', $iso2),
				deleteTable('banners_rubrics', 'title', $iso2),
				deleteTable('banners_rubrics', 'description', $iso2),
				deleteTable('category', 'name', $iso2),
				deleteTable('category', 'descr', $iso2),
				deleteTable('category', 'metatitle', $iso2),
				deleteTable('category', 'fulldescr', $iso2),
				deleteTable('email', 'template', $iso2),
				deleteTable('metatags', 'title', $iso2),
				deleteTable('metatags', 'description', $iso2),
				deleteTable('metatags', 'keywords', $iso2),
				deleteTable('metatags', 'page_title', $iso2),
				deleteTable('metatags', 'page_description', $iso2),
				deleteTable('poll', 'title', $iso2),
				deleteTable('poll', 'frage', $iso2),
				deleteTable('poll', 'body', $iso2),
				deleteTable('post', 'short_story', $iso2),
				deleteTable('post', 'full_story', $iso2),
				deleteTable('post', 'title', $iso2),
				deleteTable('post', 'description', $iso2),
				deleteTable('post', 'keywords', $iso2),
				deleteTable('post', 'metatitle', $iso2),
				deleteTable('post', 'descr', $iso2),
				deleteTable('post', 'tags', $iso2),
				deleteTable('post_extras', 'reason', $iso2),
				deleteTable('question', 'question', $iso2),
				deleteTable('question', 'answer', $iso2),
				deleteTable('rss', 'description', $iso2),
				deleteTable('rss', 'search', $iso2),
				deleteTable('rssinform', 'descr', $iso2),
				deleteTable('static', 'descr', $iso2),
				deleteTable('static', 'template', $iso2),
				deleteTable('static', 'metadescr', $iso2),
				deleteTable('static', 'metakeys', $iso2),
				deleteTable('static', 'metatitle', $iso2),
				deleteTable('tags', 'tag', $iso2),
				deleteTable('vote', 'title', $iso2),
				deleteTable('vote', 'body', $iso2),
				deleteTable('usergroups', 'group_name', $iso2),
				deleteTable('xfsearch', 'tagvalue', $iso2),
			];
			
			//
			// deleteTables includes
			//

			foreach ($dbChanges as $change) {
				$db->query($change);
			}
			echo 'ok';
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}

		break;

	case 'new':

		try {
			$db->super_query('INSERT INTO '. PREFIX . "_languages (code, flag, name, iso2, dir, active, international) VALUES ('{$code}', '{$flag}', '{$name}', '{$iso2}', '{$dir}', {$active}, '{$international}')");

			$dbChanges = [
				alterTable('banners', 'descr', $iso2, "varchar(200) default '' null;"),
				alterTable('banners_rubrics', 'title', $iso2, "varchar(70) default '' null;"),
				alterTable('banners_rubrics', 'description', $iso2, "varchar(255) default '' null;"),
				alterTable('category', 'name', $iso2, "varchar(50) default '' null;"),
				alterTable('category', 'descr', $iso2, "varchar(300) default '' null;"),
				alterTable('category', 'metatitle', $iso2, "varchar(255) default '' null;"),
				alterTable('category', 'fulldescr', $iso2, "text NULL;"),
				alterTable('email', 'template', $iso2, "text NULL;"),
				alterTable('metatags', 'title', $iso2, "varchar(200) default '' null;"),
				alterTable('metatags', 'description', $iso2, "varchar(300) default '' null;"),
				alterTable('metatags', 'keywords', $iso2, "text NULL;"),
				alterTable('metatags', 'page_title', $iso2, "varchar(255) default '' null;"),
				alterTable('metatags', 'page_description', $iso2, "text NULL;"),
				alterTable('poll', 'title', $iso2, "varchar(200) default '' null;"),
				alterTable('poll', 'frage', $iso2, "varchar(200) default '' null;"),
				alterTable('poll', 'body', $iso2, "text NULL;"),
				alterTable('post', 'short_story', $iso2, "mediumtext NULL;"),
				alterTable('post', 'full_story', $iso2, "mediumtext NULL;"),
				alterTable('post', 'title', $iso2, "varchar(255) default '' null;"),
				alterTable('post', 'description', $iso2, "varchar(300) default '' null;"),
				alterTable('post', 'descr', $iso2, "varchar(300) default '' null;"),
				alterTable('post', 'metatitle', $iso2, "varchar(255) default '' null;"),
				alterTable('post', 'tags', $iso2, "varchar(255) default '' null;"),
				alterTable('post', 'keywords', $iso2, "text NULL;"),
				alterTable('post_extras', 'reason', $iso2, "varchar(255) default '' null;"),
				alterTable('question', 'question', $iso2, "varchar(255) default '' null;"),
				alterTable('question', 'answer', $iso2, "text NULL;"),
				alterTable('rss', 'description', $iso2, "text NULL;"),
				alterTable('rss', 'search', $iso2, "text NULL;"),
				alterTable('rssinform', 'descr', $iso2, "varchar(255) default '' null;"),
				alterTable('static', 'descr', $iso2, "varchar(255) default '' null;"),
				alterTable('static', 'template', $iso2, "mediumtext NULL;"),
				alterTable('static', 'metadescr', $iso2, "varchar(300) default '' null;"),
				alterTable('static', 'metakeys', $iso2, "text NULL;"),
				alterTable('static', 'metatitle', $iso2, "varchar(255) default '' null;"),
				alterTable('tags', 'tag', $iso2, "varchar(100) default '' null;"),
				alterTable('vote', 'title', $iso2, "varchar(200) default '' null;"),
				alterTable('vote', 'body', $iso2, "text null;"),
				alterTable('usergroups', 'group_name', $iso2, "varchar(50) default '' null;"),
				alterTable('xfsearch', 'tagvalue', $iso2, "varchar(100) default '' null;"),
			];
			
			//
			// alterTables includes
			//

			foreach ($dbChanges as $change) {
				$db->query($change);
			}
			$i18n->generatePhrases();
			echo 'ok';
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}

		break;

	case 'saveAll':

		if (!$_POST['data']) return;
		$data = json_decode($_POST['data'], true);

		foreach ($data as $key => $val) {
			$id = (int)$val['id'];
			$code = trim(strip_tags($val['code']));
			$flag = trim(strip_tags($val['flag']));
			$name = trim(strip_tags($val['name']));
			$international = trim(strip_tags($val['international']));
			$iso2 = strtolower(trim(strip_tags($val['iso2'])));
			$dir = trim(strip_tags($val['dir']));
			$active = ($val['active'] == 'on' ? true : false);

			if (empty($flag)) $flag = '/uploads/maharder/flags/' . $iso2 . '.png';

			$db->query('UPDATE '. PREFIX . "_languages SET code = '{$code}', flag = '{$flag}', name = '{$name}', iso2 = '{$iso2}', dir = '{$dir}', active = {$active}, international = '{$international}' WHERE id = {$id}");
		}
		$i18n->generatePhrases();

		echo 'ok';

		break;

	case 'redo':
		$checkedOnly = ($_POST['onlyNew'] == 'on');
		$dbChanges = [
			redoTable($checkedOnly, 'banners', 'descr', $iso2, "varchar(200) default '' null;"),
			redoTable($checkedOnly, 'banners_rubrics', 'title', $iso2, "varchar(70) default '' null;"),
			redoTable($checkedOnly, 'banners_rubrics', 'description', $iso2, "varchar(255) default '' null;"),
			redoTable($checkedOnly, 'category', 'name', $iso2, "varchar(50) default '' null;"),
			redoTable($checkedOnly, 'category', 'descr', $iso2, "varchar(300) default '' null;"),
			redoTable($checkedOnly, 'category', 'metatitle', $iso2, "varchar(255) default '' null;"),
			redoTable($checkedOnly, 'category', 'fulldescr', $iso2, "text NULL;"),
			redoTable($checkedOnly, 'category', 'keywords', $iso2, "text NULL;"),
			redoTable($checkedOnly, 'email', 'template', $iso2, "text NULL;"),
			redoTable($checkedOnly, 'metatags', 'title', $iso2, "varchar(200) default '' null;"),
			redoTable($checkedOnly, 'metatags', 'description', $iso2, "varchar(300) default '' null;"),
			redoTable($checkedOnly, 'metatags', 'keywords', $iso2, "text NULL;"),
			redoTable($checkedOnly, 'metatags', 'page_title', $iso2, "varchar(255) default '' null;"),
			redoTable($checkedOnly, 'metatags', 'page_description', $iso2, "text NULL;"),
			redoTable($checkedOnly, 'poll', 'title', $iso2, "varchar(200) default '' null;"),
			redoTable($checkedOnly, 'poll', 'frage', $iso2, "varchar(200) default '' null;"),
			redoTable($checkedOnly, 'poll', 'body', $iso2, "text NULL;"),
			redoTable($checkedOnly, 'post', 'short_story', $iso2, "mediumtext NULL;"),
			redoTable($checkedOnly, 'post', 'full_story', $iso2, "mediumtext NULL;"),
			redoTable($checkedOnly, 'post', 'title', $iso2, "varchar(255) default '' null;"),
			redoTable($checkedOnly, 'post', 'description', $iso2, "varchar(300) default '' null;"),
			redoTable($checkedOnly, 'post', 'descr', $iso2, "varchar(300) default '' null;"),
			redoTable($checkedOnly, 'post', 'metatitle', $iso2, "varchar(255) default '' null;"),
			redoTable($checkedOnly, 'post', 'tags', $iso2, "varchar(255) default '' null;"),
			redoTable($checkedOnly, 'post', 'keywords', $iso2, "text NULL;"),
			redoTable($checkedOnly, 'post_extras', 'reason', $iso2, "varchar(255) default '' null;"),
			redoTable($checkedOnly, 'question', 'question', $iso2, "varchar(255) default '' null;"),
			redoTable($checkedOnly, 'question', 'answer', $iso2, "text NULL;"),
			redoTable($checkedOnly, 'rss', 'description', $iso2, "text NULL;"),
			redoTable($checkedOnly, 'rss', 'search', $iso2, "text NULL;"),
			redoTable($checkedOnly, 'rssinform', 'descr', $iso2, "varchar(255) default '' null;"),
			redoTable($checkedOnly, 'static', 'descr', $iso2, "varchar(255) default '' null;"),
			redoTable($checkedOnly, 'static', 'template', $iso2, "mediumtext NULL;"),
			redoTable($checkedOnly, 'static', 'metadescr', $iso2, "varchar(300) default '' null;"),
			redoTable($checkedOnly, 'static', 'metakeys', $iso2, "text NULL;"),
			redoTable($checkedOnly, 'static', 'metatitle', $iso2, "varchar(255) default '' null;"),
			redoTable($checkedOnly, 'tags', 'tag', $iso2, "varchar(100) default '' null;"),
			redoTable($checkedOnly, 'vote', 'title', $iso2, "varchar(200) default '' null;"),
			redoTable($checkedOnly, 'vote', 'body', $iso2, "text null;"),
			redoTable($checkedOnly, 'usergroups', 'group_name', $iso2, "varchar(50) default '' null;"),
			redoTable($checkedOnly, 'xfsearch', 'tagvalue', $iso2, "varchar(100) default '' null;"),
		];
		
		//
		// redoTables includes
		//

		foreach ($dbChanges as $change) {
			if(is_array($change)) {
				foreach ($change as $ch) {
					try {
						$db->super_query($ch);
					} catch (Exception $e) {
						continue;
					}
				}
			} else {
				try {
					$db->super_query($change);
				} catch (Exception $e) {
					continue;
				}
			}
		}

		$i18n->generatePhrases();
		echo 'ok';

		break;

	case 'rebuild_lang':
		$i18n->generatePhrases();
		echo 'ok';
		break;

	case 'translate':
		echo $i18n->translate($_POST['wort']);
		break;

	
	case 'translator':
		$translator->setTo($_POST['langInto']);
		try {
			echo json_encode($translator->translate( $_POST['text'] ));
		} catch ( Exception $e ) {
			echo $e->getMessage();
		}
		break;
}
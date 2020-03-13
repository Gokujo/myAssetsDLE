<?php
////////////////////////////////////////////////////////////
// =======================================================
// Mod: MaHarder Assets
// File: post.php
// Path: /engine/inc/maharder/assets/include/inc/editnews/post.php
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

$shortStoryLang = [];
$fullStoryLang  = [];
$titleLang      = [];
$metatagsLang   = [];
$tagsLang       = [];

function create_metatags_lang ($story, $lang, $ajax = false) {
	global $config, $db;

	$keyword_count = 20;
	$newarr        = [];
	$headers       = [];
	$quotes        = ["\x22", "\x60", "\t", '\n', '\r', "\n", "\r", "\\", ",", ".", "/", "#", ";", ":", "@", "~", "[", "]", "{", "}", "=", "-", "+", ")", "(", "*", "^", "%", "$", "<", ">", "?", "!", '"'];
	$fastquotes    = ["\x22", "\x60", "\t", "\n", "\r", '"', '\r', '\n', "$", "{", "}", "[", "]", "<", ">", "\\"];

	$story = preg_replace("#\[hide(.*?)\](.+?)\[/hide\]#is", "", $story);
	$story = preg_replace("'\[attachment=(.*?)\]'si", "", $story);
	$story = preg_replace("'\[page=(.*?)\](.*?)\[/page\]'si", "", $story);
	$story = str_replace("{PAGEBREAK}", "", $story);
	$story = str_replace("&nbsp;", " ", $story);

	$story = str_replace('<br />', ' ', $story);
	$story = str_replace('<br>', ' ', $story);
	$story = strip_tags($story);
	$story = preg_replace("#&(.+?);#", "", $story);
	$story = trim(str_replace(" ,", "", $story));

	if (trim($_REQUEST['meta_title'])) {

		$headers['title'] = trim(htmlspecialchars(strip_tags(stripslashes($_REQUEST['meta_title_'.$lang])),
			ENT_COMPAT, $config['charset']));
		$headers['title'] = $db->safesql(str_replace($fastquotes, '', $headers['title']));

	} else $headers['title'] = "";

	if (trim($_REQUEST['descr'])) {

		$headers['description'] = trim(strip_tags(stripslashes($_REQUEST['descr_'.$lang])));

		if (dle_strlen($headers['description'], $config['charset']) > 300) {

			$headers['description'] = dle_substr($headers['description'], 0, 300, $config['charset']);

			if (($temp_dmax = dle_strrpos($headers['description'], ' ', $config['charset']))) $headers['description'] = dle_substr($headers['description'], 0, $temp_dmax, $config['charset']);

		}

		$headers['description'] = $db->safesql(str_replace($fastquotes, '', $headers['description']));

	} elseif ($config['create_metatags'] OR $ajax) {

		$story = str_replace($fastquotes, '', $story);

		$headers['description'] = stripslashes($story);

		if (dle_strlen($headers['description'], $config['charset']) > 300) {

			$headers['description'] = dle_substr($headers['description'], 0, 300, $config['charset']);

			if (($temp_dmax = dle_strrpos($headers['description'], ' ', $config['charset']))) $headers['description'] = dle_substr($headers['description'], 0, $temp_dmax, $config['charset']);

		}

		$headers['description'] = $db->safesql($headers['description']);

	} else {

		$headers['description'] = '';

	}

	if (trim($_REQUEST['keywords_'.$lang])) {

		$arr    = explode(",", $_REQUEST['keywords_'.$lang]);
		$newarr = [];

		foreach ($arr as $word) {
			$newarr[] = trim($word);
		}

		$_REQUEST['keywords_'.$lang] = implode(", ", $newarr);

		$headers['keywords'] = $db->safesql(str_replace($fastquotes, " ", strip_tags(stripslashes($_REQUEST['keywords_'.$lang]))));

	} elseif ($config['create_metatags'] OR $ajax) {

		$story = str_replace($quotes, ' ', $story);

		$arr = explode(" ", $story);

		foreach ($arr as $word) {
			if (dle_strlen($word, $config['charset']) > 4) $newarr[] = $word;
		}

		$arr = array_count_values($newarr);
		arsort($arr);

		$arr = array_keys($arr);

		$total = count($arr);

		$offset = 0;

		$arr = array_slice($arr, $offset, $keyword_count);

		$headers['keywords'] = $db->safesql(implode(", ", $arr));
	} else {

		$headers['keywords'] = '';

	}

	return $headers;
}

foreach ($i18n_lang['active'] as $code => $lang_ar) {
	if ($i18n->getLocale() == $code) {
		$shortStoryLang[$lang_ar['iso2']][] = $short_story;
		$fullStoryLang[$lang_ar['iso2']][]  = $full_story;
		$titleLang[$lang_ar['iso2']][]      = $title;
		$metatagsLangg[$lang_ar['iso2']][]  = $metatags;
		$tagsLang[$lang_ar['iso2']][]       = $_POST['tags'];
	} else {

		if (!$user_group[$member_id['user_group']]['allow_html']) {

			$_POST['short_story_'.$lang_ar['iso2']] = strip_tags($_POST['short_story_'.$lang_ar['iso2']]);
			$_POST['full_story_'.$lang_ar['iso2']]  = strip_tags($_POST['full_story_'.$lang_ar['iso2']]);

		}

		if ($config['allow_admin_wysiwyg']) $parse->allow_code = false;

		$_POST['full_story_'.$lang_ar['iso2']]  = $parse->process($_POST['full_story_'.$lang_ar['iso2']]);
		$_POST['short_story_'.$lang_ar['iso2']] = $parse->process($_POST['short_story_'.$lang_ar['iso2']]);

		if ($config['allow_admin_wysiwyg'] OR $allow_br != '1') {

			$_POST['full_story_'.$lang_ar['iso2']]  = $db->safesql($parse->BB_Parse($_POST['full_story_'.$lang_ar['iso2']]));
			$_POST['short_story_'.$lang_ar['iso2']] = $db->safesql($parse->BB_Parse($_POST['short_story_'.$lang_ar['iso2']]));

		} else {

			$_POST['full_story_'.$lang_ar['iso2']]  = $db->safesql($parse->BB_Parse($_POST['full_story_'.$lang_ar['iso2']], false));
			$_POST['short_story_'.$lang_ar['iso2']] = $db->safesql($parse->BB_Parse($_POST['short_story_'.$lang_ar['iso2']], false));
		}

		$_POST['title_'.$lang_ar['iso2']] = $parse->process(trim(strip_tags($_POST['title_'.$lang_ar['iso2']])));

		if (@preg_match("/[\||\<|\>|\"|\!|\?|\$|\@|\/|\\\|\~\*\+]/", $_POST['tags_'.$lang_ar['iso2']])) $_POST['tags_'.$lang_ar['iso2']] = "";
		else $_POST['tags_'.$lang_ar['iso2']] = @$db->safesql(htmlspecialchars(strip_tags(stripslashes(trim($_POST['tags_'.$lang_ar['iso2']]))), ENT_COMPAT, $config['charset']));

		if ($_POST['tags_'.$lang_ar['iso2']]) {

			$temp_array = [];
			$tags_array = [];
			$temp_array = explode(',', $_POST['tags_'.$lang_ar['iso2']]);

			if (count($temp_array)) {

				foreach ($temp_array as $value) {
					if (trim($value)) {
						$tags_array[] = trim($value);
					}
				}

			}

			if (count($tags_array)) {
				$_POST['tags_'.$lang_ar['iso2']] = implode(', ', $tags_array);
			} else {
				$_POST['tags_'.$lang_ar['iso2']] = '';
			}

		}

		$metatagsLang[$lang_ar['iso2']][]   = create_metatags_lang($_POST['short_story_'.$lang_ar['iso2']].' '.$_POST['full_story_'.$lang_ar['iso2']], $lang_ar['iso2']);
		$shortStoryLang[$lang_ar['iso2']][] = $_POST['short_story_'.$lang_ar['iso2']];
		$fullStoryLang[$lang_ar['iso2']][]  = $_POST['full_story_'.$lang_ar['iso2']];
		$titleLang[$lang_ar['iso2']][]      = $db->safesql($_POST['title_'.$lang_ar['iso2']]);
		$tagsLang[$lang_ar['iso2']][]       = $_POST['tags_'.$lang_ar['iso2']];
	}

}

$shortAll    = [];
$fullAll     = [];
$metatagsAll = [];
$titleAll    = [];
$tagsAll     = [];

foreach ($shortStoryLang as $lng => $inh) {
	$shortAll[] = "short_story_{$lng} = '{$inh[0]}'";
}
foreach ($fullStoryLang as $lng => $inh) {
	$fullAll[] = "full_story_{$lng} = '{$inh[0]}'";
}
foreach ($metatagsLang as $lng => $inh) {
	$metatagsAll[] = "descr_{$lng} = '{$metatagsLang[$lng][0]['description']}'";
	$metatagsAll[] = "keywords_{$lng} = '{$metatagsLang[$lng][0]['keywords']}'";
	$metatagsAll[] = "metatitle_{$lng} = '{$metatagsLang[$lng][0]['title']}'";
}
foreach ($titleLang as $lng => $inh) {
	$titleAll[] = "title_{$lng} = '{$inh[0]}'";
}
foreach ($tagsLang as $lng => $inh) {
	$tagsAll[] = "tags_{$lng} = '{$inh[0]}'";
}


$newsAll   = [];
$newsAll[] = implode(', ', $shortAll);
$newsAll[] = implode(', ', $fullAll);
$newsAll[] = implode(', ', $metatagsAll);
$newsAll[] = implode(', ', $titleAll);
$newsAll[] = implode(', ', $tagsAll);

$newsAll = implode(', ', $newsAll);

$dle_prefix = PREFIX;

$db->query("UPDATE {$dle_prefix}_post SET {$newsAll} where id = {$item_db[0]}");


<?php
////////////////////////////////////////////////////////////
// =======================================================
// Mod: MaHarder Assets
// File: addMetaTag.php
// Path: /engine/inc/maharder/assets/include/inc/metatags/addMetaTag.php
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

$pageTitle = [];
$pageDescr = [];
$metaTitle = [];
$metaDescr = [];
$metaKeyWords = [];

if (!function_exists('createTabs')) {
	function createTabs($name, $content) {
		global $i18n_lang;

		$template = '<ul class=\'nav nav-tabs nav-tabs-solid\'>';

		$count = 0;
		foreach ($i18n_lang['active'] as $code => $lang_ar) {
			if($count == 0) $active = 'class=\'active\'';
			else $active = '';
			$title = $lang_ar['name'] . ' / ' . $lang_ar['international'];
			$template .= "<li {$active}><a href='#{$name}_{$count}' data-toggle='tab'><img src='{$lang_ar['flag']}' alt='{$title}' title='{$title}' style='max-width: 23px;width: 100%;height: auto;'>  {$title}</a></li>";
			$count++;
		}
		$template .= '</ul><div class=\'panel-tab-content tab-content\'>';

		$count = 0;
		foreach ($content as $id => $inhalt) {
			if($count == 0) $active = 'active';
			else $active = '';
			$template .= "<div class='tab-pane {$active}' id='{$name}_{$count}'>{$inhalt}</div>";
			$count++;
		}
		$template .= '</div>';

		return $template;
	}
}

foreach ($i18n_lang['active'] as $code => $lang_ar) {
	$iso = $lang_ar['iso2'];
	$titleName = "<img src='{$lang_ar['flag']}' alt='{$title}' title='{$title}' style='max-width: 23px;width: 100%;height: auto;'> " . $lang_ar['name'] . ' (' . $lang_ar['international'] . ')';
	if ($i18n->getLocale() == $code) {
		$pageTitle[]    = "{$lang['page_header_1']} <br /><input type='text' name='page_title' class='classic' style='width:100%;' value=''><br><br>";
		$pageDescr[]    = "{$lang['page_header_2']}<br><textarea name='page_description' class='classic' style='width:100%;' rows='5' placeholder='{$lang['page_header_3']}'></textarea><br><br>";
		$metaTitle[]    = "{$lang['meta_title']}<br /><input type='text' name='meta_title' class='classic' style='width:100%;' value=''><br><br>";
		$metaDescr[]    = "{$lang['meta_descr']} <br /><input type='text' name='descr' class='classic' style='width:100%;' value=''/><br><br>";
		$metaKeyWords[] = "{$lang['meta_keys']}<br /><textarea name='keywords' id='dle-promt-keywords' class='classic' style='width:100%;' rows='3'></textarea>";
	} else {
		$pageTitle[]    = "{$lang['page_header_1']} {$titleName}" .setTranslator($lang_ar['iso2'], 'page_title') . "<br /><input type='text' name='page_title_{$iso}' class='classic' style='width:100%;' value=''><br><br>";
		$pageDescr[]    = "{$lang['page_header_2']} {$titleName}" .setTranslator($lang_ar['iso2'], 'page_description') . "<br><textarea name='page_description_{$iso}' class='classic' style='width:100%;' rows='5' placeholder='{$lang['page_header_3']}'></textarea><br><br>";
		$metaTitle[]    = "{$lang['meta_title']} {$titleName}" .setTranslator($lang_ar['iso2'], 'meta_title') . "<br /><input type='text' name='meta_title_{$iso}' class='classic' style='width:100%;' value=''><br><br>";
		$metaDescr[]    = "{$lang['meta_descr']} {$titleName}" .setTranslator($lang_ar['iso2'], 'descr') . "<br /><input type='text' name='descr_{$iso}' class='classic' style='width:100%;' value=''/><br><br>";
		$metaKeyWords[] = "{$lang['meta_keys']} {$titleName}" .setTranslator($lang_ar['iso2'], 'keywords') . "<br /><textarea name='keywords_{$iso}' id='dle-promt-keywords-{$iso}' class='classic' style='width:100%;' rows='3'></textarea>";
	}

}

$pageTitle = createTabs('page_title', $pageTitle);
$pageDescr = createTabs('page_description', $pageDescr);
$metaTitle = createTabs('meta_title', $metaTitle);
$metaDescr = createTabs('descr', $metaDescr);
$metaKeyWords = createTabs('keywords', $metaKeyWords);

echo <<<HTML
		var tempL = "";
		tempL += "{$pageTitle}";
		tempL += "{$pageDescr}";
		tempL += "{$metaTitle}";
		tempL += "{$metaDescr}";
		tempL += "{$metaKeyWords}";

		$("body").append("<div id='dlepopup' title='{$lang['add_links_meta']}' style='display:none'><form id='addtags' method='post'><input type='hidden' name='mod' value='metatags'><input type='hidden' name='action' value='add'><input type='hidden' name='user_hash' value='{$dle_login_hash}'><input type='text' name='url' id='dle-promt-url' class='classic' style='width:100%;' value='' placeholder='{$lang['meta_param_1']}'>" + tempL + "</form></div>");

HTML;


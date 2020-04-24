<?php
////////////////////////////////////////////////////////////
// =======================================================
// Mod: MaHarder Assets
// File: editMetaTag.php
// Path: D:/OSPanel/domains/dle131.test/engine/inc/maharder/assets/include/inc/metatags/editMetaTag.php
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

foreach ($i18n_lang['active'] as $code => $lang_ar) {
	$iso = $lang_ar['iso2'];
	$titleName = "<img src='{$lang_ar['flag']}' alt='{$title}' title='{$title}' style='max-width: 23px;width: 100%;height: auto;'> " . $lang_ar['name'] . ' (' . $lang_ar['international'] . ')';
	if ($i18n->getLocale() == $code) {
		$pageTitle[]    = "{$lang['page_header_1']} <br /><input type='text' name='page_title' class='classic' style='width:100%;' value='\"+page_title+\"'><br><br>";
		$pageDescr[]    = "{$lang['page_header_2']}<br><textarea name='page_description' class='classic' style='width:100%;' rows='5' placeholder='{$lang['page_header_3']}'>\"+page_description+\"</textarea><br><br>";
		$metaTitle[]    = "{$lang['meta_title']}<br /><input type='text' name='meta_title' class='classic' style='width:100%;' value='\"+meta_title+\"'><br><br>";
		$metaDescr[]    = "{$lang['meta_descr']} <br /><input type='text' name='descr' class='classic' style='width:100%;' value='\"+meta_description+\"'/><br><br>";
		$metaKeyWords[] = "{$lang['meta_keys']}<br /><textarea name='keywords' class='classic' style='width:100%;' rows='3'>\"+meta_keywords+\"</textarea>";
	} else {
		$pageTitle[]    = "{$lang['page_header_1']} {$titleName}<br /><input type='text' name='page_title_{$iso}' class='classic' style='width:100%;' value='\"+page_title_{$iso}+\"'><br><br>";
		$pageDescr[]    = "{$lang['page_header_2']} {$titleName}<br><textarea name='page_description_{$iso}' class='classic' style='width:100%;' rows='5' placeholder='{$lang['page_header_3']}'>\"+page_description_{$iso}+\"</textarea><br><br>";
		$metaTitle[]    = "{$lang['meta_title']} {$titleName}<br /><input type='text' name='meta_title_{$iso}' class='classic' style='width:100%;' value='\"+meta_title_{$iso}+\"'><br><br>";
		$metaDescr[]    = "{$lang['meta_descr']} {$titleName}<br /><input type='text' name='descr_{$iso}' class='classic' style='width:100%;' value='\"+meta_description_{$iso}+\"'/><br><br>";
		$metaKeyWords[] = "{$lang['meta_keys']} {$titleName}<br /><textarea name='keywords_{$iso}' class='classic' style='width:100%;' rows='3'>\"+meta_keywords_{$iso}+\"</textarea>";

		echo <<<HTML

			var meta_title_{$iso} = $('#title_'+$(this).attr('uid')+'_{$iso}').val();
			meta_title_{$iso} = meta_title_{$iso}.replace(/'/g, "&#039;");
			var meta_description_{$iso} = $('#title_'+$(this).attr('uid')+'_{$iso}').data('description');
			var meta_keywords_{$iso} = $('#title_'+$(this).attr('uid')+'_{$iso}').data('keywords');
			var page_title_{$iso} = $('#title_'+$(this).attr('uid')+'_{$iso}').data('pagetitle');
			page_title_{$iso} = page_title_{$iso}.replace(/'/g, "&#039;");
			var page_description_{$iso} = $('#descr_'+$(this).attr('uid')+'_{$iso}').val();

HTML;

	}

}

$pageTitle = createTabs('page_title_edit', $pageTitle);
$pageDescr = createTabs('page_description_edit', $pageDescr);
$metaTitle = createTabs('meta_title_edit', $metaTitle);
$metaDescr = createTabs('descr_edit', $metaDescr);
$metaKeyWords = createTabs('keywords_edit', $metaKeyWords);

echo <<<HTML
	
	$("body").append("<div id='dlepopup' title='{$lang['add_links_meta']}' style='display:none'><form id='edittags' method='post'><input type='hidden' name='id' value='"+urlid+"'><input type='hidden' name='mod' value='metatags'><input type='hidden' name='action' value='edit'><input type='hidden' name='searchword' value='{$searchword}'><input type='hidden' name='start_from' value='{$start_from}'><input type='hidden' name='user_hash' value='{$dle_login_hash}'>{$lang['meta_param_1']}<br>{$pageTitle}{$pageDescr}{$metaTitle}{$metaDescr}{$metaKeyWords}</form></div>");

HTML;


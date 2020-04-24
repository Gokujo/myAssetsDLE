<?php
////////////////////////////////////////////////////////////
// =======================================================
// Mod: MaHarder Assets
// File: rubrics.editRubric.php
// Path: /engine/inc/maharder/assets/include/inc/banners/rubrics.editRubric.php
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

$rubTitle = '';
$rubDescr = '';
foreach ($i18n_lang['active'] as $code => $lang_ar) {
	if ($i18n->getLocale() == $code) continue;

	$langN = "{$lang_ar['name']} ({$lang_ar['international']})";
	$langD = "<img src='{$lang_ar['flag']}' style='max-width: 23px;width: 100%;height: auto;' alt='{$langN}' title='{$langN}'> {$langN}";

	$rubTitle .= <<<HTML
<br><br>{$lang['rubric_title']} ({$langD})
HTML;
	$rubTitle .= setTranslator($lang_ar['iso2'], 'title');
	$rubTitle .= <<<HTML
<br><input type='text' name='title_{$lang_ar['iso2']}' id='dle-promt-title-{$lang_ar['iso2']}' class='classic' style='width:100%;' value='"+title_{$lang_ar['iso2']}+"'>
HTML;

	$rubDescr .= <<<HTML
<br><br>{$lang['rubric_description']} ({$langD})
HTML;
	$rubDescr .= setTranslator($lang_ar['iso2'], 'description');
	$rubDescr .= <<<HTML
<br><textarea name='description_{$lang_ar['iso2']}' id='dle-promt-descr-{$lang_ar['iso2']}' class='classic' style='width:100%;' rows='3'>"+descr_{$lang_ar['iso2']}+"</textarea>
HTML;

	echo <<<HTML
	var title_{$lang_ar['iso2']} = $('#title_' + rid + '_{$lang_ar['iso2']}').val();
	var descr_{$lang_ar['iso2']} = $('#descr_' + rid + '_{$lang_ar['iso2']}').val();
HTML;


}

echo <<<HTML


b[dle_act_lang[2]] = function() { 
	if ( $("#dle-promt-title").val().length < 1) {
		$("#dle-promt-title").addClass('ui-state-error');
HTML;
foreach ($i18n_lang['active'] as $code => $lang_ar) {
	if ($i18n->getLocale() == $code) continue;

	echo <<<HTML
	} else if ( $("#dle-promt-title-{$lang_ar['iso2']}").val().length < 1) {
		$("#dle-promt-title-{$lang_ar['iso2']}").addClass('ui-state-error');
HTML;

}
echo <<<HTML
	} else {
		$("#editrubric").submit();
	}			
};

$("#dlepopup").remove();

$("body").append("<div id='dlepopup' title='{$lang['add_rubric_2']}' style='display:none'><form id='editrubric' method='post'>{$lang['rubric_title']}<input type='hidden' name='mod' value='banners'><input type='hidden' name='action' value='editrubric'><input type='hidden' name='user_hash' value='{$dle_login_hash}'><input type='hidden' name='editrubricid' value='"+rid+"'><br /><input type='text' name='title' id='dle-promt-title' class='classic' style='width:100%;' value='"+title+"'>{$rubTitle}<br /><br />{$lang['rubric_description']}<br /><textarea name='description' id='dle-promt-descr' class='classic' style='width:100%;' rows='3'>"+description+"</textarea>{$rubDescr}</form></div>");

HTML;

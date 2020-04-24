<?php
////////////////////////////////////////////////////////////
// =======================================================
// Mod: MaHarder Assets
// File: addQuestion.php
// Path: /engine/inc/maharder/assets/include/inc/question/addQuestion.php
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

$qs = [];
$as = [];

if (!function_exists('createTabs')) {
	function createTabs($name, $content) {
		global $i18n_lang;

		$template = '<ul class=\'nav nav-tabs nav-tabs-solid\'>';

		$count = 0;
		foreach ($i18n_lang['active'] as $code => $lang_ar) {
			if($count == 0) $active = 'class=\'active\'';
			else $active = '';
			$title = $lang_ar['name'] . ' / ' . $lang_ar['international'];
			$flag = "<img src='{$lang_ar['flag']}' alt='{$title}' title='{$title}' style='max-width: 23px;width: 100%;height: auto;'>";
			$template .= "<li {$active}><a href='#{$name}_{$count}' data-toggle='tab'>{$flag}  {$title}</a></li>";
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
	$flag = "<img src='{$lang_ar['flag']}' alt='{$title}' title='{$title}' style='max-width: 23px;width: 100%;height: auto;'>";

	if ($i18n->getLocale() == $code) {
		$qs[] = "{$lang['opt_question_3']}<br><input type='text' name='question' id='question' class='classic' style='width:100%' value='' />";
		$as[] = "{$lang['opt_question_4']}<br/><textarea name='answer' id='answer' class='classic' style='width:100%;height:100px;'></textarea>";
	} else {
		$qs[] = "{$lang['opt_question_3']} {$flag}" .setTranslator($lang_ar['iso2'], 'question') . "<br><input type='text' name='question_{$iso}' id='question_{$iso}' class='classic' style='width:100%' value='' />";
		$as[] = "{$lang['opt_question_4']} {$flag}" .setTranslator($lang_ar['iso2'], 'answer') . "<br/><textarea name='answer_{$iso}' id='answer_{$iso}' class='classic' style='width:100%;height:100px;'></textarea>";
	}

}

$qs = createTabs('question_tab', $qs);
$as = createTabs('answer_tab', $as);

echo <<<HTML
$('body').append("<div id='dlepopup' title='{$lang['opt_question_2']}' style='display:none;'><form action='?mod=question' method='POST' name='saveform' id='saveform'>{$qs} <br> <br>{$as} <input type='hidden' name='mod' value='question'> <input type='hidden' name='user_hash' value='{$dle_login_hash}'> <input type='hidden' name='action' value='addquestion'></form></div>");
HTML;

unset($qs, $as);

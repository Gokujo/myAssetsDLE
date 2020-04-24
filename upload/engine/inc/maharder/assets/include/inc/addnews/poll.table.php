<?php
////////////////////////////////////////////////////////////
// =======================================================
// Mod: MaHarder Assets
// File: poll.table.php
// Path: /engine/inc/maharder/assets/include/inc/addnews/poll.table.php
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

foreach ($i18n_lang['active'] as $code => $lang_ar) {
	$iso = $lang_ar['iso2'];
	$titleName = "<img src='{$lang_ar['flag']}' alt='{$title}' title='{$title}' style='max-width: 23px;width: 100%;height: auto;'> " . $lang_ar['name'] . ' (' . $lang_ar['international'] . ')';
	if ($i18n->getLocale() == $code) continue;

	if($_GET['action'] != "editnews") {
		$voteBody = $poll['body_' . $iso];
		$voteFrage = $poll['frage_' . $iso];
		$voteTitle = $poll['title_' . $iso];
	} else {
		$voteBody = '';
		$voteFrage = '';
		$voteTitle = '';
	}

	$content = <<<HTML
		<div class="form-group">
			<label class="control-label col-md-2 col-sm-3">{$lang['v_ftitle']}<br>{$titleName}
HTML;
	$content .= setTranslator($lang_ar['iso2'], 'vote_title');
	$content .= <<<HTML
</label>
			<div class="col-md-10 col-sm-9">
				<input type="text" name="vote_title_{$iso}" class="form-control width-400" maxlength="200" value="{$voteTitle}"><i 
				class="help-button visible-lg-inline-block text-primary-600 fa fa-question-circle position-right position-left" data-rel="popover" data-trigger="hover" data-placement="right" data-content="{$lang['hint_ftitle']}" ></i>
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label col-md-2 col-sm-3">{$lang['vote_title']}<br>{$titleName}
HTML;
	$content .= setTranslator($lang_ar['iso2'], 'frage');
	$content .= <<<HTML
</label>
			<div class="col-md-10 col-sm-9">
				<input type="text" name="frage_{$iso}" class="form-control width-400" maxlength="200" value="{$voteFrage}"><i 
				class="help-button visible-lg-inline-block text-primary-600 fa fa-question-circle position-right position-left" data-rel="popover" data-trigger="hover" data-placement="right" data-content="{$lang['hint_vtitle']}" ></i>
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label col-md-2 col-sm-3">{$lang['vote_body']}<br>{$titleName}
HTML;
	$content .= setTranslator($lang_ar['iso2'], 'vote_body');
	$content .= <<<HTML
<div class="text-muted 
			text-size-small">{$lang['vote_str_1']}</div></label>
			<div class="col-md-10 col-sm-9">
				<textarea rows="7" class="classic width-400" name="vote_body_{$iso}">{$voteBody}</textarea>
			</div>
		</div>
HTML;

	echo $content;

}

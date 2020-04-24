<?php
////////////////////////////////////////////////////////////
// =======================================================
// Mod: MaHarder Assets
// File: title.php
// Path: /engine/inc/maharder/assets/include/inc/poll/title.php
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

$titleLang = [];

foreach ($i18n_lang['active'] as $code => $lang_ar) {
	$iso = $lang_ar['iso2'];

	if( ($_GET['action'] == "edit") && $id != '' ) {
		if ($i18n->getLocale() == $code) continue;
		$titleLang[$iso] = $parse->decodeBBCodes( $row['title_' . $iso], false );
	} else {
		$titleLang[$iso] = '';
	}

}

foreach ($i18n_lang['active'] as $code => $lang_ar) {
	$iso = $lang_ar['iso2'];
	$titleName = "<img src='{$lang_ar['flag']}' alt='{$title}' title='{$title}' style='max-width: 23px;width: 100%;height: auto;'> " . $lang_ar['name'] . ' / ' . $lang_ar['international'];
	if ($i18n->getLocale() == $code) continue;

	echo <<<HTML
		<div class="form-group">
			<label class="control-label col-md-2 col-sm-3">{$lang['vote_title']} ({$titleName})</label>
		  	<div class="col-md-10 col-sm-9">
				<input type="text" name="title_{$iso}" class="form-control width-500" value="{$titleLang[$iso]}"><i 
				class="help-button visible-lg-inline-block text-primary-600 fa fa-question-circle position-right position-left" data-rel="popover" data-trigger="hover" data-placement="right" data-content="{$lang['hint_vtitle']}" ></i>
		  	</div>
		</div>
HTML;

}


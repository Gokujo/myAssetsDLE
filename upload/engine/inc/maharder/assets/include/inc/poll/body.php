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

$bodyLang = [];

foreach ($i18n_lang['active'] as $code => $lang_ar) {
	$iso = $lang_ar['iso2'];

	if( ($_GET['action'] == "edit") && $id != '' ) {
		if ($i18n->getLocale() == $code) continue;
		$bodyLang[$iso] = $parse->decodeBBCodes( $row['body_' . $iso], false );
	} else {
		$bodyLang[$iso] = '';
	}

}

foreach ($i18n_lang['active'] as $code => $lang_ar) {
	$iso = $lang_ar['iso2'];
	$titleName = "<img src='{$lang_ar['flag']}' alt='{$title}' title='{$title}' style='max-width: 23px;width: 100%;height: auto;'> " . $lang_ar['name'] . ' / ' . $lang_ar['international'];
	if ($i18n->getLocale() == $code) continue;

	$content = <<<HTML
		<div class="form-group">
			<label class="control-label col-md-2 col-sm-3">
				{$lang['vote_body']}<br>
				<small>({$titleName})</small>
HTML;
	$content .= setTranslator($lang_ar['iso2'], 'body');
	$content .= <<<HTML
<br />
				<span class="note large">{$lang['vote_str_1']}</span>
			</label>
		  	<div class="col-md-10 col-sm-9">
				<textarea class="classic width-500" style="height:200px;" name="body_{$iso}" id="body_{$iso}">{$bodyLang[$iso]}</textarea>
		  	</div>
		</div>
HTML;

	echo $content;

}


<?php
////////////////////////////////////////////////////////////
// =======================================================
// Mod: MaHarder Assets
// File: rubrics.table.php
// Path: /engine/inc/maharder/assets/include/inc/banners/rubrics.table.php
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
	if ($i18n->getLocale() == $code) continue;

	$r_list .= <<<HTML
	<input type="hidden" id="title_{$value['id']}_{$lang_ar['iso2']}" value="{$value['title_' . $lang_ar['iso2']]}">
HTML;

	$r_list .= <<<HTML
	<textarea id="descr_{$value['id']}_{$lang_ar['iso2']}" style="display:none;">{$value['description_' . $lang_ar['iso2']]}</textarea>
HTML;

}
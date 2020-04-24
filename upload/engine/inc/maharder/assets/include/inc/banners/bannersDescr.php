<?php
////////////////////////////////////////////////////////////
// =======================================================
// Mod: MaHarder Assets
// File: bannersDescr.php
// Path: /engine/inc/maharder/assets/include/inc/banners/bannersDescr.php
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

	$langN = "{$lang_ar['name']} ({$lang_ar['international']})";
	$langD = "<img src='{$lang_ar['flag']}' style=\"max-width: 23px;width: 100%;height: auto;\" alt='{$langN}' title='{$langN}'> {$langN}";
	$thisField = $row['descr_' . $lang_ar['iso2']];
	$thisVal = htmlspecialchars( $thisField, ENT_QUOTES, $config['charset'] );
	echo <<<HTML
		<div class="form-group">
		  <label class="control-label col-md-2 col-sm-3">{$lang['banners_xdescr']}</label>
		  <div class="col-md-10 col-sm-9">
			<input class="form-control width-350 position-left" maxlength="40" type="text" name="banner_descr_{$lang_ar['iso2']}" 
			value="{$thisField}" /><span class="text-muted text-size-small">{$langD}</span>
		  </div>
		 </div>
HTML;

}
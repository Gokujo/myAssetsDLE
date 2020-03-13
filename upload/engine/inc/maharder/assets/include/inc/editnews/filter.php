<?php
////////////////////////////////////////////////////////////
// =======================================================
// Mod: dle131.test
// File: filter.php
// Path: D:/OSPanel/domains/dle131.test/engine/inc/maharder/assets/include/inc/editnews/filter.php
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

$orderLangList = [];
foreach ($search_order_lang as $code => $lang_ar) {
	$name = "{$i18n_lang['iso'][$code]['name']} / {$i18n_lang['iso'][$code]['international']}";
	if($code == '----') $name = translate('Язык');
	$orderLangList[] = "<option {$search_order_title[$code]} value=\"{$code}\">$name</option>";
}
$orderLangList = implode('\n\r', $orderLangList);
echo <<<HTML
	<span class="input-group-btn">
				<select class="uniform" data-width="100%" name="search_lang" id="search_lang">
					{$orderLangList}
				</select>
			</span>
HTML;


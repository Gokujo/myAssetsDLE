<?php
////////////////////////////////////////////////////////////
// =======================================================
// Mod: MaHarder Assets
// File: addCat.php
// Path: /engine/inc/maharder/assets/include/inc/categories/addCat.php
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
	$langN = "{$lang_ar['name']} ({$lang_ar['international']})";
	$langD = "<img src='{$lang_ar['flag']}' style='max-width: 23px;width: 100%;height: auto;' alt='{$langN}' title='{$langN}'> {$langN}";
	if ($i18n->getLocale() == $code) continue;

	echo <<<HTML
		<div class="form-group">
			<div class="row">
				<div class="col-sm-12">
					<label>{$lang['cat_name']} ({$langD})</label>
					<input name="cat_name_{$iso}" type="text" class="form-control" maxlength="200">
					<span class="input-group-addon">
						<i class="help-button visible-lg-inline-block text-primary-600 fa fa-question-circle 
						position-right" data-rel="popover" data-trigger="hover" data-placement="right" data-content="{$lang['hint_catname']} ({$langN})" ></i>
					</span>
				</div>
			</div>
		</div>
		
		<div class="form-group">
			<div class="row">
				<div class="col-sm-12">
					<label>{$lang['cat_fulldescr']} ({$langD})</label>
					<textarea name="fulldescr_{$iso}" class="classic" style="width:100%;" rows="5"></textarea>
				</div>
			</div>
		</div>
		
		<div class="form-group">
			<div class="row">
				<div class="col-sm-6">
					<label>{$lang['meta_title']} ({$langD})</label>
					<input name="meta_title_{$iso}" type="text" class="form-control" maxlength="200">
				</div>
				<div class="col-sm-6">
					<label>{$lang['meta_descr_cat']} ({$langD})</label>
					<input name="descr_{$iso}" type="text" class="form-control" maxlength="300">
				</div>
			</div>
		</div>
		
		<div class="form-group">
			<div class="row">
				<div class="col-sm-12">
					<label>{$lang['meta_keys']} ({$langD})</label>
					<textarea name="keywords_{$iso}" class="classic" style="width:100%;" rows="3"></textarea>
				</div>
			</div>
		</div>
HTML;

}
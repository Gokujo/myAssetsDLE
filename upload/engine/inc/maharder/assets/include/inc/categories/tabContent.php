<?php
////////////////////////////////////////////////////////////
// =======================================================
// Mod: MaHarder Assets
// File: tabContent.php
// Path: /engine/inc/maharder/assets/include/inc/categories/tabContent.php
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
	if($i18n->getLocale() == $code ) continue;

	$content = <<<HTML
		<div class="tab-pane" id="{$code}">
			<div class="panel-body">
			
				<div class="form-group">
		  			<label class="control-label col-md-2 col-sm-3">{$lang['cat_name']}
HTML;
	$content .= setTranslator($lang_ar['iso2'], 'cat_name');
	$content .= <<<HTML
</label>
		  			<div class="col-md-10 col-sm-9">
						<input class="form-control width-350" value="{$row['name_' . $iso]}" maxlength="50" type="text" 
						name="cat_name_{$iso}"><i class="help-button visible-lg-inline-block text-primary-600 fa fa-question-circle position-right" data-rel="popover" data-trigger="hover" data-placement="right" data-content="{$lang['hint_catname']}"></i>
		  			</div>
		 		</div>
		 		
		 		<div class="form-group">
		  			<label class="control-label col-md-2 col-sm-3">{$lang['cat_fulldescr']}
HTML;
	$content .= setTranslator($lang_ar['iso2'], 'fulldescr');
	$content .= <<<HTML
</label>
		  			<div class="col-md-10 col-sm-9">
						<textarea name="fulldescr_{$iso}" class="classic" style="width:100%;max-width:550px;" rows="5">{$row['fulldescr_' . $iso]}</textarea>
		  			</div>
		 		</div>
		 		
		 		<div class="form-group">
		  			<label class="control-label col-md-2 col-sm-3">{$lang['meta_title']}
HTML;
	$content .= setTranslator($lang_ar['iso2'], 'meta_title');
	$content .= <<<HTML
</label>
		  			<div class="col-md-10 col-sm-9">
						<input type="text" name="meta_title_{$iso}" class="form-control width-550" maxlength="200" 
						value="{$row['metatitle_' . $iso]}">
		 			</div>
		 		</div>
		 		
				<div class="form-group">
		  			<label class="control-label col-md-2 col-sm-3">{$lang['meta_descr_cat']}
HTML;
	$content .= setTranslator($lang_ar['iso2'], 'descr');
	$content .= <<<HTML
</label>
		  			<div class="col-md-10 col-sm-9">
						<input type="text" name="descr_{$iso}" class="form-control width-550" maxlength="300" 
						value="{$row['descr_' . $iso]}">
		  			</div>
		 		</div>
		 		
				<div class="form-group">
		  			<label class="control-label col-md-2 col-sm-3">{$lang['meta_keys']}
HTML;
	$content .= setTranslator($lang_ar['iso2'], 'keywords');
	$content .= <<<HTML
</label>
		  			<div class="col-md-10 col-sm-9">
						<textarea name="keywords_{$iso}" class="classic" style="width:100%;max-width:550px;" 
						rows="3">{$row['keywords_' . $iso]}</textarea>
		  			</div>
		 		</div>
		 		
			</div>
		</div>
HTML;
	echo $content;
}
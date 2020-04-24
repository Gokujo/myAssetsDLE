<?php
//===============================================================
// Mod: MaHarder Assets                                         =
// File: tabContent.php                                         =
// Path: /engine/inc/maharder/assets/include/inc/static/tabContent.php
// ============================================================ =
// Author: Maxim Harder (c) 2020                                =
// Website: https://maxim-harder.de / https://devcraft.club     =
// Telegram: http://t.me/MaHarder                               =
// ============================================================ =
// Do not change anything!                                      =
//===============================================================

if( !defined( 'DATALIFEENGINE' ) ) {
	header( "HTTP/1.1 403 Forbidden" );
	header ( 'Location: ../../../../../../' );
	die( "Hacking attempt!" );
}

require_once (DLEPlugins::Check(ENGINE_DIR . '/inc/maharder/assets/include/inc/static/editor.php'));

$content = <<<HTML
<script>
	function auto_keywords_lang ( key, lang ){
	    var wysiwyg = '{$config['allow_static_wysiwyg']}';

		if (wysiwyg == "2") {
			tinyMCE.triggerSave();
		}
		let tempName = 'template_' + lang;
		var short_txt = document.getElementById(tempName).value;

		ShowLoading('');

		$.post("engine/ajax/controller.php?mod=keywords", { short_txt: short_txt, key: key, user_hash: '{$dle_login_hash}' }, function(data){
	
			HideLoading('');
	
			if (key == 1) { $('#autodescr_' + lang).val(data); }
			else { $('#keywords_' + lang).tokenfield('setTokens', data); }
	
		})


	}
</script>
HTML;


foreach ($i18n_lang['active'] as $code => $lang_ar) {
	if($i18n->getLocale() == $code ) continue;
	$iso = $lang_ar['iso2'];
	$titleName = "<img src='{$lang_ar['flag']}' alt='{$title}' title='{$title}' style='max-width: 23px;width: 100%;height: auto;'> " . $lang_ar['name'] . ' (' . $lang_ar['international'] . ')';

	if ($action != "doedit") {
		$row['template_' . $iso] = '';
		$row['metatitle_' . $iso] = '';
		$row['descr_' . $iso] = '';
		$row['metakeys_' . $iso] = '';
		$row['metadescr_' . $iso] = '';
	}

	$content .= <<<HTML
		<div class="tab-pane" id="{$code}">
			<div class="panel-body">
			
				<div class="form-group">
		  			<label class="control-label col-md-2">{$lang['static_descr']} ({$titleName})
HTML;
	$content .= setTranslator($lang_ar['iso2'], 'description');
	$content .= <<<HTML
</label>
		  			<div class="col-md-10">
						<input type="text" name="description_{$iso}" class="form-control width-550" maxlength="250" 
						value="{$row['descr_' . $iso]}"><i 
						class="help-button visible-lg-inline-block text-primary-600 fa fa-question-circle position-right position-left" data-rel="popover" data-trigger="hover" data-placement="auto right" data-content="{$lang['hint_sdesc']}" ></i>
		  			</div>
		 		</div>
		 		
		 		<div class="form-group editor-group">
		  			<label class="control-label col-md-2">{$lang['static_templ']} ({$titleName})
HTML;
	$content .= setTranslator($lang_ar['iso2'], 'template');
	$content .= <<<HTML
</label>
		  			<div class="col-md-10">
HTML;

	if( $config['allow_static_wysiwyg'] ) {

		$content .= insertEditor('template', $iso);

	} else {

		include (DLEPlugins::Check(ENGINE_DIR . '/inc/include/inserttag.php'));

		$content .=  <<<HTML
						<div class="editor-panel">
							<div class="shadow-depth1">
								{$bb_code}
								<textarea class="editor" style="width:100%;height:350px;" name="template_{$iso}" id="template_{$iso}" onfocus="setFieldName(this.name)">{$row['template_'.$iso]}</textarea>
							</div>
						</div>
						<script>var selField  = "template_{$iso}";</script>
HTML;

	}


		$content .=   <<<HTML
		  			</div>
		 		</div>
		 		
		 		<div class="form-group">
		 	 		<label class="control-label col-md-2"></label>
		  			<div class="col-md-10">
						{$lang['add_metatags']} ($titleName) <i class="help-button visible-lg-inline-block text-primary-600 fa fa-question-circle position-right position-left" data-rel="popover" data-trigger="hover" data-placement="auto right" data-content="{$lang['hint_metas']}" ></i>
		  			</div>
		 		</div>	
		 		
				<div class="form-group">
		 			<label class="control-label col-md-2">{$lang['meta_title']} ($titleName)
HTML;
	$content .= setTranslator($lang_ar['iso2'], 'meta_title');
	$content .= <<<HTML
</label>
		  			<div class="col-md-10">
						<input type="text" name="meta_title_{$iso}" value="{$row['metatitle_' . $iso]}" class="form-control width-500" maxlength="140">
		  			</div>
		 		</div>
		 		
				<div class="form-group">
		  			<label class="control-label col-md-2">{$lang['meta_descr']} ($titleName)
HTML;
	$content .= setTranslator($lang_ar['iso2'], 'descr');
	$content .= <<<HTML
</label>
		  			<div class="col-md-10">
						<input type="text" name="descr_{$iso}" id="autodescr_{$iso}" class="form-control width-500" 
						maxlength="300" value="{$row['metadescr_' . $iso]}">
		  			</div>
		 		</div>	
		 		
				<div class="form-group">
		  			<label class="control-label col-md-2">{$lang['meta_keys']}  ($titleName)
HTML;
	$content .= setTranslator($lang_ar['iso2'], 'keywords');
	$content .= <<<HTML
</label>
		  			<div class="col-md-10">
						<textarea class="tags" name="keywords_{$iso}" id='keywords_{$iso}'>
							{$row['metakeys_' . $iso]}
						</textarea><br /><br />
						<button onclick="auto_keywords_lang(1, '{$iso}'); return false;" class="btn bg-primary-600 
						btn-sm 
						btn-raised position-left"><i class="fa fa-exchange position-left"></i>{$lang['btn_descr']}</button>
						<button onclick="auto_keywords_lang(2, '{$iso}'); return false;" class="btn bg-primary-600 btn-sm 
						btn-raised"><i class="fa fa-exchange position-left"></i>{$lang['btn_keyword']}</button>
		  			</div>
		 		</div>		 
		 
			</div>
		</div>
HTML;
	echo $content;
}
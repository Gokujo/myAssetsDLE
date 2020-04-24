<?php
////////////////////////////////////////////////////////////
// =======================================================
// Mod: MaHarder Assets
// File: tabContent.php
// Path: /engine/inc/maharder/assets/include/inc/addnews/tabContent.php
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

require_once (DLEPlugins::Check(ENGINE_DIR . '/inc/maharder/assets/include/inc/addnews/editor.php'));

echo <<<HTML
<script>
	function auto_keywords_lang ( key, lang ){
		var wysiwyg = '{$config['allow_admin_wysiwyg']}';

		if (wysiwyg == "2") {
			tinyMCE.triggerSave();
		}

		var short_txt = document.getElementById('short_story_' + lang).value;
		var full_txt = document.getElementById('full_story_' + lang).value;

		ShowLoading('');

		$.post("engine/ajax/controller.php?mod=keywords", { short_txt: short_txt, full_txt: full_txt, key: key, user_hash: '{$dle_login_hash}' }, function(data){
	
			HideLoading('');

			if (key == 1) { $('#autodescr_' + lang).val(data); }
			else { $('#keywords_' + lang).tokenfield('setTokens', data); }
	
		});

		return false;
	}
	
	function find_relates_lang ( lang )
	{
		var title = document.getElementById('title_' + lang).value;

		ShowLoading('');

		$.post('engine/ajax/controller.php?mod=find_relates', { title: title, user_hash: '{$dle_login_hash}' }, function(data){
	
			HideLoading('');
	
			$('#related_news_' + lang).html(data);
	
		});

		return false;

	};
</script>
HTML;


foreach ($i18n_lang['active'] as $code => $lang_ar) {
	if($i18n->getLocale() == $code ) continue;

	if ($mod != "editnews") {
		$row['title_' . $lang_ar['iso2']] = '';
		$row['meta_title_' . $lang_ar['iso2']] = '';
		$row['descr_' . $lang_ar['iso2']] = '';
		$row['keywords_' . $lang_ar['iso2']] = '';
		$row['full_story_' . $lang_ar['iso2']] = '';
		$row['short_story_' . $lang_ar['iso2']] = '';
		$row['keywords_' . $lang_ar['iso2']] = '';
	}

	$content = <<<HTML
		<div class="tab-pane" id="{$code}">
			<div class="panel-body">
				<div class="form-group">
					<label class="control-label col-sm-2">{$lang['edit_et']} ({$lang_ar['name']})</label>
					<div class="col-sm-10">
						<input type="text" class="form-control width-550 position-left" 
						name="title_{$lang_ar['iso2']}" id="title_{$lang_ar['iso2']}" maxlength="250" value="{$row['title_' . $lang_ar['iso2']]}">
						<button onclick="find_relates_lang('{$lang_ar['iso2']}'); return false;" 
						class="visible-lg-inline-block btn bg-info-800 btn-sm btn-raised">{$lang['b_find_related']}</button>
						<i class="help-button visible-lg-inline-block text-primary-600 fa fa-question-circle position-right" data-rel="popover" data-trigger="hover" data-placement="right" data-content="{$lang['hint_title']}"></i>
						<span id="related_news_{$lang_ar['iso2']}"></span>
					</div>	
				</div>
							
				<div class="form-group">
					<label class="control-label col-md-2 col-sm-3">{$lang['meta_title']} ({$lang_ar['name']})</label>
					<div class="col-md-10 col-sm-9">
						<input type="text" name="meta_title_{$lang_ar['iso2']}" class="form-control width-500" 
						maxlength="140" value="{$row['title_' . $lang_ar['iso2']]}">
					</div>
				</div>	
				
				<div class="form-group">
					<label class="control-label col-md-2 col-sm-3">{$lang['meta_descr']} ({$lang_ar['name']})</label>
					<div class="col-md-10 col-sm-9">
						<input type="text" name="descr_{$lang_ar['iso2']}" id="autodescr_{$lang_ar['iso2']}" 
						class="form-control width-500" maxlength="300" value="{$row['descr_' . $lang_ar['iso2']]}">
					</div>
				</div>	
				
				<div class="form-group">
					<label class="control-label col-md-2 col-sm-3">{$lang['meta_keys']} ({$lang_ar['name']})</label>
					<div class="col-md-10 col-sm-9">
						<textarea class="tags" name="keywords_{$lang_ar['iso2']}" 
						id="keywords_{$lang_ar['iso2']}">{$row['keywords_' . $lang_ar['iso2']]}</textarea><br /><br />
							<button onclick="auto_keywords_lang(1, '{$lang_ar['iso2']}'); return false;" class="btn bg-primary-600 btn-sm 
							btn-raised position-left"><i class="fa fa-exchange position-left"></i>{$lang['btn_descr']}</button>
							<button onclick="auto_keywords_lang(2, '{$lang_ar['iso2']}'); return false;" class="btn bg-primary-600 btn-sm 
							btn-raised"><i class="fa fa-exchange position-left"></i>{$lang['btn_keyword']}</button>
					</div>
				</div>	
				
				<div class="form-group editor-group">
					<label class="control-label col-md-2">{$lang['addnews_short']} ({$lang_ar['name']})</label>
					<div class="col-md-10">
HTML;

	if( $config['allow_admin_wysiwyg'] ) {
		$content .= insertEditor('short_story', $lang_ar['iso2']);

	} else {
		$content .=  "<div class=\"editor-panel\"><div class=\"shadow-depth1\">{$bb_code}<textarea class=\"editor\" style=\"width:100%;height:300px;\" onfocus=\"setFieldName(this.name)\" name=\"short_story_{$lang_ar['iso2']}\" id=\"short_story_{$lang_ar['iso2']}\">{$row['short_story_' . $lang_ar['iso2']]}</textarea></div></div>";
	}
	$content .= <<<HTML
					</div>
				</div>
							
				<div class="form-group editor-group">
					<label class="control-label col-md-2">{$lang['addnews_full']} ({$lang_ar['name']})</label>
					<div class="col-md-10">
HTML;

	if( $config['allow_admin_wysiwyg'] ) {

		$content .=  insertEditor('full_story', $lang_ar['iso2']);

	} else {

		$content .=  "<div class=\"editor-panel\"><div class=\"shadow-depth1\">{$bb_panel}<textarea class=\"editor\" style=\"width:100%;height:350px;\" onfocus=\"setFieldName(this.name)\" name=\"full_story_{$lang_ar['iso2']}\" id=\"full_story_{$lang_ar['iso2']}\">{$row['full_story_' . $lang_ar['iso2']]}</textarea></div></div>";
	}

	$content .= <<<HTML
					</div>
				</div>
			</div>
		</div>
HTML;
	echo $content;
}
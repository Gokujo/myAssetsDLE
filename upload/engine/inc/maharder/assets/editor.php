<?php
//===============================================================
// Mod: MaHarder Assets                                         =
// File: editor.php                                             =
// Path: /engine/inc/maharder/assets/editor.php                 =
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

function insertEditor($field, $iso, $id, $model, $field_name, $data = '') {
	global $config, $image_q_upload, $p_name, $dle_login_hash, $implugin, $image_upload, $user_group, $member_id;

	if ( $user_group[$member_id['user_group']]['allow_image_upload'] OR $user_group[$member_id['user_group']]['allow_file_upload'] ) {
		$image_upload = "'dleupload',";
		$image_q_upload = ", 'imageUpload'";
	} else {$image_upload = ""; $image_q_upload = "";}

	if($config['bbimages_in_wysiwyg']) {
		$implugin = 'dleimg';
	} else $implugin = 'insertImage';

	if (empty($p_name) || !isset($p_name)) $p_name = $member_id['user_id'];

	$scripts = [];
	$fieldEditor = '';

		$scripts[] = <<<HTML
jQuery(function($){

		$('[data-cmd="dleupload"]').on('click', function () {
			$(document).find('#mediauploadframe').each((id, frame) => {
				$(frame).attr('src', 'engine/ajax/controller.php?mod=maharder_upload&area={$field}&author={$p_name}&model_id={$id}&model_name={$model}&model_field={$field_name}&wysiwyg=1&dle_theme=null');
			})
		});

      $('#{$field}').froalaEditor({
        dle_root: '',
        dle_upload_area : "{$field}",
        dle_upload_user : "{$p_name}",
        dle_upload_news : "{$id}",
        width: '100%',
        height: '400',
        language: '{$iso}',
		body_class: dle_theme,

        htmlRemoveTags: [],
		htmlAllowedAttrs: ['.*'],
		
        imageAllowedTypes: ['jpeg', 'jpg', 'png', 'gif', 'webp'],
        imageDefaultWidth: 0,
        imageInsertButtons: ['imageBack', '|', 'imageByURL'{$image_q_upload}],
		imageUploadURL: 'engine/ajax/controller.php?mod=maharder_upload',
		imageUploadParam: 'qqfile',
		imageUploadParams: { "subaction" : "upload", "model_id" : "{$id}", "model_name" : "{$model}", "model_field": "{$field_name}","author" : "{$p_name}", "mode" : "quickload", "user_hash" : "{$dle_login_hash}"},
        imageMaxSize: {$config['max_up_size']} * 1024,
		
        toolbarButtonsXS: ['bold', 'italic', 'underline', 'strikeThrough', 'align', 'color', 'insertLink', 'emoticons', '{$implugin}', {$image_upload}'insertVideo', 'paragraphFormat', 'paragraphStyle', 'dlehide', 'dlequote', 'dlespoiler'],

        toolbarButtonsSM: ['bold', 'italic', 'underline', 'strikeThrough', '|', 'align', 'color', 'insertLink', '|', 'emoticons', '{$implugin}',{$image_upload}'insertVideo', 'dleaudio', '|', 'paragraphFormat', 'paragraphStyle', '|', 'formatOL', 'formatUL', '|', 'dlehide', 'dlequote', 'dlespoiler'],

        toolbarButtonsMD: ['bold', 'italic', 'underline', 'strikeThrough', '|', 'align', 'indent', 'outdent', '|', 'subscript', 'superscript', '|', 'insertTable', 'formatOL', 'formatUL', 'insertHR', '|', 'undo', 'redo', 'dletypo', 'clearFormatting', 'selectAll', '|', 'fullscreen', '-', 
                         'fontFamily', 'fontSize', '|', 'color', 'paragraphFormat', 'paragraphStyle', '|', 'insertLink', 'dleleech', '|', 'emoticons', '{$implugin}',{$image_upload}'|', 'insertVideo', 'dleaudio', 'dlemedia','|', 'dlehide', 'dlequote', 'dlespoiler','dlecode','page_dropdown', 'html'],

        toolbarButtons: ['bold', 'italic', 'underline', 'strikeThrough', '|', 'align', 'indent', 'outdent', '|', 'subscript', 'superscript', '|', 'insertTable', 'formatOL', 'formatUL', 'insertHR', '|', 'undo', 'redo', 'dletypo', 'clearFormatting', 'selectAll', '|', 'fullscreen', '-', 
                         'fontFamily', 'fontSize', '|', 'color', 'paragraphFormat', 'paragraphStyle', '|', 'insertLink', 'dleleech', '|', 'emoticons', '{$implugin}',{$image_upload}'|', 'insertVideo', 'dleaudio', 'dlemedia','|', 'dlehide', 'dlequote', 'dlespoiler','dlecode','page_dropdown', 'html']
                         
      }).on('froalaEditor.image.inserted froalaEditor.image.replaced', function (e, editor, \$img, response) {
	  
			if( response ) {
			
			    response = JSON.parse(response);
			  
			    \$img.removeAttr("data-returnbox").removeAttr("data-success").removeAttr("data-xfvalue").removeAttr("data-flink");

				if(response.flink) {
				  if(\$img.parent().hasClass("highslide")) {
		
					\$img.parent().attr('href', response.flink);
		
				  } else {
		
					\$img.wrap( '<a href="'+response.flink+'" class="highslide"></a>' );
					
				  }
				}
			  
			}
			
		});

});
HTML;

		$fieldEditor = <<<HTML
<textarea id="{$field}" name="{$field}" class="wysiwygeditor_{$iso}" style="width:100%;height:200px;">{$data}</textarea>
HTML;



	$fieldEditor .= '<script>' . implode('\n\r', $scripts) . '</script>';

	return $fieldEditor;
}

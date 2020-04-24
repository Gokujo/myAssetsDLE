//===============================================================
// Mod: MaHarder Assets                                         =
// File: language.js                                            =
// Path: /engine/skins/maharder/js/language.js                  =
// ============================================================ =
// Author: Maxim Harder (c) 2020                                =
// Website: https://maxim-harder.de / https://devcraft.club     =
// Telegram: http://t.me/MaHarder                               =
// ============================================================ =
// Do not change anything!                                      =
//===============================================================

function translateJS(phrase, hash) {
    var output;
    return $.ajax({
        // async: false,
        url: 'engine/ajax/controller.php?mod=maharder',
        data: {
            user_hash: hash,
            module: 'maharder',
            file: 'languages',
            action: 'translate',
            wort: phrase
        },
        type: 'POST',
        success: function (data) {
            output = data;
        }
    });
}

function mh_media_upload ( area, author, model_id, model_name, model_field, wysiwyg = '1'){

		var rndval = new Date().getTime();
		var shadow = 'none';
		let dle_root = '/', text_upload = 'Upload', dle_skin = 'null';

		$('#mediaupload').remove();
		$('body').append("<div id='mediaupload' title='"+text_upload+"' style='display:none'></div>");
	
		$('#mediaupload').dialog({
			autoOpen: true,
			width: 710,
			resizable: false,
			dialogClass: "modalfixed dle-popup-upload",
			open: function(event, ui) { 
				$("#mediaupload").html("<iframe name='mediauploadframe' id='mediauploadframe' width='100%' height='550' src='"+dle_root+"engine/ajax/controller.php?mod=maharder_upload&&area="+area+"&author="+author+"&model_id="+model_id+"&model_name="+model_name+"&model_field="+model_field+"&wysiwyg=" + wysiwyg + "&skin=" + dle_skin + "&rndval=" + rndval + "' frameborder='0' marginwidth='0' marginheight='0' allowtransparency='true'></iframe>");
				$( ".ui-dialog" ).draggable( "option", "containment", "" );
			},
			dragStart: function(event, ui) {
				shadow = $(".modalfixed").css('box-shadow');
				$(".modalfixed").fadeTo(0, 0.6).css('box-shadow', 'none');
				$("#mediaupload").css('visibility', 'hidden');
			},
			dragStop: function(event, ui) {
				$(".modalfixed").fadeTo(0, 1).css('box-shadow', shadow);
				$("#mediaupload").css('visibility', 'visible');
			},
			beforeClose: function(event, ui) { 
				$("#mediaupload").html("");
			}
		});

		if ($(window).width() > 830 && $(window).height() > 530 ) {
			$('.modalfixed.ui-dialog').css({position:"fixed"});
			$('#mediaupload').dialog( "option", "position", { my: "center", at: "center", of: window } );
		}
		return false;

};

$.FroalaEditor.DefineIcon('mhupload', {NAME: 'dle dle-i-dleicon icon-up', template:'dleicons'});
    $.FroalaEditor.RegisterCommand('mhupload', {
      title: 'Uploading files',
      focus: true,
      undo: true,
      refreshAfterCallback: true,
      callback: function () {
      	active_editor = this;
		active_editor.selection.save();
        mh_media_upload( 
			this.opts.dle_upload_area, 
			this.opts.dle_upload_user, 
			this.opts.dle_upload_model_id, 
			this.opts.dle_upload_model_name, 
			this.opts.dle_upload_model_field
		);
    }
});
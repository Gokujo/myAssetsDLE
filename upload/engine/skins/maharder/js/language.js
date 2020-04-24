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
    let output;
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

$(() => {

    $('[data-action="translate"]').on('click', function () {
        ShowLoading('');
        let lang = $(this).data('lang'), textID = $(this).data('input'), hash = $(this).data('hash'), text = $(`[name="${textID}"]`).val();

        if (text === '') text = $(`[name="${textID}"]`).val();
        if (text !== '') {
            $.ajax({
                url: 'engine/ajax/controller.php?mod=maharder',
                data: {
                    user_hash: hash,
                    module: 'maharder',
                    file: 'languages',
                    action: 'translator',
                    text: text,
                    langInto: lang
                },
                type: 'POST',
                success: function (data) {
                    try {
                        data = JSON.parse(data);
                        let langInput = $(`[name="${textID}_${lang}"]`);

                        $(langInput).val(data.text[0]);
                        if (textID == 'short_story' || textID == 'full_story' || textID == 'template')
                            $(langInput).parent().find('.fr-element.fr-view').first().html('').html(data.text[0]);
                    } catch(e) {
                        console.log(e, data);
                    }
                    HideLoading('');
                }
            });
        } else {
            console.log('Text is empty');
            HideLoading('');
        }
    });

});

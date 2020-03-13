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
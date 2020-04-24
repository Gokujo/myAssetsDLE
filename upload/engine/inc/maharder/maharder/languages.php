<?php
////////////////////////////////////////////////////////////
// =======================================================
// Модуль: dle131.test
// Файл: languages.php
// Путь: /engine/inc/maharder/maharder/languages.php
// =======================================================
// Автор: Maxim Harder (c) 2020
// Сайт: https://maxim-harder.de / https://devcraft.club
// Телеграм: http://t.me/MaHarder
// =======================================================
// Ничего не менять
// =======================================================
////////////////////////////////////////////////////////////



echoheader( '<i class="fad fa-cogs"></i> '.$name.' '.$version.'<br><small>'.$descr.'</small>', array($adminlink => $name, '' => translate('Список языков')) );

$boxList = [

	'lang' => [
		'name' => translate('Список языков'),
		'icon' => 'fal fa-flag-usa',
	],
];

$data = $db->query('SELECT * FROM '. PREFIX .'_languages');

$thead = array('ID', translate('Языковой код'), translate('Сокращение (ISO-2)'), translate('Название'), translate('Интернациональное'), translate('Папка'), translate('Флаг'), translate('Доступен'), translate('Действие'));
$tbody = array();

while ($row = $db->get_array($data)) {

	$temp = array();
	$code = htmlspecialchars( stripslashes( $row['code'] ), ENT_QUOTES, $config['charset'] );
	$code = str_replace('&amp;', '&', $code );
	$code = "<div class=\"ui input\"><input type='text' name='code' value='{$code}' placeholder='".translate('Укажи интернациональный код языка. Пример: ru_RU')."'></div>";
	$iso2 = "<div class=\"ui input\"><input type='text' name='iso2' value='{$row['iso2']}' placeholder='".translate('Укажи интернациональный код языка в формате ISO-2. Пример: ru')."'></div>";

	$name = htmlspecialchars( stripslashes( $row['name'] ), ENT_QUOTES, $config['charset'] );
	$name = str_replace('&amp;', '&', $name );
	$_name = $name;
	$name = "<div class=\"ui input\"><input type='text' name='name' value='{$name}' placeholder='".translate('Укажите название языка.')."'>";
	$name .= "<input name='this_id' value='{$row['id']}' type='hidden'></div>";

	$int_name = htmlspecialchars( stripslashes( $row['international'] ), ENT_QUOTES, $config['charset'] );
	$int_name = str_replace('&amp;', '&', $int_name );
	$_int_name = $int_name;
	$int_name = "<div class=\"ui input\"><input type='text' name='international' value='{$int_name}' placeholder='".translate('Укажите название языка. Желательно в нативном правописании')."'>";

	$dir = htmlspecialchars( stripslashes( $row['dir'] ), ENT_QUOTES, $config['charset'] );
	$dir = str_replace('&amp;', '&', $dir );
	$dir = "<div class=\"ui input\"><input type='text' name='dir' value='{$dir}' placeholder='".translate('Укажите папку с языком в папке languages.')."'>";

	$flag = htmlspecialchars( stripslashes( $row['flag'] ), ENT_QUOTES, $config['charset'] );
	$flag = str_replace('&amp;', '&', $flag );
	if(!empty($flag)) $flag_img = '<img src="' . $flag . '" alt="' . $_name  . '" class="ui fluid image" style="max-width: 25px;width: 100%;height: 100%;vertical-align: middle;display: inline-block;">';
	else $flag_img = '';
	$flag = "<div class=\"ui input\">{$flag_img}<input type='text' name='flag' value='{$flag}' placeholder='".translate('Укажите ссылку на флаг языка.')."'>";

	$active = "<div class=\"ui checkbox\"><input type='checkbox' name=\"active\" " . ($row['active'] == 1 ? ' checked' : '') .">";

	$action = array();
	$action[] = "<div class=\"ui icon pointing dropdown link item\"><i class=\"wrench icon\"></i><span class=\"text\">" . translate('Действие') . "</span><i class=\"dropdown icon\"></i><div class=\"menu\">";
	$action[] = "<a data-action='list' class=' act_btn item' role='button' data-id='{$row['id']}'><i class=\"far fa-language\"></i> " . translate('Перевести') .'</a>';
	$action[] = "<a data-action='save' class=' act_btn item' role='button' data-id='{$row['id']}'><i class='fas fa-check'></i> " . translate('Сохранить') .'</a>';
	$action[] = "<a data-action='delete' class='act_btn item' role='button' data-id='{$row['id']}'><i class='fas fa-trash'></i> " . translate('Удалить') .'</a>';
	$action[] = "<a data-action='redo' data-lang='{$row['iso2']}' class='act_btn item' role='button' data-id='{$row['id']}'><i class='fas fa-refresh'></i> " . translate('Пересоздать') .'</a>';
	$action[] = '</div></div>';

	$temp[] = '#' .(int)$row['id'];
	$temp[] = $code;
	$temp[] = $iso2;
	$temp[] = $name;
	$temp[] = $int_name;
	$temp[] = $dir;
	$temp[] = $flag;
	$temp[] = $active;
	$temp[] = implode('', $action);

	$tbody[] = $temp;
	unset($temp);

}
$addLang = translate('Добавить язык');
$rebuildLang = translate('Перестроить языковые файлы');
$tfoot = <<<HTML
	<tr>
		<th colspan="9">
			<div class="ui buttons">
				<a href="#" role="button" class="ui button act_btn" data-action='new'>{$addLang}</a>
				<a href="#" role="button" class="ui button act_btn" data-action='rebuild_lang'>{$rebuildLang}</a>
			</div>
		</th>
	</tr>
HTML;


$mod_admin->segmentTable('lang', $mod_admin->createTable($tbody, $thead, $tfoot), true);
$mod_admin->setWebSite(saveButton(), 'footer');
$mod_admin->getWebSite();

$jsLang = [
	0 => translate('Добавить новый язык'),
	1 => translate('Языковой код'),
	2 => translate('Сокращённое название языка (ISO-2)'),
	3 => translate('Название языка'),
	4 => translate('Папка с языком системы'),
	5 => translate('Ссылка на флаг'),
	6 => translate('Включить язык?'),
	7 => translate('Сохранить'),
	8 => translate('Отмена'),
	9 => translate('Всё хорошо!'),
	10 => translate('Все данные были сохранены!'),
	11 => translate('Все возможные коды можно найти здесь: <a href="http://www.i18nguy.com/unicode/language-identifiers.html" target="_blank">i18nguy</a>'),
	12 => translate('Интернациональное название языка'),
	13 => translate('Пересоздание полей'),
	14 => translate('При выполнении этого действия будут удалены все существующие поля и их содержимое! Продолжить?'),
	15 => translate('Пересоздать'),
	16 => translate('Сохранить существующие данные'),
	17 => translate('Всё плохо!'),
];

echo <<<JSCRIPT
	<script> 
		const hash = '{$dle_login_hash}';
	
		$(() => {
	        $('.ui.buttons .fas').hide();
	        $(document).on('click', '.act_btn', function () {
	            const parent = $(this).parents('tr'), id = $(this).data('id'), code = $(parent).find('[name="code"]').val
	            (), flag = $(parent).find('[name="flag"]').val(), name = $(parent).find('[name="name"]').val(), iso2 = $
	            (parent).find('[name="iso2"]').val(), dir = $(parent).find('[name="dir"]').val(), active = $(parent).find
	            ('[name="active"]').val(), inter = $(parent).find('[name="international"]').val(), action = $(this).data
	            ('action');
	            startLoading();
		        if(action === 'save' || action === 'delete') {
		            $.ajax({
		                url: 'engine/ajax/controller.php?mod=maharder',
		                data: {
		                    user_hash: hash,
		                    module: '{$codename}',
		                    file: 'languages',
		                    id: id,
		                    code: code,
		                    flag: flag,
		                    name: name,
		                    international: inter,
		                    iso2: iso2,
		                    dir: dir,
		                    active: active,
		                    action: action,
		                },
		                type: 'POST',
		                success: function (data) {
		                    if(action === "delete")  $(parent).hide();
		                    hideLoading('');
		                    $(this).find('.fas').fadeIn('slow');
		                    setTimeout("$(this).find('.fas').fadeOut('slow');", 2000);
		                }
		            });
		        } else if (action === 'redo'){
		            $.confirm({
		                title: '{$jsLang[13]}',
		                content: '<div class="ui message warning">' +
		                 '{$jsLang[14]}' +
		                 '</div>' +
		                  '<div class="ui checkbox">' +
		                   '<input type="checkbox" id="onlyNew" name="onlyNew">' +
		                    '<label for="onlyNew">{$jsLang[16]}</label>' +
		                    '</div>' ,
		                buttons: {
		                    spreichern: {
		                        text: '{$jsLang[15]}',
		                        btnClass: 'ui button green',
		                        keys: ['enter'],
		                        action: function(){
		                            let  iso2 = $('[data-action="redo"][data-id="' + id + '"]').first().data('lang'),
		                             onlyNew = $(document).find('#onlyNew').first().val();
		                            $.ajax({
		                                url: 'engine/ajax/controller.php?mod=maharder',
		                                data: {
		                                    user_hash: hash,
		                                    module: '{$codename}',
		                                    file: 'languages',
		                                    action: action,
		                                    iso2: iso2,
		                                    onlyNew: onlyNew,
		                                },
		                                type: 'POST',
		                                success: function (data) {
		                                    console.log(data);
		                                    $(this).find('.fas').fadeIn('slow');
		                                    setTimeout(()=>{
		                                    	$(this).find('.fas').fadeOut('slow');
		                                    }, 2000);
			                                hideLoading('');
		                                }
		                            });
		                    	}
		                	},
		                	abbrechen: {
			                    text: '{$jsLang['8']}',
			                    btnClass: 'ui button red',
			                    keys: ['esc'],
			                    action: function () {
			                        hideLoading();
			                    }
		                	},
		            	}
		            });
		        } else if (action === 'new') {
		            $.confirm({
		                title: '{$jsLang[0]}',
		                content: '<div class="ui form">' +
		                 '<div class="field">' +
		                    '<label for="new_code">{$jsLang[1]}</label>' +
		                    '<input type="text" name="new_code" id="new_code" placeholder="{$jsLang[1]}" required>' +
		                     '<small>{$jsLang[11]}</small>' +
		                 '</div>' +
		                 '<div class="field">' +
		                    '<label for="new_iso2">{$jsLang[2]}</label>' +
		                    '<input type="text" name="new_iso2" id="new_iso2" placeholder="{$jsLang[2]}" required>' +
		                 '</div>' +
		                 '<div class="field">' +
		                    '<label for="new_name">{$jsLang[3]}</label>' +
		                    '<input type="text" name="new_name" id="new_name" placeholder="{$jsLang[3]}" required>' +
		                 '</div>' +
		                 '<div class="field">' +
		                    '<label for="new_international">{$jsLang[12]}</label>' +
		                    '<input type="text" name="new_international" id="new_international" placeholder="{$jsLang[12]}" required>' +
		                 '</div>' +
		                 '<div class="field">' +
		                    '<label for="new_dir">{$jsLang[4]}</label>' +
		                    '<input type="text" name="new_dir" id="new_dir" placeholder="{$jsLang[4]}" required>' +
		                 '</div>' +
		                 '<div class="field">' +
		                    '<label for="new_flag">{$jsLang[5]}</label>' +
		                    '<input type="text" name="new_flag" id="new_flag" placeholder="{$jsLang[5]}">' +
		                 '</div>'  +
		                 '<div class="field">' +
		                    '<div class="ui checkbox">' +
		                    '<input type="checkbox" name="new_active" id="new_active" placeholder="{$jsLang[6]}" checked>' +
		                     '<label for="new_active">{$jsLang[6]}</label>' +
		                 '</div></div>' +
		                  '</div>',
		                buttons: {
		                    spreichern: {
		                        text: '{$jsLang[7]}',
		                        btnClass: 'ui button green',
		                        keys: ['enter'],
		                        action: function(){
		                            let new_code = $('#new_code').val(), new_iso2 = $('#new_iso2').val(), new_name = $('#new_name').val(), new_dir = $('#new_dir').val(), new_flag = $('#new_flag').val(), new_active = $('#new_active').val(), new_international = $('#new_international').val();
		                            $.ajax({
		                                url: 'engine/ajax/controller.php?mod=maharder',
		                                data: {
		                                    user_hash: hash,
		                                    module: '{$codename}',
		                                    file: 'languages',
		                                    action: action,
						                    code: new_code,
						                    flag: new_flag,
						                    name: new_name,
						                    international: new_international,
						                    iso2: new_iso2,
						                    dir: new_dir,
						                    active: new_active,
		                                },
		                                type: 'POST',
		                                success: function (data) {
		                                    $(this).find('.fas').fadeIn('slow');
		                                    setTimeout("$(this).find('.fas').fadeOut('slow');", 2000);
		                                    
		                                }
		                            }).then(()=>{
		                                window.location.reload();
		                        	hideLoading();
		                            });
		                    	}
		                	},
			                abbrechen: {
			                    text: '{$jsLang['8']}',
			                    btnClass: 'ui button red',
			                    keys: ['esc'],
			                    action: function () {
			                        hideLoading();
			                    }
			                },
		            	}
	            	});
		        } else {
		            $.ajax({
		                url: 'engine/ajax/controller.php?mod=maharder',
		                data: {
		                    user_hash: hash,
		                    module: '{$codename}',
		                    file: 'languages',
		                    action: action,
		                },
		                type: 'POST',
		                success: function (data) {
		                    let title = '{$jsLang[9]}', descr = '{$jsLang[10]}';
		                    if(data !== 'ok') {
		                        title = '{$jsLang[17]}';
		                        descr = data;
		                    }
		                    $.alert({
                                title: title,
                                content: descr,
							});
		                    $(this).find('.fas').fadeIn('slow');
		                    setTimeout("$(this).find('.fas').fadeOut('slow');", 2000);
		                                    
		                }
                    }).then(()=>{
		               	hideLoading();
		            });
		        }
		    });
		    $(document).on('click', '.save', function () {
		        var rows = $('[data-tab="lang"] table tbody tr'), data = [];
		        $(rows).each(function () {
		            let id = $(this).find('[name="this_id"]').val(), code = $(this).find('[name="code"]').val()
		            , flag = $(this).find('[name="flag"]').val(), name = $(this).find('[name="name"]').val(), international = $
		            (this).find('[name="international"]').val(), iso2 = $(this).find('[name="iso2"]').val(), dir = $(this).find('[name="dir"]').val(), active = $(this).find('[name="active"]').val(), temp = {};
		            temp = {
			            id: id,
			            code: code,
			            flag: flag,
			            name: name,
			            international: international,
			            iso2: iso2,
			            dir: dir,
			            active: active,
		            };
		            data.push(temp);
		        });
		
		        $.ajax({
		            url: 'engine/ajax/controller.php?mod=maharder',
		            data: {
		                user_hash: hash,
		                module: '{$codename}',
		                file: 'languages',
		                action: 'saveAll',
		                data: JSON.stringify(data)
		            },
		            type: 'POST',
		            success: function (data) {
		                hideLoading('');
		                $.alert('{$jsLang['10']}', '{$jsLang['9']}');
		            }
		        });
		    });
		});
	</script>
JSCRIPT;


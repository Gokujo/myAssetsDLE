<?php

//	===============================
//	Настройки модуля | главная
//	===============================
//	Автор: Maxim Harder
//	Сайт: https://maxim-harder.de
//	Телеграм: http://t.me/MaHarder
//	===============================
//	Ничего не менять
//	===============================

global $i18n, $i18n_lang;

echoheader( '<i class="fad fa-cogs"></i> '.$name.' '.$version.'<br><small>'.$descr.'</small>', $name);

$boxList = [
    'lang' => [
	    'name' => translate('Языковые настройки'),
	    'icon' => 'fas fa-flag',
    ],
    'dev' => [
	    'name' => translate('Настройки разработчика'),
	    'icon' => 'fas fa-bug',
    ],
	'author' => [
		'name' => translate('Автор'),
		'icon' => 'fas fa-user-circle',
	],
];
$mod_admin->boxes($boxList);

$lang_list = [];
foreach($i18n_lang['names'] as $id => $lang) {
	$lang_list[$lang['code']] = $lang['name'];
}

$blockLang = [
	segRow(translate('Язык'), translate('Список языков'), '<a href="' . $adminlink . '&section=languages" role="button" class="ui primary button">' . translate('Перейти') . '</a>'),
	segRow2(translate('Стандартный язык'), translate('Язык по умолчанию, пока пользователь не переключит его на свой'), 'default_language', $mod_config, 'select', $lang_list),
	segRow2(translate('Запасной язык'), translate('Если у основного языка не будет перевода или произойдёт какая-либо ошибка, то на какой язык переключить?'),	'fallback_language', $mod_config,	'select', $lang_list),
	segRow2(translate('Путь до языковых файлов'), translate('Стандартный путь до языковых файлов /locales.'),	'path', $mod_config,	'input'),
	segRow2(translate('Переменная для COOKIE'), translate('Используемый язык будет браться из куки браузера.'),	'cookieField', $mod_config,'input'),
];

$blockDev = [
	segRow2(translate('Отлажка'), translate('Включить отлаживание ошибок в системе. Это поможет в разработке и выявлении неисправностей в скриптах'),	'debug', $mod_config,'checkbox'),
];

$blockAuthor = [
	segRow(translate('Автор'), '', author('name')),
	segRow(translate('Документация'), translate('Инструкции по установке, использованию, обновлению...'), "<a href=\"{$doc_link}\">{$doc_link}</a>"),
	segRow(translate('Связь'), '', author('social')),
	segRow(translate('Версия модуля'), '', $version),
	segRow(translate('Изменения'), '', author('changes')),
];

$mod_admin->segment('lang', $blockLang);
$mod_admin->segment('dev', $blockDev);
$mod_admin->segment('author', $blockAuthor);

$mod_admin->setWebSite(saveButton(), 'footer');

$mod_admin->getWebSite();

$ok_message = [
	translate('Всё хорошо!'),
	translate('Все данные были сохранены!')
];

echo <<<JSCRIPT
	<script>
		$(() => {
			$(document).on('click', '.save', function() {
				$.ajax({
					url: 'engine/ajax/controller.php?mod=maharder',
					data: {
						user_hash: '{$dle_login_hash}',
						module: '{$codename}',
						file: 'save',
						method: 'settings',
						data: $('.form').serializeArray()
					},
					type: 'POST',
					success: function (data) {
					    console.log(data)
						hideLoading('');
						$.alert( '{$ok_message[1]}', '{$ok_message[0]}');
					}
				});
			});
		});
	</script>
JSCRIPT;

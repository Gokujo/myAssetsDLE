<?php
//	===============================
//	Документация к модулю
//	===============================
//	Автор: Maxim Harder
//	Сайт: https://maxim-harder.de
//	Телеграм: http://t.me/MaHarder
//	===============================
//	Ничего не менять
//	===============================

if( !defined( 'DATALIFEENGINE' ) ) die( "Oh! You little bastard!" );

echoheader( "<i class=\"cogs icon\"></i> ".$name." ".$version."<br><small>".$descr."</small>", array($adminlink => $name, '' => "Документация") );

$helplink = "http://help.maxim-harder.de/forum/31-telegram-posting/";
$sitelink = "https://maxim-harder.de/dle/71-telegram-posting.html";

$jsfiles[] = 'engine/skins/maharder/js/prettify.js';
$jsfiles[] = 'engine/skins/maharder/js/run_prettify.js';
$cssfiles[] = 'engine/skins/maharder/cdd/prettify.css';

$boxList = [
    'install' => [
        'name' => "Установка",
        'icon' => "tasks icon",
    ],
    'dates' => [
        'name' => "Формат дат",
        'icon' => "tasks icon",
    ],
    'update13' => [
        'name' => "Обновление с 1.2 до 1.3",
        'icon' => "tasks icon",
    ],
    'update12' => [
        'name' => "Обновление с 1.1 до 1.3",
        'icon' => "tasks icon",
    ],
    'changelog' => [
        'name' => "Изменения",
        'icon' => "sitemap icon",
    ]
];

$columnOne = docMenu($boxList);

$install = [
    addDocItem(
        'list ol icon',
        'Установка',
        "Обновляемая документация всегда <a href=\"{$helplink}\" target=\"_blank\">здесь  <i class=\"external alternate icon\"></i></a>",
        stepByStep(array(
            "Установите <b>модуль</b> в админпанеле <a href=\"{$config['http_home_url']}{$config['admin_path']}?mod=plugins\" target=\"_blank\">через систему плагинов  <i class=\"external alternate icon\"></i></a>",
            "Открываем <b>/cron.php</b> и ищем <pre class=\"prettyprint linenums\">\$allow_cron = 0;</pre> и меняем значение на <pre class=\"prettyprint linenums\">\$allow_cron = 1;</pre>",
            "Ищем в <b>/cron.php</b> <pre class=\"prettyprint linenums\">} elseif(\$cronmode == \"antivirus\") {</pre> и ставим выше <pre class=\"prettyprint linenums\">} elseif(\$cronmode == \"telegram\") {
            include_once (DLEPlugins::Check(ENGINE_DIR . \"/ajax/maharder/telegram/cronadd.php\"));
            die (\"done\");
</pre>"
        ))
    ),
];

$update14 = [
    addDocItem(
        'list ol icon',
        'Обновление с 1.3 до 1.x',
        "Обновляемая документация всегда <a href=\"{$helplink}\" target=\"_blank\">здесь  <i class=\"external alternate icon\"></i></a>",
        stepByStep(array(
            'Обновите <b>модуль</b> в админпанеле <a href=\"{$config[\'http_home_url\']}{$config[\'admin_path\']}?mod=plugins\" target=\"_blank\">через систему плагинов  <i class=\"external alternate icon\"></i></a>',
        ))
    ),
];

$update13 = [
    addDocItem(
        'list ol icon',
        'Обновление с 1.2 до 1.3',
        "Обновляемая документация всегда <a href=\"{$helplink}\" target=\"_blank\">здесь  <i class=\"external alternate icon\"></i></a>",
        stepByStep(array(
            'Удалить все файлы связанные с TelegramPosting. <ul><li>engine/ajax/maharder/telegram</li><li>engine/inc/maharder/telegram</li><li>engine/skins/images/telegram.png</li></ul>',
            'Удалить все файлы связанные с авторской админкой. <ul><li>engine/skins/maharder</li><li>engine/inc/maharder/assets</li></ul>',
            'Установить плагин через менеджер плагинов'
        ))
    ),
];

$update12 = [
    addDocItem(
        'list ol icon',
        'Обновление с 1.1 до 1.3',
        "Обновляемая документация всегда <a href=\"{$helplink}\" target=\"_blank\">здесь  <i class=\"external alternate icon\"></i></a>",
        stepByStep(array(
            'Удалить все файлы связанные с TelegramPosting. <ul><li>engine/ajax/maharder/telegram</li><li>engine/inc/maharder/telegram</li><li>engine/skins/images/telegram.png</li></ul>',
            'Удалить все файлы связанные с авторской админкой. <ul><li>engine/skins/maharder</li><li>engine/inc/maharder/assets</li></ul>',
            'Установить плагин через менеджер плагинов',
            "Открываем <b>/cron.php</b> и ищем <pre class=\"prettyprint linenums\">\$allow_cron = 0;</pre> и меняем значение на <pre class=\"prettyprint linenums\">\$allow_cron = 1;</pre>",
            "Ищем в <b>/cron.php</b> <pre class=\"prettyprint linenums\">} elseif(\$cronmode == \"antivirus\") {</pre> и ставим выше <pre class=\"prettyprint linenums\">} elseif(\$cronmode == \"telegram\") {
            include_once (DLEPlugins::Check(ENGINE_DIR . \"/ajax/maharder/telegram/cronadd.php\"));
            die (\"done\");
</pre>"
        ))
    ),
];

$changelog = [
    addDocItem(
        'sitemap icon',
        'Изменения в версиях',
        "Обновляемая документация всегда <a href=\"{$helplink}\" target=\"_blank\">здесь  <i class=\"external alternate icon\"></i></a>",
        author('changes')
    ),
];

$columnTwo = docBoxes('install', $install, true);
$columnTwo .= docBoxes('update14', $update14);
$columnTwo .= docBoxes('update13', $update13);
$columnTwo .= docBoxes('update12', $update12);
$columnTwo .= docBoxes('changelog', $changelog);

docPage($columnOne,$columnTwo);

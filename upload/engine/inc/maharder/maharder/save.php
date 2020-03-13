<?php

//	===============================
//	Настройки модуля | сохраняем
//	===============================
//	Автор: Maxim Harder
//	Сайт: https://maxim-harder.de
//	Телеграм: http://t.me/MaHarder
//	===============================
//	Ничего не менять
//	===============================

echoheader( "<i class=\"cogs icon\"></i> ".$name." ".$version."<br><small>".$descr."</small>", array($adminlink => $name, $adminlink => 'Настройки', '' => "Сохранение настроек") );

$save_con = $_REQUEST['save'];
$handler = fopen(ENGINE_DIR . '/data/'.$codename.'.php', "w");
	
fwrite($handler, "<?PHP\n//	===============================\n//	Конфигурация модуля\n//	===============================\n//	Автор: Maxim Harder\n//	Сайт: https://maxim-harder.de\n//	Телеграм: http://t.me/MaHarder\n//	===============================\n//	Меняем, если скрипт неверно сохраняет\n//	===============================\n\n\$xfdate = array (\n");
foreach ($save_con as $name => $value) {
	$value = htmlspecialchars($value);
	fwrite($handler, "\t'{$name}' => \"{$value}\",\n");
}
fwrite($handler, ");\n?>");
fclose($handler);
	
clear_cache();

messageOut("Настройки сохранены", "Чтобы проверить - сохранились ли они - перейдите на страницу с настройками.", array($adminlink => "Настройки"));

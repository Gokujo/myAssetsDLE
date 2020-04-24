<?php
////////////////////////////////////////////////////////////
// =======================================================
// Mod: MaHarder Assets
// File: list.php
// Path: /engine/inc/maharder/assets/include/inc/email/list.php
// =======================================================
// Author: Maxim Harder (c) 2020
// Website: https://maxim-harder.de / https://devcraft.club
// Telegram: http://t.me/MaHarder
// =======================================================
// Do not change anything!
// =======================================================
////////////////////////////////////////////////////////////

$db->query( "SELECT * FROM " . PREFIX . "_email" );
$mailTemplateLang = [];

while ( $row = $db->get_row() ) {
	foreach ($i18n_lang['active'] as $code => $lang_ar) {
		$iso = $lang_ar['iso2'];
		if ($i18n->getLocale() == $code || empty($row['template_' . $iso])) {
			$mailTemplateLang[$row['name']][$iso] = htmlspecialchars_decode (stripslashes(html_entity_decode($row['template'], ENT_QUOTES, $config['charset'])));
		} else {
			$mailTemplateLang[$row['name']][$iso] = htmlspecialchars_decode (stripslashes(html_entity_decode($row['template_'.$iso], ENT_QUOTES, $config['charset'])));
		}
	}
}
$db->free();

if (!function_exists('createTabs')) {
	function createTabs($name) {
		global $i18n_lang, $i18n, $mail_template, $mailTemplateLang;

		$template = '<ul class="nav nav-tabs nav-tabs-solid">';

		$count = 0;
		foreach ($i18n_lang['active'] as $code => $lang_ar) {
			if($count == 0) $active = 'class="active"';
			else $active = '';
			$title = $lang_ar['name'] . ' / ' . $lang_ar['international'];
			$template .= "<li {$active}><a href=\"#{$name}_{$code}\" data-toggle=\"tab\"><img src='{$lang_ar['flag']}' alt='{$title}' title='{$title}' style=\"max-width: 23px;width: 100%;height: auto;\">  {$title}</a></li>";
			$count++;
		}
		$template .= '</ul><div class="panel-tab-content tab-content">';

		$count = 0;
		foreach ($i18n_lang['active'] as $code => $lang_ar) {
			if($count == 0) $active = 'active';
			else $active = '';
			if ($i18n->getLocale() == $code) {
				$iso = '';
				$useTemplate = $mail_template[$name];
			} else {
				$iso = '_' . $lang_ar['iso2'];
				$useTemplate = $mailTemplateLang[$name][$lang_ar['iso2']];
			}

			$template .= <<<HTML
				<div class="tab-pane {$active}" id="{$name}_{$code}">
					<textarea class="classic" rows="15" style="width:100%;" name="{$name}{$iso}">{$useTemplate}</textarea>
				</div>
HTML;
			$count++;
		}
		$template .= '</div>';

		echo $template;
	}
}
<?php
////////////////////////////////////////////////////////////
// =======================================================
// Mod: MaHarder Assets
// File: table.php
// Path: /engine/inc/maharder/assets/include/inc/usergroups/tabler.php
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

$grNameT = [];

foreach ($i18n_lang['active'] as $code => $lang_ar) {
	$iso = $lang_ar['iso2'];
	$titleName = "<img src='{$lang_ar['flag']}' alt='{$title}' title='{$title}' style='max-width: 23px;width: 100%;height: auto;'> " . $lang_ar['name'] . ' (' . $lang_ar['international'] . ')';
	if( $action == "add" ) {
		$grNameT[$iso] = '';
	} else {
		if ($i18n->getLocale() == $code) continue;
		$grNameT[$iso] = htmlspecialchars( stripslashes( $user_group[$id]['group_name_' . $iso] ), ENT_QUOTES,
			$config['charset'] );
	}

}

foreach ($i18n_lang['active'] as $code => $lang_ar) {
	if ($i18n->getLocale() == $code) continue;
	$iso = $lang_ar['iso2'];
	$titleName = "<img src='{$lang_ar['flag']}' alt='{$title}' title='{$title}' style='max-width: 23px;width: 100%;height: auto;'> " . $lang_ar['name'] . ' (' . $lang_ar['international'] . ')';
	$content = <<<HTML
    <tr>
        <td style="width:58%"><h6 class="media-heading text-semibold">{$lang['group_name']} {$titleName}</h6><span 
        class="text-muted text-size-small hidden-xs">{$lang['hint_gtitle']}</span>
HTML;
	$content .= setTranslator($lang_ar['iso2'], 'group_name');
	$content .= <<<HTML
</td>
        <td style="width:42%"><input type="text" class="form-control" name="group_name_{$iso}" value="{$grNameT[$iso]}"></td>
    </tr>
HTML;

	echo $content;
}
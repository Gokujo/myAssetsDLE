<?php
//===============================================================
// Mod: MaHarder Assets                                         =
// File: preEdit.php                                            =
// Path: /engine/inc/maharder/assets/include/inc/static/preEdit.php
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

//global $row;
//
//echo "<pre>";
//var_dump($row);
//echo "</pre>";

foreach ($i18n_lang['active'] as $code => $lang_ar) {
	$iso = $lang_ar['iso2'];
	if ($i18n->getLocale() == $code) {
		if (!empty($row['template_' . $iso])) $row['template'] = $row['template_' . $iso];
		if (!empty($row['descr_' . $iso])) $row['descr'] = $row['descr_' . $iso];
		if (!empty($row['metatitle_' . $iso])) $row['metatitle'] = $row['metatitle_' . $iso];
		if (!empty($row['metadescr_' . $iso])) $row['metadescr'] = $row['metadescr_' . $iso];
		if (!empty($row['metakeys_' . $iso])) $row['metakeys'] = $row['metakeys_' . $iso];
	}
	if ($row['allow_br'] == 2) {
		$row['template_' . $iso] = htmlspecialchars( stripslashes( $row['template_' . $iso] ), ENT_QUOTES, $config['charset'] );
	} else {
		if( $row['allow_br'] != '1' or $config['allow_static_wysiwyg'] ) {
			$row['template_' . $iso] = $parse->decodeBBCodes( $row['template_' . $iso], true, $config['allow_static_wysiwyg'] );
		} else {
			$row['template_' . $iso] = $parse->decodeBBCodes( $row['template_' . $iso], false );
		}
	}
	$row['descr_' .$iso]    = stripslashes($row['descr_' . $iso]);
	$row['metatitle_' . $iso] = stripslashes($row['metatitle_' . $iso]);
	$row['metadescr_' . $iso] = stripslashes($row['metadescr_' . $iso]);
	$row['metakeys_' . $iso] = stripslashes($row['metakeys_' . $iso]);

}
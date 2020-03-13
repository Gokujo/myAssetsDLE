<?php
////////////////////////////////////////////////////////////
// =======================================================
// Mod: MaHarder Assets
// File: preEdit.php
// Path: /engine/inc/maharder/assets/include/inc/categories/preEdit.php
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

foreach ($i18n_lang['active'] as $code => $lang_ar) {
	$iso = $lang_ar['iso2'];
	if ($i18n->getLocale() == $code) {
		if (!empty($row['name_' . $iso])) $row['name'] = $row['name_' . $iso];
		if (!empty($row['metatitle_' . $iso])) $row['metatitle'] = $row['metatitle_' . $iso];
		if (!empty($row['descr_' . $iso])) $row['descr'] = $row['descr_' . $iso];
		if (!empty($row['keywords_' . $iso])) $row['keywords'] = $row['keywords_' . $iso];
		if (!empty($row['fulldescr_' . $iso])) $row['fulldescr'] = $row['fulldescr_' . $iso];

		$row['name'] = stripslashes( preg_replace( array ("'\"'", "'\''" ), array ("&quot;", "&#039;" ), $row['name'] ) );
		$row['metatitle'] = stripslashes( preg_replace( array ("'\"'", "'\''" ), array ("&quot;", "&#039;" ), $row['metatitle'] ) );
		$row['descr'] = stripslashes( preg_replace( array ("'\"'", "'\''" ), array ("&quot;", "&#039;" ), $row['descr'] ) );
		$row['keywords'] = stripslashes( preg_replace( array ("'\"'", "'\''" ), array ("&quot;", "&#039;" ), $row['keywords'] ) );
	} else {
		$row['name_' . $iso] = stripslashes( preg_replace( array ("'\"'", "'\''" ), array ("&quot;", "&#039;" ), $row['name_' . $iso] ) );
		$row['metatitle_' . $iso] = stripslashes( preg_replace( array ("'\"'", "'\''" ), array ("&quot;", "&#039;" ), $row['metatitle_' . $iso] ) );
		$row['descr_' . $iso] = stripslashes( preg_replace( array ("'\"'", "'\''" ), array ("&quot;", "&#039;" ), $row['descr_' . $iso] ) );
		$row['keywords_' . $iso] = stripslashes( preg_replace( array ("'\"'", "'\''" ), array ("&quot;", "&#039;" ), $row['keywords_' . $iso] ) );
		$row['fulldescr_' . $iso] = stripslashes( preg_replace( array ("'\"'", "'\''" ), array ("&quot;", "&#039;" ), $row['fulldescr_' . $iso] ) );
	}
}
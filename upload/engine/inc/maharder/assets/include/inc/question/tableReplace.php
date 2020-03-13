<?php
////////////////////////////////////////////////////////////
// =======================================================
// Mod: MaHarder Assets
// File: tableReplace.php
// Path: /engine/inc/maharder/assets/include/inc/question/tableReplace.php
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

$tableReplaces = '<div id="langData_' . $row['id'] . '">';

foreach ($i18n_lang['active'] as $code => $lang_ar) {
	$iso = $lang_ar['iso2'];
	if ($i18n->getLocale() == $code) {
		if(!empty($row['question_' . $iso]))
			$row['question'] = htmlspecialchars( stripslashes($row['question_' . $iso]), ENT_QUOTES, $config['charset'] );

		if(!empty($row['answer_' . $iso]))
			$row['answer'] = htmlspecialchars( stripslashes($row['answer_' . $iso]), ENT_QUOTES, $config['charset'] );
	} else {
		$tableReplaces .= "<textarea id='answer_{$row['id']}_{$iso}' data-question='{$row['question_' . $iso]}' style='display:none;'>{$row['answer_' . $iso]}</textarea>";
	}

}

$tableReplaces .= '</div>';
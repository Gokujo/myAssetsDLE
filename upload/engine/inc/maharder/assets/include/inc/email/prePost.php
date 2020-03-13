<?php
////////////////////////////////////////////////////////////
// =======================================================
// Mod: MaHarder Assets
// File: prePost.php
// Path: /engine/inc/maharder/assets/include/inc/email/prePost.php
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

$regMailLang = [];
$feedMailLang = [];
$lostMailLang = [];
$newNewsLang = [];
$commentsLang = [];
$pmLang = [];
$newsletterLang = [];
$waitMailLang = [];
$twofactorLang = [];

foreach ($i18n_lang['active'] as $code => $lang_ar) {
	$iso = $lang_ar['iso2'];
	if ($i18n->getLocale() == $code) {
		$regMailLang[$iso]    = $db->safesql($_POST['reg_mail']);
		$feedMailLang[$iso]   = $db->safesql($_POST['feed_mail']);
		$lostMailLang[$iso]   = $db->safesql($_POST['lost_mail']);
		$newNewsLang[$iso]    = $db->safesql($_POST['new_news']);
		$commentsLang[$iso]   = $db->safesql($_POST['comments']);
		$pmLang[$iso]         = $db->safesql($_POST['pm']);
		$newsletterLang[$iso] = $db->safesql($_POST['newsletter']);
		$waitMailLang[$iso]   = $db->safesql($_POST['wait_mail']);
		$twofactorLang[$iso]  = $db->safesql($_POST['twofactor']);
	} else {
		$regMailLang[$iso]    = $db->safesql($_POST['reg_mail_'.$iso]);
		$feedMailLang[$iso]   = $db->safesql($_POST['feed_mail_'.$iso]);
		$lostMailLang[$iso]   = $db->safesql($_POST['lost_mail_'.$iso]);
		$newNewsLang[$iso]    = $db->safesql($_POST['new_news_'.$iso]);
		$commentsLang[$iso]   = $db->safesql($_POST['comments_'.$iso]);
		$pmLang[$iso]         = $db->safesql($_POST['pm_'.$iso]);
		$newsletterLang[$iso] = $db->safesql($_POST['newsletter_'.$iso]);
		$waitMailLang[$iso]   = $db->safesql($_POST['wait_mail_'.$iso]);
		$twofactorLang[$iso]  = $db->safesql($_POST['twofactor_'.$iso]);
	}
}

foreach ($i18n_lang['active'] as $code => $lang_ar) {
	$dle_prefix = PREFIX;
	$iso = $lang_ar['iso2'];
	if ($i18n->getLocale() == $code) {
		$db->query( "UPDATE {$dle_prefix}_email SET template='{$regMailLang[$iso]}', use_html='$reg_mail_html' WHERE name='reg_mail'" );
		$db->query( "UPDATE {$dle_prefix}_email SET template='{$feedMailLang[$iso]}', use_html='$feed_mail_html' WHERE name='feed_mail'" );
		$db->query( "UPDATE {$dle_prefix}_email SET template='{$lostMailLang[$iso]}', use_html='$lost_mail_html' WHERE name='lost_mail'" );
		$db->query( "UPDATE {$dle_prefix}_email SET template='{$newNewsLang[$iso]}', use_html='$new_news_html' WHERE name='new_news'" );
		$db->query( "UPDATE {$dle_prefix}_email SET template='{$commentsLang[$iso]}', use_html='$new_comments_html' WHERE name='comments'" );
		$db->query( "UPDATE {$dle_prefix}_email SET template='{$pmLang[$iso]}', use_html='$new_pm_html' WHERE name='pm'" );
		$db->query( "UPDATE {$dle_prefix}_email SET template='{$newsletterLang[$iso]}', use_html='1' WHERE name='newsletter'" );
		$db->query( "UPDATE {$dle_prefix}_email SET template='{$waitMailLang[$iso]}', use_html='$wait_mail_html' WHERE name='wait_mail'" );
		$db->query( "UPDATE {$dle_prefix}_email SET template='{$twofactorLang[$iso]}', use_html='$twofactor_html' WHERE name='twofactor'" );
	}
	$db->query( "UPDATE {$dle_prefix}_email SET template_{$iso}='{$regMailLang[$iso]}' WHERE name='reg_mail'" );
	$db->query( "UPDATE {$dle_prefix}_email SET template_{$iso}='{$feedMailLang[$iso]}' WHERE name='feed_mail'" );
	$db->query( "UPDATE {$dle_prefix}_email SET template_{$iso}='{$lostMailLang[$iso]}' WHERE name='lost_mail'" );
	$db->query( "UPDATE {$dle_prefix}_email SET template_{$iso}='{$newNewsLang[$iso]}' WHERE name='new_news'" );
	$db->query( "UPDATE {$dle_prefix}_email SET template_{$iso}='{$commentsLang[$iso]}' WHERE name='comments'" );
	$db->query( "UPDATE {$dle_prefix}_email SET template_{$iso}='{$pmLang[$iso]}' WHERE name='pm'" );
	$db->query( "UPDATE {$dle_prefix}_email SET template_{$iso}='{$newsletterLang[$iso]}' WHERE name='newsletter'" );
	$db->query( "UPDATE {$dle_prefix}_email SET template_{$iso}='{$waitMailLang[$iso]}' WHERE name='wait_mail'" );
	$db->query( "UPDATE {$dle_prefix}_email SET template_{$iso}='{$twofactorLang[$iso]}' WHERE name='twofactor'" );
}
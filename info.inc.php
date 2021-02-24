<?php

/**
 * checkin | flatCore Modul
 * Configuration File
 */

if(FC_SOURCE == 'backend') {
	$mod_root = '../modules/';
} else {
	$mod_root = 'modules/';
}

include $mod_root.'checkin.mod/lang/en/dict.php';

if(is_file($mod_root.'checkin.mod/lang/'.$languagePack.'/dict.php')) {
	include $mod_root.'checkin.mod/lang/'.$languagePack.'/dict.php';
}

$mod = array(
	"name" => "checkin",
	"version" => "0.1.2",
	"author" => "Patrick Konstandin",
	"description" => "Guest check-in - log personal data for restaurants and/or events",
	"database" => "content/SQLite/checkin.sqlite3"
);


/* acp navigation */
$modnav[] = array('link' => $checkin_lang['nav_dashboard'], 'title' => $checkin_lang['nav_dashboard_title'], 'file' => "start");
$modnav[] = array('link' => $checkin_lang['nav_preferences'], 'title' => $checkin_lang['nav_preferences_title'], 'file' => "prefs");

?>
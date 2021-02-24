<?php
/**
 * @addon	checkin
 * backend preferences
 */
 

if(!defined('FC_INC_DIR')) {
	die("No access");
}

include __DIR__.'/include.php';

echo '<h3>'.$mod_name.' '.$mod_version.' <small>| '.$checkin_lang['nav_preferences'].'</small></h3>';



if(isset($_POST['save_prefs'])) {
	
	$dbh = new PDO("sqlite:$mod_db");
	$sql = "UPDATE preferences
					SET entry_lifetime = :entry_lifetime,
							snippet_intro = :snippet_intro,
							snippet_privacy_policy = :snippet_privacy_policy,
							snippet_checkin_success = :snippet_checkin_success,
							ignore_inline_css = :ignore_inline_css
					WHERE status = 'active' ";
	$sth = $dbh->prepare($sql);
	$sth->bindParam(':entry_lifetime', $_POST['entry_lifetime'], PDO::PARAM_STR);
	$sth->bindParam(':snippet_intro', $_POST['snippet_intro'], PDO::PARAM_STR);
	$sth->bindParam(':snippet_privacy_policy', $_POST['snippet_privacy_policy'], PDO::PARAM_STR);
	$sth->bindParam(':snippet_checkin_success', $_POST['snippet_checkin_success'], PDO::PARAM_STR);
	$sth->bindParam(':ignore_inline_css', $_POST['ignore_inline_css'], PDO::PARAM_STR);
	$cnt_changes = $sth->execute();
	$dbh = null;
}


$checkin_prefs = checkin_get_preferences();

$entry_lifetime = $checkin_prefs['entry_lifetime'];
$snippet_intro = $checkin_prefs['snippet_intro'];
$snippet_privacy_policy = $checkin_prefs['snippet_privacy_policy'];
$snippet_checkin_success = $checkin_prefs['snippet_checkin_success'];
$ignore_inline_css = $checkin_prefs['ignore_inline_css'];

if($entry_lifetime == '') {
	$entry_lifetime = 0;
}




echo '<form action="acp.php?tn=moduls&sub=checkin.mod&a=prefs" method="POST">';


echo '<div class="form-group">';
echo '<label>'.$checkin_lang['entry_lifetime'].'</label>';
echo '<input class="form-control" name="entry_lifetime" type="text" value="'.$entry_lifetime.'">';
echo '<small class="form-text text-muted">'.secondsToTime($entry_lifetime).'</small>';
echo '</div>';


$dbh = new PDO("sqlite:".CONTENT_DB);
$sql = "SELECT * FROM fc_textlib WHERE textlib_name LIKE 'checkin%' ORDER BY textlib_name ASC";
foreach ($dbh->query($sql) as $row) {
	$snippets_list[] = $row;
}
$dbh = null;

echo '<fieldset class="mt-4">';
echo '<legend>Intro Snippet</legend>';

echo '<select class="form-control custom-select" name="snippet_intro">';
echo '<option value="no_snippet">'.$checkin_lang['no_intro_snippet'].'</option>';

foreach($snippets_list as $snippet) {
	$selected = "";
	if($snippet['textlib_name'] == $snippet_intro) {
		$selected = 'selected';
	}
	echo '<option '.$selected.' value='.$snippet['textlib_name'].'>'.$snippet['textlib_name'].'</option>';
}
echo '</select>';
echo '<span class="form-text text-muted">'.$checkin_lang['snippet_help_text'].'</span>';

echo '</fieldset>';


echo '<fieldset>';
echo '<legend>Datenschutz Snippet</legend>';

echo '<select class="form-control custom-select" name="snippet_privacy_policy">';
echo '<option value="no_snippet">'.$checkin_lang['no_privacy_policy_snippet'].'</option>';

foreach($snippets_list as $snippet) {
	$selected = "";
	if($snippet['textlib_name'] == $snippet_privacy_policy) {
		$selected = 'selected';
	}
	echo '<option '.$selected.' value='.$snippet['textlib_name'].'>'.$snippet['textlib_name'].'</option>';
}
echo '</select>';
echo '<span class="form-text text-muted">'.$checkin_lang['snippet_help_text'].'</span>';

echo '</fieldset>';

echo '<fieldset>';
echo '<legend>Snippet - erfolgreich angemeldet</legend>';

echo '<select class="form-control custom-select" name="snippet_checkin_success">';
echo '<option value="no_snippet">'.$checkin_lang['no_checkin_success_snippet'].'</option>';

foreach($snippets_list as $snippet) {
	$selected = "";
	if($snippet['textlib_name'] == $snippet_checkin_success) {
		$selected = 'selected';
	}
	echo '<option '.$selected.' value='.$snippet['textlib_name'].'>'.$snippet['textlib_name'].'</option>';
}
echo '</select>';
echo '<span class="form-text text-muted">'.$checkin_lang['snippet_help_text'].'</span>';

echo '</fieldset>';

if($ignore_inline_css == 'ignore') {
	$ckeck_ignore_inline_css = 'checked';
} else {
	$ckeck_ignore_inline_css = '';
}

echo '<div class="form-check">';
echo '<input id="ignore_inline_css" class="form-check-input" name="ignore_inline_css" type="checkbox" value="ignore" '.$ckeck_ignore_inline_css.'>';
echo '<label for="ignore_inline_css" class="form-check-label">'.$checkin_lang['label_ignore_inline_css'].'</label>';
echo '</div>';


echo '<hr><div class="well">';
echo '<input type="hidden" name="csrf_token" value="'.$_SESSION['token'].'">';
echo '<input class="btn btn-success" type="submit" name="save_prefs" value="'.$lang['update'].'">';
echo '</div>';

echo '</form>';

?>
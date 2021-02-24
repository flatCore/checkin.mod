<?php

include FC_CORE_DIR.'/modules/checkin.mod/info.inc.php';
include FC_CORE_DIR.'/modules/checkin.mod/global/functions.php';


$checkin_prefs = checkin_get_preferences();
$checkin_msg = '';

/* individual settings from $page_contents */
$addon_data = str_replace('&quot;', '"', $page_contents['page_addon_string']);
$addon_data = utf8_encode($addon_data);
$addon_data = json_decode($addon_data,true, 512, JSON_UNESCAPED_UNICODE);

if(is_numeric($addon_data['checkin_event'])) {
	$get_event = checkin_get_event_data($addon_data['checkin_event']);
}


/* save visitors data */
if(isset($_POST['checkin'])) {
	
	foreach($_POST as $key => $val) {
		$$key = strip_tags($val); 
	}
		
	$checkin = TRUE;
	
	if($_POST['name'] == '' OR $_POST['tel'] == '') {
		$checkin_msg .= '<p class="alert alert-danger">Bitte füllen Sie die Pflichtfelder aus</p>';
		$checkin = FALSE;
	}
	
	if($_POST['privacy_policy'] != 'on') {
		$checkin_msg .= '<p class="alert alert-danger">Bitte geben Sie an, dass Sie die Datenschutzbestimmungen gelesen haben.</p>';
		$checkin = FALSE;		
	}
	
	
	if($checkin == TRUE) {
		$save_visitor = checkin_save_visitor($_POST);
	}
	
	if($save_visitor == 1) {
		
		$snippet_checkin_success = checkin_get_snippet_data($checkin_prefs['snippet_checkin_success'],$languagePack);
		
		$checked_data = '<p>';
		$checked_data .= $get_event['event'].'<br>';
		$checked_data .= date('Y-m-d H:i:s',time()).'<br>';
		$checked_data .= 'Name: '.$name . ' - Tel.: '.$tel.'<br>';
		$checked_data .= '<p>';
		
		$checkin_msg .= '<div class="alert alert-success">';
		$checkin_msg .= $snippet_checkin_success['textlib_content'].'<hr>';
		$checkin_msg .= $checked_data;
		$checkin_msg .= '</div>';
		unset($name,$tel,$street,$street_nbr,$zip,$city);
	} else {
		$checkin_msg .= '<p class="alert alert-danger">Es ist ein Fehler aufgetreten, bitte versuchen Sie es erneut.</p>';
	}
	
}




$snippet_intro = checkin_get_snippet_data($checkin_prefs['snippet_intro'],$languagePack);
$snippet_privacy_policy = checkin_get_snippet_data($checkin_prefs['snippet_privacy_policy'],$languagePack);

$form_tpl = file_get_contents('modules/checkin.mod/tpl/form.tpl');

$form_tpl = str_replace('{snippet_intro}', $snippet_intro['textlib_content'], $form_tpl);
$form_tpl = str_replace('{snippet_privacy_policy}', $snippet_privacy_policy['textlib_content'], $form_tpl);
$form_tpl = str_replace('{event}', $get_event['event'], $form_tpl);
$form_tpl = str_replace('{event_text}', $get_event['text'], $form_tpl);
$form_tpl = str_replace('{event_id}', $get_event['id'], $form_tpl);
$form_tpl = str_replace('{formaction}', $mod_slug, $form_tpl);

$form_tpl = str_replace('{name}', $name, $form_tpl);
$form_tpl = str_replace('{tel}', $tel, $form_tpl);
$form_tpl = str_replace('{street}', $street, $form_tpl);
$form_tpl = str_replace('{street_nbr}', $street_nbr, $form_tpl);
$form_tpl = str_replace('{zip}', $zip, $form_tpl);
$form_tpl = str_replace('{city}', $city, $form_tpl);

$modul_content = $checkin_msg.$form_tpl;

?>
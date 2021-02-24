<?php

if(!defined('FC_INC_DIR')) {
	die("No access");
}

include '../modules/checkin.mod/lang/en/dict.php';
if(is_file("../modules/checkin.mod/lang/$languagePack/dict.php")) {
	include "../modules/checkin.mod/lang/$languagePack/dict.php";
}

echo '<h4>checkin.mod</h4>';


$addon_data = str_replace('&quot;', '"', $page_addon_string);
$addon_data = utf8_encode($addon_data);
$addon_data = json_decode($addon_data,true, 512, JSON_UNESCAPED_UNICODE);


$dbh = new PDO("sqlite:../content/SQLite/checkin.sqlite3");
$sql = "SELECT * FROM events ORDER BY id ASC";
$sth = $dbh->prepare($sql);
$sth->execute();
$events = $sth->fetchAll(PDO::FETCH_ASSOC);
$dbh = null;


echo '<div class="form-group">';
echo '<label>Event</label>';
echo '<select name="addon[checkin_event]" class="form-control custom-select">';
foreach($events as $event) {
	
	$selected = '';
	if($addon_data['checkin_event'] == $event['id']) {
		$selected = 'selected';
	}
	
	echo '<option value="'.$event['id'].'" '.$selected.'>#'.$event['id'].' '.$event['event'].'</option>';
}
echo '</select>';
echo '</div>';

?>
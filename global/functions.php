<?php

/**
 * global checkin.mod functions for backend and frontend
 * please prefix functions 'checkin_'
 */

/**
 * get preferences
 *
 */

function checkin_get_preferences() {
	
	global $mod_db;
	
	if(FC_SOURCE == 'frontend') {
		$mod_db = './content/SQLite/checkin.sqlite3';
	}
	
	$dbh = new PDO("sqlite:$mod_db");
	$sql = "SELECT * FROM preferences WHERE status LIKE '%active%' ";
	$prefs = $dbh->query($sql);
	$prefs = $prefs->fetch(PDO::FETCH_ASSOC);
	$dbh = null;
	
	
	
	return $prefs;
	
}


function checkin_get_events() {
	
	global $mod_db;

	if(FC_SOURCE == 'frontend') {
		$mod_db = './content/SQLite/checkin.sqlite3';
	}
		
	$dbh = new PDO("sqlite:$mod_db");
	$sql = "SELECT * FROM events ORDER BY id ASC";
	$sth = $dbh->prepare($sql);
	$sth->execute();
	$events = $sth->fetchAll(PDO::FETCH_ASSOC);
	$dbh = null;
	
	return $events;
		
	
}



function checkin_get_event_data($id) {

	global $mod_db;

	if(FC_SOURCE == 'frontend') {
		$mod_db = './content/SQLite/checkin.sqlite3';
	}
	
	$dbh = new PDO("sqlite:$mod_db");
	$sql = "SELECT * FROM events WHERE id = $id";
	$sth = $dbh->prepare($sql);
	$sth->execute();
	$get_event = $sth->fetch(PDO::FETCH_ASSOC);
	$dbh = null;
	
	return $get_event;
	
}





function checkin_get_snippet_data ($textlib_name,$textlib_lang) {
	
	global $fc_db_content;
	
	$dbh = new PDO("sqlite:$fc_db_content");
	$sql = 'SELECT * FROM fc_textlib WHERE textlib_name = :textlib_name AND textlib_lang = :textlib_lang ';
	$sth = $dbh->prepare($sql);
	$sth->bindParam(':textlib_name', $textlib_name, PDO::PARAM_STR);
	$sth->bindParam(':textlib_lang', $textlib_lang, PDO::PARAM_STR);
	$sth->execute();
	$textlibData = $sth->fetch(PDO::FETCH_ASSOC);
	$dbh = null;
	
	return $textlibData;
	
}


function checkin_save_visitor($data) {

	global $mod_db;

	if(FC_SOURCE == 'frontend') {
		$mod_db = './content/SQLite/checkin.sqlite3';
	}
	$entrydate = time();
	
	$dbh = new PDO("sqlite:$mod_db");
		
		
	$sql = "INSERT INTO entries	(
					id, entrydate, event, name, street, street_nbr, tel, zip, city
					) VALUES (
					NULL, :entrydate, :event, :name, :street, :street_nbr, :tel, :zip, :city
					) ";
	$sth = $dbh->prepare($sql);
	$sth->bindParam(':entrydate', $entrydate, PDO::PARAM_STR);
	$sth->bindParam(':event', $data['event_id'], PDO::PARAM_STR);
	$sth->bindParam(':name', $data['name'], PDO::PARAM_STR);
	$sth->bindParam(':street', $data['street'], PDO::PARAM_STR);
	$sth->bindParam(':street_nbr', $data['street_nbr'], PDO::PARAM_STR);
	$sth->bindParam(':tel', $data['tel'], PDO::PARAM_STR);
	$sth->bindParam(':zip', $data['zip'], PDO::PARAM_STR);
	$sth->bindParam(':city', $data['city'], PDO::PARAM_STR);

	$cnt_changes = $sth->execute();
	$dbh = null;
	
	return $cnt_changes;
		
}


function secondsToTime($seconds) {
    $dtF = new \DateTime('@0');
    $dtT = new \DateTime("@$seconds");
    
    if($seconds >= 86400) {
	    return $dtF->diff($dtT)->format('%a days, %h hours, %i minutes and %s seconds');
    } else if ($seconds >= 3600) {
	    return $dtF->diff($dtT)->format('%h hours, %i minutes and %s seconds');
    } else {
	    return $dtF->diff($dtT)->format('%i minutes and %s seconds');
    }
    
    
}



?>
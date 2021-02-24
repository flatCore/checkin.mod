<?php


function checkin_delete_event($id) {
	
	global $mod_db;
	$dbh = new PDO("sqlite:$mod_db");
	$query = "DELETE FROM events WHERE id = :id";
	$sth = $dbh -> prepare($query);
	$sth -> bindParam(':id', $id, PDO::PARAM_INT);
	$sth->execute();
	$dbh = null;
	
	$remove_checkers = checkin_remove_checker($id);
	
}


function checkin_get_event_checkers($event_id) {
	
	global $mod_db;
	$dbh = new PDO("sqlite:$mod_db");
	$sql = "SELECT * FROM entries WHERE event = $event_id";
	$sth = $dbh->prepare($sql);
	$sth->execute();
	$get_checkers = $sth->fetchAll(PDO::FETCH_ASSOC);
	$dbh = null;
	
	return $get_checkers;	
}

function checkin_remove_checker($id) {
	
	global $mod_db;
	$dbh = new PDO("sqlite:$mod_db");
	$query = "DELETE FROM entries WHERE id = :id";
	$sth = $dbh -> prepare($query);
	$sth -> bindParam(':id', $id, PDO::PARAM_INT);
	$sth->execute();
	$dbh = null;
}


?>
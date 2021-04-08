<?php

/**
 * @addon	checkin
 * backend
 */

if(!defined('FC_INC_DIR')) {
	die("No access");
}

include '../modules/checkin.mod/install/installer.php';
include __DIR__.'/include.php';

$checkin_prefs = checkin_get_preferences();

$event_id = '';

if(isset($_POST['edit'])) {
	if(is_numeric($_POST['edit'])) {

		$dbh = new PDO("sqlite:$mod_db");
		
		$event_id = (int) $_POST['edit'];

		$sql = "SELECT * FROM events WHERE id = $event_id";
		$sth = $dbh->prepare($sql);
		$sth->execute();
		$get_event = $sth->fetch(PDO::FETCH_ASSOC);
		$dbh = null;
		
		$event = $get_event['event'];
		$text = $get_event['text'];		
	}
}

if(isset($_POST['delete'])) {
	
	$event_id = (int) $_POST['delete'];
	
	$delete_event = checkin_delete_event($event_id);
	
}


if(isset($_POST['save_event'])) {
	
	$dbh = new PDO("sqlite:$mod_db");
	
	if(is_numeric($_POST['event_id'])) {
		$sql = "UPDATE events
						SET event = :event,
								text = :text
						WHERE id = :id ";
		$sth = $dbh->prepare($sql);
		$sth->bindParam(':event', $_POST['event'], PDO::PARAM_STR);
		$sth->bindParam(':text', $_POST['text'], PDO::PARAM_STR);
		$sth->bindParam(':id', $_POST['event_id'], PDO::PARAM_INT);
		
	} else {
		
		$entrydate = time();
		
		$sql = "INSERT INTO events	(
					id, event, text, entrydate
					) VALUES (
					NULL, :event, :text, :entrydate
					) ";
		$sth = $dbh->prepare($sql);
		$sth->bindParam(':event', $_POST['event'], PDO::PARAM_STR);
		$sth->bindParam(':text', $_POST['text'], PDO::PARAM_STR);
		$sth->bindParam(':entrydate', $entrydate, PDO::PARAM_STR);
					
	}


	$cnt_changes = $sth->execute();
	$dbh = null;
	
}



echo '<h3>'.$mod_name.' '.$mod_version.' <small>| '.$mod['description'].'</small></h3>';


echo '<form action="acp.php?tn=moduls&sub=checkin.mod&a=start" method="POST">';

echo '<div class="row">';
echo '<div class="col-md-4">';

echo '<div class="form-group">';
echo '<label>'.$checkin_lang['event_name'].'</label>';
echo '<input class="form-control" name="event" type="text" value="'.$event.'">';
echo '</div>';

echo '</div>';
echo '<div class="col-md-6">';

echo '<div class="form-group">';
echo '<label>'.$checkin_lang['event_text'].'</label>';
echo '<input class="form-control" name="text" type="text" value="'.$text.'">';
echo '</div>';

echo '</div>';
echo '<div class="col-md-2">';

echo '<div class="form-group">';
echo '<label class="d-block"><br></label>';
echo '<input type="hidden" name="event_id" value="'.$event_id.'">';
echo '<input type="hidden" name="csrf_token" value="'.$_SESSION['token'].'">';
echo '<input class="btn btn-success btn-block" type="submit" name="save_event" value="'.$lang['save'].'">';
echo '</div>';

echo '</div>';
echo '</div>';

echo '</form>';



/* list events */


$events = checkin_get_events();
$cnt_events = count($events);

echo '<table class="table">';
for($i=0;$i<$cnt_events;$i++) {
	echo '<tr>';
	echo '<td>'.$events[$i]['id'].'</td>';
	echo '<td>'.$events[$i]['event'].'</td>';
	echo '<td>'.$events[$i]['text'].'</td>';
	echo '<td class="text-right">';
	echo '<form action="acp.php?tn=moduls&sub=checkin.mod&a=start" method="POST">';
	echo '<button class="btn btn-danger" type="submit" name="delete" value="'.$events[$i]['id'].'">'.$icon['trash_alt'].'</button> ';
	echo '<button class="btn btn-success" type="submit" name="edit" value="'.$events[$i]['id'].'">'.$icon['edit'].'</button>';
	echo '</form></td>';
	echo '</tr>';
	
	echo '<tr>';
	$checkers = checkin_get_event_checkers($events[$i]['id']);
	$cnt_checkers = count($checkers);
	echo '<td colspan="4">';
	echo '<a class="btn btn-fc btn-sm" data-toggle="collapse" href="#collapse'.$i.'" role="button" aria-expanded="false" aria-controls="collapse'.$i.'">'.$cnt_checkers.' Adressen</a>';
	
	echo '<div class="collapse" id="collapse'.$i.'">';
	echo '<div class="scroll-container">';
	echo '<table class="table table-sm table-striped">';
	
	echo '<tr><td>Checkin</td><td>Lösch-Datum</td><td>Name</td><td>Telefon</td><td>Straße/Nr.</td><td>PLZ/Ort</td></tr>';
	
	for($x=0;$x<$cnt_checkers;$x++) {
		
		$now = time();
		$checkers_entrydate = $checkers[$x]['entrydate'];
		$entry_lifetime = $checkin_prefs['entry_lifetime'];
		$checkers_lifetime = $checkers_entrydate+$entry_lifetime;
		$checkers_lifetime_seconds = $checkers_lifetime-$now;
		$time_to_delete = secondsToTime($checkers_lifetime_seconds);
		
		if($checkers_lifetime_seconds <= 0) {
			checkin_remove_checker($checkers[$x]['id']);
		}
		
		
		
		echo '<tr>';
		echo '<td>'.date('Y-m-d H:i:s',$checkers[$x]['entrydate']).'</td>';
		echo '<td>'.date('Y-m-d H:i:s',$checkers_lifetime).' <small>('.$time_to_delete.')</small></td>';
		echo '<td>'.$checkers[$x]['name'].'</td>';
		echo '<td>'.$checkers[$x]['tel'].'</td>';
		echo '<td>'.$checkers[$x]['street'].' '.$checkers[$x]['street_nbr'].'</td>';
		echo '<td>'.$checkers[$x]['zip'].' '.$checkers[$x]['city'].'</td>';
		echo '</tr>';
	}
	echo '</table>';
	echo '</div>';
	echo '</div>';
	echo '</td>';
	
	echo '</tr>';
}

echo '</table>';


?>
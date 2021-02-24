<?php

/**
 * checkin.mod Database-Scheme
 * install/update the table for news
 * 
 */

$database = "checkin";
$table_name = "events";

$cols = array(
	"id"  => 'INTEGER NOT NULL PRIMARY KEY',
	"entrydate"  => 'VARCHAR', /* timestring entry time */
	"event" => 'VARCHAR',
	"text" => 'VARCHAR'
	);
 
?>
<?php

/**
 * checkin.mod Database-Scheme
 * install/update the table for news
 * 
 */

$database = "checkin";
$table_name = "entries";

$cols = array(
	"id"  => 'INTEGER NOT NULL PRIMARY KEY',
	"entrydate"  => 'VARCHAR', /* timestring entry time */
	"event" => 'VARCHAR',
	"name" => 'VARCHAR',
	"street" => 'VARCHAR',
	"street_nbr" => 'VARCHAR',
	"zip" => 'VARCHAR',
	"city" => 'VARCHAR',
	"tel" => 'VARCHAR',
	"text" => 'VARCHAR'
	);
 
?>
<?php

/**
 * checkin.mod Database-Scheme
 * install/update the table for preferences
 * 
 */

$database = "checkin";
$table_name = "preferences";

$cols = array(
	"id"  => 'INTEGER NOT NULL PRIMARY KEY',
	"status"  => 'VARCHAR',
	"entry_lifetime" => 'VARCHAR',
	"snippet_intro" => 'VARCHAR',
	"snippet_privacy_policy" => 'VARCHAR',
	"snippet_checkin_success" => 'VARCHAR',
	"ignore_inline_css" => 'VARCHAR',
	"version" => 'VARCHAR'
  );
  

?>

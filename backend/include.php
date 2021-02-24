<?php
/**
 * @addon	checkin
 * include in all backend files
 */
 
error_reporting(E_ALL ^E_NOTICE);

if(!defined('FC_INC_DIR')) {
	die("No access");
}

include '../modules/checkin.mod/backend/functions.php';
include '../modules/checkin.mod/global/functions.php';


?>
<?php
	$config['header'] = "Timepry Setup Wizard";
	$config['applicationPath'] = "../nodcms/config/";
	$config['database_file'] = "database.php";
	
	// INTRODUCTION
	$introduction = array();
	$introduction["product"] = "Timepry - Dental Portal";
	$introduction["productVersion"] = "1.0";
	$introduction["company"] = "Techopialabs";

	// SERVER REQUIREMENTS
	$requirements = array();
	$requirements["phpVersion"] = "5";
	$requirements["extensions"] = array("mysql", "pcre");

	// FILE PERMISSIONS
	// r = readable, w = writable, x = executable
	$filePermissions = array();
	$filePermissions["database.php"] = "rw";

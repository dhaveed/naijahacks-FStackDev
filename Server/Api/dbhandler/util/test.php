<?php 
	session_start();
	require('functions.php');
	$db_handle = new Utility();
	$db_handle2 = new Products();

	$pcode = 'p1';
	$statement = $db_handle2->cartfetch("SELECT * FROM products WHERE code='" . $pcode . "'");
	

	while($statement->fetch()){ 	
		echo "test working";
	}
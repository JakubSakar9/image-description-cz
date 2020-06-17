<?php
	global $wpdb;
	$table_name = $wpdb->prefix . 'image_description_cz';

	//$wpdb->insert($table_name, array( 'ID' => 1, 'key' => htmlspecialchars($_POST["CV_key"]), 'URI' => htmlspecialchars($_POST["CV_endpoint"])), array('%d', '%s', '%s'));
	//$wpdb->insert($table_name, array( 'ID' => 2, 'key' => htmlspecialchars($_POST["TT_key"]), 'URI' => htmlspecialchars($_POST["TT_endpoint"])), array('%d', '%s', '%s'));

	$wpdb->insert($table_name, array( 'ID' => 1, 'key' => 'a', 'URI' => 'b', array('%d', '%s', '%s'));
	$wpdb->insert($table_name, array( 'ID' => 2, 'key' => 'c', 'URI' => 'd', array('%d', '%s', '%s'));
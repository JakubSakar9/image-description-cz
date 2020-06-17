<?php
	global $wpdb;
	$table_name = $wpdb->prefix . "api_data";

	$wpdb->insert($table_name, array( 'ID' => 1, 'key' => htmlspecialchars($_POST["CV_key"]), 'URI' => htmlspecialchars($_POST["CV_endpoint"])), null);
	$wpdb->insert($table_name, array( 'ID' => 2, 'key' => htmlspecialchars($_POST["TT_key"]), 'URI' => htmlspecialchars($_POST["TT_endpoint"])), null);
	$wpdb->insert($table_name, array( 'ID' => 2, 'key' => 'test', 'URI' => 'test'), null);
?>
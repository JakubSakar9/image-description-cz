<?php

/**
 * @package ImageDescriptionCZ
 */

/*
Plugin Name: Image Description CZ
Plugin URI: https://github.com/JakubSakar9/image-description-cz
Description: This automatically generates description for images on a website, if they don't have one already.
Version: 1.0.0
Author: Jakub Sakař
Author URI: https://github.com/JakubSakar9
License: GPLv2 or later
Text Domain: image-description-cz

*/

/*
[More license information to be added here]
*/

require_once('class.postcontroller.php');

$Poster = new PostController;

defined('ABSPATH') or die('You are not allowed to access this file');

class ImageDescription {

	function __construct(){
		add_action('publish_post', 'make_description', 10, 1);
	}

	function activate(){
		flush_rewrite_rules();
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$sql = "CREATE TABLE '{$wpdb->base_prefix}api_data' (key varchar(255), uri varchar(255)) $charset_collate;";
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
		//echo 'The plugin was activated';
	}

	function deactivate(){
		//echo 'The plugin was deactivated';
	}

	function uninstall(){

	}

	function make_description($ID){
		$Poster->search('id', $ID);
		$rawContent = $Poster->get_var('content');
		$imgPath = 'none';
		for($i = 0; $i < strlen($rawContent); $i++){
			if(substr($rawContent, $i, 10) == '<img src="'){
				$i += 10;
				$j = 0;
				while($rawContent[$i + $j] != '"'){
					$j++;
				}
				$imgPath = substr($rawContent, $i, $j);
				$decriptionText = shell_exec('php describe.php ' . $imgPath);
				$translatedText = shell_exec('php translate.php ' . $descriptionText);
			}	
		}
		
	}
}

if(class_exists('ImageDescription')){
	$imageDescription = new ImageDescription();
}

//activation
register_activation_hook(__FILE__, array($imageDescription, 'activate'));

//deactivation
register_deactivation_hook(__FILE__, array($imageDescription, 'deactivate'));
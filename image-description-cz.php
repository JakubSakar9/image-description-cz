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

//global $wpdb;
//$table_name = $wpdb->prefix . "api_data";

defined('ABSPATH') or die('You are not allowed to access this file');

class ImageDescription {
	function __construct(){
		add_action('publish_post', 'make_description', 10, 1);
	}

	function activate(){
		global $wpdb;
		$table_name = $wpdb->prefix . "api_data";

		//debug stuff
		echo $wpdb->get_var(
			"SELECT user_login FROM wp_users WHERE ID = 1"
		);

		//some additional thingies
		$charset_collate = $wpdb->get_charset_collate();

		//make api credentials table, will be added later
		/*$sql = "CREATE TABLE wp_api_data (
			ID tinyint(9) NOT NULL AUTO_INCREMENT,
			key varchar(255),
			URI varchar(255),
			PRIMARY KEY  (ID)
		) $charset_collate;";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);*/

		//database access example
		$wpdb->insert($table_name, array( 'ID' => 1, 'key' => 'a', 'URI' => 'b'), null);
	}

	function deactivate(){
		global $wpdb;
		$table_name = $wpdb->prefix . "api_data";

		//clearing the database upon deactivation
		echo 'The plugin was deactivated';
		$wpdb->delete($table_name, array('ID' => 1));
	}

	function uninstall(){

	}

	function register(){
		add_action('admin_menu', array($this, 'add_admin_pages'));
	}

	public function add_admin_pages(){
		add_menu_page('Image description CZ', 'IDCZ', 'manage_options', 'image_description_cz', array($this, 'admin_index'), 'dashicons-store', 110);	
	}

	public function admin_index(){
		require_once plugin_dir_path(__FILE__) . 'templates/admin.php';
	}

	function make_description($ID){
		//get the post that has just been posted
		$Poster->search('id', $ID);
		$rawContent = $Poster->get_var('content');
		$imgPath = 'none';

		//search for images in the post
		for($i = 0; $i < strlen($rawContent); $i++){
			if(substr($rawContent, $i, 4) == '<img'){
				$i +=4;
				while(!(substr($rawContent, $i, 5) == 'src="')){
					$i++;
				}
				$i += 5;
				$j = 0;
				while($rawContent[$i + $j] != '"'){
					$j++;
				}
				//get their path
				$imgPath = substr($rawContent, $i, $j);

				//pass it to the API
				$decriptionText = shell_exec('php describe.php ' . $imgPath);
				$translatedText = shell_exec('php translate.php ' . $descriptionText);

				//here be dragons
				do{
					$i++;
				}
				while(substr($rawContent, $i, 1) != '>');
				
			}	
		}	
	}
}

if(class_exists('ImageDescription')){
	$imageDescription = new ImageDescription();
	$imageDescription->register();
}

//activation
register_activation_hook(__FILE__, array($imageDescription, 'activate'));

//deactivation
register_deactivation_hook(__FILE__, array($imageDescription, 'deactivate'));
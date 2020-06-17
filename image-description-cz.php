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
	//global $wpdb;
	//$table_name = $wpdb->prefix . "image_description_cz";

	function __construct(){
		add_action('add_attachment', 'make_description');
	}

	function activate(){
		global $wpdb;
		$table_name = $wpdb->prefix . "image_description_cz";
	    if($wpdb->get_var('SHOW TABLES LIKE' . $table_name) != $table_name){
	        $sql = "CREATE TABLE $table_name (
	            `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'nezadavej',
	            `key` varchar(255) DEFAULT NULL,
	            `URI` varchar(255) DEFAULT NULL,
	            PRIMARY KEY (`ID`),
	            UNIQUE KEY `ID` (`ID`)
	          ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci";	 
	          require_once(ABSPATH . '/wp-admin/includes/upgrade.php');
	          dbDelta($sql);
	          add_option('mse_database_version','1.0');
	    }
	}

	function deactivate(){
		global $wpdb;
		$table_name = $wpdb->prefix . "image_description_cz";
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
		require_once plugin_dir_path(__FILE__) . 'admin.php';
	}

	function make_description($post_ID){
		global $wpdb;
		$table_name = $wpdb->prefix . "postmeta";

		if(wp_attachment_is_image($post_ID)){
			//Debug
			$wpdb->update($table_name, array('post_excerpt' => 'test'), array('ID' => $post_ID));
		}
		//$description_text = shell_exec('php describe.php' . $imgPath);
		//$translated_text = shell_exec('php translate.php' . $imgPath);
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
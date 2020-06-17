<h1>Image Description CZ</h1>
<h2>API credentials</h2>
<form 
	<?php
		echo 'action="' . str_replace("\\", "/", plugin_dir_path(__FILE__)) . 'save_api_data.php" method="post">'
	?>
	Computer Vision key: <input type="text" name="CV_key"><br>
	Computer Vision endpoint: <input type="text" name="CV_endpoint"><br>
	Translator Text key: <input type="text" name="TT_key"><br>
	Translator Text endpoint <input type="text" name="TT_endpoint"><br>
	<input type="submit" name="submit">
</form>

<?php
	echo(str_replace("\\", "/", plugin_dir_path(__FILE__)) . 'save_api_data.php');
?>
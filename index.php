<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <script language="javascript" src="includes\header.js"></script>
	<p>Here are all of the lead feeds currently available:</p>
	<ul>
	<?php
	$path = "leads/";
	$files = scandir($path);
	foreach ($files as &$value) {
		if (is_file("leads/".$value)) { 
			echo "<li><a href='leads/".$value."'>".$value."</a></li>"; 
		}
	}
	?>
	</ul>
 <script language="javascript" src="includes\footer.js"></script>
</html>
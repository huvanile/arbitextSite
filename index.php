<?php 
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/includes/header.php"); 
?>

	<table>
	<thead>
	<caption>Here are all of the lead feeds currently available</caption>
	<tr><th>Title</th><th>Items</th><th>RSS</th><th>Last Updated</th></tr>
	</thead>
	<tbody>
	<?php
	$path = "leads/";
	$files = scandir($path);
	foreach ($files as &$value) {
		if (is_file("$root/leads/".$value) and strpos($value, '.xml') !== false) { 
			$feed = simplexml_load_file("$root/leads/$value");
			$channelTitle=$feed->channel->title;
			$channelLastMod=$feed->channel->lastBuildDate;
			echo "<tr>
				<td class='xmlTitleCol'><a type='application/rss+xml' href='showfeed.php?feed=".$value."'>".$channelTitle."</a></td>
				<td class='xmlCountCol'>".$feed->channel->item->count()."</td>
				<td class='xmlLinkCol'><a type='application/rss+xml' href='leads/".$value."'><img src='img/rss.png'/></a></td>
				<td class='xmlDateCol'>".date ("F d, Y", strtotime($channelLastMod))."</td>
			</tr>\n"; 
		}
	}
	?>
	</tbody>
	</table>
<?php require_once("$root/includes/footer.php"); ?>
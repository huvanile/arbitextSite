<?php
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	setlocale(LC_MONETARY, 'en_US.UTF-8');
	$basedir = "http://".$_SERVER['SERVER_NAME'];
	require_once("$root/includes/header.php"); 
	$myFeed = $root."/leads/".$_GET['feed'];
	$feed = simplexml_load_file("$myFeed");
	if ($feed !== null and strpos($myFeed, '.xml') !== false) {
		$channelTitle=$feed->channel->title;
		$channelDescr=$feed->channel->description;
		$channelLastMod=$feed->channel->lastBuildDate;

		echo("<div id='featured'>\n");
			echo("<span id='facts'>");
				echo("<h2>$channelTitle</h2>\n");
				echo("<span class='itemDate'>Feed last updated on ".date ("F d, Y", strtotime($channelLastMod))."</span>\n");
				echo("<p>$channelDescr</p>\n");
			echo("</span>\n");
			echo("<span id='figure'>\n");
				echo("<a href='$basedir/leads/".$_GET['feed']."'>\n");
					echo("<img id='bigrss' src='$basedir/img/bigrss.png'/>\n");
					echo("Subscribe");
				echo("</a>\n");
			echo("</span>\n");
		echo("</div><!-- featured -->\n");
		
		echo("<div id='feedbox'>\n");
			echo("<ol>\n");
			foreach($feed->channel->item as $item) {
				$ns_arbitext = $item->children("http://huvanile.com/#");
				if (empty($ns_arbitext->bookImage)) {
					$bookImage = $basedir."/img/PlaceholderBook.png";
				} else {
					$bookImage = $ns_arbitext->bookImage;
				}	
				$askingPrice = money_format('%.2n', (float)$ns_arbitext->askingPrice);
				$buybackPrice = money_format('%.2n', (float)$ns_arbitext->buybackPrice);
				$profit = money_format('%.2n', (float)$ns_arbitext->profit);
				echo("<li>");
						echo("<img src='$bookImage' />\n");
						echo("<span class='entry-content'>");
							echo("<h2><a href=\"".$item->link."\">".$item->title."</a></h2>\n");
							echo("<span class='itemDate'>".$item->pubDate."</span>\n");
							echo("<p>Someone is selling this book in ".$ns_arbitext->postCity." for ".$askingPrice." and it sells online for at least ".$buybackPrice.".  That's a potential profit of ".$profit."!</p>\n");
						echo("</span><!-- entry-content -->\n");
				echo("</li>\n");
			}  
			echo("</ol>\n");
		echo("</div><!-- feedbox -->\n");
		
	} else {
		echo '<p id="errormessage">Feed is empty or some other error occurred :(</p>';
	}
require_once("$root/includes/footer.php"); 
?>
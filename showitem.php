<?php
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	setlocale(LC_MONETARY, 'en_US.UTF-8');
	require_once("$root/includes/header.php"); 
	$querystring = explode("|",$_GET['item']);
	$baseURL = "http://".$_SERVER['SERVER_NAME'];
	$myFeed = $baseURL."/leads/".$querystring[0];
	$myItem = $querystring[1];
	$feed = simplexml_load_file("$myFeed");
	if ($feed !== null and $myItem !== null) {
		foreach($feed->channel->item as $item) {
			if ($item->guid == $myItem) {
				
				//get data from XML into variables
				$ns_arbitext = $item->children("http://huvanile.com/#");
				$channelTitle=$feed->channel->title;
				$bookTitle = $item->title;
				$buybackLink = $ns_arbitext->buybackLink;
				$postLink = $ns_arbitext->postLink;
				$isbn = $ns_arbitext->isbn;
				$author = $ns_arbitext->author;
				$amazonLink = "https://href.li/?https://smile.amazon.com/s/?field-keywords=".$isbn;
				$pubDate = $item->pubDate;
				$postTitle = $ns_arbitext->postTitle;
				$postCity = $ns_arbitext->postCity;
				$resultDesc = $item->description;
				$askingPrice = money_format('%.2n', (float)$ns_arbitext->askingPrice);
				$buybackPrice = money_format('%.2n', (float)$ns_arbitext->buybackPrice);
				$profit = money_format('%.2n', (float)$ns_arbitext->profit);
				if (empty($ns_arbitext->bookImage) or strlen($ns_arbitext->bookImage) <20) {
					$bookImage = "$basedir/img/PlaceholderBook.png";
				} else {
					$bookImage = $ns_arbitext->bookImage;
				}	
				if (empty($ns_arbitext->postImage) or strlen($ns_arbitext->postImage) <20) {
					$postImage = "$basedir/img/PlaceholderBook.png";
				} else {
					$postImage = $ns_arbitext->postImage;
				}	
				
				//display the result
				echo("<div id='featured'>\n");
					echo("<h2><a type='application/rss+xml' href='$basedir/showfeed.php?feed=".$querystring[0]."'>$channelTitle</a> » Lead Analysis</h2>\n");
					echo("<p id='booklinks'>\n");
						echo("<img class='booklink' src='$baseURL/img/cl.png'/>&nbsp;<a href='$postLink'>Sale Post</a>\n");
						echo("&nbsp;&nbsp;&nbsp;&nbsp");
						echo("<img class='booklink' src='$baseURL/img/bs.png'/>&nbsp;<a href='$buybackLink'>BookScouter Link</a>\n");
						echo("&nbsp;&nbsp;&nbsp;&nbsp");
						echo("<img class='booklink' src='$baseURL/img/ama.png'/>&nbsp;<a href='$amazonLink'>Amazon Link</a>\n");
					echo("</p>\n");
				echo("</div><!-- featured -->\n");
				
				
				echo("<div id='feedbox'>\n");
				
					echo("<div id='pics'>");
						echo("<img src='$bookImage' />\n");
						echo("<p class='itemDate'>Cover from Amazon</p>\n");
						echo("<img src='$postImage' />\n");	
						echo("<p class='itemDate'>Cover from sale post</p>\n");
					echo("</div><!-- pics -->\n");
					
					echo("<div id='details'>");
					
						echo("<h3>deal details</h3>\n");
						echo("<ul>\n");
							echo("<li>Seller's asking price: <strong>$askingPrice</strong></li>\n");
							echo("<li>Online buyback price: <strong><a href='$buybackLink'>$buybackPrice</a></strong></li>\n");
							echo("<li>Potential profit: <strong>$profit</strong></li>\n");
						echo("</ul>\n");
					
						echo("<h3>post details</h3>\n");
						echo("<ul>\n");
							echo("<li>Title: <strong><a href='$postLink'>$postTitle</a></strong></li>\n");
							echo("<li>Last Updated: <strong>$pubDate</strong></li>\n");
							echo("<li>City: <strong>$postCity</strong></li>\n");
						echo("</ul>\n");
						
						echo("<h3>book details</h3>\n");
						echo("<ul>\n");
							echo("<li>ISBN: <strong><a href='".$amazonLink."'>$isbn</a></strong></li>\n");
							echo("<li>Title: <strong>$bookTitle</strong></li>\n");
							echo("<li>Author: <strong>$author</strong></li>\n");
						echo("</ul>\n");
						
					echo("</div><!-- details -->\n");
					

					
				echo("</div><!-- feedbox -->\n");
				break;
			}
		}
	} else {
		echo '<p id="errormessage">Feed is empty, item could not be found, or some other error occurred :(</p>';
	}
	require_once("$root/includes/footer.php"); 
?>
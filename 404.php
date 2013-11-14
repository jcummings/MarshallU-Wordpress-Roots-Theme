<?php header("HTTP/1.1 404 Not Found"); ?> 
<?php 
	// this function will be called after logging has occured
	// this is done so that we know the page is missing on this server
	// but the user will be sent to the live version of it on the other server
	// if it exists instead of showing them the 404 page.
	function tryOldServer($url){
		//$surl = parse_url($url);
		
		if(substr($url, -1) != '/'){
			$url = $url . '/';
			//echo $url;
		}

		$oldhost = "http://web.marshall.edu";
		$checkUrl = $oldhost . $url;
		
		$handle = curl_init($checkUrl); 
		
		//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
		$response = curl_exec($handle); 
		
		$code =  curl_getinfo($handle, CURLINFO_HTTP_CODE);
		
		
		//echo $code;		
		//if($code==200 || $code==301){
		if($code==200){
			header('Location:' . $checkUrl);
		} 

	}


$linkData = array();

$linkData["referer"] = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "";

if(strlen($linkData["referer"])){

	$linkData["method"] = $_SERVER['REQUEST_METHOD'];
	$linkData["time"] = $_SERVER['REQUEST_TIME'];
	$linkData["url"] = array();
	$linkData["url"]["target"] = $_SERVER['REQUEST_URI'];
	$linkData["url"]["protocol"] = preg_split("/\//",$_SERVER['SERVER_PROTOCOL']);
	$linkData["url"]["protocol"] = $linkData["url"]["protocol"][0];

	$linkData["url"]["host"] = $_SERVER['HTTP_HOST'];

	$pathparts  = array_map(
									function($a){
										return $a;
									},
									preg_split("/\//", $_SERVER['SCRIPT_NAME']));




	$linkData["url"]["qs"] = strlen($_SERVER['REDIRECT_QUERY_STRING']) ? $_SERVER['REDIRECT_QUERY_STRING'] :  $_SERVER['QUERY_STRING'];

	if(strpos($linkData["url"]["qs"],"404;") !== false){
		$linkData["url"]["qs"] = preg_split("/\?/",$linkData["url"]["qs"]);
		$linkData["url"]["target"] = $linkData["url"]["qs"][0];

		$linkData["url"]["target"] = preg_split('/\;/',$linkData["url"]["target"]);
		$linkData["url"]["target"] = $linkData["url"]["target"][1];
		



		if(count($linkData["url"]["qs"]) > 1){
			$linkData["url"]["qs"] = $linkData["url"]["qs"][1];
		} else {
			$linkData["url"]["qs"] = ""; 
		}
		//$linkData["url"]["qs"] = $linkData["url"]["qs"][1];
	}




	$linkData["url"]["siteaddress"] = preg_split('/\//',$linkData["referer"]);
	if(count($linkData["url"]["siteaddress"]) > 3){
		$linkData["url"]["siteaddress"] = $linkData["url"]["siteaddress"][3];
	} else {
		$linkData["url"]["siteaddress"] = "it";  //default so we get the notice instead of it being lost forever..
	}


		

	$linkData["filedata"] = preg_split("/\./",$linkData["url"]["target"]);
	$linkData["filetype"] = strtolower($linkData["filedata"][count($linkData["filedata"])-1]);


	$linkData["url"]["target"] = str_replace(":80", "", $linkData["url"]["target"]); // remove any reference to the port
	$linkData["altfiletype"] = strtolower(substr($linkData["url"]["target"],-3)); // sometimes the first effort gives us a weird file extension, so a double check!


$ignoreFilesOfType = array("gif","jpg","jpe","css","bmp","png","class","js", "swf", "jpeg", "xml");

$ignoredURLs = array("http://muwww-new.marshall.edu/index.php","http://muwww-new.marshall.edu/wp-includes/ms-files.php");

//$ignoredURL = "http://muwww-new.marshall.edu/index.php";
$evaluatingURL = $linkData["url"]["target"];

//if($ignoredURL <> $evaluatingURL){
$logit = !in_array($linkData["filetype"], $ignoreFilesOfType) && !in_array($linkData["altfiletype"], $ignoreFilesOfType) && 
!in_array($evaluatingURL, $ignoredURLs) && (strpos($linkData["url"]["target"],"trackback") === false);


	if($logit){
/* need to write to the db now */

  		$recordDetails = array();
  		$recordDetails["target"] = $linkData["url"]["target"];
  		$recordDetails["referer"] = $linkData["referer"];
  		$recordDetails["hits"] = 1;
  		$recordDetails["siteaddress"] = $linkData["url"]["siteaddress"];



     	//Get the data from the Jobs database
      	$conn = new COM("ADODB.Connection") or die("Cannot start ADO"); 

		// Microsoft Access connection string.
		$conn->Open("Provider=SQLOLEDB;Data Source=MUWEBSQL\MUWEBSQLDB;Initial Catalog=overseer_SQL;User ID=OverseerEdit;Password=lillyallen;");

		if($conn){

			$sql = "SELECT hits
				  FROM BrokenLinks
				 WHERE targetURL= '". $linkData["url"]["target"]. "'
				 AND refererURL = '". $linkData["referer"]. "'
				 AND siteAddress = '". strtolower($linkData["url"]["siteaddress"]) . "'";
				
			$rs = $conn->Execute( $sql );


			if(!$rs){
				exit("Error in Lookup SQL");
			}


			$update = false;

			if(!$rs->EOF){
				$recordDetails["hits"] = $rs->Fields[0]->Value + 1;
				$update = true;
			}
			$rs->Close();
			$rs=null;

		}



		if($update){
			$sql = "UPDATE BrokenLinks
					   SET hits = " . $recordDetails['hits'] . "
				 WHERE targetURL= '". $linkData["url"]["target"]. "'
				 AND refererURL = '". $linkData["referer"]. "'
				 AND siteAddress = '". $linkData["url"]["siteaddress"]. "'";
		} else {
			$sql = "INSERT INTO BROKENLINKS (
						targetURL,
						refererURL,
						siteAddress
					) VALUES (
					'" . $linkData["url"]["target"] . "',
					'" . $linkData["referer"] . "',						
					'" . $linkData["url"]["siteaddress"] . "')";
		}

		$conn->Execute($sql);




		$conn->close();
		$conn = null;
	} 
}

tryOldServer($_SERVER['REQUEST_URI']);

//echo $_SERVER['REQUEST_URI'];

?>

		<section class="page-header hero-unit">
			<h1>Sorry about that...</h1>
			<br />
			<p>The Marshall University webpage that you were looking for cannot 
be found.</p>
		</section>

						<h3>What happened to the page?</h3>
						<p>
						The page may have been moved to a different section of the server 
						or removed completely.  It's also possible that the site owner updated the link, and your bookmarks are out of date.
						</p>
						<h3>How can I find the right page?</h3>
						<p>
						If you typed in a URL, please check to make sure that there are no misspellings or syntax 
						problems with the address.  You can also use the site search located at the top of the page, or the site index linked below to attempt to find any updates to the location of the page you are looking for.
						</p>
						<h3>Reporting this issue</h3>
						<p>
						The URL you were requesting, and the fact that the page is missing has been automatically captured and reported to both the web team and the site owner.</p>
						<p>Try using the search box below to find pages that might have moved to a new location.
						</p>
						<p>
						<script type="text/javascript">
						var GOOG_FIXURL_LANG = 'en';
						var GOOG_FIXURL_SITE = 'http://www.marshall.edu/';
						</script>
						<script type="text/javascript" 
						src="http://linkhelp.clients.google.com/tbproxy/lh/wm/fixurl.js"></script>
						</p>
						<p>
						You can also attempt to locate the page using the site index below:
						</p>
						<p><b>
						<a href="http://muwww-new.marshall.edu/siteindex.asp?alpha=A">A</a>&nbsp;
						<a href="http://muwww-new.marshall.edu/siteindex.asp?alpha=B">B</a>&nbsp;
						<a href="http://muwww-new.marshall.edu/siteindex.asp?alpha=C">C</a>&nbsp;
						<a href="http://muwww-new.marshall.edu/siteindex.asp?alpha=D">D</a>&nbsp;
						<a href="http://muwww-new.marshall.edu/siteindex.asp?alpha=E">E</a>&nbsp;
						<a href="http://muwww-new.marshall.edu/siteindex.asp?alpha=F">F</a>&nbsp;
						<a href="http://muwww-new.marshall.edu/siteindex.asp?alpha=G">G</a>&nbsp;
						<a href="http://muwww-new.marshall.edu/siteindex.asp?alpha=H">H</a>&nbsp;
						<a href="http://muwww-new.marshall.edu/siteindex.asp?alpha=I">I</a>&nbsp;
						<a href="http://muwww-new.marshall.edu/siteindex.asp?alpha=J">J</a>&nbsp;
						<a href="http://muwww-new.marshall.edu/siteindex.asp?alpha=K">K</a>&nbsp;
						<a href="http://muwww-new.marshall.edu/siteindex.asp?alpha=L">L</a>&nbsp;
						<a href="http://muwww-new.marshall.edu/siteindex.asp?alpha=M">M</a>&nbsp;
						<a href="http://muwww-new.marshall.edu/siteindex.asp?alpha=N">N</a>&nbsp;
						<a href="http://muwww-new.marshall.edu/siteindex.asp?alpha=O">O</a>&nbsp;
						<a href="http://muwww-new.marshall.edu/siteindex.asp?alpha=P">P</a>&nbsp;
						<a href="http://muwww-new.marshall.edu/siteindex.asp?alpha=Q">Q</a>&nbsp;
						<a href="http://muwww-new.marshall.edu/siteindex.asp?alpha=R">R</a>&nbsp;
						<a href="http://muwww-new.marshall.edu/siteindex.asp?alpha=S">S</a>&nbsp;
						<a href="http://muwww-new.marshall.edu/siteindex.asp?alpha=T">T</a>&nbsp;
						<a href="http://muwww-new.marshall.edu/siteindex.asp?alpha=U">U</a>&nbsp;
						<a href="http://muwww-new.marshall.edu/siteindex.asp?alpha=V">V</a>&nbsp;
						<a href="http://muwww-new.marshall.edu/siteindex.asp?alpha=W">W</a>&nbsp;
						<a href="http://muwww-new.marshall.edu/siteindex.asp?alpha=X">X</a>&nbsp;
						<a href="http://muwww-new.marshall.edu/siteindex.asp?alpha=Y">Y</a>&nbsp;
						<a href="http://muwww-new.marshall.edu/siteindex.asp?alpha=Z">Z</a></b></p>
                        <br/>
						<hr />

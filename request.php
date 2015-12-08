<?php

// include the UntappdPHP library
include ("untappdPHP.php");

// load the cache Write function
include ("handleCache.php");

// we are returning json to be parse by the front-end, so we need to set the header
header("Content-type: application/json");

// add your client ID / client secret
$client_id = "XXXXXX";
$client_secret = "XXXXX";

// initalize the Untapd class (note: the third param is redirect_url which is not needed here)
$untappd = new UntappdPHP($client_id, $client_secret, "");

// this is that path you are saving the cache to (it must be writable)
$cachePath = $_SERVER["DOCUMENT_ROOT"] . "/untappd-cache/cache";

// how long you want file to live (in cache to prevent before requesting more information)
$fileTTL = 3600;

// create a return variable
$return_array = array();

// check if the query string exists as is numeric
if (isset($_GET['uid']) && is_numeric($_GET['uid'])) {
	// the 'uid' is the Untappd ID you want to query alone with the 'utype'
	$uid = $_GET['uid'];

	// check if the type string exists as is a string
	if (isset($_GET['utype']) && is_string($_GET['utype'])) {
		
		$utype = $_GET['utype'];

		// construct the file to save
		$cachedFile = "untappd-".$utype."-checkin-feed-".$uid.".json";
		$cacheFilePath = $cachePath . "/". $cachedFile;

		// get the last modified date of the file to determine when it was created/updated

		if (file_exists($cacheFilePath)) {

			$lastModified = date("U", filemtime($cacheFilePath));
			$currentTime = time();

			// subtract the currentTime form the file last modified date to see if it's longer than the $fileTTL;
			$timeDiff = (float)$currentTime - (float)$lastModified;

			if ((int)$timeDiff > $fileTTL) {

				// cache has expired - let's go ahead and re-request data.

				// request the data from the api, with a limit of 15 checkins (you can increase if need more)
				$result = $untappd->get("/".$utype."/checkins/".$uid, array("limit" => "15"));

				// check if we get back a result
				$return_array = handleCacheWrite($cacheFilePath, $result);

			} else {

				// read from cache
				$results = file_get_contents($cacheFilePath);

				if ($results != "") {
					// parse the string back to JSON
					$resultsJSON = json_decode($results);

					$return_array = $resultsJSON;
					$return_array->cacheType = "cache";
				} else {
					$return_array["error"] = "File contents are empty";
				}
			}

		} else {
			// file doesn't exist, make call to Untappd to get data.

			// request the data from the api, with a limit of 15 checkins (you can increase if need more)
			$result = $untappd->get("/".$utype."/checkins/".$uid, array("limit" => "15"));

			// check if we get back a result
			$return_array = handleCacheWrite($cacheFilePath, $result);
		}
	} else {
	// throw a error when utype isn't passed.
	$return_array["error"] = "Invalid Untappd Type (beer, venue, brewery, ...)";
	}
} else {
	// throw a error when UID isn't passed.
	$return_array["error"] = "Invalid Untappd ID";
}

// output 
echo json_encode($return_array);



?>




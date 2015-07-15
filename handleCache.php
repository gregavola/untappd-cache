<?php

function handleCacheWrite($cacheFilePath, $result) {
		
	// define the return array;
	$return_array = array();

	// check if we get back a result
	if ($result != null) {
		// check if we don't get an error
		if ($result->meta->code == 200) {
			// save the results back to the file
			file_put_contents($cacheFilePath, json_encode($result));
			$return_array = $result;

		} else {
			// if the http code is not 200, we don't have to save it in our cache, but just return it the front-end for error checking.
			$return_array = $result;

		}

		$return_array->cacheType = "api";
	}
	else {
		// throw an error if you didn't get a response from the Untappd
		$return_array["error"] = "Unable to access the Untappd API";
	}

	return $return_array;
}
 
?>
<?php
//
// Company: Cloudmanic Labs, LLC
// Website: http://cloudmanic.com
// Date: 10/18/2012
//

namespace Cloudmanic\DayLife;

class Api
{
	static private $_access_key = '';
	static private $_secret_key = '';
	static private $_server = 'freeapi.daylife.com';
	static private $_version = '4.10';

	//
	// Authenticate with the API.
	//
	public static function auth($access, $secret)
	{
		self::$_access_key = $access;
		self::$_secret_key = $secret;
	}

	//
	// Returns and array of image urls. We pass in the size the image should be
	// we pass in the search query. 
	//
	public static function get_image_feed($search, $limit = 10, $width = 600, $height = 600, $days = 365)
	{
		// configure the daylife api server url here 
		$access_url = 'http://' . self::$_server . '/jsonrest/publicapi/' . self::$_version . '/'; 
		 
		// get handle to public api 
		$now_s = time();
		$publicapi = new PublicApi($access_url, self::$_access_key, self::$_secret_key); 
		 
		// build params for article search 
		$params = array(); 
		$params['query'] = $search; 
		$params['sort'] = 'date'; 
		$params['offset'] = 0; 
		$params['limit'] = $limit; 
		$params['end_time'] = $now_s; 
		$params['start_time'] = $now_s - ($days * 86400); 
		 
		// make the API call 
		$results = $publicapi->search_getRelatedImages($params); 
		
		//echo '<pre>' . print_r($results['response']['payload']['image'], TRUE) . '</pre>';
		
		// Loop through and get the images.
		$data = array();
		foreach($results['response']['payload']['image'] AS $key => $row)
		{
			$url = str_replace('133x200.jpg', '1000x1000.jpg?fit=scale&background=ffffff', $row['url']);
			$url = str_replace('200x133.jpg', '1000x1000.jpg?fit=scale&background=ffffff', $url);
			$data[] = $url;
		}
		
		return $data;
	}
}

/* End File */
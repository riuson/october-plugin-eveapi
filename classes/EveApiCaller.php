<?php namespace riuson\EveApi\Classes;

use riuson\EveApi\Classes\EveApiUserData;
use riuson\EveApi\Classes\EveApiCallsLibraryItem;
use riuson\EveApi\Classes\EveApiCallsLibrary;
use DB;
use riuson\EveApi\Commands\ServerStatus;

/**
 * Class to execute request to EVE API server.
 */
class EveApiCaller {

	/**
	 *
	 * @var API Server URL.
	 */
	protected $mApiUrl = "https://api.eveonline.com";

	/**
	 *
	 * @var User data for protected calls.
	 */
	protected $mUserCredentials;

	/**
	 *
	 * @var Static information about api call.
	 */
	protected $mApiMethodData;

	/**
	 *
	 * @var Parameters for call.
	 */
	protected $mCallData;

	/**
	 * Constructor of caller.
	 *
	 * @param \riuson\EveApi\Classes\EveApiCallsLibraryItem $_methodData
	 *        	Static information about api call.
	 *        	
	 * @param array $_callData
	 *        	Parameters for call.
	 *        	
	 * @param \riuson\EveApi\Classes\EveApiUserData $_userData
	 *        	User data for protected calls.
	 *        	
	 * @param bool $_debug
	 *        	Show debug output.
	 */
	public function __construct($_methodData, $_callData = array(), $_userData = null, $debug = false)
	{
		if ($_methodData == null) {
			throw new \Exception("Method data missing");
		}
		
		$this->mApiMethodData = $_methodData;
		$this->mCallData = $_callData;
		$this->mUserCredentials = $_userData;
		
		// base url
		$targetUrl = $this->mApiUrl . $_methodData->uri() . "?";
		
		$params = $_callData;
		
		// if user credendtials present, add to parameters
		if ($_userData != null) {
			$params["keyID"] = $_userData->keyId;
			$params["vCode"] = $_userData->verificationCode;
			
			if ($_userData->characterId != 0) {
				$params["characterID"] = $_userData->characterId;
			}
		}
		
		// append to url, GET
		foreach ($params as $k => $v) {
			$targetUrl .= $k . "=" . $v . "&";
		}
		
		$targetUrl = substr($targetUrl, 0, strlen($targetUrl) - 1);
		$targetUrlWS = str_replace(" ", "%20", $targetUrl);
		// echo $targetUrl;
		
		$result = array();
		$needReload = false;
		$needCache = false;
		$success = false;
		$error = '';
		$serverResponse = '';
		
		// check for cached answer
		$cachedRecord = $this->cachedAnswer($targetUrlWS);
		
		if (empty($cachedRecord)) {
			$needReload = true;
		} else {
			$cached = \DateTime::createFromFormat('Y-m-d H:i:s', $cachedRecord[0]->cached, new \DateTimeZone('UTC'));
			$cachedUntil = \DateTime::createFromFormat('Y-m-d H:i:s', $cachedRecord[0]->cachedUntil, new \DateTimeZone('UTC'));
			$now = new \DateTime("now", new \DateTimeZone('UTC'));
			
			if ($cachedUntil < $now) {
				$needReload = true;
			} else {
				$serverResponse = $cachedRecord[0]->result;
				$success = true;
				$needCache = false;
			}
		}
		//print_r($serverResponse);
		
		if ($needReload == true) {
			// send request
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $targetUrlWS);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			$serverResponse = curl_exec($curl);
			curl_close($curl);
			
			// if error detected
			$matches = array();
			if (preg_match('/\<html\>\<body\>(.*)\<\/body\>\<\/html\>/i', $serverResponse, $matches)) { // || strlen($serverResponse) < 10 || )
				//
				$error = $matches[1];
				$success = false;
				$needCache = false;
			} else {
				// check for error in xml
				if (preg_match("/eveapi/i", $serverResponse) != 0) {
					$success = true;
					$needCache = true;
				} else {
					$error = 'Data received without <eveapi/> xml';
					$success = false;
					$needCache = false;
				}
			}
		}

		// process answer
		if ($success == true) {
			// parse answer
			$domDoc = new \DOMDocument('1.0', 'UTF-8');
			$domDoc->loadXML($serverResponse);
			$domPath = new \DOMXPath($domDoc);
			
			$nodeCurrentTime = $domPath->query('currentTime')->item(0);
			$cached = $nodeCurrentTime->nodeValue;
			
			$nodeCachedUntil = $domPath->query('cachedUntil')->item(0);
			$cachedUntil = $nodeCachedUntil->nodeValue;
			
			if ($needCache == true) {
				DB::table('riuson_eveapi_cache')->insert(array(
					'uri' => $targetUrlWS,
					'cached' => $cached,
					'cachedUntil' => $cachedUntil,
					'result' => $serverResponse
				));
			}
			
			$answerClassName = $_methodData->answerClassName();
			$result = new $answerClassName($domPath);
		} else {
			// create failed answer
		}
		
		//echo $serverResponse;
		//echo "\n";
	}

	private function clearCache()
	{
		$oldTime = date('Y-m-d H:i:s', strtotime('-2 day'));
		DB::table('riuson_eveapi_cache')->where('cached', '<', $oldTime)->delete();
	}

	private function cachedAnswer($_uri)
	{
		$result = DB::table('riuson_eveapi_cache')->where('uri', '=', $_uri)
			->orderBy('cached', 'DESC')
			->take(1)
			->get();
		return $result;
	}
}
<?php namespace riuson\EveApi\Classes\Api;

use riuson\EveApi\Classes\Api\EveApiUserData;
use riuson\EveApi\Classes\Api\EveApiCallsLibraryItem;
use riuson\EveApi\Classes\Api\EveApiCallsLibrary;
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
	 * 
	 * @var Debug mode enabled
	 */
	protected $mDebugMode;

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
		$this->mDebugMode = true;
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

		if ($this->mDebugMode == true) {
			echo "Checking cache...\n";
		}

		// check for cached answer
		$cachedRecord = $this->cachedAnswer($targetUrlWS);
		
		if (empty($cachedRecord)) {
			if ($this->mDebugMode == true) {
				echo "Cache empty. Need reload...\n";
			}

			$needReload = true;
		} else {
			$cached = \DateTime::createFromFormat('Y-m-d H:i:s', $cachedRecord[0]->cached, new \DateTimeZone('UTC'));
			$cachedUntil = \DateTime::createFromFormat('Y-m-d H:i:s', $cachedRecord[0]->cachedUntil, new \DateTimeZone('UTC'));
			$now = new \DateTime("now", new \DateTimeZone('UTC'));

			if ($this->mDebugMode == true) {
				echo "Cached record found.\n";
				echo "Cached until: ";
				print_r($cachedUntil);
				echo "\nCurrent time: ";
				print_r($now);
				echo "\n";
			}

			if ($cachedUntil < $now) {
				if ($this->mDebugMode == true) {
					echo "Cached record obsolete. Need reload.\n";
				}

				$needReload = true;
			} else {
				if ($this->mDebugMode == true) {
					echo "Get from cache.\n";
				}

				$serverResponse = $cachedRecord[0]->result;
				$success = true;
				$needCache = false;
			}
		}
		//print_r($serverResponse);
		
		if ($needReload == true) {
			if ($this->mDebugMode == true) {
				echo "Reloading...\n";
			}

			// send request
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $targetUrlWS);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			$serverResponse = curl_exec($curl);
			curl_close($curl);
			
			// if error detected
			$matches = array();
			if (preg_match('/\<html\>\<body\>(.*)\<\/body\>\<\/html\>/i', $serverResponse, $matches)) { // || strlen($serverResponse) < 10 || )
				if ($this->mDebugMode == true) {
					echo "Html answer detected.\n";
				}

				$error = $matches[1];
				$success = false;
				$needCache = false;
			} else {
				// check for error in xml
				if (preg_match("/\<error.+?\>(.+?)\<\/error\>/i", $serverResponse, $matches) != 0) {
					if ($this->mDebugMode == true) {
						echo "<error> tag detected:\n";
						echo $matches[1];
						echo "\n";
					}

					$error = $matches[1];
					$success = false;
					$needCache = false;
				} else if (preg_match("/eveapi/i", $serverResponse, $matches) != 0) {
					$success = true;
					$needCache = true;
				} else {
					if ($this->mDebugMode == true) {
						echo "<eveapi> tag not found in xml.\n";
					}

					$error = 'Data received without <eveapi/> xml';
					$success = false;
					$needCache = false;
				}
			}
		}

		// process answer
		if ($success == true) {
			if ($this->mDebugMode == true) {
				echo "Processing answer...\n";
			}

			// parse answer
			$domDoc = new \DOMDocument('1.0', 'UTF-8');
			$domDoc->loadXML($serverResponse);
			$domPath = new \DOMXPath($domDoc);
			
			$nodeCurrentTime = $domPath->query('currentTime')->item(0);
			$cached = $nodeCurrentTime->nodeValue;
			
			$nodeCachedUntil = $domPath->query('cachedUntil')->item(0);
			$cachedUntil = $nodeCachedUntil->nodeValue;
			
			if ($needCache == true) {
				if ($this->mDebugMode == true) {
					echo "Save answer to cache.\n";
				}

				DB::table('riuson_eveapi_cache')->insert(array(
					'uri' => $targetUrlWS,
					'cached' => $cached,
					'cachedUntil' => $cachedUntil,
					'result' => $serverResponse
				));
			}
			
			if ($this->mDebugMode == true) {
				echo "Create answer class instance...\n";
			}

			$answerClassName = $_methodData->answerClassName();
			$result = new $answerClassName($domPath);
		} else {
			if ($this->mDebugMode == true) {
				echo "Create failed answer instance.\n";
			}

			// create failed answer
			$result = new FailedCall($error);
		}
		
		//echo $serverResponse;
		//echo "\n";

		return $result;
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

	public function setDebug($_value)
	{
		$this->mDebugMode = $_value;
	}
}
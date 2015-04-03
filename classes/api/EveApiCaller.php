<?php namespace riuson\EveApi\Classes\Api;

use riuson\EveApi\Classes\Api\EveApiUserData;
use riuson\EveApi\Classes\Api\EveApiCallsLibraryItem;
use riuson\EveApi\Classes\Api\EveApiCallsLibrary;
use riuson\EveApi\Models;
use Riuson\EveApi\Models\Cache;
use Carbon\Carbon;

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
	 *
	 * @var array Combined parameters list.
	 */
	protected $mParameters;

	/**
	 * Constructor of caller.
	 *
	 * @param \riuson\EveApi\Classes\EveApiCallsLibraryItem $methodData
	 *        	Static information about api call.
	 *
	 * @param array $callData
	 *        	Parameters for call.
	 *
	 * @param \riuson\EveApi\Classes\EveApiUserData $userData
	 *        	User data for protected calls.
	 */
	public function __construct($methodData, $callData = array(), $userData = null)
	{
		if ($methodData == null) {
			throw new \Exception("Method data missing");
		}

		$this->mDebugMode = false;
		$this->mApiMethodData = $methodData;
		$this->mCallData = $callData;
		$this->mUserCredentials = $userData;

		$this->mParameters = $this->mCallData;

		// if user credendtials present, add to parameters
		if ($userData != null) {
			$this->mParameters["keyID"] = $userData->keyId;
			$this->mParameters["vCode"] = $userData->verificationCode;

			if ($userData->characterId != 0) {
				$this->mParameters["characterID"] = $userData->characterId;
			}
		}

		foreach ($methodData->requiredParameters() as $key) {
			if (! array_key_exists($key, $this->mParameters)) {
				throw new \Exception(sprintf("Parameter '%s' missing", $key));
			}
		}
	}

	public function call()
	{
		// base url
		$targetUrl = $this->mApiUrl . $this->mApiMethodData->uri() . "?";

		// append to url, GET
		foreach ($this->mParameters as $k => $v) {
			$targetUrl .= $k . "=" . $v . "&";
		}

		$targetUrl = substr($targetUrl, 0, strlen($targetUrl) - 1);
		$targetUrlWS = str_replace(" ", "%20", $targetUrl);
		// echo $targetUrl;

		$result = array();
		$needReload = false;
		$needCache = false;
		$success = false;
		$errorCode = 0;
		$errorText = '';
		$serverResponse = '';

		if ($this->mDebugMode == true) {
			echo "Checking cache...\n";
		}

		// check for cached answer
		$cachedRecord = Cache::where('uri', '=', $targetUrlWS)
			->orderBy('cached', 'DESC')
			->first();

		// if cached record not found
		if (empty($cachedRecord)) {
			if ($this->mDebugMode == true) {
				echo "Cache empty. Need reload...\n";
			}

			$needReload = true;
		} else { // found
			$cached = $cachedRecord->cached;
			$cachedUntil = $cachedRecord->cachedUntil;
			$now = Carbon::now('UTC');

			if ($this->mDebugMode == true) {
				printf("Cached record found.\nCached until: %s\nCurrent time: %s\n",
					print_r($cachedUntil, true),
					print_r($now, true));
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

				$serverResponse = $cachedRecord->result;
				$success = true;
				$needCache = false;
			}
		}
		// print_r($serverResponse);

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

				$errorText = $matches[1];
				$errorCode = 99999;
				$success = false;
				$needCache = false;
			} else {
				// check for error in xml
				if (preg_match("/\<error.+?code=\"(.+?)\"\>(.+?)\<\/error\>/i", $serverResponse, $matches) != 0) {
					if ($this->mDebugMode == true) {
						printf("<error> tag detected: %d - %s\n", $matches[1], $matches[2]);
					}

					$errorCode = $matches[1];
					$errorText = $matches[2];
					$success = false;
					$needCache = false;
				} else
					if (preg_match("/eveapi/i", $serverResponse, $matches) != 0) {
						$success = true;
						$needCache = true;
					} else {
						if ($this->mDebugMode == true) {
							echo "<eveapi> tag not found in xml.\n";
						}

						$errorText = 'Data received without <eveapi/> xml';
						$errorCode = 99999;
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

			if ($needCache == true) {
				if ($this->mDebugMode == true) {
					echo "Save answer to cache.\n";
				}

				$nodeCurrentTime = $domPath->query('currentTime')->item(0);
				$cached = Carbon::createFromFormat('Y-m-d H:i:s', $nodeCurrentTime->nodeValue, 'UTC');

				$nodeCachedUntil = $domPath->query('cachedUntil')->item(0);
				$cachedUntil = Carbon::createFromFormat('Y-m-d H:i:s', $nodeCachedUntil->nodeValue, 'UTC');

				$cachedRecord = new Cache();
				$cachedRecord->uri = $targetUrlWS;
				$cachedRecord->method = $this->mApiMethodData->uri();
				$cachedRecord->cached = $cached;
				$cachedRecord->cachedUntil = $cachedUntil;
				$cachedRecord->result = $serverResponse;

				$p = '';
				foreach ($this->mParameters as $k => $v) {
					$p .= $k . ": " . $v . "\n";
				}

				$cachedRecord->params = preg_replace('/[\n\r]$/i', '', $p);
				;

				$cachedRecord->save();
			}

			if ($this->mDebugMode == true) {
				echo "Create answer class instance...\n";
			}

			$answerClassName = $this->mApiMethodData->answerClassName();
			$result = new $answerClassName($domPath);
		} else {
			if ($this->mDebugMode == true) {
				echo "Create failed answer instance.\n";
			}

			// create failed answer
			$result = new FailedCall($errorCode, $errorText);
		}

		if ($this->mDebugMode == true) {
			print_r($result);
			echo "\n";
		}

		return $result;
	}

	private function clearCache()
	{
		$beforeTime = Carbon::now('UTC')->subDay(2);
		Cache::where('cachedUntil', '<', $beforeTime)->delete();
	}

	public function setDebug($enabled)
	{
		$this->mDebugMode = $enabled;
	}
}
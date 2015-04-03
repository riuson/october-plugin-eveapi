<?php namespace riuson\EveApi\Classes\Parser;

use Carbon\Carbon;

class DataValues {

	public function __construct(\DOMXPath $domPath, $rootNode)
	{
		$values = array();

		$cachedUntil = $domPath->query('/eveapi/cachedUntil')->item(0)->nodeValue;
		$currentTime = $domPath->query('/eveapi/currentTime')->item(0)->nodeValue;

		if (! empty($cachedUntil) && ! empty($cachedUntil)) {
			$values['cachedUntil'] = Carbon::createFromFormat('Y-m-d H:i:s', $cachedUntil, 'UTC');
			$values['currentTime'] = Carbon::createFromFormat('Y-m-d H:i:s', $currentTime, 'UTC');
		}

		// select nodes without childs and attributes
		$simpleNodes = $domPath->query('child::*[not(*)]', $rootNode);
		foreach ($simpleNodes as $simpleNode) {
			if ($simpleNode->attributes->length == 0) {
				//printf("%s - %d\n", $simpleNode->nodeName, $simpleNode->attributes->length);
				//printf(" %d \n", $simpleNode->childNodes->length);

				// collect key-value pairs
				$values[$simpleNode->nodeName] = $simpleNode->nodeValue;

				$matches = array();
				if (preg_match("/^\d{4}\-\d{2}\-\d{2} \d{2}\:\d{2}\:\d{2}$/i", $simpleNode->nodeValue, $matches) == 1) {
					$values[$simpleNode->nodeName] = Carbon::createFromFormat('Y-m-d H:i:s', $matches[0], 'UTC');
				}
			}
		}

		$this->mValues = $values;
	}

	private $mValues;

	public function all()
	{
		return $this->mValues;
	}

	public function byName($name)
	{
		if (array_key_exists($name, $this->mValues)) {
			return $this->mValues[$name];
		}

		return NULL;
	}
}
<?php namespace riuson\EveApi\Classes\Parser;

use Carbon\Carbon;

class DataValues {

	public function __construct(\DOMXPath $_domPath, $_rootNode)
	{
		$values = array();

		$cachedUntl = $_domPath->query('/eveapi/cachedUntil')->item(0)->nodeValue;
		$currentTime = $_domPath->query('/eveapi/currentTime')->item(0)->nodeValue;

		if (! empty($cachedUntl) && ! empty($cachedUntl)) {
			$values['cachedUntil'] = Carbon::createFromFormat('Y-m-d H:i:s', $cachedUntl, 'UTC');
			$values['currentTime'] = Carbon::createFromFormat('Y-m-d H:i:s', $currentTime, 'UTC');
		}

		// select nodes without childs and attributes
		$simpleNodes = $_domPath->query('child::*[not(*)]', $_rootNode);
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

	public function values()
	{
		return $this->mValues;
	}

	public function value($_name)
	{
		if (array_key_exists($_name, $this->mValues)) {
			return $this->mValues[$_name];
		}

		return NULL;
	}
}
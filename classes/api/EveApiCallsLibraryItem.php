<?php namespace riuson\EveApi\Classes\Api;

/**
 * Library item with basic data collection.
 */
class EveApiCallsLibraryItem {

	/**
	 *
	 * @var Uri of the API request
	 */
	public $uri = null;

	/**
	 *
	 * @var Access mask of the key, required for request
	 */
	public $accessMask = 0;

	/**
	 *
	 * @var Common name of the API function
	 */
	public $commonName = null;

	/**
	 *
	 * @var List of required parameters for API call
	 */
	public $requiredParameters = null;

	/**
	 *
	 * @var Name of class for answer
	 */
	public $answerClassName = '';

	/**
	 * Constructor with credentials.
	 *
	 * @param string $uri
	 *        	Access mask of the key, required for request
	 *
	 * @param int $accessMask
	 *        	Access mask of the key, required for request
	 *
	 * @param string $commonName
	 *        	Common name of the API function
	 *
	 * @param array $parameters
	 *        	List of required parameters for API call
	 */
	public function __construct($uri, $accessMask, $commonName, $answerClassName, $parameters = array())
	{
		$this->uri = $uri;
		$this->accessMask = $accessMask;
		$this->commonName = $commonName;
		$this->answerClassName = $answerClassName;
		$this->requiredParameters = $parameters;
	}
}

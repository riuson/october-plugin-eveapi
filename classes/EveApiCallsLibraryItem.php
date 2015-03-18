<?php namespace riuson\EveApi\Classes;

/**
 * Library item with basic data collection.
 */
class EveApiCallsLibraryItem {

	/**
	 *
	 * @var Uri of the API request
	 */
	protected $mUri = null;

	/**
	 * Access mask of the key, required for request
	 */
	protected $mAccessMask = 0;

	/**
	 * Common name of the API function
	 */
	protected $mCommonName = null;

	/**
	 * List of required parameters for API call
	 */
	protected $mRequiredParameters = null;

	/**
	 * Constructor with credentials.
	 *
	 * @param string $_uri
	 *        	Access mask of the key, required for request
	 *        	
	 * @param int $_accessMask
	 *        	Access mask of the key, required for request
	 *        	
	 * @param string $_commonName
	 *        	Common name of the API function
	 *        	
	 * @param array $_parameters
	 *        	List of required parameters for API call
	 */
	public function __construct($_uri, $_accessMask, $_commonName, $_parameters = array())
	{
		$this->mUri = $_uri;
		$this->mAccessMask = $_accessMask;
		$this->mCommonName = $_commonName;
		$this->mRequiredParameters = $_parameters;
	}

	/**
	 * Gets Uri of the API request
	 */
	public function uri()
	{
		return $this->mUri;
	}

	/**
	 * Gets access mask of the key, required for request
	 */
	public function accessMask()
	{
		return $this->mAccessMask;
	}

	/**
	 * Common name of the API function
	 */
	public function commonName()
	{
		return $this->mCommonName;
	}

	/**
	 * List of required parameters for API call
	 */
	public function requiredParameters()
	{
		return $this->mRequiredParameters;
	}
}

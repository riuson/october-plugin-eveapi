<?php namespace riuson\EveApi\Classes\Api;

/**
 * User Data for API request
 *
 * @package riuson\EveApi\Classes
 * @author riuson
 */
class EveApiUserData {

	/**
	 *
	 * @var EVE API Key ID
	 */
	public $keyId = null;

	/**
	 *
	 * @var EVE API Verification Code
	 */
	public $verificationCode = null;

	/**
	 *
	 * @var Character ID
	 */
	public $characterId = null;

	/**
	 * Constructor with credentials and userId.
	 *
	 * @param integer $_keyId
	 *        	The ID of the Customizable API Key for authentication, found at: https://support.eveonline.com/api
	 *
	 * @param string $_vCode
	 *        	The user defined or CCP generated Verification Code for the Customizable API Key, found at https://support.eveonline.com/api
	 *
	 * @param integer $_characterId
	 *        	The ID of the character for the requested data, from Character List. Only for /Char/ endpoints. Optional when the API Key is only valid for a single character.
	 */
	public function __construct($_keyId = null, $_vCode = null, $_characterId = 0)
	{
		$this->keyId = $_keyId;
		$this->verificationCode = $_vCode;
		$this->characterId = $_characterId;
	}
}
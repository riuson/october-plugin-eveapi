<?php namespace riuson\EveApi\Classes\Api;

/**
 * Class of answer, indicating failed API call
 *
 * @author vladimir
 *
 */
class FailedCall {

	/**
	 *
	 * @param unknown $errorText
	 *        	Error message
	 */
	public function __construct($errorCode, $errorText)
	{
		$this->errorCode = $errorCode;
		$this->errorText = $errorText;
	}

	/**
	 *
	 * @var integer Error code
	 */
	public $errorCode;

	/**
	 *
	 * @var string Error message
	 */
	public $errorText;
}
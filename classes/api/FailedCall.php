<?php namespace riuson\EveApi\Classes\Api;

/**
 * Class of answer, indicating failed API call
 * @author vladimir
 *
 */
class FailedCall {
	/**
	 * 
	 * @param unknown $_message
	 * Error message
	 */
	public function __construct($_message)
	{
		$this->mMessage = $_message;
	}
	
	/**
	 * 
	 * @var unknown
	 * Error message
	 */
	protected $mMessage;
	
	/**
	 * 
	 * @return \riuson\EveApi\Classes\Api\unknown
	 * Error message
	 */
	public function message()
	{
		return $this->mMessage;
	}
}
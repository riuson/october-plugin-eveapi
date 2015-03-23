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
	 * @param unknown $_message
	 *        	Error message
	 */
	public function __construct($_code, $_message)
	{
		$this->mCode = $_code;
		$this->mMessage = $_message;
	}

	/**
	 *
	 * @var integer Error code
	 */
	protected $mCode;

	/**
	 *
	 * @var string Error message
	 */
	protected $mMessage;

	/**
	 *
	 * @return integer Error code
	 */
	public function code()
	{
		return $this->mCode;
	}

	/**
	 *
	 * @return string Error message
	 */
	public function message()
	{
		return $this->mMessage;
	}
}
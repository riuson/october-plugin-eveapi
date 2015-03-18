<?php namespace riuson\EveApi\Classes\Api\Account;

class AccountStatus {

	/**
	 * Object constructor
	 * rowset multiCharacterTraining not implemented
	 *
	 * @param \DOMXPath $domPath
	 *        	XPath for source document with data
	 */
	public function __construct($domPath)
	{
		$paidUntilValue = $domPath->query('//result/paidUntil')->item(0)->nodeValue;
		$this->mPaidUntil = \DateTime::createFromFormat('Y-m-d H:i:s', $paidUntilValue, new \DateTimeZone('UTC'));

		$createDateValue = $domPath->query('//result/createDate')->item(0)->nodeValue;
		$this->mCreateDate = \DateTime::createFromFormat('Y-m-d H:i:s', $createDateValue, new \DateTimeZone('UTC'));

		$logonCountValue = $domPath->query('//result/logonCount')->item(0)->nodeValue;
		$this->mLogonCount = intval($logonCountValue);

		$logonMinutesValue = $domPath->query('//result/logonMinutes')->item(0)->nodeValue;
		$this->mLogonMinutes = intval($logonMinutesValue);
	}

	/**
	 *
	 * @var Account datetime paid until
	 */
	protected $mPaidUntil;

	/**
	 *
	 * @var Create date
	 */
	protected $mCreateDate;

	/**
	 *
	 * @var Logon count
	 */
	protected $mLogonCount;

	/**
	 *
	 * @var Logon minutes
	 */
	protected $mLogonMinutes;
	
	/**
	 * 
	 * @return \DateTime Account datetime paid until
	 */
	public function paidUntil()
	{
		return $this->mPaidUntil;
	}

	/**
	 * 
	 * @return \DateTime Create date
	 */
	public function createDate()
	{
		return $this->mCreateDate;
	}

	/**
	 * 
	 * @return integer Logon count
	 */
	public function logonCount()
	{
		return $this->mLogonCount;
	}

	/**
	 * 
	 * @return integer Logon minutes
	 */
	public function logonMinutes()
	{
		return $this->mLogonMinutes;
	}
}
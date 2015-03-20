<?php namespace riuson\EveApi\Classes\Api\Account;

use riuson\EveApi\Classes\Parser\DataRowset;

/**
 *
 * @author vladimir
 *         API Key Info
 */
class APIKeyInfo {

	/**
	 * Object constructor
	 * rowset multiCharacterTraining not implemented
	 *
	 * @param \DOMXPath $domPath
	 *        	XPath for source document with data
	 */
	public function __construct(\DOMXPath $_domPath)
	{
		$nodeRowset = $_domPath->query('/eveapi/result/key/rowset')->item(0);
		$this->mCharactersRowset = new DataRowset($_domPath, $nodeRowset);

		$nodeKey = $_domPath->query('/eveapi/result/key')->item(0);
		$this->mAccessMask = $nodeKey->getAttribute('accessMask');
		$this->mType = $nodeKey->getAttribute('type');
		$this->mExpires = \DateTime::createFromFormat('Y-m-d H:i:s', $nodeKey->getAttribute('expires'), new \DateTimeZone('UTC'));
	}

	/**
	 *
	 * @var integer The bitwise number of the calls the API key can query
	 */
	protected $mAccessMask;

	/**
	 *
	 * @var string The access level of the API key (ex. Account, Character, Corporation)
	 */
	protected $mType;

	/**
	 *
	 * @var \DateTime The date the API key expires. This value will be empty if the key is not set to expire.
	 */
	protected $mExpires;

	/**
	 *
	 * @var DataRowset Characters list exposed by API key
	 */
	protected $mCharactersRowset;

	/**
	 *
	 * @return integer The bitwise number of the calls the API key can query
	 */
	public function accessMask()
	{
		return $this->mAccessMask;
	}

	/**
	 *
	 * @return string The access level of the API key (ex. Account, Character, Corporation)
	 */
	public function type()
	{
		return $this->mType;
	}

	/**
	 *
	 * @return DateTime The date the API key expires. This value will be empty if the key is not set to expire.
	 */
	public function expires()
	{
		return $this->mExpires;
	}

	/**
	 *
	 * @return DataRowset Returns characters list exposed by API key
	 */
	public function rowset()
	{
		return $this->mCharacterRowset;
	}
}
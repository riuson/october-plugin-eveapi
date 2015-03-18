<?php namespace riuson\EveApi\Classes\Api\Server;

class ServerStatus {

	/**
	 * Object constructor
	 *
	 * @param \DOMXPath $domPath
	 *        	XPath for source document with data
	 */
	public function __construct($domPath)
	{
		$openedValue = $domPath->query('//result/serverOpen')->item(0)->nodeValue;
		$this->mServerOpen = $openedValue === 'True'? true: false;

		$onlineValue = $domPath->query('//result/onlinePlayers')->item(0)->nodeValue;
		$this->mOnlinePlayers = intval($onlineValue);
	}

	/**
	 *
	 * @var bool Is server online
	 */
	protected $mServerOpen;

	/**
	 *
	 * @var integer Number of players online
	 */
	protected $mOnlinePlayers;

	/**
	 * 
	 * @return boolean Is server online
	 */
	public function serverOpen()
	{
		return $this->mServerOpen;
	}

	/**
	 * 
	 * @return number Number of players online
	 */
	public function onlinePlayers()
	{
		return $this->mOnlinePlayers;
	}
}
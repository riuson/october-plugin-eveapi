<?php namespace riuson\EveApi\Classes\Api\Server;

use riuson\EveApi\Classes\Parser\DataValues;

class ServerStatus {

	/**
	 * Object constructor
	 *
	 * @param \DOMXPath $domPath
	 *        	XPath for source document with data
	 */
	public function __construct($_domPath)
	{
		$this->values = new DataValues($_domPath, $_domPath->query('//result')->item(0));

		$this->values->all()['serverOpen'] = ($this->values->byName('serverOpen') === 'True' ? true : false);
	}

	/**
	 * Simple values list
	 *
	 * @var riuson\EveApi\Classes\Parser\DataValues
	 */
	public $values;
}
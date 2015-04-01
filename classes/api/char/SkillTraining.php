<?php namespace riuson\EveApi\Classes\Api\Char;

use riuson\EveApi\Classes\Parser\DataValues;
use riuson\EveApi\Classes\Parser\DataRowset;

class SkillTraining {

	/**
	 * Object constructor
	 *
	 * @param \DOMXPath $domPath
	 *        	XPath for source document with data
	 */
	public function __construct($_domPath)
	{
		$this->values = new DataValues($_domPath, $_domPath->query('//result')->item(0));
	}

	/**
	 * Simple values list
	 *
	 * @var riuson\EveApi\Classes\Parser\DataValues
	 */
	public $values;
}
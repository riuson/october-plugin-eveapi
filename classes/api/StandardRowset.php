<?php namespace riuson\EveApi\Classes\Api;

use riuson\EveApi\Classes\Parser\DataRowset;

/**
 * Class for typical answer, contaning only rowset
 */

class StandardRowset {

	/**
	 * Object constructor
	 *
	 * @param \DOMXPath $domPath
	 *        	XPath for source document with data
	 */
	public function __construct(\DOMXPath $_domPath)
	{
		$nodeRowset = $_domPath->query('/eveapi/result/rowset')->item(0);
		$this->mRowset = new DataRowset($_domPath, $nodeRowset);
	}

	/**
	 *
	 * @var DataRowset Rowset
	 */
	protected $mRowset;

	/**
	 *
	 * @return DataRowset Returns rowset
	 */
	public function rowset()
	{
		return $this->mRowset;
	}
}
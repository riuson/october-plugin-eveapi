<?php namespace riuson\EveApi\Classes\Api\Char;

use riuson\EveApi\Classes\Parser\DataRowset;

class AssetList {

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

	protected $mRowset;

	public function rowset()
	{
		return $this->mRowset;
	}
}
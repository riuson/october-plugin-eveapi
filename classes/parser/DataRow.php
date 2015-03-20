<?php namespace riuson\EveApi\Classes\Parser;

/**
 *
 * @author vladimir
 *         Row for rowset
 */
class DataRow {

	/**
	 *
	 * @param \DOMXPath $_domPath
	 *        	XPath for parent DOM document
	 * @param \DOMNode $_rowsetNode
	 *        	Root rowset's node for relative queries
	 */
	public function __construct($_domPath, $_rowNode)
	{
		$this->mValues = array();
		$this->mHasChild = false;
		$this->mRowset = null;

		foreach ($_rowNode->attributes as $attr) {
			$this->mValues[$attr->nodeName] = $attr->nodeValue;
		}

		if ($_rowNode->hasChildNodes()) {
			$nodesRowset = $_domPath->query('/rowset', $_rowNode);

			if ($nodesRowset->length > 1) {
				throw new Exception('Row has more than one child rowsets.');
			}

			if ($nodesRowset->length == 1) {
				$nodeRowset = $nodesRowset->item(0);
				$this->mRowset = new DataRowset($_domPath, $nodeRowset);
			}
		}
	}

	/**
	 *
	 * @var array Values array
	 */
	protected $mValues;

	/**
	 *
	 * @var bool Has child rowset
	 */
	protected $mHasChild;

	/**
	 *
	 * @var DataRowset Child rowset
	 */
	protected $mRowset;

	/**
	 *
	 * @return array: Values array
	 */
	public function values()
	{
		return $this->mValues;
	}

	/**
	 *
	 * @return bool: Has child rowset
	 */
	public function hasChild()
	{
		return $this->mHasChild;
	}

	/**
	 *
	 * @return DataRowset: Child rowset
	 */
	public function rowset()
	{
		return $this->mRowset;
	}
}
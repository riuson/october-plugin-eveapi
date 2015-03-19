<?php namespace riuson\EveApi\Classes\Parser;

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

			$nodeRowset = $nodesRowset->item(0);
			$this->mRowset = new DataRowset($_domPath, $nodeRowset);
		}
	}

	protected $mValues;

	protected $mHasChild;

	protected $mRowset;
}
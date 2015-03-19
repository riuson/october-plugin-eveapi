<?php namespace riuson\EveApi\Classes\Parser;

class DataRowset {

	/**
	 *
	 * @param \DOMXPath $_domPath
	 *        	XPath for parent DOM document
	 * @param \DOMNode $_rowsetNode
	 *        	Root rowset's node for relative queries
	 */
	public function __construct($_domPath, $_rowsetNode)
	{
		$this->mName = $_rowsetNode->getAttribute('name');
		$this->mKey = $_rowsetNode->getAttribute('key');
		$this->mColumns = explode(',', $_rowsetNode->getAttribute('columns'));
		$this->mRows = array();

		$nodesRow = $_domPath->query("row", $_rowsetNode);

		foreach ($nodesRow as $nodeRow) {
			$row = new DataRow($_domPath, $nodeRow);
			array_push($this->mRows, $row);
		}
	}

	protected $mName;

	protected $mKey;

	protected $mColumns;

	protected $mRows;

	public function name()
	{
		return $this->mName;
	}

	public function key()
	{
		return $this->mKey;
	}

	public function columns()
	{
		return $this->mColumns;
	}

	public function rows()
	{
		return $this->mRows;
	}

	public function rowCount()
	{
		return count($this->mRows);
	}
}
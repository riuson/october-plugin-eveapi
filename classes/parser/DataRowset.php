<?php namespace riuson\EveApi\Classes\Parser;

/**
 *
 * @author vladimir
 *         Rowset
 */
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

	/**
	 *
	 * @var string Name of the rowset
	 */
	protected $mName;

	/**
	 *
	 * @var string Key column of the rowset
	 */
	protected $mKey;

	/**
	 *
	 * @var array Columns list
	 */
	protected $mColumns;

	/**
	 *
	 * @var array Child rows of rowset
	 */
	protected $mRows;

	/**
	 *
	 * @return string Name of the rowset
	 */
	public function name()
	{
		return $this->mName;
	}

	/**
	 *
	 * @return string Key column of the rowset
	 */
	public function key()
	{
		return $this->mKey;
	}

	/**
	 *
	 * @return array: Columns list
	 */
	public function columns()
	{
		return $this->mColumns;
	}

	/**
	 *
	 * @return array: Child rows of rowset
	 */
	public function rows()
	{
		return $this->mRows;
	}

	/**
	 *
	 * @return integer Returns number of child rows
	 */
	public function rowCount()
	{
		return count($this->mRows);
	}
}
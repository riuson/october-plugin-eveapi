<?php
namespace Riuson\EveApi\Classes\Parser;

/**
 *
 * @author vladimir
 *         Rowset
 */
class DataRowset
{

    /**
     *
     * @param \DOMXPath $domPath
     *            XPath for parent DOM document
     * @param \DOMNode $rowsetNode
     *            Root rowset's node for relative queries
     */
    public function __construct($domPath, $rowsetNode)
    {
        $this->name = $rowsetNode->getAttribute('name');
        $this->key = $rowsetNode->getAttribute('key');
        $this->columns = explode(',', $rowsetNode->getAttribute('columns'));
        $this->rows = array();

        $nodesRow = $domPath->query("row", $rowsetNode);

        foreach ($nodesRow as $nodeRow) {
            $row = new DataRow($domPath, $nodeRow);
            array_push($this->rows, $row);
        }
    }

    /**
     *
     * @var string Name of the rowset
     */
    public $name;

    /**
     *
     * @var string Key column of the rowset
     */
    public $key;

    /**
     *
     * @var array Columns list
     */
    public $columns;

    /**
     *
     * @var array Child rows of rowset
     */
    public $rows;

    /**
     *
     * @return \DataRow Child row of rowset by index
     */
    public function row($index)
    {
        return $this->rows[$index];
    }

    /**
     *
     * @return integer Returns number of child rows
     */
    public function rowCount()
    {
        return count($this->rows);
    }
}
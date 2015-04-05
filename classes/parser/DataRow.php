<?php
namespace Riuson\EveApi\Classes\Parser;

/**
 *
 * @author vladimir
 *         Row for rowset
 */
class DataRow
{

    /**
     *
     * @param \DOMXPath $domPath
     *            XPath for parent DOM document
     * @param \DOMNode $rowNode
     *            Root rowset's node for relative queries
     */
    public function __construct($domPath, $rowNode)
    {
        $this->values = array();
        $this->hasChild = false;
        $this->rowset = null;

        foreach ($rowNode->attributes as $attr) {
            $this->values[$attr->nodeName] = $attr->nodeValue;
        }

        if ($rowNode->hasChildNodes()) {
            $nodesRowset = $domPath->query('/rowset', $rowNode);

            if ($nodesRowset->length > 1) {
                throw new Exception('Row has more than one child rowsets.');
            }

            if ($nodesRowset->length == 1) {
                $nodeRowset = $nodesRowset->item(0);
                $this->rowset = new DataRowset($domPath, $nodeRowset);
            }
        }
    }

    /**
     *
     * @var array Values array
     */
    public $values;

    /**
     *
     * @var bool Has child rowset
     */
    public $hasChild;

    /**
     *
     * @var DataRowset Child rowset
     */
    public $rowset;
}

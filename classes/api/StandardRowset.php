<?php
namespace Riuson\EveApi\Classes\Api;

use Riuson\EveApi\Classes\Parser\DataRowset;

/**
 * Class for typical answer, contaning only rowset
 */
class StandardRowset
{

    /**
     * Object constructor
     *
     * @param \DOMXPath $domPath
     *            XPath for source document with data
     */
    public function __construct(\DOMXPath $domPath)
    {
        $nodeRowset = $domPath->query('/eveapi/result/rowset')->item(0);
        $this->rowset = new DataRowset($domPath, $nodeRowset);
    }

    /**
     *
     * @var DataRowset Rowset
     */
    public $rowset;
}
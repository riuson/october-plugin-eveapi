<?php
namespace riuson\EveApi\Classes\Api\Eve;

use riuson\EveApi\Classes\Parser\DataValues;
use riuson\EveApi\Classes\Parser\DataRowset;

class CharacterInfo
{

    /**
     * Object constructor
     * rowset multiCharacterTraining not implemented
     *
     * @param \DOMXPath $domPath
     *            XPath for source document with data
     */
    public function __construct($domPath)
    {
        $this->values = new DataValues($domPath, $domPath->query('//result')->item(0));
        $this->employmentHistory = new DataRowset($domPath, $domPath->query('/eveapi/result/rowset[@name = "employmentHistory"]')->item(0));
    }

    /**
     * Simple values list
     *
     * @var riuson\EveApi\Classes\Parser\DataValues
     */
    public $values;

    /**
     * Employment history
     *
     * @var riuson\EveApi\Classes\Parser\DataRowset
     */
    public $employmentHistory;
}
<?php
namespace Riuson\EveApi\Classes\Api\Account;

use Riuson\EveApi\Classes\Parser\DataValues;

class AccountStatus
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
    }

    /**
     * Simple values list
     *
     * @var Riuson\EveApi\Classes\Parser\DataValues
     */
    public $values;
}
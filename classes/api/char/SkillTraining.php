<?php
namespace Riuson\EveApi\Classes\Api\Char;

use Riuson\EveApi\Classes\Parser\DataValues;
use Riuson\EveApi\Classes\Parser\DataRowset;

class SkillTraining
{

    /**
     * Object constructor
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
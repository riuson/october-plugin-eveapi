<?php
namespace Riuson\EveApi\Classes\Api\Server;

use Riuson\EveApi\Classes\Parser\DataValues;

class ServerStatus
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

        $this->values->all()['serverOpen'] = ($this->values->byName('serverOpen') === 'True' ? true : false);
    }

    /**
     * Simple values list
     *
     * @var Riuson\EveApi\Classes\Parser\DataValues
     */
    public $values;
}
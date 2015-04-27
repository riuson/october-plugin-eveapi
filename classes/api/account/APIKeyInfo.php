<?php
namespace Riuson\EveApi\Classes\Api\Account;

use Riuson\EveApi\Classes\Parser\DataRowset;
use Riuson\EveApi\Classes\Parser\DataValues;

/**
 *
 * @author vladimir
 *         API Key Info
 */
class APIKeyInfo
{

    /**
     * Object constructor
     * rowset multiCharacterTraining not implemented
     *
     * @param \DOMXPath $domPath
     *            XPath for source document with data
     */
    public function __construct(\DOMXPath $domPath)
    {
        $this->values = new DataValues($domPath, $domPath->query('//result')->item(0));

        $nodeRowset = $domPath->query('/eveapi/result/key/rowset')->item(0);
        $this->charactersRowset = new DataRowset($domPath, $nodeRowset);

        $nodeKey = $domPath->query('/eveapi/result/key')->item(0);
        $this->accessMask = $nodeKey->getAttribute('accessMask');
        $this->type = $nodeKey->getAttribute('type');
        $this->expires = \DateTime::createFromFormat('Y-m-d H:i:s', $nodeKey->getAttribute('expires'), new \DateTimeZone('UTC'));
    }

    /**
     *
     * @var integer The bitwise number of the calls the API key can query
     */
    public $accessMask;

    /**
     *
     * @var string The access level of the API key (ex. Account, Character, Corporation)
     */
    public $type;

    /**
     *
     * @var \DateTime The date the API key expires. This value will be empty if the key is not set to expire.
     */
    public $expires;

    /**
     *
     * @var DataRowset Characters list exposed by API key
     */
    public $charactersRowset;

    /**
     * Simple values list
     *
     * @var Riuson\EveApi\Classes\Parser\DataValues
     */
    public $values;
}
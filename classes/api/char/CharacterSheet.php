<?php
namespace Riuson\EveApi\Classes\Api\Char;

use Riuson\EveApi\Classes\Parser\DataValues;
use Riuson\EveApi\Classes\Parser\DataRowset;

class CharacterSheet
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
        $this->headAttributes = new DataValues($domPath, $domPath->query('//result/attributes')->item(0));
        $this->jumpClones = new DataRowset($domPath, $domPath->query('/eveapi/result/rowset[@name = "jumpClones"]')->item(0));
        $this->jumpCloneImplants = new DataRowset($domPath, $domPath->query('/eveapi/result/rowset[@name = "jumpCloneImplants"]')->item(0));
        $this->implants = new DataRowset($domPath, $domPath->query('/eveapi/result/rowset[@name = "implants"]')->item(0));
        $this->skills = new DataRowset($domPath, $domPath->query('/eveapi/result/rowset[@name = "skills"]')->item(0));
        $this->certificates = new DataRowset($domPath, $domPath->query('/eveapi/result/rowset[@name = "certificates"]')->item(0));
        $this->corporationRolesAtHQ = new DataRowset($domPath, $domPath->query('/eveapi/result/rowset[@name = "corporationRolesAtHQ"]')->item(0));
        $this->corporationRolesAtBase = new DataRowset($domPath, $domPath->query('/eveapi/result/rowset[@name = "corporationRolesAtBase"]')->item(0));
        $this->corporationRolesAtOther = new DataRowset($domPath, $domPath->query('/eveapi/result/rowset[@name = "corporationRolesAtOther"]')->item(0));
        $this->corporationTitles = new DataRowset($domPath, $domPath->query('/eveapi/result/rowset[@name = "corporationTitles"]')->item(0));
    }

    /**
     * Simple values list
     *
     * @var Riuson\EveApi\Classes\Parser\DataValues
     */
    public $values;

    /**
     * Attributes
     *
     * @var Riuson\EveApi\Classes\Parser\DataValues
     */
    public $headAttributes;

    /**
     * Jump clones
     *
     * @var Riuson\EveApi\Classes\Parser\DataRowset
     */
    public $jumpClones;

    /**
     * Jump clone implants
     *
     * @var Riuson\EveApi\Classes\Parser\DataRowset
     */
    public $jumpCloneImplants;

    /**
     * Current implants
     *
     * @var Riuson\EveApi\Classes\Parser\DataRowset
     */
    public $implants;

    /**
     * Learned skills
     *
     * @var Riuson\EveApi\Classes\Parser\DataRowset
     */
    public $skills;

    /**
     *
     * @var Riuson\EveApi\Classes\Parser\DataRowset
     */
    public $certificates;

    /**
     *
     * @var Riuson\EveApi\Classes\Parser\DataRowset
     */
    public $corporationRolesAtHQ;

    /**
     *
     * @var Riuson\EveApi\Classes\Parser\DataRowset
     */
    public $corporationRolesAtBase;

    /**
     *
     * @var Riuson\EveApi\Classes\Parser\DataRowset
     */
    public $corporationRolesAtOther;

    /**
     *
     * @var Riuson\EveApi\Classes\Parser\DataRowset
     */
    public $corporationTitles;
}
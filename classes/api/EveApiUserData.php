<?php
namespace riuson\EveApi\Classes\Api;

/**
 * User Data for API request
 *
 * @package riuson\EveApi\Classes
 * @author riuson
 */
class EveApiUserData
{

    /**
     *
     * @var EVE API Key ID
     */
    public $keyId = null;

    /**
     *
     * @var EVE API Verification Code
     */
    public $verificationCode = null;

    /**
     *
     * @var Character ID
     */
    public $characterId = null;

    /**
     * Constructor with credentials and userId.
     *
     * @param integer $keyId
     *            The ID of the Customizable API Key for authentication, found at: https://support.eveonline.com/api
     *
     * @param string $vCode
     *            The user defined or CCP generated Verification Code for the Customizable API Key, found at https://support.eveonline.com/api
     *
     * @param integer $characterId
     *            The ID of the character for the requested data, from Character List. Only for /Char/ endpoints. Optional when the API Key is only valid for a single character.
     */
    public function __construct($keyId = null, $vCode = null, $characterId = 0)
    {
        if ($keyId == null || intval($keyId) == 0) {
            throw new \Exception("keyID can't be equals to zero or null.");
        }

        if (empty($vCode)) {
            throw new \Exception("vCode can't be empty");
        }

        $this->keyId = $keyId;
        $this->verificationCode = $vCode;
        $this->characterId = $characterId;
    }
}
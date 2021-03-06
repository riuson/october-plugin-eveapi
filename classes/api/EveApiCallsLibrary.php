<?php
namespace Riuson\EveApi\Classes\Api;

use Riuson\EveApi\Classes\Api\EveApiCallsLibraryItem;

/**
 * Calls library
 */
class EveApiCallsLibrary
{

    public static function server_serverStatus()
    {
        $result = new EveApiCallsLibraryItem("/server/ServerStatus.xml.aspx", 0, "Server Status", "Riuson\EveApi\Classes\Api\Server\ServerStatus");
        return $result;
    }

    public static function account_accountStatus()
    {
        $result = new EveApiCallsLibraryItem("/account/AccountStatus.xml.aspx", 33554432, "Account Status", "Riuson\EveApi\Classes\Api\Account\AccountStatus", array(
            "keyID",
            "vCode"
        ));
        return $result;
    }

    public static function account_characters()
    {
        $result = new EveApiCallsLibraryItem("/account/Characters.xml.aspx", 0, "List of Characters", "Riuson\EveApi\Classes\Api\StandardRowset", array(
            "keyID",
            "vCode"
        ));
        return $result;
    }

    public static function account_apiKeyInfo()
    {
        $result = new EveApiCallsLibraryItem("/account/APIKeyInfo.xml.aspx", 0, "Information about the API key and a list of the characters exposed by it", "Riuson\EveApi\Classes\Api\Account\APIKeyInfo", array(
            "keyID",
            "vCode"
        ));
        return $result;
    }

    public static function char_assetList()
    {
        $result = new EveApiCallsLibraryItem("/char/AssetList.xml.aspx", 0, "List of assets owned by character", "Riuson\EveApi\Classes\Api\StandardRowset", array(
            "keyID",
            "vCode",
            "characterID"
        ));
        return $result;
    }

    public static function char_characterSheet()
    {
        $result = new EveApiCallsLibraryItem("/char/CharacterSheet.xml.aspx", 0, "Character sheet data", "Riuson\EveApi\Classes\Api\Char\CharacterSheet", array(
            "keyID",
            "vCode",
            "characterID"
        ));
        return $result;
    }

    public static function char_skillTraining()
    {
        $result = new EveApiCallsLibraryItem("/char/SkillInTraining.xml.aspx", 0, "Current skill in training", "Riuson\EveApi\Classes\Api\Char\SkillTraining", array(
            "keyID",
            "vCode",
            "characterID"
        ));
        return $result;
    }

    public static function corp_memberTracking()
    {
        $result = new EveApiCallsLibraryItem("/corp/MemberTracking.xml.aspx", 0, "List of corporation members", "Riuson\EveApi\Classes\Api\StandardRowset", array(
            "keyID",
            "vCode"
        ));
        return $result;
    }

    public static function eve_characterInfo()
    {
        $result = new EveApiCallsLibraryItem("/eve/CharacterInfo.xml.aspx", 0, "Public and private character info", "Riuson\EveApi\Classes\Api\Eve\CharacterInfo", array(
            "characterID"
        ));
        return $result;
    }

    public static function eve_conquerableStationsList()
    {
        $result = new EveApiCallsLibraryItem("/eve/ConquerableStationList.xml.aspx", 0, "Conquerable Station List (Includes Outposts)", "Riuson\EveApi\Classes\Api\Eve\ConquerableStations");
        return $result;
    }
}

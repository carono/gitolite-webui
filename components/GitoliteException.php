<?php
/**
 * Created by PhpStorm.
 * User: Карно
 * Date: 14.05.2016
 * Time: 14:26
 */

namespace app\components;


class GitoliteException extends \Exception
{
    public static function throwUndefinedTeam($name)
    {
        throw new self("Team '$name' is undefined");
    }

    public static function throwInvalidSyntax($text)
    {
        throw new \Exception($text);
    }

    public static function throwWrongTeamType($team, $need)
    {
        throw new self("Team $team is wrong type, needed $need");
    }

    public static function throwInvalidRule($raw)
    {
        throw new self("Invalid rule definition: $raw");
    }

    public static function throwInvalidTeam($raw)
    {
        throw new self("Invalid team definition: $raw");
    }

    public static function throwInvalidRepo($raw)
    {
        throw new self("Invalid repo definition: $raw");
    }
}
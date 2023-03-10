<?php

namespace App\Doctrine;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Types;

/**
 * Doctrine mapeléshez használatos, az adatbázisbeli enum típusokat konvertája string primitív típusokká.
 */
abstract class CustomPlatform extends AbstractPlatform
{
    public function getDoctrineTypeMapping($dbType)
    {
        if ($dbType === 'enum') {
            return Types::STRING;
        }

        return parent::getDoctrineTypeMapping($dbType);
    }
}
?>
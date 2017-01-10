<?php

namespace App\Helpers;

/**
 * Here i add custom methods, that help to work with arrays.
 */
trait ArrayAdditional
{


    private function _anyInArray(array $container, array $checkedItems)
    {
        if (count(array_intersect($container, $checkedItems)) !== 0) {
            return true;
        }

        return false;

    }//end _anyInArray()


    private function _valueAtAnyKey(array $container, array $keysToTry)
    {
        foreach ($keysToTry as $keyName) {
            if (key_exists($keyName, $container) === true) {
                return $container[$keyName];
            }
        }

        return null;

    }//end _valueAtAnyKey()


}

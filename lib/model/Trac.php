<?php

require 'lib/model/om/BaseTrac.php';


/**
 * Skeleton subclass for representing a row from the 'trac' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 01/13/11 10:45:05
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class Trac extends BaseTrac {

    public function setInactiu()
    {
        $this->setActiu(false);            
    }

} // Trac

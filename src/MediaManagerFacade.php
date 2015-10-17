<?php
/**
 * Created by PhpStorm.
 * User: Tamir
 * Date: 9/30/2015
 * Time: 5:48 PM
 */

namespace tamirh67\MediaManager;

use Illuminate\Support\Facades\Facade;

class MediaManagerFacade extends Facade
{
    protected static function getFacadeAccessor() {
        return 'MediaManager';
    }
}
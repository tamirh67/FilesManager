<?php
/**
 * Created by PhpStorm.
 * User: Tamir
 * Date: 9/30/2015
 * Time: 5:48 PM
 */

namespace tamirh67\FilesManager;

use Illuminate\Support\Facades\Facade;

class FilesManagerFacade extends Facade
{
    protected static function getFacadeAccessor() {
        return 'FilesManager';
    }
}
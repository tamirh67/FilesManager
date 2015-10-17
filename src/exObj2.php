<?php

namespace tamirh67\FilesManager;
//namespace App;

use Illuminate\Database\Eloquent\Model;


class exObj2 extends Model
{
    protected $table = 'example_object2';

    /**
     * Get all of the staff member's photos.
     */
    public function mymedia()
    {
        return $this->morphMany('tamirh67\FilesManager\Media', 'mediaable');
    }

}

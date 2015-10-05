<?php

namespace tamirh67\MediaManager;
//namespace App;

use Illuminate\Database\Eloquent\Model;


//use tamirh67\MediaManager\models\Media;

class exObj1 extends Model
{
    protected $table    = 'example_object1';
    protected $fillable = ['name', 'description'];
    /**
     * Get all of the staff member's photos.
     */
    public function mymedia()
    {
        return $this->morphMany('tamirh67\MediaManager\Media', 'mediaable');
    }
}

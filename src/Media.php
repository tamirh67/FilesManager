<?php

namespace tamirh67\MediaManager;
//namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'media';

    public function mediaable()
    {
        return $this->morphTo();
    }
}

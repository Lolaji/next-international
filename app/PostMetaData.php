<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostMetaData extends Model {

    public function post () {
        return $this->belongsTo(Posts::class);
    }
    
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Services extends Model {

    protected $guarded = [];

    public function serviceMetaData () {
        return $this->hasMany(ServicesMetaData::class);
    }

    public function getByTitle ($title) {
        return $this->where('title', $title)->first();
    }
}

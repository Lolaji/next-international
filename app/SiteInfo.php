<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiteInfo extends Model {
    public function getByName($name) {
        return $this->where('name', $name)->first();
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model {

    protected $guarded = [];

    public function user () {
        return $this->belongsTo(User::class);
    }

    public function getByTitle ($title) {
        return $this->where('title', $title)->first();
    }

    public static function fetchLatestThree () {
        return self::latest()->limit(3)->get();
    }

    public static function search ($title=null, $category=null, $tag=null) {
        $where = [];
        if ($title)
            array_push ($where, ['title', 'like', "%$title%"]);

        if ($category)
            array_push ($where, ['category', '=', $category]);

        if ($tag)
            array_push ($where, ['tags', '=', $tag]);

        return self::where($where)->get();
    }

    public static function related ($id, $category, array $tags=[]) {
        return self::where('category', $category)->where('id', '!=', $id)->latest()->limit(3)->get();
    }
}

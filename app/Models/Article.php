<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'user_id', 'key', 'created_at',
    ];

    protected $dates = [
        'created_at',
    ];

    public $timestamps = false;

    public function users()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function table_of_contents()
    {
        return $this->belongsToMany('App\Models\TableOfContent');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag');
    }
}

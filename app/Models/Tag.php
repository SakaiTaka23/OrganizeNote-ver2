<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'user_id',
    ];

    public $timestamps = false;

    public function articles()
    {
        return $this->belongsToMany('Article');
    }

    public function users()
    {
        return $this->belongsTo('User');
    }
}

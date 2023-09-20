<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "description",
        "obtained",
        "image",
        "image_name",
        "labels"
    ];

    protected $casts = [
        'obtained' => 'datetime:Y-m-d',
    ];


    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function labels(){
        return $this->belongsToMany(Label::class);
    }
}

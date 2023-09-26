<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'sort'];


    public function cards()
    {
        return $this->hasMany(Card::class)->orderBy("sort");
    }
}

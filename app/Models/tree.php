<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tree extends Model
{
    use HasFactory;

    protected $table = 'tree';

    public function childs() {
        return $this->hasMany('App\Models\tree','parentId','id') ;
    }
}

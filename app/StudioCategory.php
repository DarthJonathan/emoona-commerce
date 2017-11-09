<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudioCategory extends Model
{
    protected $table = 'studio_category';

    public $timestamps = false;

    protected $fillable = [
    	'name', 'description' , 'template'
    ];

    public function StudioItem(){
        return $this->hasMany('App\StudioItem', 'id');
    }
}

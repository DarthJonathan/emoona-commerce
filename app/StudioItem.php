<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudioItem extends Model
{	
	protected $table = 'item_studio';

    protected $fillable = [
    	'category_id','title','content','files'
    ];

    function StudioCategory()
    {
    	return $this->belongsTo('App\StudioCategory','category_id');
    }

}

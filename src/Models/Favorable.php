<?php

namespace Hamedov\Favorites\Models;

use Illuminate\Database\Eloquent\Model;
use Hamedov\Favorites\Favorites;


class Favorable extends Model
{
    /**
     * No columns need to be guraded
     * @var array
     */
    protected $guarded = [
    	
    ];

    public function favorable()
    {
    	return $this->morphTo();
    }

    public function user()
    {
    	return $this->belongsTo(Favorites::userModel());
    }
}

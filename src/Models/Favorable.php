<?php

namespace Hamedov\Favorites\Models;

use Illuminate\Database\Eloquent\Model;
use Hamedov\Favorites\Favorites;


class Favorable extends Model
{
    protected $fillable = [
    	Favorites::userForeignKey(), 'favorable_id', 'favorable_type',
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

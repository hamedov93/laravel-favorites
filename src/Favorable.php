<?php

namespace Hamedov\Favorites;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Favorable extends Model
{
    /**
     * No columns need to be guraded
     * @var array
     */
    protected $guarded = [];

    /**
     * Favorable model relationship
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function favorable(): MorphTo
    {
    	return $this->morphTo();
    }

    /**
     * User relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
    	return $this->belongsTo(Favorites::userModel());
    }
}

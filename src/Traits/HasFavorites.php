<?php

namespace Hamedov\Favorites\Traits;

use Illuminate\Database\Eloquent\Model;
use Hamedov\Favorites\Models\Favorable;

/**
 * HasFavorites trait
 */
trait HasFavorites
{
	/**
	 * Get user favorites by model
	 * @param  string|null $type
	 * @return [type]       [description]
	 */
	public function favorites($type)
	{
		return $this->morphedByMany($type, 'favorable');
	}

	/**
	 * Get all related entries in pivot table
	 * @return [type] [description]
	 */
	public function favorables($type = null)
	{
		if ($type === null)
		{
			return $this->hasMany(Favorable::class);
		}
		else
		{
			return $this->hasMany(Favorable::class)->where('favorables.favorable_type', $type);
		}
	}

	public function favoriteIds($type = null)
	{
		return $this->favorables($type)->pluck('favorable_id');
	}

	public function addFavorite(Model $model)
	{
		return $this->favorables()->firstOrCreate([
			$this->getForeignKey() => $this->getKey(),
			'favorable_id' => $model->getKey(),
			'favorable_type' => $model->getMorphClass(),
		]);
	}

	public function removeFavorite(Model $model)
	{
		return $this->favorables()->where([
			'favorable_id' => $model->getKey(),
			'favorable_type' => $model->getMorphClass(),
		])->delete();
	}

	public function flushFavorites($type = null)
	{
		return $this->favorables($type)->delete();
	}

	public function scopeHasFavorite($query, Model $model)
	{
		return $query->whereHas('favorables', function($q) use ($model) {
			$q->where('favorables.favorable_id', $model->getKey());
			$q->where('favorables.favorable_type', $model->getMorphClass());
		});
	}

	public function scopeHasFavoriteOfType($query, $type)
	{
		return $query->whereHas('favorables', function($q) use ($type) {
			$q->where('favorables.favorable_type', $type);
		});
	}
}

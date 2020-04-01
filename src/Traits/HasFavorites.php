<?php

namespace Hamedov\Favorites\Traits;

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
	public function favorites($type = null)
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

	public function addFavorite(Model $model)
	{
		return $this->favorables()->create([
			$this->getForeignKey() => $this->{$this->getKeyName()},
			'favorable_id' => $model->id,
			'favorable_type' => $model->getMorphClass(),
		]);
	}

	public function removeFavorite(Model $model)
	{
		return $this->favorables()->where([
			'favorable_id' => $model->id,
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
			$q->where('favorables.favorable_id', $model->id);
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
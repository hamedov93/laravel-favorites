<?php

namespace Hamedov\Favorites;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphedByMany;
use Illuminate\Support\Collection;

/**
 * HasFavorites trait
 */
trait HasFavorites
{
	/**
	 * Get user favorites by model
	 * @param  string|null $type
	 * @return \Illuminate\Database\Eloquent\Relations\MorphedByMany
	 */
	public function favorites($type): MorphedByMany
	{
		return $this->morphedByMany($type, 'favorable');
	}

	/**
	 * Get all related entries in pivot table
	 * @param string|null $type Favorable model type
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function favorables($type = null): HasMany
	{
		if ($type === null) {
			return $this->hasMany(Favorable::class);
		} else {
			return $this->hasMany(Favorable::class)
				->where('favorables.favorable_type', $type);
		}
	}

	/**
	 * Get favorable model ids from pivot table by type or all.
	 * @param  string|null $type
	 * @return \Illuminate\Support\Collection
	 */
	public function favoriteIds($type = null): Collection
	{
		return $this->favorables($type)->pluck('favorable_id');
	}

	/**
	 * Add model to user favorites
	 * @param \Illuminate\Database\Eloquent\Model $model
	 * @return \Hamedov\Favorites\Favorable
	 */
	public function addFavorite(Model $model): Favorable
	{
		return $this->favorables()->firstOrCreate([
			$this->getForeignKey() => $this->getKey(),
			'favorable_id' => $model->getKey(),
			'favorable_type' => $model->getMorphClass(),
		]);
	}

	/**
	 * Remove model from favorites
	 * @param  \Illuminate\Database\Eloquent\Model $model
	 * @return void
	 */
	public function removeFavorite(Model $model): void
	{
		$this->favorables()->where([
			'favorable_id' => $model->getKey(),
			'favorable_type' => $model->getMorphClass(),
		])->delete();
	}

	/**
	 * Remove user favorites
	 * @param  string|null $type
	 * @return void
	 */
	public function flushFavorites($type = null)
	{
		$this->favorables($type)->delete();
	}

	/**
	 * Filter users who have specific model as favorite
	 * @param  \Illuminate\Database\Eloquent\Builder $query
	 * @param  \Illuminate\Database\Eloquent\Model  $model
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeHasFavorite(Builder $query, Model $model): Builder
	{
		return $query->whereHas('favorables', function($q) use ($model) {
			$q->where('favorables.favorable_id', $model->getKey());
			$q->where('favorables.favorable_type', $model->getMorphClass());
		});
	}

	/**
	 * Filter users who have any model specific type as favorite
	 * @param  \Illuminate\Database\Eloquent\Builder $query
	 * @param  string $type
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeHasFavoriteOfType(Builder $query, string $type): Builder
	{
		return $query->whereHas('favorables', function($q) use ($type) {
			$q->where('favorables.favorable_type', $type);
		});
	}
}

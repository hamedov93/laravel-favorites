# Laravel favorites
Manage user favorites in laravel application.

# Installation
```composer require hamedov/laravel-favorites```

# Publish config file
```php artisan vendor:publish --provider="Hamedov\Favorites\FavoritesServiceProvider" --tag="config"```

# Set user model in config file
- Make sure you do this before migrations
  ```
  return [
	  'user_model' => \App\User::class,
  ];
  ```

# Execute migrations
```php artisan migrate```

# Setup user model
- Add `Hamedov\Favorites\HasFavorites` trait to your user model
  ```
  class User extends Model {
    use HasFavorites;
  }
  ```

# Usage
- Add item to user favorites
  ```
  $book = Book::find(1);
  $user->addFavorite($book);
  
  $ad = Ad::find(1);
  $user->addFavorite($ad);
  ```

- Remove item from user favorites
  ```
  $book = Book::find(1);
  $user->removeFavorite($book);
  ```

- Get user favorites of specific type
  ```
  $favorites = $user->favorites('App\Book')->get();
  // Or
  $favorites = $user->favorites('App\Book')->paginate(10);
  ```

- Get user favorite ids of specific type
  ```
  // This will return a collection of book ids
  // Passing null as a parameter will return all ids
  $favorites = $user->favoriteIds('App\Book');
  ```

- Get use favorite ids with corresponding types, i.e, pivot table entries
  ```
  $favorables = $user->favorables()->get();
  // Or pass type as parameter to get only specific type
  $favorables = $user->favorables('App\Ad')->get();
  ```

- Remove all user favorites
  ```
  $user->flushFavorites();
  // Or
  $user->flushFavorites('App\Book');
  ```

# Available scopes
- `hasFavorite` Scope users who added specific model to favorites
  ```
  $book = Book::find(1);
  $users = App\User::hasFavorite($book)->get();
  ```

- `hasFavoriteOfType` Scope users who add any model of specific type to favorites
  ```
  $users = App\User::hasFavoriteOfType('App\Book')->get();
  ```

# License
Released under the Mit license, see [LICENSE](https://github.com/hamedov93/laravel-favorites/blob/master/LICENSE)

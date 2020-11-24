<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Hamedov\Favorites\Favorites;

class CreateFavorablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favorables', function (Blueprint $table) {
            $table->foreignId(Favorites::userForeignKey())
                ->constrained(Favorites::userTable(), Favorites::userInstance()->getKeyName())
                ->onDelete('cascade');
            $table->morphs('favorable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('favorables');
    }
}

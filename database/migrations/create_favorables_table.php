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
            $table->unsignedBigInteger(Favorites::userForeignKey());
            $table->morphs('favorable');

            $table->foreign(Favorites::userForeignKey())->references(Favorites::userInstance()->getKey())->on(Favorites::userTable())
                ->onDelete('cascade')->onUpdate('cascade');
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

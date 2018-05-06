<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index();
            $table->unsignedInteger('odlbook_id')->index();
            $table->string('title');
            $table->string('author');
            $table->string('picture')->nullable();
            $table->string('picture_thumb')->nullable();
            $table->text('sinopse')->nullable();
            $table->boolean('favorite')->default(0);
            $table->boolean('listed')->default(0);
            $table->string('status')->default('N/D'); // Possible status: N/D, reading, finished
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
        Schema::dropIfExists('books');
    }
}

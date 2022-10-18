<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
//    public $timestamps = false;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quack_id');
            $table->text('content');
            $table->text('image')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->string('tags')->nullable();
            $table->timestamps();
            
            $table->foreign('quack_id')->references('id')->on('quacks')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}

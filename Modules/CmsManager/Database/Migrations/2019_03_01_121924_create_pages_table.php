<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',150);
            $table->string('sub_title',150)->nullable();
            $table->string('slug',200)->unique();
            $table->text('short_description')->nullable();
            $table->text('description');
            $table->string('banner',250)->nullable();
            $table->string('meta_title',250);
            $table->string('meta_keyword',350);
            $table->text('meta_description');
            $table->boolean('status')->default(1)->comment("1=active, 0=in active");
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
        Schema::dropIfExists('pages');
    }
}

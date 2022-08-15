<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->integer('category_id')->unsigned();
            $table->string('title', 150);
            $table->string('slug', 150);
            $table->text('content')->nullable();
            $table->text('image')->nullable();
            $table->text('tags')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // create index id
            $table->index('id');
            $table->index('slug');
            $table->index('category_id');
            // create fulltext
            $table->fullText(['title', 'content', 'tags']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contents');
    }
}

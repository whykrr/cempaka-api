<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemplates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('templates', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->enum('type', ['root', 'parrent', 'child']);
            $table->integer('parent_id')->unsigned()->nullable();
            $table->boolean('is_repeatable')->default(false);
            $table->string('name', 150);
            $table->longText('template');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // index
            $table->index('id');
            $table->index('parent_id');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('templates');
    }
}

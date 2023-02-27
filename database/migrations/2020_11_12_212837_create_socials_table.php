<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('socials', function (Blueprint $table) {
            $table->id();
            $table->string('type', 10);
            $table->integer('user_id')->nullable();
            $table->string('social_name', 25);
            $table->string('icon', 25);
            $table->string('link');
            $table->string('background', 15)->default('#00aced');
            $table->string('text_color', 15)->default('#fff');
            $table->tinyInteger('position')->default(0);
            $table->tinyInteger('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('socials');
    }
}

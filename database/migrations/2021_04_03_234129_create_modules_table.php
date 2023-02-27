<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('module_name', 175);
            $table->string('slug', 175);
            $table->string('icon', 55)->default("fa fa-align-left");
            $table->string('route', 125)->nullable();
            $table->tinyInteger('is_view_vissible')->nullable()->default(1);
            $table->tinyInteger('is_add_vissible')->nullable()->default(1);
            $table->tinyInteger('is_edit_vissible')->nullable()->default(1);
            $table->tinyInteger('is_delete_vissible')->nullable()->default(1);
            $table->tinyInteger('is_hidden_sidebar')->nullable();
            $table->tinyInteger('is_hidden_role_permission')->nullable();
            $table->tinyInteger('position')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->integer('updated_by');
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
        Schema::dropIfExists('modules');
    }
}

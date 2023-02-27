<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('general_settings', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('logo')->default('logo.png');
        //     $table->string('invoice_logo')->default('invoice_logo.png');
        //     $table->string('favicon')->default('favicon.png');
        //     $table->string('site_name')->nullable();
        //     $table->string('site_owner')->nullable();
        //     $table->string('bg_color', 175)->nullable();
        //     $table->string('text_color', 175)->nullable();
        //     $table->string('phone', 150)->nullable();
        //     $table->string('email', 150)->nullable();
        //     $table->string('currency', 25)->default('USD');
        //     $table->string('currency_symble', 15)->default('$');
        //     $table->string('shipping_method', 25)->default('flat_shipping');
        //     $table->decimal('shipping_cost')->default('60');
        //     $table->decimal('shipping_calculate')->nullable();
        //     $table->string('shipping_time', 125)->nullable();
        //     $table->string('title')->nullable();
        //     $table->text('description')->nullable();
        //     $table->text('meta_keywords')->nullable();
        //     $table->string('meta_image')->nullable();
        //     $table->string('about')->nullable();
        //     $table->string('address')->nullable();
        //     $table->text('header')->nullable();
        //     $table->integer('header_no')->nullable();
        //     $table->string('header_bg_color', 175)->nullable();
        //     $table->string('header_text_color', 175)->nullable();
        //     $table->text('footer')->nullable();
        //     $table->integer('footer_no')->nullable();
        //     $table->string('footer_bg_color', 175)->nullable();
        //     $table->string('footer_text_color', 175)->nullable();
            
        //     $table->tinyInteger('registration')->nullable();
        //     $table->tinyInteger('email_verification')->nullable();
        //     $table->tinyInteger('sms_verification')->nullable();
        //     $table->tinyInteger('seller_sms_verification')->nullable();
        //     $table->tinyInteger('seller_email_verification')->nullable();
        //     $table->tinyInteger('email_notification')->nullable();
        //     $table->tinyInteger('sms_notification')->nullable();

        //     $table->tinyInteger('newsletters')->default(1);
        //     $table->text('google_analytics')->nullable();
        //     $table->text('google_adsense')->nullable();
        //     $table->tinyInteger('is_loader')->default(1);
        //     $table->string('date_format')->default('j M, Y');

        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('general_settings');
    }
}

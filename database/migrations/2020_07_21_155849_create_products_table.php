<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('vendor_id')->nullable();
            $table->string('title');
            $table->string('slug');
            $table->text('summery')->nullable();
            $table->longText('description');
            $table->integer('category_id');
            $table->integer('subcategory_id')->nullable();
            $table->integer('childcategory_id')->nullable();
            $table->integer('brand_id')->nullable();
            $table->char('feature_image', 225)->nullable();
            $table->decimal('purchase_price')->default(0);
            $table->decimal('selling_price')->default(0);
            $table->decimal('reseller_price')->default(0);
            $table->string('discount',5)->nullable();
            $table->string('discount_type',5)->nullable();
            $table->string('stock', 15)->nullable();
            $table->integer('total_stock')->default(0);
            $table->date('manufacture_date')->nullable();
            $table->date('expired_date')->nullable();
            $table->string('sku', 75)->nullable();
            $table->string('hsn')->nullable();
            $table->integer('views')->default(0);
            $table->tinyInteger('voucher')->nullable();
            $table->tinyInteger('featured')->nullable();
            $table->string('product_type', 15)->nullable();
            $table->string('file', 255)->nullable();
            $table->text('file_link')->nullable();
            $table->tinyInteger('video')->nullable();
            $table->integer('weight')->nullable();
            $table->integer('length')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->tinyInteger('cash_on_delivery')->nullable();
            $table->tinyInteger('free_shipping')->nullable();
            $table->integer('sales')->default(0);
            $table->double('avg_ratting')->default(0);
            $table->string('meta_title')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_image')->nullable();
            $table->integer('position')->nullable();
            $table->tinyInteger('approved')->default(0);
            $table->string('status', '10')->default('pending')->comment('pending,active,reject');
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('products');
    }
}

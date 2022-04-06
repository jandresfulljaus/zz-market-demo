<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products_products', function (Blueprint $table) {
            $table->id();
            $table->string('sku', 255)->unique();
            $table->string('name', 255);
            $table->string('description', 255)->nullable(true);
            $table->integer('stock');
            $table->string('start date', 255)->nullable(true);
            $table->string('end date', 255)->nullable(true);
            $table->boolean('published')->default(0);
            $table->string('currency', 3);
            $table->decimal('price', 10, 2);
            $table->decimal('aliquot', 3, 2);
            $table->string('weight', 255)->nullable(true);
            $table->string('heigth', 255)->nullable(true);
            $table->string('width', 255)->nullable(true);
            $table->string('depth', 255)->nullable(true);
            $table->boolean('active')->default(0);
            //table->marca
            //table->category
            //table->empresa_id
            //table->proveedor_id
            //table->parent_id
            //table->is_parent
            $table->date('date_register');
            $table->string('code_provider');
            $table->string('thumbnail', 255)->nullable(true);
            //$table->base64_decode('hash', 500)->nullable(true);
            //$table->base64_encode('hash_image', 500)->nullable(true);
            $table->boolean('available_to_update')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_products');
    }
}

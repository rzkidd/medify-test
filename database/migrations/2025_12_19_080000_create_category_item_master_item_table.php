<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('category_item_master_item', function (Blueprint $table) {
            $table->unsignedBigInteger('master_item_id');
            $table->unsignedBigInteger('category_item_id');

            $table->foreign('master_item_id')->references('id')->on('master_items')->onDelete('cascade');
            $table->foreign('category_item_id')->references('id')->on('category_items')->onDelete('cascade');

            $table->primary(['master_item_id', 'category_item_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('category_item_master_item');
    }
};

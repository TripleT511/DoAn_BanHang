<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thuoc_tinh_san_phams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('san_pham_id');
            $table->foreign('san_pham_id')->references('id')->on('san_phams')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('thuoc_tinh_id');
            $table->foreign('thuoc_tinh_id')->references('id')->on('thuoc_tinhs')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('thuoc_tinh_san_phams');
    }
};

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
        Schema::create('tuy_chon_bien_thes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bien_the_san_pham_id');
            $table->foreign('bien_the_san_pham_id')->references('id')->on('bien_the_san_phams')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('tuy_chon_thuoc_tinh_id');
            $table->foreign('tuy_chon_thuoc_tinh_id')->references('id')->on('tuy_chon_thuoc_tinhs')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('tuy_chon_bien_thes');
    }
};

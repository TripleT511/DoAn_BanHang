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
        Schema::create('tuy_chon_thuoc_tinhs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('thuoc_tinh_id');
            $table->foreign('thuoc_tinh_id')->references('id')->on('thuoc_tinhs')->onUpdate('cascade')->onDelete('cascade');
            $table->string('tieuDe');
            $table->string('mauSac');
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
        Schema::dropIfExists('tuy_chon_thuoc_tinhs');
    }
};

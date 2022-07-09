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
        Schema::create('chi_tiet_phieu_khos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('phieu_kho_id');
            $table->foreign('phieu_kho_id')->references('id')->on('phieu_khos')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('san_pham_id');
            $table->foreign('san_pham_id')->references('id')->on('san_phams')->onUpdate('cascade')->onDelete('cascade');
            $table->string('sku');
            $table->integer('soLuong');
            $table->double('gia');
            $table->double('tongTien');
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
        Schema::dropIfExists('chi_tiet_phieu_khos');
    }
};

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
        Schema::create('phieu_khos', function (Blueprint $table) {
            $table->id();
            $table->string('maDonHang');
            $table->unsignedBigInteger('nha_cung_cap_id');
            $table->foreign('nha_cung_cap_id')->references('id')->on('nha_cung_caps')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->dateTime('ngayTao');
            $table->string('ghiChu');
            $table->tinyInteger('loaiPhieu');
            $table->tinyInteger('trangThai');
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
        Schema::dropIfExists('phieu_khos');
    }
};

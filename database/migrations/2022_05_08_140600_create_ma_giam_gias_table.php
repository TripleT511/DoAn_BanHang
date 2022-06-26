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
        Schema::create('ma_giam_gias', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('tenMa');
            $table->string('hinhAnh');
            $table->string('moTa');
            $table->integer('soLuong')->default(1);
            $table->integer('loaiKhuyenMai')->default(0);
            $table->double('giaTriKhuyenMai');
            $table->double('mucGiamToiDa')->nullable();
            $table->dateTime('ngayBatDau');
            $table->dateTime('ngayKetThuc');
            $table->double('giaTriToiThieu')->nullable();
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
        Schema::dropIfExists('ma_giam_gias');
    }
};

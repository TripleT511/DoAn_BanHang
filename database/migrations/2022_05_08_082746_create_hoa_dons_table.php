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
        Schema::create('hoa_dons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nhan_vien_id')->nullable();
            $table->foreign('nhan_vien_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('khach_hang_id');
            $table->foreign('khach_hang_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('ma_giam_gia_id')->nullable();
            $table->foreign('ma_giam_gia_id')->references('id')->on('ma_giam_gias')->onUpdate('cascade')->onDelete('cascade');
            $table->string('hoTen');
            $table->string('diaChi');
            $table->string('email');
            $table->string('soDienThoai');
            $table->dateTime('ngayXuatHD');
            $table->double('tongTien');
            $table->double('giamGia')->default(0);
            $table->double('tongThanhTien')->default(0);
            $table->string('ghiChu')->nullable();
            $table->integer('trangThaiThanhToan')->default(0);
            $table->integer('trangThai')->default(0);
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
        Schema::dropIfExists('hoa_dons');
    }
};

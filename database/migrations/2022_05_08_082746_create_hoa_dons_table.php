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
            $table->unsignedBigInteger('nhan_vien_id');
            $table->foreign('nhan_vien_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade')->nullable();
            $table->unsignedBigInteger('khach_hang_id');
            $table->foreign('khach_hang_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('hoTen');
            $table->string('diaChi');
            $table->string('email');
            $table->string('soDienThoai');
            $table->dateTime('ngayXuatHD');
            $table->double('tongTien');
            $table->string('ghiChu');
            $table->integer('trangThai');
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

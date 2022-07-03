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
        Schema::create('san_phams', function (Blueprint $table) {
            $table->id();
            $table->string('sku');
            $table->unsignedBigInteger('danh_muc_id');
            $table->foreign('danh_muc_id')->references('id')->on('danh_mucs')->onUpdate('cascade')->onDelete('cascade');
            $table->string('tenSanPham')->unique();
            $table->text('moTa');
            $table->longText('noiDung');
            $table->integer('dacTrung')->nullable();
            $table->double('gia');
            $table->double('giaKhuyenMai')->nullable()->default(0);
            $table->double('giaNhap')->default(0);
            $table->string('slug')->unique();
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
        Schema::dropIfExists('san_phams');
    }
};

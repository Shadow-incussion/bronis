<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('stok', function (Blueprint $table) {
        $table->string('tipe')->after('jumlah'); // 'masuk' atau 'keluar'
    });
}

public function down()
{
    Schema::table('stok', function (Blueprint $table) {
        $table->dropColumn('tipe');
    });
}

};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifySalesColumnsNullable extends Migration
{
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->integer('diskon')->nullable()->change();
            $table->integer('ongkir')->nullable()->change();
            $table->integer('total_bayar')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->integer('diskon')->nullable(false)->change();
            $table->integer('ongkir')->nullable(false)->change();
            $table->integer('total_bayar')->nullable(false)->change();
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyDiskonNullableInSalesTable extends Migration
{
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->integer('diskon')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->integer('diskon')->nullable(false)->change();
        });
    }
}


<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropUniqueKeyResponsesVoucherUniqueToResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('responses', function (Blueprint $table) {
            //drop unique key name responses_voucher_unique
            $table->dropUnique('responses_voucher_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('responses', function (Blueprint $table) {
            //un drop unique key name responses_voucher_unique
            $table->unique(['voucher'], 'responses_voucher_unique');
        });
    }
}

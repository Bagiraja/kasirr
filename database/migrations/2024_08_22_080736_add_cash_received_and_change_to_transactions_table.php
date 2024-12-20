<?php

// database/migrations/xxxx_xx_xx_xxxxxx_add_cash_received_and_change_to_transactions_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCashReceivedAndChangeToTransactionsTable extends Migration
{
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->decimal('cash_received', 10, 2)->nullable()->after('total');
            $table->decimal('change', 10, 2)->nullable()->after('cash_received');
        });
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['cash_received', 'change']);
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->text('shipping_address')->after('notes')->nullable();
            $table->timestamp('confirmed_at')->after('shipping_address')->nullable();
            $table->timestamp('rejected_at')->after('confirmed_at')->nullable();
            $table->text('rejection_reason')->after('rejected_at')->nullable();
        });

        // Reset payment_method semua transaksi lama ke cod
        DB::table('transactions')->update(['payment_method' => 'cod']);
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['shipping_address', 'confirmed_at', 'rejected_at', 'rejection_reason']);
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            if (! Schema::hasColumn('transactions', 'product_id')) {
                $table->foreignId('product_id')->after('id')->constrained('products')->cascadeOnDelete();
            }
            if (! Schema::hasColumn('transactions', 'buyer_id')) {
                $table->foreignId('buyer_id')->after('product_id')->constrained('users')->cascadeOnDelete();
            }
            if (! Schema::hasColumn('transactions', 'seller_id')) {
                $table->foreignId('seller_id')->after('buyer_id')->constrained('users')->cascadeOnDelete();
            }
            if (! Schema::hasColumn('transactions', 'payment_method')) {
                $table->string('payment_method')->after('seller_id');
            }
            if (! Schema::hasColumn('transactions', 'amount')) {
                $table->decimal('amount', 12, 2)->after('payment_method');
            }
            if (! Schema::hasColumn('transactions', 'status')) {
                $table->string('status')->default('pending')->after('amount');
            }
            if (! Schema::hasColumn('transactions', 'notes')) {
                $table->text('notes')->nullable()->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            if (Schema::hasColumn('transactions', 'notes')) {
                $table->dropColumn('notes');
            }
            if (Schema::hasColumn('transactions', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('transactions', 'amount')) {
                $table->dropColumn('amount');
            }
            if (Schema::hasColumn('transactions', 'payment_method')) {
                $table->dropColumn('payment_method');
            }
            if (Schema::hasColumn('transactions', 'seller_id')) {
                $table->dropConstrainedForeignId('seller_id');
            }
            if (Schema::hasColumn('transactions', 'buyer_id')) {
                $table->dropConstrainedForeignId('buyer_id');
            }
            if (Schema::hasColumn('transactions', 'product_id')) {
                $table->dropConstrainedForeignId('product_id');
            }
        });
    }
};

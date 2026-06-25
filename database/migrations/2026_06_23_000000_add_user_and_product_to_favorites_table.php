<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('favorites', function (Blueprint $table) {
            if (! Schema::hasColumn('favorites', 'user_id')) {
                $table->foreignId('user_id')->after('id')->constrained()->cascadeOnDelete();
            }
            if (! Schema::hasColumn('favorites', 'product_id')) {
                $table->foreignId('product_id')->after('user_id')->constrained()->cascadeOnDelete();
            }
            $table->unique(['user_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('favorites', function (Blueprint $table) {
            if (Schema::hasColumn('favorites', 'user_id') && Schema::hasColumn('favorites', 'product_id')) {
                $table->dropUnique(['user_id', 'product_id']);
            }
            if (Schema::hasColumn('favorites', 'product_id')) {
                $table->dropConstrainedForeignId('product_id');
            }
            if (Schema::hasColumn('favorites', 'user_id')) {
                $table->dropConstrainedForeignId('user_id');
            }
        });
    }
};

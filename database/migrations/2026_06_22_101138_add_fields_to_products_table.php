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
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2)->default(0);
            $table->string('location')->nullable();
            $table->string('brand', 50)->nullable();
            $table->string('model', 100)->nullable();
            $table->string('condition', 20)->nullable();
            $table->string('payment_methods')->nullable();
            $table->boolean('is_sold')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn([
                'user_id',
                'title',
                'description',
                'price',
                'location',
                'brand',
                'model',
                'condition',
                'payment_methods',
                'is_sold',
            ]);
        });
    }
};

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
        Schema::table('chats', function (Blueprint $table) {
            if (!Schema::hasColumn('chats', 'product_id')) {
                $table->foreignId('product_id')->after('id')->constrained()->cascadeOnDelete();
            }
            if (!Schema::hasColumn('chats', 'buyer_id')) {
                $table->foreignId('buyer_id')->after('product_id')->constrained('users')->cascadeOnDelete();
            }
            if (!Schema::hasColumn('chats', 'seller_id')) {
                $table->foreignId('seller_id')->after('buyer_id')->constrained('users')->cascadeOnDelete();
            }
        });

        Schema::table('messages', function (Blueprint $table) {
            if (!Schema::hasColumn('messages', 'chat_id')) {
                $table->foreignId('chat_id')->after('id')->constrained()->cascadeOnDelete();
            }
            if (!Schema::hasColumn('messages', 'sender_id')) {
                $table->foreignId('sender_id')->after('chat_id')->constrained('users')->cascadeOnDelete();
            }
            if (!Schema::hasColumn('messages', 'message_text')) {
                $table->text('message_text')->after('sender_id');
            }
            if (!Schema::hasColumn('messages', 'read_at')) {
                $table->timestamp('read_at')->nullable()->after('message_text');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            if (Schema::hasColumn('messages', 'read_at')) {
                $table->dropColumn('read_at');
            }
            if (Schema::hasColumn('messages', 'message_text')) {
                $table->dropColumn('message_text');
            }
            if (Schema::hasColumn('messages', 'sender_id')) {
                $table->dropConstrainedForeignId('sender_id');
            }
            if (Schema::hasColumn('messages', 'chat_id')) {
                $table->dropConstrainedForeignId('chat_id');
            }
        });

        Schema::table('chats', function (Blueprint $table) {
            if (Schema::hasColumn('chats', 'seller_id')) {
                $table->dropConstrainedForeignId('seller_id');
            }
            if (Schema::hasColumn('chats', 'buyer_id')) {
                $table->dropConstrainedForeignId('buyer_id');
            }
            if (Schema::hasColumn('chats', 'product_id')) {
                $table->dropConstrainedForeignId('product_id');
            }
        });
    }
};

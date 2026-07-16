<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('merchant_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Data Diri Pemilik
            $table->string('owner_name');
            $table->string('owner_nik', 16);
            $table->string('owner_phone', 20);
            $table->string('owner_address');
            $table->string('owner_city');
            $table->string('owner_province');
            $table->date('owner_dob');
            $table->string('id_card_photo')->nullable(); // foto KTP

            // Data Toko
            $table->string('store_name');
            $table->string('store_category'); // jenis barang yang dijual
            $table->text('store_description');
            $table->string('store_address');
            $table->string('store_city');
            $table->string('store_province');
            $table->string('store_phone', 20);
            $table->string('store_email')->nullable();
            $table->string('store_logo')->nullable();

            // Data Legalitas
            $table->string('npwp', 20)->nullable();
            $table->string('npwp_photo')->nullable();    // foto NPWP
            $table->string('siup_nib')->nullable();      // SIUP / NIB
            $table->string('bank_name');
            $table->string('bank_account_number', 30);
            $table->string('bank_account_name');

            // Status review
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('merchant_applications');
    }
};

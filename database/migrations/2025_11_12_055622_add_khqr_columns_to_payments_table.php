<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('khqr_md5')->nullable()->after('provider_payment_id');
            $table->text('khqr_payload')->nullable()->after('khqr_md5');
            $table->timestamp('khqr_generated_at')->nullable()->after('khqr_payload');
            $table->timestamp('khqr_expires_at')->nullable()->after('khqr_generated_at');
            // keep paid_at which you already have
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['khqr_md5', 'khqr_payload', 'khqr_generated_at', 'khqr_expires_at']);
        });
    }
};

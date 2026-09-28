<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Check if table doesn't exist before creating
        if (!Schema::hasTable('newsletter_subscriptions')) {
            Schema::create('newsletter_subscriptions', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email');
                $table->string('ip_address')->nullable();
                $table->timestamp('subscribed_at')->useCurrent();
                $table->timestamp('unsubscribed_at')->nullable();
                $table->timestamps();
                
                // SQLite compatible index creation
                $table->unique('email');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('newsletter_subscriptions');
    }
};
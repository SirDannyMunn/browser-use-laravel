<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bu_sessions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('provider_session_id')->unique();
            $table->string('provider_profile_id')->nullable();
            $table->uuid('linkedin_account_id')->nullable()->index();
            $table->uuid('organization_id')->nullable()->index();
            $table->string('source')->default('automation');
            $table->string('status')->default('active')->index();
            $table->string('last_task_provider_id')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('last_activity_at')->nullable();
            $table->timestamp('stale_after_at')->nullable()->index();
            $table->timestamp('last_health_checked_at')->nullable();
            $table->timestamp('stopped_at')->nullable();
            $table->text('stop_reason')->nullable();
            $table->timestamp('restart_eligible_at')->nullable();
            $table->unsignedSmallInteger('restart_attempts')->default(0);
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index(['linkedin_account_id', 'status']);
            $table->index(['status', 'stale_after_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bu_sessions');
    }
};

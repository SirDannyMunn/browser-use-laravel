<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bu_tasks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('provider_task_id')->unique();
            $table->string('provider_session_id')->nullable()->index();
            $table->uuid('bu_session_id')->nullable()->index();
            $table->uuid('linkedin_account_id')->nullable()->index();
            $table->uuid('organization_id')->nullable()->index();
            $table->uuid('campaign_id')->nullable()->index();
            $table->uuid('campaign_contact_id')->nullable()->index();
            $table->uuid('step_id')->nullable()->index();
            $table->string('action_type')->nullable()->index();
            $table->string('status')->default('created')->index();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->timestamp('timeout_at')->nullable();
            $table->timestamp('last_polled_at')->nullable();
            $table->string('error_code')->nullable();
            $table->text('error_message')->nullable();
            $table->json('result_summary')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index(['provider_session_id', 'created_at']);
            $table->index(['linkedin_account_id', 'created_at']);
            $table->index(['status', 'timeout_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bu_tasks');
    }
};

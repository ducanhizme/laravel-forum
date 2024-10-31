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
        Schema::table('discussions', function (Blueprint $table) {
            $table->enum('status',\App\Enum\DiscussionStatus::toArray())->default(\App\Enum\DiscussionStatus::OPEN);
        });
    }

    public function down(): void
    {
        Schema::table('discussions', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};

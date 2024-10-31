<?php

use App\Enum\VotableType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('votable', function (Blueprint $table) {
            $table->id();
            $table->integer('votable_id');
            $table->string('votable_type');
            $table->foreignId('user_id')->constrained('users');
            $table->enum('type',VotableType::toArray())->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('votable');
    }
};

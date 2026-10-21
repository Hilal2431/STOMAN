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
        Schema::create('folders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('folders')->cascadeOnDelete();
            $table->string('name');
            $table->string('color')->default('primary');
            $table->boolean('is_starred')->default(false);
            $table->boolean('is_archived')->default(false);
            $table->boolean('is_trashed')->default(false);
            $table->timestamp('trashed_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'parent_id']);
            $table->index(['user_id', 'is_starred']);
            $table->index(['user_id', 'is_archived']);
            $table->index(['user_id', 'is_trashed']);
        });

        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('folder_id')->nullable()->constrained('folders')->cascadeOnDelete();
            $table->string('name');
            $table->string('path');
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('size')->default(0);
            $table->boolean('is_starred')->default(false);
            $table->boolean('is_archived')->default(false);
            $table->boolean('is_trashed')->default(false);
            $table->timestamp('trashed_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'folder_id']);
            $table->index(['user_id', 'is_starred']);
            $table->index(['user_id', 'is_archived']);
            $table->index(['user_id', 'is_trashed']);
        });

        Schema::create('shares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('folder_id')->nullable()->constrained('folders')->cascadeOnDelete();
            $table->foreignId('file_id')->nullable()->constrained('files')->cascadeOnDelete();
            $table->string('shared_with_email');
            $table->string('role')->default('viewer'); // viewer, editor
            $table->boolean('link_share')->default(false);
            $table->timestamps();

            $table->index(['user_id', 'shared_with_email']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shares');
        Schema::dropIfExists('files');
        Schema::dropIfExists('folders');
    }
};

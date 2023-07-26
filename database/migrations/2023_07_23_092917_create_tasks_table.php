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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("list_id");
            $table->string("title");
            $table->string("preview")->nullable();
            $table->boolean("isCompleted")->default("0");
            $table->timestamps();
            $table->softDeletes();

            $table->index('list_id', 'tasks_lists_idx');
            $table->foreign('list_id', 'tasks_lists_fk')->on('lists')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};

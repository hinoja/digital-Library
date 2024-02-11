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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string("title")->unique();
            $table->string("slug");
            $table->longText("description");
            $table->string("file");
            // $table->string("image")->nullable();
            $table->foreignId("user_id")->constrained();
            $table->string("extension")->nullable();
            $table->date("authors")->nullable();
            // $table->foreignId("category_id")->constrained();
            $table->enum('type', ['Projet de Memoire', 'Rapport de Stage'])->default('Projet de Memoire')->constrained();
            $table->enum('level', ['1', '2', '3', '4', '5', '>5'])->default('3')->constrained();
            $table->foreignId("option_id")->constrained();
            $table->boolean('is_visible')->default(true);
            $table->date("published_at")->nullable();
            $table->string("github_link")->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};

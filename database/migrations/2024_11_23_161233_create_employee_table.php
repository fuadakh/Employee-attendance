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
        Schema::create('employee', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('employee_id');
            $table->string('birth_city')->nullable();
            $table->date('birth')->nullable();
            $table->bigInteger('phone')->nullable();
            $table->string('gander')->nullable();
            $table->longtext('address')->nullable();
            $table->bigInteger('id_card_number')->nullable();
            $table->string('id_card_image')->nullable();
            $table->string('avatar')->nullable();
            $table->boolean('is_delete')->nullable();
            $table->timestamp('created_at');
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee');
    }
};

<?php

use App\Enums\MemberTypeEnum;
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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('id_number');
            $table->string('type')->default(MemberTypeEnum::Temporary);
            $table->string('phone');
            $table->foreignId('company_id')->constrained('companies')->nullable();
            $table->foreignId('department_id')->constrained('departments')->nullable();
            $table->foreignId('camp_id')->constrained('camps')->nullable();
            $table->foreignId('room_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};

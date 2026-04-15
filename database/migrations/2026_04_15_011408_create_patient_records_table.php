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
        Schema::create('patient_records', function (Blueprint $table) {
            $table->id();
            $table->string("code",255)->nullable();
            $table->string("name",255);
            $table->string("nik",255);
            $table->char("gender",1);
            $table->date("date_of_birth");
            $table->unsignedBigInteger("doctor_id");
            $table->date("examined_date");
            $table->decimal('height',16,4)->nullable();
            $table->decimal('weight',16,4)->nullable();
            $table->decimal('systole',16,4)->nullable();
            $table->decimal('diastole',16,4)->nullable();
            $table->decimal('heart_rate',16,4)->nullable();
            $table->decimal('respiration_rate',16,4)->nullable();
            $table->decimal('temperature',16,4)->nullable();
            $table->longText('note',255)->nullable();
            $table->string('attachment')->nullable();
            $table->tinyInteger("status")->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign("doctor_id")
                ->references("id")
                ->on("users")
                ->onDelete("cascade")
                ->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_records');
    }
};

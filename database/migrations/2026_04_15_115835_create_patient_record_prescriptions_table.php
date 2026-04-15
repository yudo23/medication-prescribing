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
        Schema::create('patient_record_prescriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("record_id");
            $table->string("medicine_id",255);
            $table->string("medicine_name",255);
            $table->decimal("price",16,4);
            $table->decimal("qty",16,4);
            $table->string("note",255)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign("record_id")
                ->references("id")
                ->on("patient_records")
                ->onDelete("cascade")
                ->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_record_prescriptions');
    }
};

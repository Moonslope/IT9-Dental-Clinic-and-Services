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
        Schema::table('prescriptions', function (Blueprint $table) {
            $table->unsignedBigInteger('patient_id')->after('treatment_id');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');

            $table->text('instructions')->after('medication');
            $table->dropColumn('dosage');
            $table->dropColumn('date_issued');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

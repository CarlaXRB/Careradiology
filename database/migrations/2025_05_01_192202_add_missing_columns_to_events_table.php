<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            if (!Schema::hasColumn('events', 'details')) {
                $table->string('details')->nullable();
            }
            if (!Schema::hasColumn('events', 'assigned_doctor')) {
                $table->unsignedBigInteger('assigned_doctor')->nullable();
                $table->foreign('assigned_doctor')->references('id')->on('users')->nullOnDelete();
            }
            if (!Schema::hasColumn('events', 'assigned_radiologist')) {
                $table->unsignedBigInteger('assigned_radiologist')->nullable();
                $table->foreign('assigned_radiologist')->references('id')->on('users')->nullOnDelete();
            }
            if (!Schema::hasColumn('events', 'patient_id')) {
                $table->unsignedBigInteger('patient_id')->nullable()->after('id');
                $table->foreign('patient_id')->references('id')->on('patients')->nullOnDelete();
            } 
        });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            //
        });
    }
};

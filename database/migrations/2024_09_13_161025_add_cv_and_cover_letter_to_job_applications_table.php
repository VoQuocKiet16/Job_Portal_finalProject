<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('job_applications', function (Blueprint $table) {
            $table->string('cv_file')->nullable(); 
            $table->text('cover_letter')->nullable(); 
            $table->unsignedBigInteger('resume_id')->nullable(); 
            $table->foreign('resume_id')->references('id')->on('resumes')->onDelete('set null');
        });
    }
    
    public function down()
    {
        Schema::table('job_applications', function (Blueprint $table) {
            $table->dropColumn('cv_file');
            $table->dropColumn('cover_letter');
            $table->dropForeign(['resume_id']);
            $table->dropColumn('resume_id'); 
        });
    }
};

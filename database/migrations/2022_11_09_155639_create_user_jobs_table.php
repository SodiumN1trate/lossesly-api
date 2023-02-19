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
        Schema::create('user_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('job_name');
            $table->text('job_description');
            $table->foreignId('user_id')->constrained();
            $table->foreignId('expert_id')->constrained('users');
            $table->foreignId('status_id')->constrained();
            $table->date('started');
            $table->decimal('price')->nullable();
            $table->date('end')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_jobs');
    }
};

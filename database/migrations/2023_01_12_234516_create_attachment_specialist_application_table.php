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
        Schema::create('attach_spec_application', function (Blueprint $table) {
            $table->id();
            $table->foreignId('specialist_application_id')->constrained('specialist_applications');
            $table->foreignId('attachment_id')->constrained('attachments');
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
        Schema::dropIfExists('attachment_specialist_application');
    }
};

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
        Schema::create('offiziere', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->comment('Name des Offiziers');
            $table->string('img_path')->comment('Der Pfad zur Datei, welche angezeigt werden soll');
            $table->string('posten')->comment('Der genaue Offiziersposten');
            $table->text('posten_text')->comment('Der Text der zu jedem Offizier angezeigt wird');
            $table->timestampTz('off_seid')->comment('Seit wann ist die Person Offizier?');
            $table->boolean('active')->default(false)->comment('Wird der Eintrag angezeigt, 0/false = Nein; 1/true = Ja');
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offiziere');
    }
};

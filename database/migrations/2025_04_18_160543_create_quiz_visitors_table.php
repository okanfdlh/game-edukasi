<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_create_quiz_visitors_table.php

public function up()
{
    Schema::create('quiz_visitors', function (Blueprint $table) {
        $table->id();
        $table->string('npm');
        $table->date('visit_date'); // untuk menyimpan tanggal kunjungan
        $table->timestamps();
    
        // // Menambahkan unique constraint pada kombinasi 'npm' dan 'visit_date'
        // $table->unique(['npm', 'visit_date']);
    });
    
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_visitors');
    }
};

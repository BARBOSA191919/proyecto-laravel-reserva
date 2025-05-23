<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('eventos', function (Blueprint $table) {
        $table->integer('precio')->nullable()->change(); // Cambia el tipo a integer
    });
}

    public function down()
{
    Schema::table('eventos', function (Blueprint $table) {
        $table->decimal('precio', 8, 2)->nullable()->change(); // Reverte el cambio (opcional)
    });
}
};

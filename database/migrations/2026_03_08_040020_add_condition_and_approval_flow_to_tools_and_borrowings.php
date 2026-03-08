<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tools', function (Blueprint $table) {
            $table->text('description')->nullable()->after('name');
            $table->string('initial_condition')->default('Baik')->after('stock');
        });

        // Updating enum for status in borrowings
        // In Laravel 11/MySQL, changing enum can be done via raw SQL or dropping/adding
        DB::statement("ALTER TABLE borrowings MODIFY COLUMN status ENUM('menunggu', 'dipinjam', 'menunggu_kembali', 'dikembalikan') DEFAULT 'menunggu'");

        Schema::table('returns', function (Blueprint $table) {
            $table->string('return_condition')->nullable()->after('fine');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tools', function (Blueprint $table) {
            $table->dropColumn(['description', 'initial_condition']);
        });

        DB::statement("ALTER TABLE borrowings MODIFY COLUMN status ENUM('menunggu', 'dipinjam', 'dikembalikan') DEFAULT 'menunggu'");

        Schema::table('returns', function (Blueprint $table) {
            $table->dropColumn('return_condition');
        });
    }
};

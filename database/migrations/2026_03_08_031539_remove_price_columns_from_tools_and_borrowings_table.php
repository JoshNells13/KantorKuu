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
        Schema::table('tools', function (Blueprint $table) {
            $table->dropColumn('price_per_day');
        });

        Schema::table('borrowings', function (Blueprint $table) {
            $table->dropColumn('total_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tools', function (Blueprint $table) {
            $table->decimal('price_per_day', 8, 2)->after('stock');
        });

        Schema::table('borrowings', function (Blueprint $table) {
            $table->decimal('total_price', 8, 2)->default(0)->after('qty');
        });
    }
};

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
        Schema::table('supply_in_barcodes', function (Blueprint $table) {
            $table->foreignId('product_id')->nullable()->after('supply_in_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('supply_in_barcodes', function (Blueprint $table) {
            //
        });
    }
};

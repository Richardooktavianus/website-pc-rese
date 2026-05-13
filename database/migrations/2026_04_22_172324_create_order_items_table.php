<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {

            // tambahkan jika belum ada
            if (!Schema::hasColumn('order_items', 'product_id')) {
                $table->unsignedBigInteger('product_id')->nullable();
            }

            if (!Schema::hasColumn('order_items', 'product_name')) {
                $table->string('product_name')->nullable();
            }

            if (!Schema::hasColumn('order_items', 'quantity')) {
                $table->integer('quantity')->default(1);
            }

            if (!Schema::hasColumn('order_items', 'price')) {
                $table->bigInteger('price')->default(0);
            }

        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {

            $table->dropColumn([
                'product_id',
                'product_name',
                'quantity',
                'price'
            ]);

        });
    }
};
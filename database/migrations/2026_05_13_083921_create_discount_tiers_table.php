<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('discount_tiers', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->integer('min_order');
            $table->integer('discount');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        DB::table('discount_tiers')->insert([
            [
                'label'       => 'Silver',
                'min_order'   => 15000000,
                'discount'    => 15,
                'description' => 'Belanja minimal Rp 15.000.000 hemat 15%',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'label'       => 'Gold',
                'min_order'   => 25000000,
                'discount'    => 25,
                'description' => 'Belanja minimal Rp 25.000.000 hemat 25%',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'label'       => 'Platinum',
                'min_order'   => 100000000,
                'discount'    => 50,
                'description' => 'Belanja minimal Rp 100.000.000 hemat 50%',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('discount_tiers');
    }
};
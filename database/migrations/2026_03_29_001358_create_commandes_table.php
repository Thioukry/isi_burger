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
        Schema::create('commandes', function (Blueprint $table) {

                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('statut')->default('en attente');

                $table->decimal('total', 10, 2)->default(0);

                $table->string('statut_paiement')->default('non_paye');
                $table->datetime('date_paiement')->nullable();
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};

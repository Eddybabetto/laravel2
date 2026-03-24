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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string("after_tax_total");
            $table->text("notes");
            /*
            P -> PENDING ordine aperto appena creato, non pagato, significa che qualcosa è andato storto
            PU -> PENDING-UNCOFIRMED ordine creato con successo, utente reindirizzato a stripe almeno una volta
            C -> CONFIRMED ordine pagato, confermato da stripe
            R -> REFUSED rifiutato da stripe
            D -> DELETED ordine scaduto o annullato, giacenza stornata
            */
            $table->string("status", 10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

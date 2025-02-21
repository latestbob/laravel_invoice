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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string("invoice_number");
            $table->string("customer_name");
            $table->date("due_date");
            $table->decimal('grand_total', 10, 2);
            $table->json('items'); //
            $table->enum('status', ['draft', 'sent', 'paid', 'canceled']);
            $table->string('uploadUrl')->nullable();


            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};

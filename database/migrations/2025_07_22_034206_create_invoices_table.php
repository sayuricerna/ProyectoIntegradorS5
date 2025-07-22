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
            $table->string('invoice_number')->unique();
            $table->date('issue_date');
            $table->date('due_date')->nullable();
            
            // Datos del cliente (relacionado con users y addresses)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('client_name');
            $table->string('client_email');
            $table->string('client_cedula');
            $table->string('client_phone');
            $table->text('client_address');
            $table->string('client_city');
            $table->string('client_province');
            $table->string('client_country');
            $table->string('client_zip');
            $table->string('client_reference')->nullable();

            $table->string('payment_method'); 
            $table->string('payment_status')->default('pending');
            
            $table->decimal('subtotal', 12, 2);
            $table->decimal('tax_amount', 12, 2);
            $table->decimal('discount_amount', 12, 2)->default(0);
            $table->decimal('shipping_amount', 12, 2)->default(0);
            $table->decimal('total_amount', 12, 2);
            
            $table->json('items');
            
            $table->string('pdf_path');
            
            $table->text('notes')->nullable();
            $table->text('terms')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice');
    }
};

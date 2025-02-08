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
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nome do item ou serviço
            $table->foreignId('supplier_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('priority_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('price', 10, 2); // Valor do orçamento
            $table->text('description')->nullable(); // Detalhes do orçamento
            $table->date('due_date')->nullable(); // Data prevista para compra/execução
            $table->enum('status', [
                'PENDING',
                'APPROVED',
                'DENIED',
                'RECEIVED',
                'CANCELED',
                'IN_PROGRESS',
                'COMPLETED'
            ])->default('PENDING');
            $table->integer('stalement')->default(1); // Parcelas
            $table->decimal('stalement_value', 10, 2)->default(0); // Valor das parcelas
            $table->date('stalement_start')->nullable(); // Data de início das parcelas
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};

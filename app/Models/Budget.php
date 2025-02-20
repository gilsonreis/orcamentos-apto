<?php

namespace App\Models;

use Database\Factories\BudgetFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Budget extends Model
{
    /** @use HasFactory<BudgetFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'supplier_id',
        'category_id',
        'priority_id',
        'price',
        'description',
        'due_date',
        'status',
        'stalement',
        'stalement_value',
        'stalement_start',
    ];

    public const STATUS_OPTIONS = [
        'PENDING'     => 'Pendente',
        'APPROVED'    => 'Aprovado',
        'DENIED'      => 'Negado',
        'RECEIVED'    => 'Recebido',
        'CANCELED'    => 'Cancelado',
        'IN_PROGRESS' => 'Em execução',
        'COMPLETED'   => 'Finalizado',
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function priority(): BelongsTo
    {
        return $this->belongsTo(Priority::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}

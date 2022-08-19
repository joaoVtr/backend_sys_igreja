<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'church_id',
        'name',
        'cpf',
        'birthday',
        'email',
        'cell_number',
        'street_name',
        'city',
        'state',
    ];

    /**
     * Get church of member
     */
    public function church(): BelongsTo
    {
        return $this->belongsTo(Church::class);
    }
}

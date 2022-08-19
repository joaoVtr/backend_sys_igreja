<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Church extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'website',
        'picture',
    ];

    /**
     * Get members for the church
     */

    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }
}

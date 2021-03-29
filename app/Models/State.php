<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class State extends Model
{
    use HasFactory;
    
    /**
     * Method country
     *
     * @return BelongsTo
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
    
    /**
     * Method cities
     *
     * @return HasMany
     */
    public function cities(): HasMany
    {
        return $this->hasMany(State::class);
    }
    
    /**
     * Method adresses
     *
     * @return HasMany
     */
    public function adresses(): HasMany
    {
        return $this->hasMany(State::class);
    }
}

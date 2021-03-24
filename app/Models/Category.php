<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'slug',
    ];
    
    /**
     * Method realStates
     *ff
     * @return BelongsToMany
     */
    public function realStates(): BelongsToMany
    {
        return $this->belongsToMany(RealState::class, 'real_state_categories');
    }
}

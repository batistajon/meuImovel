<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RealStatePhoto extends Model
{
    use HasFactory;
    
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'photo',
        'is_thumb',
    ];
    
    /**
     * Method realState
     *
     * @return BelongsTo
     */
    public function realState(): BelongsTo
    {
        return $this->belongsTo(RealState::class);
    }
}

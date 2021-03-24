<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RealState extends Model
{
    use HasFactory;
    
    /**
     * table
     *
     * @var string
     */
    protected $table = 'real_state';   

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'content',
        'price',
        'bathrooms',
        'bedrooms',
        'property_area',
        'total_property_area',
        'slug'
    ];
    
    /**
     * Method user
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Method categories
     *
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'real_state_categories');
    }

    public function photos(): HasMany
    {
        return $this->hasMany(RealStatePhoto::class);
    }
}

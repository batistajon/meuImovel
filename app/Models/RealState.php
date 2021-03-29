<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Routing\Router;

class RealState extends Model
{
    use HasFactory;
    
    /**
     * appends
     *
     * @var array
     */
    protected $appends = ['_links', 'thumb'];
    
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
    
    /**
     * Method address
     *
     * @return BelongsTo
     */
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function getLinksAttribute()
    {
        return [
            'href' => route('real_states.real-states.show', ['real_state' => $this->id]),
            'rel' => 'Real State'
        ];
    }

    public function getThumbAttribute()
    {
        $thumb = $this->photos()->where('is_thumb', true);

        if (!$thumb->count()) {
            
            return null;
        }

        return $thumb->first()->photo;
    }
}

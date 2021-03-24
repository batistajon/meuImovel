<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    use HasFactory;
    
    /**
     * table
     *
     * @var string
     */
    protected $table = 'user_profile';
    
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'about',
        'social_networks',
        'phone',
        'mobile_phone',
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
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Client extends Model
{
    use HasFactory;

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * The users that belong to the client.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * The values for user defined content.
     */
    public function content_fields(): HasMany
    {
        return $this->hasMany(ContentField::class);
    }

    /**
     * The form generated leads that belong to the client.
     */
    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class);
    }
}

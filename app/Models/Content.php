<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Content extends Model
{
    use HasFactory;

    public $table = 'content';


    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function content_values(): HasMany
    {
        return $this->hasMany(ContentValue::class);
    }


}

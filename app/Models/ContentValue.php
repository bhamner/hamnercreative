<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentValue extends Model
{

    public $table = 'content_field_values';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'client_content_field_id',
        'content_id',
        'value'
    ];
}

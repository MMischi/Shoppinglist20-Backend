<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Address extends Model
{
    protected $fillable = [
        'street',
        'house_number',
        'post_code',
        'place',
        'country'
    ];

    public function users() : HasMany {
        return $this->hasMany(User::Class);
    }
}

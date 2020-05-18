<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ShoppingList extends Model
{
    protected $fillable = [
        'title',
        'due_date',
        'price',
        'bill_url',
        'status',

        'creator_id',
        'volunteer_id'
    ];

    public function users() : BelongsToMany {
        return $this->belongsToMany(User::Class)->withTimestamps();
    }

    public function comments() : HasMany {
        return $this->hasMany(ListComment::Class);
    }

    public function list_items() : HasMany {
        return $this->hasMany(ListItem::Class);
    }

    public function creator() : BelongsTo {
        return $this->belongsTo(User::Class);
    }

    public function volunteer() : BelongsTo {
        return $this->belongsTo(User::Class);
    }
}

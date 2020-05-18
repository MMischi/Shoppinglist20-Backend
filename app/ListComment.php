<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ListComment extends Model
{
    protected $fillable = [
        'comment',
        'user_id',
        'list_id'
    ];

    public function user() : BelongsTo {
        return $this->belongsTo(User::Class);
    }

    public function shoppingList() : BelongsTo {
        return $this->belongsTo(ShoppingList::class);
    }
}

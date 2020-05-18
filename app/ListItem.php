<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ListItem extends Model
{
    protected $fillable = [
        'title',
        'amount',
        'extra_info',
        'max_price'
    ];

    public function shoppingList() : BelongsTo {
        return $this->belongsTo(ShoppingList::Class);
    }
}

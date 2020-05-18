<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use PhpParser\Comment;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;


    protected $fillable = [
        'firstName',
        'lastName',
        'email',
        'password',
        'flag',
        'address_id'
    ];

    public function shoppingLists() : BelongsToMany {
        return $this->belongsToMany(User::Class)->withTimestamps();
    }

    public function address() : BelongsTo {
        return $this->belongsTo(Address::Class);
    }

    public function comments() : HasMany {
        return $this->hasMany(Comment::Class);
    }

    public function creator() : HasMany {
        return $this->hasMany(ShoppingList::class);
    }

    public function volunteer() : HasMany {
        return $this->hasMany(ShoppingList::class);
    }

    # Authentication
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        # in this method could be more values, which could use in JWT
        return ['user' => ['id' => $this->id]];
    }

}

<?php

namespace App\Http\Controllers\Auth;

use App\Address;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiRegisterController extends Controller {

    use RegistersUsers;

    protected $redirectTo = '/lists';

    public function __construct() {
        $this->middleware('guest');
    }

    protected function validator(Request $request) {
        return Validator::make($request, [
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'flag' => 'required|string|max:255',
        ]);
    }

    protected function create(Request $request) {
        $address_id = '';

        # create address to address table
        if(isset($request['address_id']) && is_array($request['address_id'])) {
            foreach ($request['address_id'] as $address) {
                $a = Address::firstOrNew([
                    'street' => $address['street'],
                    'house_number' => $address['house_number'],
                    'post_code' => $address['post_code'],
                    'place' => $address['place'],
                    'country' => $address['country']
                ]);
                $a->save();
            }

            # searching for address id
            $address_search = Address::where('id', '=', $a['id'])
                ->first();
            $address_id = $address_search['id'];
        } else {
            $address_id = $request['address_id'];
        }

        # create user with fk address_id
        return User::create([
            'firstName' => $request['firstName'],
            'lastName' => $request['lastName'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'flag' => $request['flag'],
            'address_id' => $address_id
        ]);
    }
}
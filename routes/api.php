<?php

use Illuminate\Http\Request;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


# find by user id
Route::get('/{userId}/lists', 'ShoppingListController@showByUserId');

# find by volunteer id
# return all open lists an list of volunteer
Route::get('/getAllVolunteer/{volunteerId}', 'ShoppingListController@showListsVolunteer');

# find by id (detail-page)
Route::get('/lists/{listId}', 'ShoppingListController@showById');

# Auth
Route::group(['middleware' => ['api', 'cors']], function () {
    Route::post('auth/login', 'Auth\ApiAuthController@login');
    Route::post('auth/register', 'Auth\ApiRegisterController@create');
});

# user info
Route::get('/getUser/{userId}', 'ShoppingListController@getUserById');

# Methods need auth
Route::group(['middleware' => ['api','cors', 'auth.jwt']], function () {
    Route::post('/addList', 'ShoppingListController@save');
    Route::delete('/deleteList/{id}', 'ShoppingListController@delete');
    Route::put('/updateList/{id}', 'ShoppingListController@update');

    Route::post('auth/logout', 'Auth\ApiAuthController@logout');
});

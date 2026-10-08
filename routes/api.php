<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('sample/data',function(){ // read
    return "this is patient naniska";
});

Route::post('sample/data/registration',function(Request $request){ //create
    return $request->all();
});

Route::put('sample/data/{id}',function(Request $request){ //update
    return $request->all();
});

Route::delete('sample/delete/{patient_id}',function(){ //delete
    return "this is delete module";
});


//hindi existing dito sample/update/

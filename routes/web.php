<?php


use App\Http\Middleware\AdminCheck;
use illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
| admin_login
  */
      // Route::post('app/create_user',  'AdminController@adduser');
      // Route::get('app/get_users',  'AdminController@getusers');
      // Route::post('app/delete_user',  'AdminController@deleteuser');
      // Route::post('app/edit_user',  'AdminController@edituser');
      // Route::post('app/create_tag',  'AdminController@addTag');
      // Route::get('app/get_tags',  'AdminController@getTag');
      // Route::post('app/edit_tag',  'AdminController@editTag');
      // Route::post('app/delete_tag',  'AdminController@deleteTag');
      // Route::post('app/upload',  'AdminController@upload');
      // Route::post('app/delete_image',  'AdminController@delete_image');
      // Route::post('app/create_category',  'AdminController@addCategory');
      // Route::get('app/get_category',  'AdminController@getCategory');
      // Route::post('app/edit_category',  'AdminController@editCategory');
      // Route::post('app/delete_category',  'AdminController@deletecategory');
      //   Route::post('app/create_role',  'AdminController@addRole');
      //   Route::post('app/edit_role',  'AdminController@editrole');
      //   Route::get('app/get_roles',  'AdminController@getroles');
      //   Route::post('app/delete_role',  'AdminController@deleterole');
      //   Route::post('app/admin_login',  'AdminController@adminlogin');
  //  
 Route::prefix('app')->middleware(AdminCheck::class)->group(function(){
    Route::post('/create_user',  'AdminController@adduser');
        Route::get('/get_users',  'AdminController@getusers');
        Route::post('/delete_user',  'AdminController@deleteuser');
        Route::post('/edit_user',  'AdminController@edituser');
    Route::post('/create_tag',  'AdminController@addTag');
    Route::get('/get_tags',  'AdminController@getTag');
    Route::post('/edit_tag',  'AdminController@editTag');
    Route::post('/delete_tag',  'AdminController@deleteTag');
    Route::post('/upload',  'AdminController@upload');
    Route::post('/delete_image',  'AdminController@delete_image');
    Route::post('/create_category',  'AdminController@addCategory');
    Route::get('/get_category',  'AdminController@getCategory');
    Route::post('/edit_category',  'AdminController@editCategory');
    Route::post('/delete_category',  'AdminController@deletecategory');
 
    Route::post('/admin_login',  'AdminController@adminlogin');
    //roles routes   
   Route::post('/delete_user',  'AdminController@deleteuser');
    Route::post('/create_role',  'AdminController@addRole');
     Route::post('/edit_role',  'AdminController@editrole');
      Route::get('/get_roles',  'AdminController@getroles');
        Route::post('/delete_role',  'AdminController@deleterole');
      Route::post('/assign_roles',  'AdminController@assignrole');    
     
 });


//  Route::post('app/assign_roles',  'AdminController@assignrole');  
Route::get('/logout', function(){
    return view('welcome');
});

Route::get('/logout',  'AdminController@logout');
Route::get('/',  'AdminController@index');
Route::any('{slug}',  'AdminController@index');
// 


// Route::any('{slug}', function(){
//     return view('welcome');
// });
// // 
// Route::get('/', function(){
//     return view('welcome');
// });
<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | This file is where you may define all of the routes that are handled
  | by your application. Just tell Laravel the URIs it should respond
  | to using a Closure or controller method. Build something great!
  |
 */

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout');
Route::get('/home', 'HomeController@index');


Route::group(['middleware' => 'admin'], function() {
    Route::get('/admin', function() {
        return view('admin.index');
    });
    Route::resource('admin/users', 'AdminUsersController', ['names' => [
            'index' => 'admin.users.index',
            'create' => 'admin.users.create',
            'store' => 'admin.users.store',
            'edit' => 'admin.users.edit',
            'destroy' => 'admin.users.destroy',
            'show' => 'admin.users.show',
            'update' => 'admin.users.update',
    ]]);
    Route::resource('admin/posts', 'AdminPostsController', ['names' => [
            'index' => 'admin.posts.index',
            'create' => 'admin.posts.create',
            'store' => 'admin.posts.store',
            'edit' => 'admin.posts.edit',
            'destroy' => 'admin.posts.destroy',
            'show' => 'admin.posts.show',
            'update' => 'admin.posts.update',
    ]]);
    Route::resource('admin/categories', 'AdminCategoriesController', ['names' => [
            'index' => 'admin.categories.index',
            'create' => 'admin.categories.create',
            'store' => 'admin.categories.store',
            'edit' => 'admin.categories.edit',
            'destroy' => 'admin.categories.destroy',
            'show' => 'admin.categories.show',
            'update' => 'admin.categories.update',
    ]]);
    Route::resource('admin/medias', 'AdminMediasController', ['names' => [
            'index' => 'admin.medias.index',
            'create' => 'admin.medias.create',
            'store' => 'admin.medias.store',
            'edit' => 'admin.medias.edit',
            'destroy' => 'admin.medias.destroy',
            'show' => 'admin.medias.show',
            'update' => 'admin.medias.update',
    ]]);
    
    Route::delete('admin/delete/media', 'AdminMediasController@deleteMedia');
    
    //Route::get('admin/medias/upload',['as'=>'admin.medias.upload', 'uses'=>'AdminMediasController@store']);
    
    Route::resource('admin/comments', 'PostCommentsController', ['names' => [
            'index' => 'admin.comments.index',
            'create' => 'admin.comments.create',
            'store' => 'admin.comments.store',
            'edit' => 'admin.comments.edit',
            'destroy' => 'admin.comments.destroy',
            'show' => 'admin.comments.show',
            'update' => 'admin.comments.update',
    ]]);
    Route::resource('admin/comment/replies', 'CommentRepliesController', ['names' => [
            'index' => 'admin.comment.replies.index',
            'create' => 'admin.comment.replies.create',
            'store' => 'admin.comment.replies.store',
            'edit' => 'admin.comment.replies.edit',
            'destroy' => 'admin.comment.replies.destroy',
            'show' => 'admin.comment.replies.show',
            'update' => 'admin.comment.replies.update',
    ]]);
});

Route::get('post/{id}', ['as'=>'home.post', 'uses'=>'AdminPostsController@post']);
Route::get('postx/{id}', ['as'=>'home.postx', 'uses'=>'AdminPostsController@postx']);

Route::group(['middleware' => 'auth'], function() {
    Route::post('comment/reply','CommentRepliesController@createReply');
});

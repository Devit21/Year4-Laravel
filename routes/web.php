<?php

use App\Country;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Model\Post;
use App\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('user/{id}/role', function ($id) {
    $user = User::find($id);
    foreach($user->roles as $role){
        // echo $role->name . "<br>";
        echo "User Name: ". $user->name . " is " .$role->name . "<br>";
    }

});

//polymorphic relationship
Route::get('user/photos', function () {
    $user = User::find(1);
    foreach($user->photos as $photo){
        echo $photo->path;
    }


});

Route::get('user/country', function () {
    $country = Country::find(2);
    foreach($country->posts as $post){
        echo $post->title;
    }

});

Route::get('user/pivot', function () {
    $user = User::find(2);
    foreach($user->roles as $role){
        print $role->pivot->created_at ."<br>";
    }

});

Route::get('posts', function () {
    $user = User::find(1);
    foreach($user->posts as $post){
        echo $post->title .$post->content . "<br>";
    }

});

Route::get('post/{id}/user', function ($id) { //one to one reverse
    return Post::find($id)->user->name;
    // $u = Post::find($id)->user;
    // return "name ". $u->name;
});

Route::get('user/{id}/post', function ($id) {//one to one
    return User::find($id)->post->content;
}
);

//eloquent db
Route::get('readall', function () {
    $posts = Post::all();
    foreach($posts as $post){
        echo  "Read title ". $post->title. " content ". $post->content . "<br>";
    }

});
Route::get('find', function () {
    $post=Post::find(2);
    return "This is title: ". $post->title ." content". $post->content. "<br>";

});
Route::get('findwhere', function () {
    $posts=Post::where('id', 4)->orderBy('id', 'desc')->take(1)->get();
    foreach($posts as $post){
        echo $post->title. $post->content.$post->id;
    }

});
Route::get('findmore', function () {
    // $posts = Post::where('title', 'New Eloquent title insert 2')->firstOrFail();
    $posts = Post::findOrFail(6);
    return $posts;

});

Route::get('updateeloquent', function () {
    Post::where('id', 1)->where('title','This is updated first title')
    ->update(['content'=>'This is update 1',
    'title'=> 'the create mass assigment 1']);

});

Route::get('deleteeloquent', function () {
    $post=Post::find(7);
    $post->delete();

});

Route::get('destroyeloquent', function () {
    Post::destroy([2, 4]);
    print 'destroy';

});

Route::get('softdelete', function(){
    Post::find(10)->delete();

});

Route::get('readsoftdelete', function () {
    // $posts = Post::onlyTrashed()->get();
    $posts = Post::withTrashed()->where('id', 6)->get();
    foreach($posts as $post){
        echo "Read title: ". $post->title. " content:".$post->content ."deleted at: ".$post->deleted_at;
    }

});

Route::get('restore', function () {
    $posts = Post::withTrashed()->where('id', 10)->restore();
    // $posts = Post::withTrashed()->restore();

});

Route::get('forcedelete', function () {
    Post::withTrashed()->where('id', 9)->forceDelete();

});

Route::get('readeloquent', function () {
    $posts=Post::all();
    foreach($posts as $post){
        echo $post->title. " ". $post->content . "</br>";
    }
});

Route::get('createmass', function () {
    Post::create(['title'=>'this is mass assignment','content'=>'this is content']);

});

Route::get('eloquent-update', function () {
    $post = Post :: find(1);
    $post->title = 'This is updated first title';
    $post->content = 'This is updated content';
    $post->save();
    echo 'Updated';

});

Route::get('eloquent-insert', function () {
    $post = new Post;
    $post->title = 'This is the  insert of eloquent';
    $post->content = 'This is the second content';
    $post->save();

});

//raw db queries


Route::get('delete', function () {
    $u = DB::delete('delete from users where id = ?', [4]);
    return "delete user" .$u;

});

Route::get('update', function () {
    DB::update('update users set name = "devith" where id = ?', [1]);
    echo 'updated';

});


Route::get('insert', function () {           //annonymous function = function that doesn't have name
    DB::insert('insert into users (name, email, password) values (?, ?, ?)', ['Dara','dara@gmail.com', bcrypt(123456789)]);
    echo "Inserted";

});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/selectdb', 'HomeController@selectDB');
Route::get('/insertdb', 'HomeController@insertDB');
Route::get('/inserteloquent', 'HomeController@inserteloquent');

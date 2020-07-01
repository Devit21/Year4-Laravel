<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Foreach_;
use App\Model\Post;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // return view('home');

        $results = DB::select('select * from users where id = ?', [1]);
        // return $results;
        foreach($results as $result){
            echo $result->name ."<br/> ". $result->email;
        }
    }

    public function selectDB()
    {
        // return view('home');

        $results = DB::select('select * from users');
        // return $results;
        foreach($results as $result){
            echo $result->name ."<br/> ". $result->email;
        }
    }

    public function insertDB(){
        $results = DB::insert('insert into users (name, email, password) values (?, ?, ?)', ['koro','koro@gmail.com', bcrypt(123456789)]);
        echo "Inserted";
    }

    public function inserteloquent(){
        $post = new Post;
        $post->title = 'This is the third eloquent';
        $post->content = 'This is the third content';
        $post->save();
    }
}

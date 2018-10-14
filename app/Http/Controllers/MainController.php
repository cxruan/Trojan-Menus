<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use View;
use Auth;

class Meals
{     
    public $name;
    public $types;
    public $date;
    public $location;
    public $time;
      
    // Constructor is being implemented. 
    public function __construct($name,$types,$date,$location,$time) 
    { 
        $this->name = $name; 
        $this->types = $types;
        $this->date = $date;
        $this->location = $location;
        $this->time = $time;
    } 
} 

class MainController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    // public function __construct()
    // {
        
        

    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   

        return view('index');
    }



    public function json_test(Request $request)
    {   
        $target = strtolower($request->input('search'));
        $json_string = file_get_contents('../content.json');
        $data = json_decode( preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $json_string), true );
        $arr=array();
        foreach ($data['10-13'][0]['breakfast'] as $key => $value) {
            if(strpos(strtolower($value["name"]) , $target)===0 || strpos(strtolower($value["name"]), $target)){
                $obj = new Meals($value["name"],$value["type"],$data['10-13'][0]["date"],$data['10-13'][0]["dining_hall"],"breakfast");
                array_push($arr,$obj);
            }
        }
        foreach ($data['10-13'][0]['brunch'] as $key => $value) {
            if(strpos(strtolower($value["name"]) , $target)===0 || strpos(strtolower($value["name"]), $target)){
                $obj = new Meals($value["name"],$value["type"],$data['10-13'][0]["date"],$data['10-13'][0]["dining_hall"],"breakfast");
                array_push($arr,$obj);
            }
        }
        return view('index', ['data' => $arr]);
    }


}

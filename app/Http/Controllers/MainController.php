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
        $day1 = date('Y-m-d');
        $day2 = date('Y-m-d',strtotime('+1 day'));
        $day3 = date('Y-m-d',strtotime('+2 day'));
        $daylist = array($day1,$day2,$day3);

        // Search the entire json for the target food within three days
        for ($i=0; $i < 3; $i++) { 
            foreach ($data[$daylist[$i]][0]['breakfast'] as $key => $value) {
                if(strpos(strtolower($value["name"]) , $target)===0 || strpos(strtolower($value["name"]), $target)){
                    $obj = new Meals($value["name"],$value["type"],$data[$daylist[$i]][0]["date"],$data[$daylist[$i]][0]["dining_hall"],"breakfast");
                    array_push($arr,$obj);
                }
            }
            foreach ($data[$daylist[$i]][0]['brunch'] as $key => $value) {
                if(strpos(strtolower($value["name"]) , $target)===0 || strpos(strtolower($value["name"]), $target)){
                    $obj = new Meals($value["name"],$value["type"],$data[$daylist[$i]][0]["date"],$data[$daylist[$i]][0]["dining_hall"],"brunch");
                    array_push($arr,$obj);
                }
            }
            foreach ($data[$daylist[$i]][0]['lunch'] as $key => $value) {
                if(strpos(strtolower($value["name"]) , $target)===0 || strpos(strtolower($value["name"]), $target)){
                    $obj = new Meals($value["name"],$value["type"],$data[$daylist[$i]][0]["date"],$data[$daylist[$i]][0]["dining_hall"],"lunch");
                    array_push($arr,$obj);
                }
            }
            foreach ($data[$daylist[$i]][0]['dinner'] as $key => $value) {
                if(strpos(strtolower($value["name"]) , $target)===0 || strpos(strtolower($value["name"]), $target)){
                    $obj = new Meals($value["name"],$value["type"],$data[$daylist[$i]][0]["date"],$data[$daylist[$i]][0]["dining_hall"],"dinner");
                    array_push($arr,$obj);
                }
            }
        }

        return view('index', ['data' => $arr]);
    }

    public function test(){
        $today = date('d')+1;
        echo $today;
    }

}

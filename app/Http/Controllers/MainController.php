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

    public function json_search_by_name(Request $request)
    {   
        $target = strtolower($request->input('search'));
        $json_string = file_get_contents('../contents.json');
        $data = json_decode( preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $json_string), true );
        $arr=array();
        $day1 = date('Y-m-d');
        $day2 = date('Y-m-d',strtotime('+1 day'));
        $day3 = date('Y-m-d',strtotime('+2 day'));
        $day4 = date('Y-m-d',strtotime('+3 day'));
        $day5 = date('Y-m-d',strtotime('+4 day'));
        $day6 = date('Y-m-d',strtotime('+5 day'));
        $day7 = date('Y-m-d',strtotime('+6 day'));
        $daylist = array($day1,$day2,$day3,$day4,$day5,$day6,$day7);
        // $arrr = array();
        // Search the entire json for the target food within three days
        for ($i=0; $i < 7; $i++) { 
            for ($j=0; $j < 3; $j++) { 
                if (isset($data[$daylist[$i]][$j])) {
                    foreach ($data[$daylist[$i]][$j]['Breakfast'] as $key => $value) {
                        if(strpos(strtolower(preg_replace('/\(.*?\)/', '', $value["name"])) , $target)===0 || strpos(strtolower(preg_replace('/\(.*?\)/', '', $value["name"])), $target)){
                            $obj = new Meals($value["name"],$value["type"],$data[$daylist[$i]][$j]["date"],$data[$daylist[$i]][$j]["dining hall"],"Breakfast");
                            array_push($arr,$obj);
                        }
                    }
                    foreach ($data[$daylist[$i]][$j]['Brunch'] as $key => $value) {
                        if(strpos(strtolower(preg_replace('/\(.*?\)/', '', $value["name"])) , $target)===0 || strpos(strtolower(preg_replace('/\(.*?\)/', '', $value["name"])), $target)){
                            $obj = new Meals($value["name"],$value["type"],$data[$daylist[$i]][$j]["date"],$data[$daylist[$i]][$j]["dining hall"],"Brunch");
                            array_push($arr,$obj);
                        }
                    }
                    foreach ($data[$daylist[$i]][$j]['Lunch'] as $key => $value) {
                        if(strpos(strtolower(preg_replace('/\(.*?\)/', '', $value["name"])) , $target)===0 || strpos(strtolower(preg_replace('/\(.*?\)/', '', $value["name"])), $target)){
                            $obj = new Meals($value["name"],$value["type"],$data[$daylist[$i]][$j]["date"],$data[$daylist[$i]][$j]["dining hall"],"Lunch");
                            array_push($arr,$obj);
                        }
                    }
                    foreach ($data[$daylist[$i]][$j]['Dinner'] as $key => $value) {
                        if(strpos(strtolower(preg_replace('/\(.*?\)/', '', $value["name"])) , $target)===0 || strpos(strtolower(preg_replace('/\(.*?\)/', '', $value["name"])), $target)){
                            $obj = new Meals($value["name"],$value["type"],$data[$daylist[$i]][$j]["date"],$data[$daylist[$i]][$j]["dining hall"],"Dinner");
                            array_push($arr,$obj);
                        }
                    }
                }
            }
        }

        return view('index', ['data1' => $arr]);
    }

    public function json_search_by_tags(Request $request) {
            $json_string = file_get_contents('../contents.json');
            $data = json_decode( preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $json_string), true );
            $arr=array();
            if ($request->input('days')==1) {
                $days = date('Y-m-d');
            }elseif ($request->input('days')==2) {
                $days = date('Y-m-d',strtotime('+1 day'));
            }else{
                $days = date('Y-m-d',strtotime('+2 day'));
            }
            $time = $request->input('time');
            $halls = $request->input('diningHalls');
            if (isset($data[$days][$halls][$time])) {
                foreach ($data[$days][$halls][$time] as $key => $value) {
                    $obj = new Meals($value["name"],$value["type"],$data[$days][$halls]["date"],$data[$days][$halls]["dining hall"],$time);
                    array_push($arr,$obj);
                }
            }
            return view('index', ['data2' => $arr]);
    }

    public function test(){
        $cars = array
(
    array("Volvo",100,96),
    array("BMW",60,59),
    array("Toyota",110,100)
);
echo isset($cars[3][1]);
    }
}
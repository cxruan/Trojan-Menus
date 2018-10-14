@extends('layouts.index')

@section('content')

    <div id="content">
        
        <main>
        <input id="tab1" type="radio" name="tabs" <?php if (!isset($data2)) echo "checked";?>>
        <label for="tab1">Search by Name</label>
          
        <input id="tab2" type="radio" name="tabs"<?php if (isset($data2)) echo "checked";?> >
        <label for="tab2">Search by Tags</label>
          
        <section id="content1">
                <div class="row">
                  <div class="col-md-2"></div>
                  <div class="col-md-8">
                    <form action="{{ route('search_by_name') }}" method="post" class="navbar-form navbar-left" role="search" style="width: 100%">
                      {{ csrf_field() }}
                    <div class="form-group" style="width: 70%">
                      <input name="search" type="text" class="form-control" placeholder="Search" style="width: 100%">
                    </div>
                    <button type="submit" class="btn btn-default">Go</button>
                    </form>
                  </div>
                  <div class="col-md-2"></div>
                </div>
                <div class="row">
                  <div class="col-md-2" style="text-align: right;font-size: 14px;">ALLERGEN LEGEND:</div>
                  <div class="col-md-10">
                      <span class="allergen-container"><i class='fa fa-circle fa-allergen allergen-dairy'></i>Dairy</span>
                      <span class="allergen-container"><i class='fa fa-circle fa-allergen allergen-eggs'></i>Eggs</span>
                      <span class="allergen-container"><i class='fa fa-circle fa-allergen allergen-fish'></i>Fish</span>
                      <span class="allergen-container"><i class='fa fa-circle fa-allergen allergen-food-not-analyzed-for-allergens'></i>Food Not Analyzed for Allergens</span>
                      <span class="allergen-container"><i class='fa fa-circle fa-allergen allergen-peanuts'></i>Peanuts</span>
                      <span class="allergen-container"><i class='fa fa-circle fa-allergen allergen-pork'></i>Pork</span>
                  </div>
                </div>
                <div class="row" style="padding-bottom:25px;">
                  <div class="col-md-2"></div>
                  <div class="col-md-10">
                      <span class="allergen-container"><i class='fa fa-circle fa-allergen allergen-sesame'></i>Sesame</span>
                      <span class="allergen-container"><i class='fa fa-circle fa-allergen allergen-shellfish'></i>Shellfish</span>
                      <span class="allergen-container"><i class='fa fa-circle fa-allergen allergen-soy'></i>Soy</span>
                      <span class="allergen-container"><i class='fa fa-circle fa-allergen allergen-tree-nuts'></i>Tree Nuts</span>
                      <span class="allergen-container"><i class='fa fa-circle fa-allergen allergen-vegan'></i>Vegan</span>
                      <span class="allergen-container"><i class='fa fa-circle fa-allergen allergen-vegetarian'></i>Vegetarian</span>
                      <span class="allergen-container"><i class='fa fa-circle fa-allergen allergen-gluten'></i>Wheat / Gluten</span>
                  </div>
                </div>
                <?php
                // Convert date into days of week
                function wk($date1) {
                $datearr = explode("-",$date1);    
                $year = $datearr[0];
                $month = sprintf('%02d',$datearr[1]);  
                $day = sprintf('%02d',$datearr[2]);
                $hour = $minute = $second = 0;
                $dayofweek = mktime($hour,$minute,$second,$month,$day,$year);
                $shuchu = date("w",$dayofweek);
                $weekarray=array("Sun","Mon","Tue","Wed","Thu","Fri","Sat"); 
                return $weekarray[$shuchu];
              }

                function parse_types($types) {
                  $type = "";
                  foreach ($types as $key => $value) {
                    if ($value=="Dairy") {
                      $type = $type."<i class='fa fa-circle fa-allergen allergen-dairy'></i>";
                    }
                    if ($value=="Eggs") {
                      $type = $type."<i class='fa fa-circle fa-allergen allergen-eggs'></i>";
                    }
                    if ($value=="Fish") {
                      $type = $type."<i class='fa fa-circle fa-allergen allergen-fish'></i>";
                    }   
                    if ($value=="Food Not Analyzed for Allergens") {
                      $type = $type."<i class='fa fa-circle fa-allergen allergen-food-not-analyzed-for-allergens'></i>";
                    } 
                    if ($value=="Peanuts") {
                      $type = $type."<i class='fa fa-circle fa-allergen allergen-peanuts'></i>";
                    }
                    if ($value=="Pork") {
                      $type = $type."<i class='fa fa-circle fa-allergen allergen-pork'></i>";
                    }
                    if ($value=="Sesame") {
                      $type = $type."<i class='fa fa-circle fa-allergen allergen-sesame'></i>";
                    }
                    if ($value=="Shellfish") {
                      $type = $type."<i class='fa fa-circle fa-allergen allergen-shellfish'></i>";
                    }
                    if ($value=="Soy") {
                      $type = $type."<i class='fa fa-circle fa-allergen allergen-soy'></i>";
                    }
                    if ($value=="Tree Nuts") {
                      $type = $type."<i class='fa fa-circle fa-allergen allergen-tree-nuts'></i>";
                    }
                    if ($value=="Vegan") {
                      $type = $type."<i class='fa fa-circle fa-allergen allergen-vegan'></i>";
                    }
                    if ($value=="Vegetarian") {
                      $type = $type."<i class='fa fa-circle fa-allergen allergen-vegetarian'></i>";
                    }
                    if ($value=="Wheat / Gluten") {
                      $type = $type."<i class='fa fa-circle fa-allergen allergen-gluten'></i>";
                    }              
                  }                
                  return $type;
                }

                if (isset($data1)) {
                echo
                "<ul id='accordion' class='accordion'>
                <li class='default open'>
                    <div class='link'><i class='fa fa-search'></i>Search results</div>
                    <ul class='submenu'>";

                          foreach ($data1 as $key => $value) {
                            $date = "<span class='col-md-2'>".$value->date." ".wk($value->date)."</span>";
                            $time = "<span class='col-md-2'>".$value->time."</span>";
                            $location = "<span class='col-md-3'>".$value->location."</span>";
                            $types = parse_types($value->types);
                            $name = "<span class='col-md-5'>".$value->name.$types."</span>";
                            echo "<li>".preg_replace('/\(.*?\)/', '', $name).$date.$time.$location."</li>";
                          }

                echo
                        "
                    </ul>
                </li>
            </ul>";
                }
            ?>

        </section>
   
    
        <section id="content2">
                <div class="row" style="padding: 15px">
                  <div class="col-md-2"></div>
                  <div class="col-md-8">
                    <form class="form-horizontal" method="POST" action="{{ route('search_by_tags') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <div class="row">
                                <select class="form-control" name="diningHalls" style="width: 35%">
                                  <option label="USC VILLAGE DINING HALL">0</option>                            
                                  <option label="PARKSIDE RESTAURANT & GRILL">1</option>
                                  <option label="EVERYBODY'S KITCHEN">2</option>
                                </select>  

                                <select class="form-control" name="time" style="width: 15%">                            
                                  <option label="Breakfast">Breakfast</option>
                                  <option label="Brunch">Brunch</option>
                                  <option label="Lunch">Lunch</option>
                                  <option label="Dinner">Dinner</option>
                                </select>                                                

                                <select class="form-control" name="days" style="width: 15%">                            
                                  <option label="Today">1</option>
                                  <option label="Tomorrow">2</option>
                                  <option label="Day after Tomorrow">3</option>
                                </select> 

                                <button type="submit" class="btn btn-default" style="width: 6%">
                                    Go
                                </button>
                            </div>              
                        </div>
                    </form>
                  </div>
                  <div class="col-md-2"></div>
                </div>
                <div class="row">
                  <div class="col-md-2" style="text-align: right;font-size: 14px;">ALLERGEN LEGEND:</div>
                  <div class="col-md-10">
                      <span class="allergen-container"><i class='fa fa-circle fa-allergen allergen-dairy'></i>Dairy</span>
                      <span class="allergen-container"><i class='fa fa-circle fa-allergen allergen-eggs'></i>Eggs</span>
                      <span class="allergen-container"><i class='fa fa-circle fa-allergen allergen-fish'></i>Fish</span>
                      <span class="allergen-container"><i class='fa fa-circle fa-allergen allergen-food-not-analyzed-for-allergens'></i>Food Not Analyzed for Allergens</span>
                      <span class="allergen-container"><i class='fa fa-circle fa-allergen allergen-peanuts'></i>Peanuts</span>
                      <span class="allergen-container"><i class='fa fa-circle fa-allergen allergen-pork'></i>Pork</span>
                  </div>
                </div>
                <div class="row" style="padding-bottom:25px;">
                  <div class="col-md-2"></div>
                  <div class="col-md-10">
                      <span class="allergen-container"><i class='fa fa-circle fa-allergen allergen-sesame'></i>Sesame</span>
                      <span class="allergen-container"><i class='fa fa-circle fa-allergen allergen-shellfish'></i>Shellfish</span>
                      <span class="allergen-container"><i class='fa fa-circle fa-allergen allergen-soy'></i>Soy</span>
                      <span class="allergen-container"><i class='fa fa-circle fa-allergen allergen-tree-nuts'></i>Tree Nuts</span>
                      <span class="allergen-container"><i class='fa fa-circle fa-allergen allergen-vegan'></i>Vegan</span>
                      <span class="allergen-container"><i class='fa fa-circle fa-allergen allergen-vegetarian'></i>Vegetarian</span>
                      <span class="allergen-container"><i class='fa fa-circle fa-allergen allergen-gluten'></i>Wheat / Gluten</span>
                  </div>
                </div>
                <?php
                if (isset($data2)) {
                echo
                "<ul id='accordion' class='accordion'>
                <li class='default open'>
                    <div class='link'><i class='fa fa-search'></i>Search results</div>
                    <ul class='submenu'>";

                          foreach ($data2 as $key => $value) {
                            $date = "<span class='col-md-2'>".$value->date." ".wk($value->date)."</span>";
                            $time = "<span class='col-md-2'>".$value->time."</span>";
                            $location = "<span class='col-md-3'>".$value->location."</span>";
                            $types = parse_types($value->types);
                            $name = "<span class='col-md-5'>".$value->name.$types."</span>";
                            echo "<li>".preg_replace('/\(.*?\)/', '', $name).$date.$time.$location."</li>";
                          }

                echo
                        "
                    </ul>
                </li>
            </ul>";
                }
            ?>

        </section>

        </main>

@endsection
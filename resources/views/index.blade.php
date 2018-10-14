@extends('layouts.index')

@section('content')

    <div id="content">
        
        <main>
        <input id="tab1" type="radio" name="tabs" checked>
        <label for="tab1">CIE</label>
          
        <input id="tab2" type="radio" name="tabs">
        <label for="tab2">AP</label>
          
        <section id="content1">
                <div class="row">
                  <div class="col-md-2"></div>
                  <div class="col-md-8">
                    <form action="{{ route('search') }}" method="post" class="navbar-form navbar-left" role="search" style="width: 100%">
                      {{ csrf_field() }}
                    <div class="form-group" style="width: 70%">
                      <input name="search" type="text" class="form-control" placeholder="Search" style="width: 100%">
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                    </form>
                  </div>
                  <div class="col-md-2"></div>
                </div>
                <div class="row">
                  <div class="col-md-2" style="text-align: right;font-size: 18px;">LEGEND:</div>
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
                  // $type = $type."</div>";
                  return $type;
                }

                if (isset($data)) {
                echo
                "<ul id='accordion' class='accordion'>
                <li class='default open'>
                    <div class='link'><i class='fa fa-search'></i>Search results</div>
                    <ul class='submenu'>";

                          foreach ($data as $key => $value) {
                            $date = "<span class='col-md-3'>".$value->date." ".wk($value->date)."</span>";
                            $time = "<span class='col-md-3'>".$value->time."</span>";
                            $location = "<span class='col-md-3'>".$value->location."</span>";
                            $types = parse_types($value->types);
                            $name = "<span class='col-md-3'>".$value->name.$types."</span>";
                            echo "<li>".$name.$date.$time.$location."</li>";
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
             <ul id="accordion" class="accordion">
                <li class="default open">
                    <div class="link"><i class="fa fa-graduation-cap"></i>Free-Response Questions</div>
                    <ul class="submenu">
                        <li><a href="">AP Calculus BC</a></li>
                        <li><a href="">AP Chemistry</a></li>
                        <li><a href="">AP Computer Science A</a></li>
                        <li><a href="">AP Physics C: Electricity and Magnetism</a></li>
                        <li><a href="">AP Physics C: Mechanics</a></li>
                    </ul>
                </li>
        
        
            </ul>
        </section>
        </main>

@endsection
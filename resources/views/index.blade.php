@extends('layouts.index')

@section('content')

    <div id="content">
        
        <main>
        <input id="tab1" type="radio" name="tabs" checked>
        <label for="tab1">CIE</label>
          
        <input id="tab2" type="radio" name="tabs">
        <label for="tab2">AP</label>
          
        <section id="content1">
                <div class="row" style="padding:15px;">
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
                <?php
                if (isset($data)) {
                echo
                "<ul id='accordion' class='accordion'>
                <li class='default open'>
                    <div class='link'><i class='fa fa-search'></i>Search results</div>
                    <ul class='submenu'>";
                          foreach ($data as $key => $value) {
                            echo " <li><span>".$value->name."</span></li>";
                          }

                echo
                        "<li><span>AP Physics C: Mechanics</span></li>
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
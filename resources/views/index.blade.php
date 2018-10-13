@extends('layouts.index')

@section('content')

    <div id="content">

        <button id="mfmodal" type="button" class="btn btn-default" style="margin-bottom: 4px; width: 100%;" data-toggle="modal" data-target="#Modal1">
            CLICK HERE FOR HOW-TO GUIDE
        </button>
        <!-- Modal1 -->
            <div class="modal fade" id="Modal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" style="width:95%;max-width: 800px" role="document">
                <div class="modal-content">
                  <div class="modal-body" style="text-align: center;">
                    <img src="https://mfpapers.oss-cn-hangzhou.aliyuncs.com/img/res_guide.png" alt="res_guide" style="max-width: 100%;">
                  </div>
                </div>
              </div>
            </div>
        
        <main>
        <input id="tab1" type="radio" name="tabs" checked>
        <label for="tab1">CIE</label>
          
        <input id="tab2" type="radio" name="tabs">
        <label for="tab2">AP</label>
          
        <section id="content1">
                <div class="row" style="padding: 15px">
                  <form class="navbar-form navbar-left" role="search">
                    <div class="form-group">
                      <input type="text" class="form-control" placeholder="Search">
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                  </form>
                </div>
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
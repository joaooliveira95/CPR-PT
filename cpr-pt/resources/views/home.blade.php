@extends('layouts.app')

@section('highcharts')
<style>
.bs-slider{
    overflow: hidden;
    max-height: 600px;
    position: relative;
    background: #000000;
}
.bs-slider:hover {
    cursor: -moz-grab;
    cursor: -webkit-grab;
}
.bs-slider:active {
    cursor: -moz-grabbing;
    cursor: -webkit-grabbing;
}
.bs-slider .bs-slider-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.40);
}
.bs-slider > .carousel-inner > .item > img,
.bs-slider > .carousel-inner > .item > a > img {
    margin: auto;
    width: 100% !important;
}

/********************
*****Slide effect
**********************/

.fade {
    opacity: 1;
}
.fade .item {
    top: 0;
    z-index: 1;
    opacity: 0;
    width: 100%;
    position: absolute;
    left: 0 !important;
    display: block !important;
    -webkit-transition: opacity ease-in-out 1s;
    -moz-transition: opacity ease-in-out 1s;
    -ms-transition: opacity ease-in-out 1s;
    -o-transition: opacity ease-in-out 1s;
    transition: opacity ease-in-out 1s;
}
.fade .item:first-child {
    top: auto;
    position: relative;
}
.fade .item.active {
    opacity: 1;
    z-index: 2;
    -webkit-transition: opacity ease-in-out 1s;
    -moz-transition: opacity ease-in-out 1s;
    -ms-transition: opacity ease-in-out 1s;
    -o-transition: opacity ease-in-out 1s;
    transition: opacity ease-in-out 1s;
}






/*---------- LEFT/RIGHT ROUND CONTROL ----------*/
.control-round .carousel-control {
    top: 47%;
    opacity: 0;
    width: 45px;
    height: 45px;
    z-index: 100;
    color: #ffffff;
    display: block;
    font-size: 24px;
    cursor: pointer;
    overflow: hidden;
    line-height: 43px;
    text-shadow: none;
    position: absolute;
    font-weight: normal;
    background: transparent;
    -webkit-border-radius: 100px;
    border-radius: 100px;
}
.control-round:hover .carousel-control{
    opacity: 1;
}
.control-round .carousel-control.left {
    left: 1%;
}
.control-round .carousel-control.right {
    right: 1%;
}
.control-round .carousel-control.left:hover,
.control-round .carousel-control.right:hover{
    color: #fdfdfd;
    background: rgba(0, 0, 0, 0.5);
    border: 0px transparent;
}
.control-round .carousel-control.left>span:nth-child(1){
    left: 45%;
}
.control-round .carousel-control.right>span:nth-child(1){
    right: 45%;
}





/*---------- INDICATORS CONTROL ----------*/
.indicators-line > .carousel-indicators{
    right: 45%;
    bottom: 3%;
    left: auto;
    width: 90%;
    height: 20px;
    font-size: 0;
    overflow-x: auto;
    text-align: right;
    overflow-y: hidden;
    padding-left: 10px;
    padding-right: 10px;
    padding-top: 1px;
    white-space: nowrap;
}
.indicators-line > .carousel-indicators li{
    padding: 0;
    width: 15px;
    height: 15px;
    border: 1px solid rgb(158, 158, 158);
    text-indent: 0;
    overflow: hidden;
    text-align: left;
    position: relative;
    letter-spacing: 1px;
    background: rgb(158, 158, 158);
    -webkit-font-smoothing: antialiased;
    -webkit-border-radius: 50%;
    border-radius: 50%;
    margin-right: 5px;
    -webkit-transition: all 0.5s cubic-bezier(0.22,0.81,0.01,0.99);
    transition: all 0.5s cubic-bezier(0.22,0.81,0.01,0.99);
    z-index: 10;
    cursor:pointer;
}
.indicators-line > .carousel-indicators li:last-child{
    margin-right: 0;
}
.indicators-line > .carousel-indicators .active{
    margin: 1px 5px 1px 1px;
    box-shadow: 0 0 0 2px #fff;
    background-color: transparent;
    position: relative;
    -webkit-transition: box-shadow 0.3s ease;
    -moz-transition: box-shadow 0.3s ease;
    -o-transition: box-shadow 0.3s ease;
    transition: box-shadow 0.3s ease;
    -webkit-transition: background-color 0.3s ease;
    -moz-transition: background-color 0.3s ease;
    -o-transition: background-color 0.3s ease;
    transition: background-color 0.3s ease;

}
.indicators-line > .carousel-indicators .active:before{
    transform: scale(0.5);
    background-color: #fff;
    content:"";
    position: absolute;
    left:-1px;
    top:-1px;
    width:15px;
    height: 15px;
    border-radius: 50%;
    -webkit-transition: background-color 0.3s ease;
    -moz-transition: background-color 0.3s ease;
    -o-transition: background-color 0.3s ease;
    transition: background-color 0.3s ease;
}



/*---------- SLIDE CAPTION ----------*/
.slide_style_left {
    text-align: left !important;
}
.slide_style_right {
    text-align: right !important;
}
.slide_style_center {
    text-align: center !important;
}

.slide-text {
    left: 0;
    top: 25%;
    right: 0;
    margin: auto;
    padding: 10px;
    position: absolute;
    text-align: left;
    padding: 10px 85px;

}

.slide-text > h1 {

    padding: 0;
    color: #ffffff;
    font-size: 70px;
    font-style: normal;
    line-height: 84px;
    margin-bottom: 30px;
    letter-spacing: 1px;
    display: inline-block;
    -webkit-animation-delay: 0.7s;
    animation-delay: 0.7s;
}
.slide-text > p {
    padding: 0;
    color: #ffffff;
    font-size: 20px;
    line-height: 24px;
    font-weight: 300;
    margin-bottom: 40px;
    letter-spacing: 1px;
    -webkit-animation-delay: 1.1s;
    animation-delay: 1.1s;
}
.slide-text > a.btn-default{
    color: #000;
    font-weight: 400;
    font-size: 13px;
    line-height: 15px;
    margin-right: 10px;
    text-align: center;
    padding: 17px 30px;
    white-space: nowrap;
    letter-spacing: 1px;
    display: inline-block;
    border: none;
    text-transform: uppercase;
    -webkit-animation-delay: 2s;
    animation-delay: 2s;
    -webkit-transition: background 0.3s ease-in-out, color 0.3s ease-in-out;
    transition: background 0.3s ease-in-out, color 0.3s ease-in-out;

}
.slide-text > a.btn-primary{
    color: #ffffff;
    cursor: pointer;
    font-weight: 400;
    font-size: 13px;
    line-height: 15px;
    margin-left: 10px;
    text-align: center;
    padding: 17px 30px;
    white-space: nowrap;
    letter-spacing: 1px;
    background: #00bfff;
    display: inline-block;
    text-decoration: none;
    text-transform: uppercase;
    border: none;
    -webkit-animation-delay: 2s;
    animation-delay: 2s;
    -webkit-transition: background 0.3s ease-in-out, color 0.3s ease-in-out;
    transition: background 0.3s ease-in-out, color 0.3s ease-in-out;
}
.slide-text > a:hover,
.slide-text > a:active {
    color: #ffffff;
    background: #222222;
    -webkit-transition: background 0.5s ease-in-out, color 0.5s ease-in-out;
    transition: background 0.5s ease-in-out, color 0.5s ease-in-out;
}






/*------------------------------------------------------*/
/* RESPONSIVE
/*------------------------------------------------------*/

@media (max-width: 991px) {
    .slide-text h1 {
        font-size: 40px;
        line-height: 50px;
        margin-bottom: 20px;
    }
    .slide-text > p {

        font-size: 18px;
    }
}


/*---------- MEDIA 480px ----------*/
@media  (max-width: 768px) {
    .slide-text {
        padding: 10px 50px;
    }
    .slide-text h1 {
        font-size: 30px;
        line-height: 40px;
        margin-bottom: 10px;
    }
    .slide-text > p {
        font-size: 14px;
        line-height: 20px;
        margin-bottom: 20px;
    }
    .control-round .carousel-control{
        display: none;
    }

}
@media  (max-width: 480px) {
    .slide-text {
        padding: 10px 30px;
    }
    .slide-text h1 {
        font-size: 20px;
        line-height: 25px;
        margin-bottom: 5px;
    }
    .slide-text > p {
        font-size: 12px;
        line-height: 18px;
        margin-bottom: 10px;
    }
    .slide-text > a.btn-default,
    .slide-text > a.btn-primary {
        font-size: 10px;
        line-height: 10px;
        margin-right: 10px;
        text-align: center;
        padding: 10px 15px;
    }
    .indicators-line > .carousel-indicators{
        display: none;
    }

}
</style>
@endsection

@section('content')
<div class="container" style="margin-top: 70px; width: 80vw;">
    <div class="row">
        <div class="col-md-12">
           <div class="panel panel-default shadow">

                    <div class="panel-body">

                       <div id="bootstrap-touch-slider" class="carousel bs-slider fade  control-round indicators-line" data-ride="carousel" data-pause="hover" data-interval="false" >
                               <!-- Indicators -->
                               <ol class="carousel-indicators">
                                   <li data-target="#bootstrap-touch-slider" data-slide-to="0" class="active"></li>
                                   <li data-target="#bootstrap-touch-slider" data-slide-to="1"></li>
                                   <li data-target="#bootstrap-touch-slider" data-slide-to="2"></li>
                               </ol>

                               <!-- Wrapper For Slides -->
                               <div class="carousel-inner" role="listbox">

                                   <!-- Third Slide -->
                                   <div class="item active">

                                       <!-- Slide Background -->
                                       <img src="/banners/banner1.jpg" alt="Bootstrap Touch Slider"  class="slide-image"/>
                                       <div class="bs-slider-overlay"></div>

                                       <div class="container">
                                           <div class="row">
                                               <!-- Slide Text Layer -->
                                               <div class="slide-text slide_style_left">
                                                   <h1 data-animation="animated zoomInRight">Conheça a Plataforma!</h1>
                                                   <p data-animation="animated fadeInLeft">Fale Connosco.</p>

                                               </div>
                                           </div>
                                       </div>
                                   </div>
                                   <!-- End of Slide -->

                                   <!-- Second Slide -->
                                   <div class="item">

                                       <!-- Slide Background -->
                                       <img src="/banners/banner2.jpg" alt="Bootstrap Touch Slider"  class="slide-image"/>
                                       <div class="bs-slider-overlay"></div>
                                       <!-- Slide Text Layer -->
                                       <div class="slide-text slide_style_center">
                                         <h1 data-animation="animated zoomInRight">Marque já o seu agendamento!</h1>
                                         <p data-animation="animated fadeInLeft">Crie a sua conta ou então inicie sessão.</p>

                                       </div>
                                   </div>
                                   <!-- End of Slide -->

                                   <!-- Third Slide -->
                                   <div class="item">

                                       <!-- Slide Background -->
                                       <img src="/banners/banner3.jpg" alt="Bootstrap Touch Slider"  class="slide-image"/>
                                       <div class="bs-slider-overlay"></div>
                                       <!-- Slide Text Layer -->
                                       <div class="slide-text slide_style_right">
                                           <h1 data-animation="animated zoomInLeft">Slide Aleatório</h1>
                                           <p data-animation="animated fadeInRight">Just do it!</p>
                                       </div>
                                   </div>
                                   <!-- End of Slide -->
                               </div><!-- End of Wrapper For Slides -->
                               <!-- Left Control -->
                               <a class="left carousel-control" href="#bootstrap-touch-slider" role="button" data-slide="prev">
                                   <span class="fa fa-angle-left" aria-hidden="true"></span>
                                   <span class="sr-only">Previous</span>
                               </a>
                               <!-- Right Control -->
                               <a class="right carousel-control" href="#bootstrap-touch-slider" role="button" data-slide="next">
                                   <span class="fa fa-angle-right" aria-hidden="true"></span>
                                   <span class="sr-only">Next</span>
                               </a>
                           </div> <!-- End  bootstrap-touch-slider Slider -->
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection

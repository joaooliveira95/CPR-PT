@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 70px;">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default shadow">
               <div class="panel-heading" style="height: 65px;">
                 <div class="row">
                    <ol class="breadcrumb breadcrumbs">
                      <li><a href="/home">Home</a></li>
                      <li class="active">Media</li>
                    </ol>
                    <h3 class="titulo-pages">Media</h3>
                 </div>
              </div>
              <div class="panel-body">
                 <div class="video-container">
                    <iframe width="640" height="360" src="https://www.youtube.com/embed/hizBdM1Ob68" frameborder="0" allowfullscreen/>
                 </div>
              </div>
            </div>
        </div>
    </div>
</div>
@endsection

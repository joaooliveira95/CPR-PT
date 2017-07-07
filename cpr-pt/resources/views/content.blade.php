@extends('layouts.app')

@section('highcharts')
<script>

   $(document).ready(function() {
      $('.video-t li').each(function() {
      var code = $(this).attr('data-code');
      $(this).css("background-image", "url(https://img.youtube.com/vi/" + code + "/0.jpg)");
      $(this).css("background-size", "cover");
         $(this).click( function(){
            $('body').append('<div class="video-o"><div class="frame"><iframe width="100%" height="100%" src="//www.youtube.com/embed/' + code + '?rel=0&showinfo=0&controls=1&autoplay=1" frameborder="0" allowfullscreen></iframe></div></div>');
            $('.video-o').click( function(){
              $('div.video-o').remove();
            });
         });
      });
   });

</script>
@endsection

@section('content')
<div class="container" style="margin-top: 70px;">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default shadow">
               <div class="panel-heading">
                 <div class="row">
                    <ol class="breadcrumb breadcrumbs">
                      <li><a href="/home">Home</a></li>
                      <li class="active">Media</li>
                    </ol>
                    <h3 class="titulo-pages">Media</h3>
                 </div>
              </div>
              <div class="panel-body">
                 <div class="video-container text-center">
                     <h3 class="titulo-header">Videos</h3>
                     <div class="row">
                        <ul class="video-t">
                          <li data-code="Qb8YtgKrWzs"></li>
                          <li data-code="ZXL8S0PXX7A"></li>
                          <li data-code="hizBdM1Ob68"></li>
                        </ul>
                     </div>
                 </div>
              </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')

<div class="container" style="margin-top: 70px;">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default shadow">
               <div class="panel-heading">
                  <div class="row">
                     <ol class="breadcrumb breadcrumbs">
                       <li><a href="/home">Home</a></li>
                       <li><a href="/history/{{$idUser}}">Progress</a></li>
                       <li class="active">{{trans('messages.sessions')}}</li>
                     </ol>
                     <h3 class="titulo-pages">{{trans('messages.sessions')}}</h3>
                  </div>
               </div>

            <div class="panel-body">
               <div id="container">
                  <table id="datatable" class="table" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>{{trans('messages.date')}}</th>
                        <th>{{trans('messages.session')}}</th>
                      </tr>
                    </thead>
                </table>
              </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
          $('.table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "/sessions_datatable/{{$idUser}}",
            "columns":[
               {data: 'created_at'},
               {data: function (data, type, row, meta) {
                     return '<a href="/sessions/session/'+data.id+'">' + data.title + '</a>';
               }},
            ],
            "order": [[ 0, "desc" ]]
          });
    });
</script>
@endsection

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
                       <li><a href="/history/{{$user->id}}">{{trans('messages.progress')}}</a></li>
                       <li class="active">{{trans('messages.sessions')}}</li>
                     </ol>
                     <ul class="list-inline session_list">
                      <li class="nome_session">{{$user->name}}</li>
                      <li class="titulo_session"><b>{{trans('messages.sessions')}}</b></li>
                   </ul>
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
                    <tbody>
                       @foreach($sessions as $session)
                          <tr style="font-size: 16px;">
                              <td>{{$session->created_at}}</td>
                                  <td class="tabela_link"> <a href="/sessions/session/{{$session->id}}">{{$session->title}}</a></td>
                          </tr>
                        @endforeach
                    </tbody>
                </table>
              </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
          $('.table').DataTable({
                "order": [[ 0, "desc" ]]
          });
    });
</script>
@endsection

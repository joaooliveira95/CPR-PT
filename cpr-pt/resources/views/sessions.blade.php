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
                       <li><a href="/history">Progress</a></li>
                       <li class="active">{{trans('messages.sessions')}}</li>
                     </ol>
                     <h3 class="titulo-pages">{{trans('messages.sessions')}}</h3>
                  </div>
               </div>

                <div class="panel-body">
                    <form class="form-inline">
                         <div class="form-group">
                        {!! csrf_field() !!}
                         {{trans('messages.from')}}
                            <div class="input-group date" data-provide="datepicker">
                                <input class = "form-control datepicker" type="text" placeholder="MM/DD/YYYY" name="from" id="from">
                                <div class="input-group-addon">
                                    <span class="fa fa-calendar"></span>
                                </div>
                            </div>
                            <span style="display:inline-block; width: 5px;"></span>{{trans('messages.to')}}
                            <div class="input-group date" data-provide="datepicker">
                                <input class = "form-control datepicker" type="text" placeholder="MM/DD/YYYY" name="to" id="to">
                                <div class="input-group-addon">
                                    <span class="fa fa-calendar"></span>
                                </div>
                            </div>
                            <span style="display:inline-block; width: 5px; padding-top: 5px;">
                            <input class = "btn btn-default btn-md" type="submit" name="filter_button" id="filter_button" value="Submit">

                        </div>
                    </form>

                    <div class="table-responsive">
                       <table id="sessions_table" class='table table-hover'>
                             <br>
                            <thead class="thead-default">
                                <tr>
                                    <th>{{trans('messages.date')}}</th>
                                    <th>{{trans('messages.session')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sessions as $session)
                                    <tr>
                                        <td>{{$session->created_at}}</td>
                                        @if (Auth::user()->id != $session->idUser)
                                            <td> <a href="/students/{{$session->id}}/session">{{$session->title}}</a></td>
                                        @else
                                            <td> <a href="/history/{{$session->id}}/session">{{$session->title}}</a></td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                    </table>

                    {{ $sessions->links() }}

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

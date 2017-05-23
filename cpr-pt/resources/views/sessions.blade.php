@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{trans('messages.sessions')}}</div>

                <div class="panel-body">
                    <form class="form-inline">
                         <div class="form-group">
                            {{trans('messages.from')}}
                            <input class = "form-control input-sm" type="date" name="from" id="from">
                            {{trans('messages.to')}}
                            <input class = "form-control input-sm" type="date" name="to" id="to">
                            <input class = "btn btn-default btn-sm" type="submit" name="filter_button" id="filter_button" onclick="window.location.href=filterDates({{$id}})" value="Submit">
                         
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

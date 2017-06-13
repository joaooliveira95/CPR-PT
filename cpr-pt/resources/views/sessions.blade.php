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
                            <div class="input-group date" data-provide="datepicker">
                                <input class = "form-control datepicker" type="text" placeholder="MM/DD/YYYY" name="from" id="from">
                                <div class="input-group-addon">
                                    <span class="fa fa-calendar"></span>
                                </div>
                            </div>
                            {{trans('messages.to')}}
                            <div class="input-group date" data-provide="datepicker">
                                <input class = "form-control datepicker" type="text" placeholder="MM/DD/YYYY" name="to" id="to">
                                <div class="input-group-addon">
                                    <span class="fa fa-calendar"></span>
                                </div>
                            </div>
                            <input class = "btn btn-default btn-sm" type="submit" name="filter_button" id="filter_button" value="Submit">
                         
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
<script type="text/javascript">
    
    $('.datepicker').datepicker({

            format: 'dd/mm/yyyy',
            language: 'pt',
          });

</script>

@endsection

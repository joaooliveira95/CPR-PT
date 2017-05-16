@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Comments</div>

                <div class="panel-body">

                    <form class="form-inline">
                         <div class="form-group">
                                            From:
                            <input class = "form-control input-sm" type="date" name="from" id="from">
                            To:
                            <input class = "form-control input-sm" type="date" name="to" id="to">
                            <input class = "btn btn-default btn-sm" type="submit" name="filter_button" id="filter_button" onclick="window.location.href=filterDates(2)" value="Submit">
                        </div>
                    </form>
                  
                     <div class="table-responsive">
                     <table id="comments_table" class='table table-hover'>
                             <thead class="thead-default">
                                <tr>
                                    <th>From</th>
                                    <th>Date</th>
                                    <th>Session</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($comments as $comment)
                                    <tr>
                                        <td>{{$comment->name}}</td>
                                        <td>{{$comment->created_at}}</td>
                                        <td> <a href="/history/{{$comment->idSession}}/session">{{$comment->title}}</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                    </table>
                    </div>
                        {{ $comments->links() }}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

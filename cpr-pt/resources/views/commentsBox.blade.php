@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Comments</div>

                <div class="panel-body">
                  
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

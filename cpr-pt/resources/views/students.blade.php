@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"> {{trans('messages.students')}}</div>

                <div class="panel-body">
                    <form class="form-inline">
                         <div class="form-group">
                            <input class = "form-control input-md" type="text" name="filter" id="str_filter" placeholder="Search...">
                        
                           <input class = "btn btn-default btn-md fa-input" type="submit" name="filter_button" id="filter_button" onclick="window.location.href=filterStudents()" value="&#xf002;">
                        </div>
                    </form>
                    <br>
                     <div class="table-responsive">
                     <table id="sessions_table" class='table table-hover'>
                             <thead class="thead-default">
                                <tr>
                                    <th>{{trans('messages.name')}}</th>
                                    <th>Email</th>
                                    <th>Link</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $student)
                                    <tr>
                                        <td>{{$student->name}}</td>
                                        <td>{{$student->email}}</td>
                                        <td><a href="/students/{{$student->id}}/sessions">Sessões</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                    </table>
                    </div>
                           {{ $students->links() }}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

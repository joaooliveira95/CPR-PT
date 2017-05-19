@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Classes</div>

                <div class="panel-body">
                    
                    <form class="form-inline">
                         <div class="form-group">
                                            Filter:
                            <input class = "form-control input-sm" type="text" name="filter" id="str_filter">
                        
                            <input class = "btn btn-default btn-sm" type="submit" name="filter_button" id="filter_button" onclick="window.location.href=filterStudents()" value="Submit">
                        </div>
                    </form>           
                    <div class="table-responsive">
                       <table id="turmas_table" class='table table-hover'>
                             <br>
                            <thead class="thead-default">
                                <tr>
                                    <th>Name</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($turmas as $turma)
                                    <tr>
                                        <td><a href="/turma/{{$turma->id}}">{{$turma->name}}</a></td>
                                        <td>{{$turma->created_at}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                    </table>

                    {{ $turmas->links() }}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

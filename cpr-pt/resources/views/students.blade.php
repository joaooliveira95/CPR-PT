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
                       <li><a href="/turmas">{{trans('messages.classes')}}</a></li>
                       <li class="active">{{trans('messages.students')}}</li>
                     </ol>
                     <h3 class="titulo-pages">{{trans('messages.students')}}</h3>
                  </div>
            </div>

                <div class="panel-body">
                    <form class="form-inline">
                         <div class="form-group">
                            {!! csrf_field() !!}
                            <input class = "form-control input-md" type="text" name="filter" id="str_filter" placeholder="Search...">

                           <input class = "btn btn-default btn-md fa-input" type="submit" name="filter_button" id="filter_button" onclick="window.location.href=filterStudents()" value="&#xf002;">
                        </div>
                    </form>
                    <br>
                     <div class="table-responsive">
                     <table id="sessions_table" class='table table-hover'>
                             <thead class="thead-default">
                                <tr class="tabela_header">
                                    <th>{{trans('messages.name')}}</th>
                                    <th>Email</th>
                                    <th>Link</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $student)
                                    <tr style="font-size: 16px;">
                                        <td>{{$student->name}}</td>
                                        <td>{{$student->email}}</td>
                                        <td class="tabela_link"><a href="/students/{{$student->id}}/sessions">Sessões</a></td>
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

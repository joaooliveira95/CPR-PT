@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2" style="margin-top: 70px;">
            <div class="panel panel-default shadow">
               <div class="panel-heading" style="height: 65px;">
                  <div class="row">
                     <ol class="breadcrumb breadcrumbs">
                       <li><a href="/home">Home</a></li>
                       <li class="active">{{trans('messages.classes')}}</li>
                     </ol>
                     <h3 class="titulo-pages">{{trans('messages.classes')}}</h3>
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
                    <div class="table-responsive">
                       <table id="turmas_table" class='table table-hover'>
                             <br>
                            <thead class="thead-default;">
                                <tr style="font-size: 20px;">
                                    <th>{{trans('messages.class')}}</th>
                                    <th>Nº Alunos</th>
                                    <th>{{trans('messages.created_at')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($turmas as $turma)
                                    <tr style="font-size: 16px;">
                                        <td class="tabela_link"><a href="/turma/{{$turma->id}}">{{$turma->name}}</a></td>
                                        <td ondload="n_alunos({{$turma->id}})"></td>
                                        <td>{{date('d M Y' ,strtotime($turma->created_at))}}</td>
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

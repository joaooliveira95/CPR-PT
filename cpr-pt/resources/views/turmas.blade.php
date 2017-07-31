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

                    <div class="table-responsive">
                       <table id="turmas_table" class='table table-hover'>
                             <br>
                            <thead class="thead-default;">
                                <tr style="font-size: 20px;">
                                    <th>{{trans('messages.class')}}</th>
                                    <th>{{trans('messages.num_students')}}</th>
                                    <th>{{trans('messages.created_at')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($turmas as $turma)
                                    <tr style="font-size: 16px;">
                                        <td class="tabela_link"><a href="/turma/{{$turma->id}}">{{$turma->name}}</a></td>
                                        <td>{{$num_alunos[$turma->id]}}</td>
                                        <td>{{date('d M Y' ,strtotime($turma->created_at))}}</td>
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
      });
});
</script>
@endsection

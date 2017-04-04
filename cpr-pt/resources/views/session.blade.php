@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{$user->name}} session : {{$session->created_at}}</div>

                <div class="panel-body">

                      <div id="treinos">
                          @if($exercises!=null)
                            <div class="table-responsive">
                             <table id="sessions_table" class='table table-hover'>
                                   <br>
                                  <thead class="thead-default">
                                      <tr>
                                          <th>idSession</th>
                                          <th>Total Duration</th>
                                          <th>Parcial Duration</th>
                                          <th>N Correct Compressions</th>
                                          <th>N Incorrect Compressions</th>

                                      </tr>
                                  </thead>
                                  <tbody>
                                      @foreach($exercises as $exercise)
                                          <tr>
                                            <td>{{$exercise->id}}</td>
                                            <td>{{$exercise->duracaoTotal}}</td>
                                            <td>{{$exercise->duracaoParcial}}</td>
                                            <td>{{$exercise->ncompressoesCorretas}}</td>
                                            <td>{{$exercise->ncompressoesIncorretas}}</td>
                                          </tr>
                                      @endforeach
                                  </tbody>
                          </table>
                          {{ $exercises->links() }}
                      </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

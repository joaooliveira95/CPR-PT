@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">New Session</div>

                    <div class="panel-body">

                       <div id="treinos" class="table-responsive">
                          @if($exercises!=null)
                              {{ $exercises->links() }}
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

                           
                      @endif
                       <div style="display: inline">
                           <input class = "btn btn-default btn-sm" type="submit" name="filter_button" id="filter_button" value="New Exercise" onclick = "location.href='/newSession/{{$id}}'"/>

                           <input class = "btn btn-default btn-sm" type="submit" name="filter_button" id="filter_button" value="End Session" onclick="location.href='/history';"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<link href="{{ asset('/css/comentsStyle.css') }}" rel="stylesheet">
<div class="container">
    <div class="row">
       <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Resultados do Exercicio {{$exercise->id}}</div>

                <div class="panel-body">

                  <div id="treino">
                      <div class="table-responsive">
                       <table id="sessions_table" class='table table-hover'>
                             <br>
                            <thead class="thead-default">
                                <tr>
                                    <th class = "centered_tb">{{trans('messages.time')}}</th>
                                    <th class = "centered_tb">Recoil</th>
                                    <th class = "centered_tb">{{trans('messages.compressions')}}</th>
                                    <th class = "centered_tb">{{trans('messages.hands_position')}}</th>
                                </tr>
                            </thead>

                            <tbody>
                                    <tr>
                                      <td class = "centered_tb">{{$exercise->time}}</td>
                                      <td class = "centered_tb">{{$exercise->recoil}}</td>
                                      <td class = "centered_tb">{{$exercise->compressions}}</td>
                                      <td class = "centered_tb">{{$exercise->hand_position}}</td>
                                    </tr>
                            </tbody>
                        </table>
                        </div>
                  </div>
                </div>
              </div>
        </div>
    </div>
</div>

@endsection


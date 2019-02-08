@extends('layouts.app')
@inject('profile', 'App\Http\Controllers\ProfileController')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <h4>Nome: {{ $perfil->name }}</h4>
                    <hr>
                    <h4>Total Pendente: R$ {{ $profile->get_total_unpaid($id) }}</h4>
                    <hr>
                    {{ Form::open(array('route' => 'profile.debit.post')) }}
                        <div class="form-group">
                            {{ Form::token() }}
                            <div class="col-sm-3">
                                <label>Valor</label>
                                <input type="text" name="value" class="form-control"/>
                            </div>

                            <div class="col-sm-3">
                                <label>Pago com</label>
                                <select name="type" class="form-control">
                                    <option value="0"> Dinheiro </option>
                                    <option value="1"> Cartao</option>
                                </select>
                            </div>
                            <input type="hidden" name="prof_id" value="{{$id}}"></br>
                            {{ Form::submit('debitar') }}
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

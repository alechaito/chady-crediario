@extends('layouts.app')

@inject('profile', 'App\Profile')
@inject('profile_control', 'App\Http\Controllers\ProfileController')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    {{ Form::open(array('route' => 'profile.store')) }}
                        {{ Form::token() }}

                        {{ Form::label('Nome Completo') }}</br>
                        {{ Form::text('name') }}</br>

                        {{ Form::label('C.P.F') }}</br>
                        {{ Form::text('cpf') }}</br>

                        {{ Form::label('tel - Nao obrigatorio') }}</br>
                        {{ Form::text('tel') }}</br>

                        {{ Form::label('endereco - Nao obrigatorio') }}</br>
                        {{ Form::text('address') }}</br></br>


                        {{ Form::submit('cadastrar') }}
                    {{ Form::close() }}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

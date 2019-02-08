@extends('layouts.app')

@inject('profile_control', 'App\Http\Controllers\ProfileController')

<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>

<!-- JS file -->
<script src="{{ asset('js/awesomplete.js') }}"></script> 

<link href="{{ asset('css/awesomplete.css') }}" rel="stylesheet">


@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Cliente - Nome: {{ $profile->name }}
                </div>

                <div class="panel-body">
                    <table class="table">
                        <tr>
                            <td>Nome</td>
                            <td>C.P.F</td>
                            <td>Pago</td>
                            <td>Pendente</td>
                            <td>Total</td>
                            <td>Deletar</td>
                        </tr>
                        @php
                            $t_paid = $profile_control->get_total_paid($profile->id);
                            $t_unpaid = $profile_control->get_total_unpaid($profile->id);
                            $total = $profile_control->get_total($profile->id);
                        @endphp
                        <tr>
                            <td>{{ $profile->name }}</td>
                            <td>{{ $profile->cpf }}</td>
                            <td>R$ {{ number_format($t_paid, 2, '.', '.') }}</td>
                            <td>R$ {{ number_format($t_unpaid, 2, '.', '.') }}</td>
                            <td>R$ {{ number_format($total, 2, '.', '.') }}</td>
                            <td> <a href="{{ route('profile.delete', $profile->id) }}" target="_blank">Excluir</a> </td>
                        </tr>
                    </table>
                    <hr>
                    <h4>Compras</h4>
                        <tr>
                            <td>
                                <a href="{{ route('order.add', $profile->id) }}" target="_blank">
                                    <button>Cadastrar</button>
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('profile.orders', $profile->id) }}" target="_blank">
                                    <button>Historico</button>
                                </a>
                            </td>
                        </tr>
                    <hr>
                    <h4>Debitos</h4>
                        <tr>
                            <td>
                                <a href="{{ route('profile.debit', $profile->id) }}" target="_blank">
                                    <button>Debitar</button>
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('profile.debit.history', $profile->id) }}" target="_blank">
                                    <button>Historico</button>
                                </a>
                            </td>
                        </tr>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

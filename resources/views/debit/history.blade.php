@extends('layouts.app')

@inject('profile_control', 'App\Http\Controllers\ProfileController')

<!-- VARIABLES -->
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
            <div class="panel-heading">Cliente - Nome: {{ $perfil->name }}

                <div class="panel-body">
                    <h4>Total pago com dinheiro: R$ {{ $profile_control->get_total_info($perfil->id)[0] }}</h4>
                    <hr>
                    <h4>Total pago com cartao: R$ {{ $profile_control->get_total_info($perfil->id)[1] }}</h4>
                    <hr>
                    <h4>Consultar Historico de Debitos</h4>
                    <a href="{{ route('debit.filter', [1, $perfil->id]) }}">
                        <button>1 mes</button>
                    </a>
                    <a href="{{ route('debit.filter', [3, $perfil->id]) }}">
                        <button>3 mes</button>
                    </a>
                    <a href="{{ route('debit.filter', [6, $perfil->id]) }}">
                        <button>6 mes</button>
                    </a>
                    <a href="{{ route('debit.filter', [12, $perfil->id]) }}">
                        <button>12 mes</button>
                    </a>
                    <hr>
                    <table class="table">
                        <tr>
                            <td>Valor</td>
                            <td>Tipo</td>
                            <td>Data</td>
                            <td>Excluir</td>
                        </tr>
                        @foreach($history as $hist)
                        <tr>
                            <td>R$ {{ number_format($hist->value, 2, ',', '.') }}</td>
                            <td>
                                @if($hist->type == 0)
                                    Dinheiro
                                @else
                                    Cartao
                                @endif
                            </td>
                            <td>{{ $hist->created_at }}</td>
                            <td> 
                                <a href="{{ route('debit.delete', $hist->id) }}" target="_blank">Excluir</a> 
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

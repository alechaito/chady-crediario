@extends('layouts.app')

@inject('profile_control', 'App\Http\Controllers\ProfileController')
@inject('order_control', 'App\Http\Controllers\OrderController')

<!-- VARIABLES -->
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                <h4>Consultar Historico de Compras</h4>
                <a href="{{ route('order.filter', [1, $perfil->id]) }}">
                    <button>1 mes</button>
                </a>
                <a href="{{ route('order.filter', [3, $perfil->id]) }}">
                    <button>3 mes</button>
                </a>
                <a href="{{ route('order.filter', [6, $perfil->id]) }}">
                    <button>6 mes</button>
                </a>
                <a href="{{ route('order.filter', [12, $perfil->id]) }}">
                    <button>12 mes</button>
                </a>
                <hr>
                <div class="panel-body">
                    <table class="table">
                        <tr>
                            <td>Total</td>
                            <td>Items</td>
                            <td>Data</td>
                            <td>Excluir</td>
                        </tr>
                        @foreach($orders as $order)
                        <tr>
                            <td>R$ {{ number_format($order->total, 2, ',', '.') }}</td>
                            <td>{{ $order_control->format_items($order->items) }}</td>
                            <td>{{ $order->created_at }}</td>
                            <td> 
                                <a href="{{ route('order.delete', $order->id) }}" target="_blank">Excluir</a> 
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

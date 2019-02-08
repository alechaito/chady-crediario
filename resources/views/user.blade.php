@extends('layouts.app')

@inject('profile', 'App\Profile')
@inject('profile_control', 'App\Http\Controllers\ProfileController')

<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>

<!-- JS file -->
<script src="{{ asset('js/awesomplete.js') }}"></script> 

<link href="{{ asset('css/awesomplete.css') }}" rel="stylesheet">


@php 
    $profiles = $profile::All();
@endphp

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard - Clientes (cadastro/procura/exclusao)
                </div>

                <div class="panel-body">
                    <h4>Buscar Cliente</h4>
                    <form id="form-search" method="POST" action="{{ route('profile.search') }}">
                        {{ Form::token() }}
                        <input id="names" name="name" type="text"/></br>
                        digite o nome do cliente e pressione enter.
                        <div id="div"></div>
                    </form>
                    <hr>
                    <h4>Ordens</h4>
                    <table class="table">
                        <tr>
                            <td>Total Vendido</td>
                            <td>Total Pendente</td>
                        <tr>
                        @php  
                            $total_order = $profile_control->total_orders();
                            $total_debits = $profile_control->get_all_total_info();
                        @endphp
                        <tr>
                            <td>R$ {{ number_format($total_order, 2, '.', '.') }}</td>
                            <td>R$ {{ number_format($total_order-$total_debits[0]-$total_debits[1], 2, '.', '.') }}</td>
                        <tr>
                    </table>
                    <hr>
                    <h4>Debitos</h4>
                    <table class="table">
                        <tr>
                            <td>Total Dinheiro</td>
                            <td>Total Cartao</td>
                            <td>Total</td>
                        <tr>
                        <tr>
                            <td>R$ {{ number_format($total_debits[0], 2, '.', '.') }}</td>
                            <td>R$ {{ number_format($total_debits[1], 2, '.', '.') }}</td>
                            <td>R$ {{ number_format($total_debits[0]+$total_debits[1], 2, '.', '.') }}</td>
                        <tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
$(function()
{
    var input = document.getElementById("names");
	var ajax = new XMLHttpRequest();

    ajax.open("GET", "http://127.0.0.1:8000/user/all", true);
    ajax.onload = function() {
        var list = JSON.parse(ajax.responseText).map(function(i) { 
            return i.id+"/"+i.name;
        });
        new Awesomplete(input, { list: list, minChars: 1 });
    };
    ajax.send();

});

</script>

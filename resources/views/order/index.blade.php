@extends('layouts.app')
@inject('profile', 'App\Profile')
@inject('order', 'App\Order')

<!-- VARIABLES -->
@php
    $profiles = $profile::ALl();
    $orders = $order::All();
@endphp

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">

                    <table class="table">
                        <tr>
                            <td>Comprador</td>
                            <td>Items</td>
                            <td>Total</td>
                            <td>Data</td>
                            <td>abater</td>
                        </tr>
                        @foreach($orders as $unorder)
                        <tr>
                            <td>{{ $unorder->profile_id }}</td>
                            <td>{{ $unorder->items }}</td>
                            <td>R$ {{ $unorder->total }}</td>
                            <td>{{ $unorder->created_at }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@inject('profile_control', 'App\Http\Controllers\ProfileController')
@inject('order_control', 'App\Http\Controllers\OrderController')

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
                <div class="panel-heading">Dashboard - Nome: {{ $perfil->name }}</div>
                <div class="panel-body">
                    <h4>Adicionar Compra</h4>
                    <hr>
                    @php 
                        $order_id = $order_control->get_last_id();
                    @endphp
                    <h3> Pedido #{{ $order_id }}</h3>
                    <hr>
                    {{ Form::open(array('route' => 'order.store')) }}
                        {{ Form::token() }}
                        <input type="hidden" name="profile_id" value="{{ $perfil->id }}"/>
                        <input type="hidden" name="profile_name" value="{{ $perfil->name }}"/>
                        <input type="hidden" name="order_id" value="{{ $order_id }}"/>
                        <input id="param1" type="hidden" name="param1"/>
                        <input id="param2" type="hidden" name="param2"/>
                        <table>
                            <tr>
                                <td width="100px">Quantidade</td>
                                <td width="200px">Produto</td>
                                <td width="130px">Valor unitario</td>
                                <td width="100px">Subtotal</td>
                            </tr>
                        </table>
                        <div class="container1">
                            <div>
                                <input type="text" name="qnt" class="qnt" size="5">
                                <input type="text" name="item" class="item">
                                <input type="text" name="price" class="price" size="8">
                                <input type="text" name="subtotal" class="subtotal" size="10" disabled>
                                <button class="add_form_field">
                                    <span style="font-size:16px; font-weight:bold;">+</span>
                                </button>
                            </div>
                        </div></br>
                        {{ Form::label('total') }}</br>
                        <input type="text" name="total" id="total" disabled></br></br>
                        <input id="send" type="submit" value="Finalizar">
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>

$(document).ready(function() {
    var max_fields      = 10;
    var wrapper         = $(".container1");
    var add_button      = $(".add_form_field");

    var x = 1;
    $(add_button).click(function(e){
        e.preventDefault();
        if(x < max_fields){
            x++;
            $(wrapper).append('<div>'
            +'<input type="text" name="qnt" class="qnt" size="5"/>'
            +'<input type="text" name="item" class="item"/>'
            +'<input type="text" id="price" name="price" class="price" size="8"/>'
            +'<input type="text" name="subtotal" class="subtotal" size="10" disabled>'
            +'<a href="#" class="delete">Delete</a></div>'); //add input box
        }
        else {
            alert('You Reached the limits')
        }
    });

    $(wrapper).on("click",".delete", function(e){
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })

});

$(document).ready(function() {
    $("#send").on("click", function(e) {
        //e.preventDefault();
        const inputs_qnt = document.getElementsByClassName('qnt');
        const inputs_item = document.getElementsByClassName('item');
        const inputs_price = document.getElementsByClassName('price');
        const inpt_sub = document.getElementsByClassName('subtotal');
        const size = inputs_qnt.length;
        var string = "";
        var total = 0;
        for(var i = 0; i < size; i++) {
            string += inputs_qnt[i].value+"x, "+inputs_item[i].value+", R$" + inputs_price[i].value + " - "+inpt_sub[i].value+" /";
            if(!isNaN(inputs_price[i].value) && inputs_price[i].value.length!=0) {
                total += parseFloat(inputs_price[i].value)*parseInt(inputs_qnt[i].value);
            }
        }
        //document.getElementById("total").value = total.toFixed(2);
        console.log(string);
        document.getElementById("param1").value = string;
        document.getElementById("param2").value = total.toFixed(2);

        //WORKING WITH POPUP TO PRINT ORDER
        var date = new Date().toLocaleString();
        var c_name = document.getElementsByName("profile_name")[0].value;
        var order_id = document.getElementsByName("order_id")[0].value;

        /*popup = window.open ('', 'Comprovante', "width=300 height=250");
        popup.document.write ("Chady Calcados</br>");
        popup.document.write ("Cliente: "+c_name+"</br>");
        popup.document.write ("Data: "+date+"</br>");
        popup.document.write ("Ordem #"+order_id+"</br>");
        popup.document.write ("-------------------------</br>");
        const splited = string.split("/");
        for(var i = 0; i < splited.length; i++) {
            popup.document.write (splited[i]+"</br>");
        }
        popup.document.write ("-------------------------</br>");
        popup.document.write ("Total: R$"+total.toFixed(2));
        popup.document.alert(print());*/
    })
});


$(document).ready(function() {
    $(document).on("keyup", ".price", function(e){
        const inputs_price = document.getElementsByClassName('price');
        const inputs_qnt = document.getElementsByClassName('qnt');
        const size = inputs_price.length;
        var total = 0;
        for(var i=0; i < size; i++) {
            if(!isNaN(inputs_price[i].value) && inputs_price[i].value.length!=0) {
                total += parseFloat(inputs_price[i].value)*parseInt(inputs_qnt[i].value);
            }
        }
        document.getElementById("total").value = "R$"+total.toFixed(2);
    })
});

$(document).ready(function() {
    $(document).on("keyup", ".price", function(e){
        const inputs_price = document.getElementsByClassName('price');
        const inputs_qnt = document.getElementsByClassName('qnt');
        const inpt_sub = document.getElementsByClassName('subtotal')
        const size = inputs_price.length;
        var total = 0;
        for(var i=0; i < size; i++) {
            if(!isNaN(inputs_price[i].value) && inputs_price[i].value.length != 0) {
                var price = parseFloat(inputs_price[i].value);
                total = parseFloat(price)*parseInt(inputs_qnt[i].value);
                inpt_sub[i].value = "R$"+total.toFixed(2);
                //inputs_price[i].value = "R$"+price.toFixed(2);
            }
            total = 0;
        }
        //document.getElementById("total").value = "R$"+total.toFixed(2);
    })
});


</script>

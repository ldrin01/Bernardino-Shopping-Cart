@extends('layouts.app')


@section('style')
<style type="text/css" media="screen">
    .well{
        margin-bottom: 15px;
    }
</style>
@endsection


@section('content')
<div class="container">
    <div class="row">


        <!-- Products -->
        <div class="col-md-7">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Products
                </div>

                <div class="panel-body" style="padding: 15px 22px 15px 22px;">
                    <div id="product-body" class="row">
                        @foreach ($products as $product)
                            <div class="col-md-3" style="padding: 0 7px 0 7px;">
                                <div class="well well-sm">
                                    <div style="font-size: 11.2px;">{{ $product->name }} | <strong>$ {{ $product->price }}</strong></div>
                                    <img src="/img/products/{{ $product->path }}" width="100%;" style="margin: 5px 0 5px 0; border: 2px solid #dddddd; border-radius: 10px;">
                                    <p align="right" style="margin: 0 0 2px 0;"><span class="badge">{{ $product->stock }} left</span></p>
                                    <a href="/addToCart/{{ $product->id }}"><button class="btn btn-warning btn-xs" style="width: 100%; margin-top: 3px;">Add to Cart</button></a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>


        <!-- Cart -->
        <div class="col-md-4">
            <div class="panel panel-default">


                <div class="panel-heading">Cart
                </div>

                <div id="cart-panel" class="panel-body" style="padding-bottom: 0;"> 

                    @if ($cart_items == "[]")
                        <p style="color: #dddddd; text-align: center; margin-bottom: 15px;">Empty</p>

                    @elseif ($cart_items != "[]")

                        @foreach ($cart_items as $cart_item)
                            <div class="col-md-12" style="padding: 0 0 0 0 ;">
                                <div class="well well-sm">
                                    <div class="row">
                                        <div class="col-md-3" style="padding-right: 0;">
                                            <img src="/img/products/{{ $cart_item->path }}" width="100%;" style="margin: 5px 0 5px 0; border: 2px solid #dddddd; border-radius: 10px;">
                                        </div>
                                        <div class="col-md-9" style="padding-left: 8px;">
                                            <strong>{{ $cart_item->name }} | {{ $cart_item->description }}</strong><br>
                                            Price: $ {{ $cart_item->price }}<br>
                                            Quantity: {{ $cart_item->quantity }}<br>
                                        </div>
                                        
                                    </div>

                                    <hr style="margin: 10px 0 10px 0;">

                                    <div class="row">
                                        <div class="col-md-8">
                                            Total: <span class="label label-default" style="font-size: 14px;">$ {{ $cart_item->amount }}</span>
                                        </div>
                                        <div class="col-md-4">
                                            <a href="deleteProduct/{{ $cart_item->cart_id }}/{{ $cart_item->product_id }}/{{ $cart_item->quantity }}"><button class="btn btn-danger btn-xs pull-right">Cancel &times</button></a>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>


        <!-- Checkout -->
        <div class="col-md-1">
            <a href="/checkout"><button class="btn btn-success btn-sm">Checkout <span class="glyphicon glyphicon-chevron-right"></span></button></a><br><br>

            <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                <?php $i=1; ?>
                @foreach ($cart_items as $cart_item)
                    <input type="hidden" name="cmd" value="_cart">
                    <input type="hidden" name="upload" value="1">
                    <input type="hidden" name="business" value="eldrinbernardino01@gmail.com">
                    <input type="hidden" name="item_name_{{$i}}" value="{{ $cart_item->name }}">
                    <input type="hidden" name="amount_{{$i}}" value="{{ $cart_item->amount }}">
                    <?php $i++; ?>
                @endforeach

                <button type="submit" value="PayPal" class="btn btn-primary btn-sm">Use Paypal <span class="glyphicon glyphicon-chevron-right"></span></button>
            </form>
            
        </div>

    </div>
</div>
@endsection


@section('script')
<script type="text/javascript">
        
    // $(document).ready(function(data) {

    //         $.ajaxSetup({
    //             headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             }
    //         });

    //         $.ajax({
    //             type: "get",
    //             url: '/getCartItem',
    //             success: function(data) {
    //                 // alert(JSON.stringify(data));
    //                 data.forEach(function(item) {
    //                     $("#cart-panel").append("<div class=\"well well-sm\"><strong style=\"font-size: 18px;\">"+item.name+" | "+item.description+"</strong><br><i style=\"text-align: right; margin-top: -30px; margin-right: 0px;\" class=\"pull-right\">PRICE: "+item.price+"PhP<br>QUANTITY: "+item.quantity+"</i></div>");
    //                 });
    //             }
    //         });


    //         var categoryId = '1';
    //         // alert (categoryId);
    //         $.ajax({
    //             type: "get",
    //             url: '/getProduct',
    //             data: {id: categoryId},
    //             success: function(data) {
    //                 $("#product-body").html("");
    //                 $statement = "";
    //                 data.forEach(function(product) {
    //                     $statement += "<div id=\"\" class=\"col-md-4 col-md-offset-0\" style=\"width: 33%;\"> ";
    //                     $statement += " <div class=\"well well-sm\"> ";
    //                     $statement += "     <span id=\"product-name\">"+product.name+"</span> | <br>";
    //                     $statement += "     <span id=\"product-description\">"+product.description+"</span>";
    //                     $statement += "     <div class=\"well well-sm\" style=\"margin: 3px 0 3px 0; text-align: center; color: gray; height: 110px;\">image";
    //                     $statement += "     </div>Price: "+product.price+"Php<br>Stock: ";
    //                     $statement += "     <span id=\"stock"+product.id+"\" class=\"badge\">"+product.stock+"</span>";
    //                     $statement += "     <input type=\"number\" name=\"quant[1]\" id=\"quantity"+product.id+"\" class=\"form-control input-number\" oninput=\"updateInput(value, "+product.id+")\" value=\"0\" min=\"1\" max=\"0\">";
    //                     $statement += "     <button value=\""+product.id+"\" disabled type=\"button\" id=\"addtocart"+product.id+"\" class=\"btn btn-warning\" style=\"width: 100%; padding-top: 5px; margin-top: 5px;\" onclick=\"addtocart("+product.id+")\" >";
    //                     $statement += "     <span class=\"glyphicon glyphicon-shopping-cart\"></span></button></div></div>";



    //                     $("#product-body").append($statement);
    //                 });
    //             }
    //         });

    //         // $.ajax({
    //         //     type: "get",
    //         //     url: '/getProductStock',
    //         //     data: {id: categoryId},
    //         //     success: function(data) {
    //         //             // alert(JSON.stringify(data));
    //         //             $name = "test";
    //         //             $count = 0;
    //         //         data.forEach(function(dairy) {
    //         //             // alert (dairy.id);
    //         //             if ($name == "test") {
    //         //                 $name = dairy.id;
    //         //                 $("#quantity"+dairy.id).attr('max', $count);
    //         //                 $("#quantity"+dairy.id).attr('value', '1');
    //         //                 $("#stock"+dairy.id).text($count);
    //         //                 $("#addtocart"+dairy.id).removeAttr('disabled');
    //         //             }
    //         //             if (dairy.id == $name){
    //         //                 $count++;
    //         //                 $("#quantity"+dairy.id).attr('max', $count);
    //         //                 $("#quantity"+dairy.id).attr('value', '1');
    //         //                 $("#stock"+dairy.id).text($count);
    //         //                 name = dairy.id;
    //         //             }
    //         //         //     if (dairy.id != $name){
    //         //         //         $name = "test";
    //         //         //         $count = 1;
    //         //         //     }
    //         //         });
    //         //     }
    //         // });

    //     $(".category").click(function(){
    //         $dropdownName = $(this).text();
    //         // alert ($dropdownName);
    //         $("#dropdown-menu").html($dropdownName+"&nbsp <span class=\"caret\"></span>");


    //         var categoryId = $(this).attr('id');
    //         // alert (categoryId);
    //         $.ajax({
    //             type: "get",
    //             url: '/getProduct',
    //             data: {id: categoryId},
    //             success: function(data) {
    //                 $("#product-body").html("");
    //                 $statement = "";
    //                 data.forEach(function(product) {
    //                     $statement += "<div id=\"\" class=\"col-md-4 col-md-offset-0\" style=\"width: 33%;\"> ";
    //                     $statement += " <div class=\"well well-sm\"> ";
    //                     $statement += "     <span id=\"product-name\">"+product.name+"</span> | <br>";
    //                     $statement += "     <span id=\"product-description\">"+product.description+"</span>";
    //                     $statement += "     <div class=\"well well-sm\" style=\"margin: 3px 0 3px 0; text-align: center; color: gray; height: 110px;\">image";
    //                     $statement += "     </div>Price: "+product.price+"Php<br>Stock: ";
    //                     $statement += "     <span id=\"stock"+product.id+"\" class=\"badge\">"+product.stock+"</span>";
    //                     $statement += "     <input type=\"number\" name=\"quant[1]\" id=\"quantity"+product.id+"\" class=\"form-control input-number\" oninput=\"updateInput(value, "+product.id+")\" value=\"0\" min=\"1\" max=\"0\">";
    //                     $statement += "     <button value=\""+product.id+"\" disabled type=\"button\" id=\"addtocart"+product.id+"\" class=\"btn btn-warning\" style=\"width: 100%; padding-top: 5px; margin-top: 5px;\" onclick=\"addtocart("+product.id+")\" >";
    //                     $statement += "     <span class=\"glyphicon glyphicon-shopping-cart\"></span></button></div></div>";



    //                     $("#product-body").append($statement);
    //                 });
    //             }
    //         });


    //     });
    // });

    // // function addtocart(productId) {
    // //     // alert (productId);
    // //     $quantity = $("#quantity"+productId).attr('value');
    // //     // alert ($quantity);
    // //     $.ajax({
    // //             type: "get",
    // //             url: '/addToCart',
    // //             data: {quantity: $quantity, productId: productId},
    // //             success: function(response) {
    // //                 // alert (response);
    // //                 window.location = "/home";
    // //             }
    // //     });
    // // }
    // // function updateInput(value, productId) {
    // //     // alert (value);
    // //     $input_value = $("#quantity"+productId).val();
    // //     $max = $("#quantity"+productId).attr('max');
    // //     $min = 1;
    // //     if ($input_value <= $max && $input_value >= $min) {
    // //         $("#quantity"+productId).attr('value', $input_value);
    // //         $("#quantity"+productId).val($input_value);
    // //     }
    // //     if ($input_value < $min){
    // //         $("#quantity"+productId).attr('value', '1');
    // //         $("#quantity"+productId).val('1');
    // //     }
    // //     if ($input_value > $max){
    // //         $("#quantity"+productId).attr('value', $max);
    // //         $("#quantity"+productId).val($max);
    // //     }
    // //     // alert ($max);
    // // }

</script>
@endsection

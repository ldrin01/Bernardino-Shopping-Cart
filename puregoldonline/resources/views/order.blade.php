@extends('layouts.app')


@section('style')
<style type="text/css" media="screen">
    
</style>
@endsection


@section('content')
<div class="container">
    <div class="row">

        <div class="col-md-12">
            <div class="panel panel-default">

                <div class="panel-heading">
                    Orders
                </div>

                <div class="panel-body">
                    <table class="table table-condensed table-hover table-striped">

                        <thead style="font-size: 18px; border-bottom: 3px solid #000000;">
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Amount</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($order_items as $order_item)
                                <tr>
                                    <td>{{ $order_item->name }}</td>
                                    <td>${{ $order_item->price }}</td>
                                    <td>{{ $order_item->quantity }}</td>
                                    <td>${{ $order_item->amount }}</td>
                                </tr>
                            @endforeach
                                <tr class="success" style="font-size: 18px; border-top: 3px solid #000000; font-weight: bold;">
                                    <td>TOTAL:</td>
                                    <td></td>
                                    <td>{{ $total_items }} pcs.</td>
                                    <td><strong>${{ $total_amount }}</strong></td>
                                </tr>
                        </tbody>

                    </table>

                    <a href="/thankyou"><button class="btn btn-primary pull-right">Procceed and Pay</button></a>

                </div>

            </div>
        </div>


    </div>
</div>
@endsection


@section('script')
<script type="text/javascript">
</script>
@endsection

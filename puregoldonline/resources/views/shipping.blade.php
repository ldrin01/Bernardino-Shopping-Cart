@extends('layouts.app')


@section('style')
<style type="text/css" media="screen">
    
</style>
@endsection


@section('content')
<div class="container">
    <div class="row">

        <form action="/placeOrders" method="POST" accept-charset="utf-8">
            {{ csrf_field() }}
        <!-- Billing -->
        <div class="col-md-6">
            <div class="panel panel-default">

                <div class="panel-heading">
                    Billing
                </div>

                <div class="panel-body">

                    <label for="name" class="col-md-4 control-label" align="right">Name</label>
                    <div class="col-md-8">
                        <input id="name" type="text" class="form-control" name="name_billings" value="{{ Auth::user()->name }}" required autofocus>
                    </div>
                    <br>

                    <br>
                    <label for="name" class="col-md-4 control-label" align="right">Card No.</label>
                    <div class="col-md-8">
                        <input id="name" type="number" class="form-control" name="card_no" value="101" required autofocus>
                    </div>
                    <br>

                    <br>
                    <label for="name" class="col-md-4 control-label" align="right">Card Type</label>
                    <div class="col-md-8">
                        <label class="radio-inline"><input type="radio" required autofocus name="card_type">Master Card</label>
                        <label class="radio-inline"><input type="radio" required autofocus name="card_type">Visa</label>
                        <label class="radio-inline"><input type="radio" required autofocus name="card_type">Discover</label>
                    </div>
                    <br>

                    <br>
                    <label for="name" class="col-md-4 control-label" align="right">Expiration Date</label>
                    <div class="col-md-8">
                        <input id="name" type="date" class="form-control" name="exp_date" required autofocus>
                    </div>
                    <br>

                    <br>
                    <label for="name" class="col-md-4 control-label" align="right">Security Code</label>
                    <div class="col-md-8">
                        <input id="name" type="number" class="form-control" name="security_code" value="101" required autofocus>
                    </div>
                </div>

            </div>
        </div>


        <!-- Shipping -->
        <div class="col-md-5">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Shipping
                </div>

                <div class="panel-body">

                    <label for="name" class="col-md-4 control-label" align="right">Name</label>
                    <div class="col-md-8">
                        <input id="name" type="text" class="form-control" name="name_shippings" value="{{ Auth::user()->name }}" required autofocus>
                    </div>
                    <br>

                    <br>
                    <label for="name" class="col-md-4 control-label" align="right">Address</label>
                    <div class="col-md-8">
                        <input id="name" type="text" class="form-control" name="address" value="qwerty" required autofocus>
                    </div>
                    <br>

                    <br>
                    <label for="name" class="col-md-4 control-label" align="right">City</label>
                    <div class="col-md-8">
                        <input id="name" type="text" class="form-control" name="city" value="qwerty" required autofocus>
                    </div>
                    <br>

                    <br>
                    <label for="name" class="col-md-4 control-label" align="right">Country</label>
                    <div class="col-md-8">
                        <input id="name" type="text" class="form-control" name="country" value="Philippines" required autofocus>
                    </div>
                    <br>

                    <br>
                    <label for="name" class="col-md-4 control-label" align="right">Contact No.</label>
                    <div class="col-md-8">
                        <input id="name" type="number" class="form-control" name="contact_no" value="101" required autofocus>
                    </div>
                    <br>

                    <br>
                    <label for="name" class="col-md-4 control-label" align="right">E-mail</label>
                    <div class="col-md-8">
                        <input id="name" type="text" class="form-control" name="email" value="qwerty" required autofocus>
                    </div>
                    <br>
                </div>
            </div>
        </div>


        <!-- Checkout -->
        <div class="col-md-1">
            <button type="submit" class="btn btn-success btn-sm">Place Orders <span class="glyphicon glyphicon-chevron-right"></span></button>           
        </div>

        </form>
    </div>
</div>
@endsection


@section('script')
<script type="text/javascript">
</script>
@endsection


@extends('layouts.app_containerless')


@section('content')
    <div class="mainContainer">
        <div class="container">
            <div class="product_wrapper">
                <div class="product_boxwrap row">
                    <h3>Category Products</h3>
                    @include('product._products_list')
                </div>
            </div>
        </div>
    </div>
@endsection



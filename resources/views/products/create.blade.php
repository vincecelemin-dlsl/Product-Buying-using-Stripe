@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ url('/product') }}" method="post">
            @csrf
            <div class="form-group">
              <label for="product_name">Product name</label>
              <input type="text" value="{{old('product_name')}}" class="form-control" name="product_name" id="product_name" aria-describedby="helpId" placeholder="">
            </div>

            <div class="form-group">
              <label for="product_description">Product Description</label>
              <textarea class="form-control" name="product_description" id="product_description" rows="3">{{old('product_description')}}</textarea>
            </div>

            <div class="form-group">
              <label for="product_price">Product Price</label>
              <input type="text" value="{{old('product_price')}}" class="form-control" name="product_price" id="product_price" aria-describedby="productPriceHelp" placeholder="0.00">
              <small id="productPriceHelp" class="form-text text-muted">Enter a valid amount</small>
            </div>

            <div class="text-right">
                <button class="btn btn-success">Post</button>
            </div>
        </form>
    </div>
@endsection
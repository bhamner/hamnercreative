@extends('layouts.app')
@section('title') {{ config('app.name') }} - Edit Content @stop
@section('content')

<div class="py-5">
      <div class="justify-content-between align-items-center pt-1 pb-2 mb-3">
      </div>
      @include('includes.response_alerts')

      @if( $content ) 
      <div class="text-end my-4 px-5">
         <a class="btn btn-outline-danger" href="/content/delete/{{ $content->id }}" onclick="return confirm('Are you sure you want to delete this item? This cannot be undone.')">
            Delete this item
        </a>
      </div>
      @endif
      
      <h2>{{ $content ? 'Edit Item': 'New Item' }}</h2>
     
      <form method="POST" action="/content/update" class="form" enctype="multipart/form-data">
            @csrf
            @if( $content ) <input type="hidden" name="content_id" value="{{ $content->id }}" /> @endif
            <input type="hidden" name="client_id" value="{{ $client->id }}" />

            <div class="row g-3 px-5 py-3">
                  <div class="col-12">
                        <label for="content_image" class="form-label">Image</label>
                        <br/>
                        @if( $content )
                        <img src="//{{ $content->image }}" name="content_image" class="img-thumbnail" alt="image">
                        <br/>
                        @endif
                        <input class="form-control" name="content_image" type="file" accept="image/*">
                  </div>
                  <div class="col-12">
                        <label for="name_input" class="form-label">Name</label>
                        <input type="text" class="form-control @if($errors->has('content_name')) is-invalid @endif" id="content_name" name="content_name" placeholder="My Item" 
                        @if( $content ) value="{{ $content->name }}" @endif required/>
                  </div>

                  <div class="col-12 mb-5 pb-5">
                        <label for="description_input" class="form-label">Description</label>
                        <div id="quill" data-name="content_description">@if( $content ){{ $content->description }}@endif</div> 
                  </div>
                  <div class="col-12">
                        <label for="quantity_input" class="form-label">Quantity Available</label>
                        <input type="text" class="form-control @if($errors->has('content_quantity')) is-invalid @endif" id="content_quantity" name="content_quantity" placeholder="1-20" 
                        @if( $content ) value="{{ $content->quantity_available }}" @endif />
                  </div>
                  <div class="col-12">
                        <label for="price_input" class="form-label">Price</label>
                        <input type="text" class="form-control @if($errors->has('content_price')) is-invalid @endif" id="content_price" name="content_price" placeholder="20.00"  
                        @if( $content ) value="{{ $content->price }}" @endif />
                  </div>
                  <div class="col-12 my-5">
                        <div class="form-check form-switch">
                          <input class="form-check-input" name="content_in_stock"  value="1"  type="checkbox" role="switch" id="in_stock_input" @if( $content && $content->in_stock ) checked @endif>
                          <label class="form-check-label"  for="in_stock_input">In Stock?</label>
                        </div>
                  </div>
                  @foreach( $client->content_fields as $option )
                  <div class="col-12">
                        {!! App\Logic\FormInputBuilder::getInstance()->setInput($option->input_type)->setName($option->name)->setValue($content && $content->has('content_values') ? $content->content_values : null )->build() !!}
                  </div>
                  @endforeach

            <div class="row g3 px-5 py-5">
                  <div class="d-grid gap-2">
                      <button type="submit" class="btn btn-outline-primary">Submit</button>
                  </div>
            </div>
      </form>
</div>

@endsection
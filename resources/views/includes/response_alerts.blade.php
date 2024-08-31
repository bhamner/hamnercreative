@if( session('success') )
<div class="alert alert-success d-flex align-items-center slide-5" role="alert">
  <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
  <div>
     {{ session('success') }}
  </div>
</div>
@endif

@if( session('errors') )
 @foreach ($errors->all() as $message)  
  <div class="alert alert-danger d-flex align-items-center slide-5" role="alert">
    <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
    <div>
     {{ $message }}
    </div>
  </div>
 @endforeach
@endif
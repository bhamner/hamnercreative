  <div class="justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
      <form method="get" action="" class="row row-cols-md-auto g-3 align-items-center">
        <div class="col-6">
          @if( Auth::user()->clients->count() > 1 )
           <select id="client_filter" name="client" class="form-select" aria-label="client_filter"  onchange="this.form.submit()">
                <option value=""> All Clients </option>
            @foreach( $clients as $opt )
                <option value="{{ $opt->id }}" @if( $client && $client->id == $opt->id ) selected @endif> {{ $opt->name }} </option>
            @endforeach
          </select>
          @else
          <p class="pt-3 px-2"> {{ Auth::user()->clients->first()->name }} </p>
          @endif
        </div>
        <div class="col-6"> 
          <select id="date_filter" name="date" class="form-select" aria-label="date_filter" onchange="this.form.submit()">
            @foreach( $dates['options'] as $opt )
              <option value="{{ $opt }}" @if( $dates['selected'] == $opt ) selected @endif> {{ $opt }} </option>
            @endforeach
          </select>
        </div>
      </form>
   </div>
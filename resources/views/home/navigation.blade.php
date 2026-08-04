<nav class="navbar fixed-top navbar-expand-lg">
   <div class="container">
      <a class="navbar-brand text-white" href="#header">{{ strtoupper(config('app.name')) }} </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"><i class="fa fa-navicon"></i></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
         <ul class="navbar-nav ms-auto mt-2 mt-lg-0" id="navbar-nav">
            @auth
            <li class="nav-item">
               <a href="{{ ($homeClient = Auth::user()->clients->first()) ? route('metrics.show', $homeClient) : '/setup' }}" class="btn btn-dark">{{ Auth::user()->name }}</a>
            </li>
            @else
            <li class="nav-item">
               <a href="/auth/google" class="btn btn-dark">SIGN IN</a>
            </li>
            @endauth
         </ul>
      </div>
   </div>
</nav>

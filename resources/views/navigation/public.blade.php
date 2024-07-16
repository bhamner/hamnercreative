<nav class="navbar fixed-top navbar-expand-lg">
   <div class="container">
      <a class="navbar-brand text-white" href="#header">{{ strtoupper(config('app.name')) }} </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"><i class="fa fa-navicon"></i></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
         <ul class="navbar-nav ms-auto mt-2 mt-lg-0" id="navbar-nav">
            <li class="nav-item">
               <a class="nav-link" href="#header">HOME</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="#about">ABOUT</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="#work">WORK</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="#form">CONTACT</a>
            </li>
            @if(!Auth::guest())
            <li class="nav-item dropdown">
               <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"><i class="fa fa-user"></i> {{ Auth::user()->name }}</a>
               <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="/dashboard">DASHBOARD</a>
                  <a class="dropdown-item" href="/user">ACCOUNT</a>
                  <a class="dropdown-item" href="/logout">LOGOUT</a>
               </ul>
            </li>
            @else
            <li class="nav-item">
               <a href="/auth/google" class="btn  btn-dark">SIGN IN </a>
            </li>
            @endif
         </ul>
      </div>
   </div>
</nav>
@auth
@if(($variant ?? 'dropdown') === 'sidebar')
    <li class="nav-item">
        <span class="nav-link d-flex align-items-center gap-2 text-body-secondary">
            <i class="fa fa-user"></i>
            <span>{{ Auth::user()->name }}</span>
        </span>
    </li>
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center gap-2" href="{{ route('user.show') }}">
            <svg class="bi"><use xlink:href="#gear-wide-connected"></use></svg>
            Account
        </a>
    </li>
    <li class="nav-item">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-link d-flex align-items-center gap-2 border-0 bg-transparent w-100 text-start">
                <svg class="bi"><use xlink:href="#door-closed"></use></svg>
                Logout
            </button>
        </form>
    </li>
@else
<li class="nav-item dropdown{{ ($fixed ?? false) ? ' position-static' : '' }} {{ $class ?? '' }}">
    <a class="nav-link dropdown-toggle{{ ($dark ?? false) ? ' text-white' : '' }}"
       href="#"
       role="button"
       data-bs-toggle="dropdown"
       data-bs-auto-close="true"
       @if($fixed ?? false) data-bs-popper-config='{"strategy":"fixed"}' @endif
       aria-expanded="false">
        {{ Auth::user()->name }}
    </a>
    <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="{{ route('user.show') }}">Account</a></li>
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dropdown-item">Logout</button>
            </form>
        </li>
    </ul>
</li>
@endif
@endauth

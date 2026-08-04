@php
    $navClients = $clients ?? Auth::user()->clients;
    $activeClientId = isset($client) && $client ? $client->id : optional(request()->route('client'))->id;
@endphp
<ul class="nav flex-column app-client-nav">
    @foreach($navClients as $navClient)
        @php
            $isActiveClient = (int) $activeClientId === (int) $navClient->id;
            $collapseId = 'client-nav-'.$navClient->id;
        @endphp
        <li class="nav-item mb-1">
            <button
                type="button"
                class="nav-link d-flex align-items-center justify-content-between gap-2 w-100 border-0 bg-transparent text-start {{ $isActiveClient ? 'fw-semibold' : '' }}"
                data-bs-toggle="collapse"
                data-bs-target="#{{ $collapseId }}"
                aria-expanded="{{ $isActiveClient ? 'true' : 'false' }}"
                aria-controls="{{ $collapseId }}"
            >
                <span class="text-truncate">{{ $navClient->name }}</span>
                <svg class="bi flex-shrink-0 client-nav-chevron"><use xlink:href="#chevron-right"></use></svg>
            </button>
            <div class="collapse {{ $isActiveClient ? 'show' : '' }}" id="{{ $collapseId }}">
                <ul class="nav flex-column ms-3 mb-2">
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 {{ $isActiveClient && request()->routeIs('metrics.show') ? 'active' : '' }}"
                           href="{{ route('metrics.show', $navClient) }}"
                           @if($isActiveClient && request()->routeIs('metrics.show')) aria-current="page" @endif>
                            <svg class="bi"><use xlink:href="#graph-up"></use></svg>
                            Metrics
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 {{ $isActiveClient && request()->routeIs('invoices.index', 'orders.*') ? 'active' : '' }}"
                           href="{{ route('invoices.index', $navClient) }}"
                           @if($isActiveClient && request()->routeIs('invoices.index')) aria-current="page" @endif>
                            <svg class="bi"><use xlink:href="#cart"></use></svg>
                            Invoices
                        </a>
                    </li>
                    @if($navClient->has_content)
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 {{ $isActiveClient && request()->routeIs('content.*') ? 'active' : '' }}"
                           href="{{ route('content.index', $navClient) }}"
                           @if($isActiveClient && request()->routeIs('content.index')) aria-current="page" @endif>
                            <svg class="bi"><use xlink:href="#file-earmark"></use></svg>
                            Site content
                        </a>
                    </li>
                    @endif
                    @if($navClient->has_leads)
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 {{ $isActiveClient && request()->routeIs('leads.*') ? 'active' : '' }}"
                           href="{{ route('leads.index', $navClient) }}"
                           @if($isActiveClient && request()->routeIs('leads.index')) aria-current="page" @endif>
                            <svg class="bi"><use xlink:href="#people"></use></svg>
                            Leads
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
        </li>
    @endforeach
</ul>

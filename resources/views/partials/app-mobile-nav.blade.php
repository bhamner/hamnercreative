{{-- Mobile / tablet nav (below lg) — slides in from the right --}}
<div class="offcanvas offcanvas-end d-lg-none" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="sidebarMenuLabel">{{ strtoupper(config('app.name')) }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0">
        <div class="pt-2">
            @include('partials.app-nav-links')
        </div>
        <hr class="my-3">
        <ul class="nav flex-column">
            @include('partials.user-account-menu', ['variant' => 'sidebar'])
        </ul>
    </div>
</div>

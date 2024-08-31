<div class="sidebar border border-right border-bottom-0 col-md-3 col-lg-2 p-0 bg-body-tertiary">
  <div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="sidebarMenuLabel"> {{ strtoupper(config('app.name')) }} </h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link d-flex align-items-center gap-2 active" aria-current="page" 
          href="/dashboard">
            <svg class="bi"><use xlink:href="#house-fill"></use></svg>
            Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link d-flex align-items-center gap-2" 
          href="/orders{{ request()->getQueryString() ? '?'. request()->getQueryString():'' }}">
            <svg class="bi"><use xlink:href="#cart"></use></svg>
            Orders
          </a>
        </li>
        @if( isset($client) && $client->has_content )
        <li class="nav-item">
          <a class="nav-link d-flex align-items-center gap-2" 
          href="/content{{ request()->getQueryString() ? '?'. request()->getQueryString():'' }}">
            <svg class="bi"><use xlink:href="#file-earmark"></use></svg>
            Site content
          </a>
        </li>
        @endif
        @if( isset($client) && $client->has_leads )
        <li class="nav-item">
          <a class="nav-link d-flex align-items-center gap-2" 
            href="/leads{{ request()->getQueryString() ? '?'. request()->getQueryString():'' }}" >
            <svg class="bi"><use xlink:href="#people"></use></svg>
            Leads
          </a>
        </li>
        @endif
       <!-- 
        <li class="nav-item">
          <a class="nav-link d-flex align-items-center gap-2" href="#">
            <svg class="bi"><use xlink:href="#graph-up"></use></svg>
            Reports
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link d-flex align-items-center gap-2" href="#">
            <svg class="bi"><use xlink:href="#puzzle"></use></svg>
            Integrations
          </a>
        </li>
      </ul>

      <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-body-secondary text-uppercase">
        <span>Saved reports</span>
        <a class="link-secondary" href="#" aria-label="Add a new report" 
                    data-bs-toggle="modal" data-bs-target="#addReportModal">
          <svg class="bi"><use xlink:href="#plus-circle"></use></svg>
        </a>
      </h6>
      <ul class="nav flex-column mb-auto">
        <li class="nav-item">
          <a class="nav-link d-flex align-items-center gap-2" href="#">
            <svg class="bi"><use xlink:href="#file-earmark-text"></use></svg>
            Current month
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link d-flex align-items-center gap-2" href="#">
            <svg class="bi"><use xlink:href="#file-earmark-text"></use></svg>
            Last quarter
          </a>
        </li>
       -->
      </ul>

      <hr class="my-3">

      <ul class="nav flex-column mb-auto">

        <li class="nav-item">
          <a class="nav-link d-flex align-items-center gap-2" href="/user">
            <svg class="bi"><use xlink:href="#gear-wide-connected"></use></svg>
            Account
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link d-flex align-items-center gap-2" href="/logout">
            <svg class="bi"><use xlink:href="#door-closed"></use></svg>
            Sign out
          </a>
        </li>
      </ul>
    </div>
  </div>
</div>
@include('reports.add_report_modal')
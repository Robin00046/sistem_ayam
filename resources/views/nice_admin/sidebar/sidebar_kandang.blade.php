<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
      <a class="nav-link {{ Request::is('dashboard_kandang') ? '' :'collapsed' }}" href="{{ route('dashboard_kandang') }}">
        {{-- <a class="nav-link" href="#"> --}}
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li><!-- End Dashboard Nav -->
    <li class="nav-item">
      {{-- <a class="nav-link" href="#"> --}}
        <a class="nav-link {{ Request::is('pendapatan') ? '' :'collapsed' }}"  href="{{ route('pendapatan.index') }}">
          <i class="bi bi-people"></i>
        <span>Management Pendapatan</span>
      </a>
    </li>
  </ul>

</aside><!-- End Sidebar-->
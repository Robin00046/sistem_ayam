<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link {{ Request::is('dashboard') ? '' :'collapsed' }}"  href="{{ route('dashboard') }}">
        {{-- <a class="nav-link" href="#"> --}}
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->
      <li class="nav-item">
        {{-- <a class="nav-link" href="#"> --}}
          <a class="nav-link {{ Request::is('customers') ? '' :'collapsed' }}"  href="{{ route('customers.index') }}">
            <i class="bi bi-people"></i>
          <span>Management User</span>
        </a>
      </li>
      <li class="nav-item">
        {{-- <a class="nav-link" href="#"> --}}
          <a class="nav-link {{ Request::is('manage-kandang') ? '' :'collapsed' }}"  href="{{ route('manage-kandang.index') }}">
          <i class="bi bi-table"></i>
          <span>Management Kandang</span>
        </a>
      <li class="nav-item">
        <a class="nav-link" href="#">
          <a class="nav-link {{ Request::is('jenis-produk') ? '' :'collapsed' }}"  href="{{ route('jenis-produk.index') }}">
          <i class="bi bi-table"></i>
          <span>Management Product</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
          <a class="nav-link {{ Request::is('laporan-admin') ? '' :'collapsed' }}"  href="{{ route('laporan-admin.index') }}">
          <i class="bi bi-table"></i>
          <span>Management Report</span>

        </a>
      </li>
      

    </ul>

  </aside><!-- End Sidebar-->
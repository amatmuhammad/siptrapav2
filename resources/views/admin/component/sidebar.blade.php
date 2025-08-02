<ul class="menu-inner py-1">
    <!-- Dashboards -->
     <li class="menu-item {{ Request::is('Dashboard') ?  'active' : '' }}">
         <a href="{{ route('Dashboard') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home-smile"></i>
              <div class="text-truncate" data-i18n="Basic">Dashboard</div>
         </a>
     </li>
     <!-- Components -->
     <li class="menu-header small text-uppercase"><span class="menu-header-text">Geographic Information</span></li>
     <!-- Cards -->
     <li class="menu-item {{ Request::is('Peta-Persebaran') ? 'active' : '' }}">
         <a href="{{ route('persebaran') }}" class="menu-link">
             <i class="menu-icon tf-icons bx bx-collection"></i>
             <div class="text-truncate" data-i18n="Basic">Peta Persebaran</div>
            </a>
     </li>
     {{-- feature --}}
    <li class="menu-header small text-uppercase"><span class="menu-header-text">Feature</span></li>
     <li class="menu-item {{ Request::is('Data-Produsen') ? 'active' : '' }}">
      <a href="{{ route('produsen') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bxs-truck"></i>
          <div class="text-truncate" data-i18n="Basic">Data Distributor</div>
      </a>
     </li>
     <li class="menu-item {{ Request::is('Data-Pangan-Admin') ? 'active' : '' }}">
      <a href="{{ route('panganadmin') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-leaf"></i>
          <div class="text-truncate" data-i18n="Basic">Data Pangan</div>
      </a>
     </li>
     <li class="menu-item {{ Request::is('Node') ? 'active' : '' }}">
         <a href="{{ route('Node') }}" class="menu-link">
             <i class="menu-icon tf-icons bx bx-circle"></i>
             <div class="text-truncate" data-i18n="Basic">Data Node</div>
            </a>
        </li>
        <li class="menu-item {{ Request::is('Edge') ? 'active' : '' }}">
            <a href="{{ route('Edge') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-ruler"></i>
                <div class="text-truncate" data-i18n="Basic">Data Edge</div>
            </a>
        </li>
        <li class="menu-item {{ Request::is('Data-Kabupaten') ? 'active' : '' }}">
            <a href="{{ route('kabupaten') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-current-location"></i>
                <div class="text-truncate" data-i18n="Basic">Kabupaten</div>
            </a>
        </li>
        <li class="menu-item {{ Request::is('Data-Nama-Pangan') ? 'active' : '' }}">
            <a href="{{ route('namaPangan') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-restaurant"></i>
                <div class="text-truncate" data-i18n="Basic">Nama Pangan</div>
            </a>
        </li>
            
</ul>
<aside class="main-sidebar main-sidebar-custom sidebar-light-primary border-right text-truncate">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
      <img src="/assets/image/icon-app.png" alt="logo" class="brand-image img-circle elevation-1" style="border-radius: 10% !important">
      <span class="ml-2 brand-text font-weight-bold text-center">{{ config("app.name") }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
        <div class="image">
          <img src="/assets/image/account.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="#" class="d-block" id="sidebar_info_user">Default User</a>
            <span class="badge badge-button badge-info" style="font-size: 0.7rem">
                <a class="text-light" href="/user"><i class="fas fa-info-circle mr-1"></i> Detail</a>
            </span>
            <span class="badge badge-button badge-danger" style="font-size: 0.7rem;">
                <a class="text-light" href="/logout"><i class="fas fa-sign-out-alt mr-1"></i>Keluar</a>
            </span>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('/') ? 'active' : ''}}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        Dashboard
                    </p>
                </a>
            </li>


            <li class="nav-header {{ in_array(auth()->user()->role, ["SUPER ADMIN", "ADMIN"]) ? "" : "d-none"}}">Setting</li>
            <li class="nav-item {{ in_array(auth()->user()->role, ["SUPER ADMIN", "ADMIN"]) ? "" : "d-none"}}">
                <a href="{{ route('users') }}" class="nav-link {{ request()->is('users', 'users/*') ? 'active' : ''}}">
                <i class="nav-icon fas fa-tools"></i>
                    <p>
                        User
                    </p>
                </a>
            </li>



        </ul>
      </nav>
    </div>

    <div class="sidebar-custom d-flex justify-content-center align-item-center font-weight-bold text-muted font-xxs">
        V {{ config("app.version") }}
    </div>
  </aside>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{asset('assets/images/logo/shotcut-icon.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Admin Panel</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('storage/images/profile/'.$user->image) }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ ucwords($user->username) }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{ url('backoffice/dashboard') }}" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Posts
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('backoffice/post/create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>New Post</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ url('backoffice/posts') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Post</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('backoffice/categories_tags') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Taxonomies</p>
                  </a>
                </li>
            </ul>
          </li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Services
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('backoffice/service/create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add New</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ url('backoffice/services') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Services</p>
                </a>
              </li>
            </ul>
          </li>

          {{-- <li class="nav-header">SITE RESOURCES</li> --}}
          <li class="nav-item">
            <a href="{{ url('backoffice/resources') }}" class="nav-link">
              <i class="nav-icon fas fa-cogs"></i>
              <p>Settings</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('backoffice/contacts_subscribers') }}" class="nav-link">
              <i class="nav-icon fas fa-user-circle"></i>
              <p>Contacts and Subscribers</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
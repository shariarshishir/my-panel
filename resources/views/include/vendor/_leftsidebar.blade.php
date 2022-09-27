<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('admin.dashboard')}}" class="brand-link">
      <img src="{{asset('admin-assets/img/merchantbay_icon_white.png')}}" alt="Merchantbay Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">MerchantBay Shop</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('admin-assets/img/avatar04.png')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="javascript:void(0);" class="d-block">Super User</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          <li class="nav-item has-treeview menu-open">
            <a href="javascript:void(0);" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard<i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <a href="{{route('product.index',$businessProfileId)}}" class="nav-link {{ Route::is('product.index') ||Route::is('product.create')||Route::is('product.edit')? 'active' : ''}} ">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Products</p>
                </a>
             </li>
             <li class="nav-item">
                <a href="{{route('vendor.order.index',$businessProfileId)}}" class="nav-link {{ Route::is('vendor.order.index')||Route::is('vendor.order.create')||Route::is('vendor.order.edit')||Route::is('vendor.order.show')? 'active' : ''}} ">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Orders</p>
                </a>
             </li>
            </ul>
          </li>






        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

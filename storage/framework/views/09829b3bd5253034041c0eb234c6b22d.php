<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $__env->yieldContent('title', cms_name() . ' - ' . cms_description()); ?></title>
    
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempus Dominus Bootstrap 4 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.2/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqvmap/1.5.1/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.0/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('themes/adminlte/css/custom.css')); ?>">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="<?php echo e(asset('img/icon/logo_96x96.png')); ?>" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?php echo e(url('/')); ?>" class="nav-link">Beranda</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Kontak</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="<?php echo e(asset('img/icon/logo_96x96.png')); ?>" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="<?php echo e(asset('img/icon/logo_96x96.png')); ?>" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="<?php echo e(asset('img/icon/logo_96x96.png')); ?>" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-sm text-muted">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-sm text-muted">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-sm text-muted">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" role="button">
          <i class="fas fa-sign-out-alt"></i>
        </a>
        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
            <?php echo csrf_field(); ?>
        </form>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo e(url('/panel/dashboard')); ?>" class="brand-link">
      <img src="<?php echo e(asset('img/icon/logo_96x96.png')); ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light"><?php echo e(cms_name()); ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo e(asset('img/icon/logo_96x96.png')); ?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo e(auth()->user()->name ?? 'Admin'); ?></a>
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
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <?php
              $isDashboardActive = request()->routeIs('panel.dashboard');
          ?>
          <li class="nav-item">
            <a href="<?php echo e(url('/panel/dashboard')); ?>" class="nav-link <?php echo e($isDashboardActive ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          
          <!-- Dynamic plugin menu items from database -->
          <?php
              // Load all plugins to ensure routes are available
              $pluginManager = app(App\Services\PluginManager::class);
              $allPlugins = $pluginManager->getPlugins();
              
              foreach($allPlugins as $plugin) {
                  if($plugin['active']) {
                      $pluginManager->loadPlugin($plugin['name']);
                  }
              }
              
              $menus = \App\Models\Menu::where('is_active', true)
                      ->whereNull('parent_id')
                      ->where(function($query) {
                          $query->where('type', 'admin')
                                ->orWhereNull('type');
                      })
                      ->with('children')
                      ->orderBy('order')
                      ->get();
              
              // Debug: Log jumlah menu
              
              // Debug: Log user info and plugin info
              $currentUser = auth()->user();
              foreach($allPlugins as $plugin) {
              }
          ?>
          
          <?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <?php if(empty($menu->roles) || (auth()->user() && auth()->user()->role && in_array(auth()->user()->role->name, $menu->roles))): ?>
                  <?php
                      $routeExists = Route::has($menu->route);
                      $pluginActive = $menu->plugin_name ? app(App\Services\PluginManager::class)->isPluginActive($menu->plugin_name) : false;
                      $shouldDisplay = !$menu->route || ($routeExists || ($menu->plugin_name && $pluginActive));
                      
                  ?>
                  <?php if(!$menu->route || (in_array($menu->route, array_keys(app('router')->getRoutes()->getRoutesByName())) || ($menu->plugin_name && app(App\Services\PluginManager::class)->isPluginActive($menu->plugin_name)))): ?>
                      <?php if($menu->children->count() > 0): ?>
                          <!-- Menu with submenu -->
                          <?php
                              $isAnyChildActive = false;
                              foreach($menu->children as $submenu) {
                                  if(in_array($submenu->route, array_keys(app('router')->getRoutes()->getRoutesByName())) && request()->routeIs($submenu->route)) {
                                      $isAnyChildActive = true;
                                      break;
                                  }
                              }
                              $menuIsActive = request()->routeIs($menu->route) || $isAnyChildActive;
                          ?>
                          <li class="nav-item has-treeview <?php echo e($menuIsActive ? 'menu-open' : ''); ?>">
                              <a href="#" class="nav-link <?php echo e($menuIsActive ? 'active' : ''); ?>">
                                  <i class="nav-icon <?php echo e($menu->icon); ?>"></i>
                                  <p>
                                      <?php echo e($menu->title); ?>

                                      <i class="right fas fa-angle-left"></i>
                                  </p>
                              </a>
                              <ul class="nav nav-treeview">
                                  <?php $__currentLoopData = $menu->children->sortBy('order'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <!-- Menambahkan sortBy('order') -->
                                      <?php if(empty($submenu->roles) || (auth()->user() && auth()->user()->role && in_array(auth()->user()->role->name, $submenu->roles))): ?>
                                          <?php if(Route::has($submenu->route) && (!$submenu->plugin_name || (app(App\Services\PluginManager::class)->isPluginActive($submenu->plugin_name)))): ?>
                                              <li class="nav-item">
                                                  <?php
                                                      $submenuUrl = '#';
                                                      if($submenu->route) {
                                                          if(in_array($submenu->route, array_keys(app('router')->getRoutes()->getRoutesByName()))) {
                                                              $submenuUrl = route($submenu->route);
                                                          } else if($submenu->plugin_name) {
                                                              // Jika route tidak ditemukan tapi ini adalah menu plugin, 
                                                              // kita buat URL berdasarkan konvensi plugin
                                                              $routeName = $submenu->route;
                                                              if(preg_match('/^panel\.([^.]+)\.index$/', $routeName, $matches)) {
                                                                  $submenuUrl = url('/panel/' . $matches[1]);
                                                              } else if(preg_match('/^panel\.([^.]+)\.(.+)$/', $routeName, $matches)) {
                                                                  $submenuUrl = url('/panel/' . $matches[1]);
                                                              } else {
                                                                  $submenuUrl = '#';
                                                              }
                                                          }
                                                      }
                                                      $submenuActive = in_array($submenu->route, array_keys(app('router')->getRoutes()->getRoutesByName())) ? request()->routeIs($submenu->route) : false;
                                                  ?>
                                                  <a href="<?php echo e($submenuUrl); ?>" class="nav-link <?php echo e($submenuActive ? 'active' : ''); ?>">
                                                      <i class="far fa-circle nav-icon"></i>
                                                      <p><?php echo e($submenu->title); ?></p>
                                                  </a>
                                              </li>
                                          <?php endif; ?>
                                      <?php endif; ?>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </ul>
                          </li>
                      <?php else: ?>
                          <!-- Menu without submenu -->
                          <li class="nav-item">
                              <?php if($menu->route): ?>
                                  <?php
                                      $isActive = in_array($menu->route, array_keys(app('router')->getRoutes()->getRoutesByName())) ? request()->routeIs($menu->route) : false;
                                      $isParentActive = false;
                                      
                                      // Check if this menu has submenu and any of them is active
                                      if($menu->children->count() > 0) {
                                          foreach($menu->children as $submenu) {
                                              if(in_array($submenu->route, array_keys(app('router')->getRoutes()->getRoutesByName())) && request()->routeIs($submenu->route)) {
                                                  $isParentActive = true;
                                                  break;
                                              }
                                          }
                                      }
                                      
                                      $activeClass = ($isActive || $isParentActive) ? 'active' : '';
                                  ?>
                                  <?php
                                      $menuUrl = '#';
                                      if($menu->route) {
                                          if(in_array($menu->route, array_keys(app('router')->getRoutes()->getRoutesByName()))) {
                                              $menuUrl = route($menu->route);
                                          } else if($menu->plugin_name) {
                                              // Jika route tidak ditemukan tapi ini adalah menu plugin, 
                                              // kita buat URL berdasarkan konvensi plugin
                                              $routeName = $menu->route;
                                              // Contoh: panel.contohplugin.index -> /panel/contohplugin
                                              if(preg_match('/^panel\.([^.]+)\.index$/', $routeName, $matches)) {
                                                  $menuUrl = url('/panel/' . $matches[1]);
                                              } else if(preg_match('/^panel\.([^.]+)\.(.+)$/', $routeName, $matches)) {
                                                  $menuUrl = url('/panel/' . $matches[1]);
                                              } else {
                                                  $menuUrl = '#';
                                              }
                                          }
                                      }
                                      $menuActive = in_array($menu->route, array_keys(app('router')->getRoutes()->getRoutesByName())) ? request()->routeIs($menu->route) : false;
                                  ?>
                                  <a href="<?php echo e($menuUrl); ?>" class="nav-link <?php echo e($menuActive ? 'active' : ''); ?>">
                              <?php else: ?>
                                  <a href="<?php echo e($menu->url); ?>" class="nav-link">
                              <?php endif; ?>
                                  <i class="nav-icon <?php echo e($menu->icon); ?>"></i>
                                  <p><?php echo e($menu->title); ?></p>
                              </a>
                          </li>
                      <?php endif; ?>
                  <?php endif; ?>
              <?php endif; ?>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          
          <?php
              $isUsersActive = request()->routeIs('users.*');
              $isRolesActive = request()->routeIs('roles.*');
              $isUserMenuActive = $isUsersActive || $isRolesActive;
          ?>
          
          <?php
              $isUsersActive = request()->routeIs('users.*');
          ?>
          <li class="nav-item has-treeview <?php echo e($isUserMenuActive ? 'menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e($isUserMenuActive ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Pengguna
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo e(route('users.index')); ?>" class="nav-link <?php echo e($isUsersActive ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Manajemen Pengguna</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('roles.index')); ?>" class="nav-link <?php echo e($isRolesActive ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Manajemen Peran</p>
                </a>
              </li>
            </ul>
          </li>
          
          <?php
              $isThemesActive = request()->routeIs('themes.*');
              $isPluginsActive = request()->routeIs('plugins.*');
              $isMenusActive = request()->routeIs('menus.*');
              $isSettingsActive = request()->routeIs('setting.*');
              $isUpdateActive = request()->is('panel/update');
              $isSettingsMenuActive = $isThemesActive || $isPluginsActive || $isMenusActive || $isSettingsActive || $isUpdateActive;
          ?>
		  
		  
          <!--Statis Menu Pengaturan menu with submenu -->
          <li class="nav-item has-treeview <?php echo e($isSettingsMenuActive ? 'menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e($isSettingsMenuActive ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-cog"></i>
              <p>
                Pengaturan
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo e(route('themes.index')); ?>" class="nav-link <?php echo e($isThemesActive ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tema</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('plugins.index')); ?>" class="nav-link <?php echo e($isPluginsActive ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Plugin</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('menus.index')); ?>" class="nav-link <?php echo e($isMenusActive ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Menu</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('panel.widgets.index')); ?>" class="nav-link <?php echo e($isMenusActive ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Widgets</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('setting.index')); ?>" class="nav-link <?php echo e($isSettingsActive ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Setting</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(url('/panel/update')); ?>" class="nav-link <?php echo e($isUpdateActive ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Update</p>
                </a>
              </li>
            </ul>
          </li>
          
          <li class="nav-item">
            <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Logout
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><?php echo $__env->yieldContent('page_title', 'Dashboard'); ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo e(url('/panel/dashboard')); ?>">Home</a></li>
              <li class="breadcrumb-item active"><?php echo $__env->yieldContent('page_title', 'Dashboard'); ?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <?php echo $__env->yieldContent('content'); ?>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2025 <a href="https://stellocms.com" target="_blank"><?php echo e(cms_name()); ?></a>.</strong> All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> <?php echo e(config('app.version')); ?>

    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<!-- Sparkline -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sparklines/2.1.2/sparkline.min.js"></script>
<!-- JQVMap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqvmap/1.5.1/jquery.vmap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqvmap/1.5.1/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Knob/1.2.13/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js"></script>
<!-- Tempus Dominus Bootstrap 4 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.2/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.0/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<!-- <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/js/demo.js"></script> -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/js/pages/dashboard.js"></script> -->

<script>
// Wait for document ready and adminLTE initialization
$(document).ready(function() {
    // Small delay to ensure all AdminLTE components are initialized
    setTimeout(function() {
        // Fix for overlay scrollbars that might overlay clickable elements
        // This targets the overlay scrollbars that could interfere with clicks
        
        // Check if overlay scrollbars are active and causing issues
        $('.os-scrollbar').each(function() {
            // Reduce potential z-index conflicts
            if ($(this).css('z-index') > 1000) {
                $(this).css('z-index', 'auto');
            }
        });

        // Also check for any .os-overlay elements 
        $('.os-overlay').each(function() {
            $(this).css({
                'pointer-events': 'none',
                'z-index': 'auto'
            });
        });

        // Ensure wrapper does not have problematic styling
        $('.wrapper').css('transform', 'none');
    }, 500); // Delay to ensure initialization
});

// Alternative fix in case jQuery approach doesn't work initially
document.addEventListener('DOMContentLoaded', function() {
    // Check for overlay scrollbars overlay elements
    setTimeout(function() {
        // Look for overlay scrollbar overlays and adjust if needed
        const elements = document.querySelectorAll('.os-scrollbar, .os-scrollbar-corner, .os-overlay');
        elements.forEach(element => {
            if (element && element.style) {
                // Adjust z-index to prevent overlays from blocking interaction
                if (parseInt(window.getComputedStyle(element).zIndex) > 1000) {
                    element.style.zIndex = 'auto';
                }
                // If these elements are blocking interaction, make them transparent to clicks
                element.style.pointerEvents = 'none';
            }
        });
    }, 1000);
});
</script>

<?php echo $__env->yieldContent('scripts'); ?>
</body>
</html>
<?php /**PATH D:\htdocs\stelloCMS\app\Themes\admin\adminlte\layouts\app.blade.php ENDPATH**/ ?>
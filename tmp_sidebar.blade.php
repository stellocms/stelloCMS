<!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          @php
              $isDashboardActive = request()->routeIs('panel.dashboard');
          @endphp
          <li class="nav-item">
            <a href="{{ url('/panel/dashboard') }}" class="nav-link {{ $isDashboardActive ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

          <!-- Dynamic menu items from database -->
          @php
              $menus = \App\Models\Menu::where('is_active', true)
                      ->whereNull('parent_id')
                      ->where(function($query) {
                          $query->where('type', 'admin')
                                ->orWhereNull('type');
                      })
                      ->with('children')
                      ->orderBy('order')
                      ->get();
          @endphp

          @foreach($menus as $menu)
              @if(empty($menu->roles) || (auth()->user() && auth()->user()->role && in_array(auth()->user()->role->name, $menu->roles)))
                  @if(!$menu->route || (Route::has($menu->route) && (!$menu->plugin_name || (app(App\Services\PluginManager::class)->isPluginActive($menu->plugin_name)))))
                      @if($menu->children->count() > 0)
                          <!-- Menu with submenu -->
                          @php
                              $isAnyChildActive = false;
                              foreach($menu->children as $submenu) {
                                  if(request()->routeIs($submenu->route)) {
                                      $isAnyChildActive = true;
                                      break;
                                  }
                              }
                              $menuIsActive = request()->routeIs($menu->route) || $isAnyChildActive;
                          @endphp
                          <li class="nav-item has-treeview {{ $menuIsActive ? 'menu-open' : '' }}">
                              <a href="#" class="nav-link {{ $menuIsActive ? 'active' : '' }}">
                                  <i class="nav-icon {{ $menu->icon }}"></i>
                                  <p>
                                      {{ $menu->title }}
                                      <i class="right fas fa-angle-left"></i>
                                  </p>
                              </a>
                              <ul class="nav nav-treeview">
                                  @foreach($menu->children->sortBy('order') as $submenu) <!-- Menambahkan sortBy('order') -->
                                      @if(empty($submenu->roles) || (auth()->user() && auth()->user()->role && in_array(auth()->user()->role->name, $submenu->roles)))
                                          @if(Route::has($submenu->route) && (!$submenu->plugin_name || (app(App\Services\PluginManager::class)->isPluginActive($submenu->plugin_name))))
                                              <li class="nav-item">
                                                  <a href="{{ route($submenu->route) }}" class="nav-link {{ request()->routeIs($submenu->route) ? 'active' : '' }}">
                                                      <i class="far fa-circle nav-icon"></i>
                                                      <p>{{ $submenu->title }}</p>
                                                  </a>
                                              </li>
                                          @endif
                                      @endif
                                  @endforeach
                              </ul>
                          </li>
                      @else
                          <!-- Menu without submenu -->
                          <li class="nav-item">
                              @if($menu->route)
                                  @php
                                      $isActive = request()->routeIs($menu->route);
                                      $isParentActive = false;

                                      // Check if this menu has submenu and any of them is active
                                      if($menu->children->count() > 0) {
                                          foreach($menu->children as $submenu) {
                                              if(request()->routeIs($submenu->route)) {
                                                  $isParentActive = true;
                                                  break;
                                              }
                                          }
                                      }

                                      $activeClass = ($isActive || $isParentActive) ? 'active' : '';
                                  @endphp
                                  <a href="{{ route($menu->route) }}" class="nav-link {{ $activeClass }}">
                              @else
                                  <a href="{{ $menu->url }}" class="nav-link">
                              @endif
                                  <i class="nav-icon {{ $menu->icon }}"></i>
                                  <p>{{ $menu->title }}</p>
                              </a>
                          </li>
                      @endif
                  @endif
              @endif
          @endforeach

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
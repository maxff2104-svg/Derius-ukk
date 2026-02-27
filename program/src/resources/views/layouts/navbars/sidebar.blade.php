<div class="sidebar" data-color="blue">
  <!-- Sistem Pengaduan Sarana Sekolah - Sidebar Navigation -->
  <div class="logo">
    @php
      $dashboardRoute = auth()->check()
        ? (auth()->user()->role === 'admin' ? route('admin.dashboard') : (auth()->user()->role === 'siswa' ? route('siswa.dashboard') : route('login')))
        : route('login');
    @endphp
    <a href="{{ $dashboardRoute }}" class="simple-text logo-mini">
      {{ __('PS') }}
    </a>
    <a href="{{ $dashboardRoute }}" class="simple-text logo-normal">
      {{ __('Pengaduan Sarana') }}
    </a>
  </div>
  <div class="sidebar-wrapper" id="sidebar-wrapper">
    <ul class="nav">
      <!-- ADMIN MENU: Show only if user is logged in with admin role -->
      @auth
        @if (auth()->user() && auth()->user()->role === 'admin')
          <li class="nav-section">
            <span class="sidebar-mini-icon">
              <i class="now-ui-icons business_badge"></i>
            </span>
            <span class="sidebar-normal">{{ __('Admin') }}</span>
          </li>
          
          <li class="@if (request()->routeIs('admin.dashboard')) active @endif">
            <a href="{{ route('admin.dashboard') }}">
              <i class="now-ui-icons design_app"></i>
              <p>{{ __('Dashboard') }}</p>
            </a>
          </li>
          
          <li class="@if (request()->routeIs('admin.aspirasi.*')) active @endif">
            <a href="{{ route('admin.aspirasi.index') }}">
              <i class="now-ui-icons education_atom"></i>
              <p>{{ __('Daftar Aspirasi') }}</p>
            </a>
          </li>

          <li class="@if (request()->routeIs('admin.kategori.*')) active @endif">
            <a href="{{ route('admin.kategori.index') }}">
              <i class="now-ui-icons objects_diamond"></i>
              <p>{{ __('Kategori') }}</p>
            </a>
          </li>

          <li class="@if (request()->routeIs('admin.users.*')) active @endif">
            <a href="{{ route('admin.users.index') }}">
              <i class="now-ui-icons users_circle-08"></i>
              <p>{{ __('Manajemen User') }}</p>
            </a>
          </li>
          
          <li class="@if (request()->routeIs('admin.activity-log.*')) active @endif">
            <a href="{{ route('admin.activity-log.index') }}">
              <i class="now-ui-icons business_badge"></i>
              <p>{{ __('Activity Log') }}</p>
            </a>
          </li>

          <li>
            <a data-toggle="collapse" href="#adminMore" aria-expanded="false">
              <i class="now-ui-icons ui-1_settings-gear-63"></i>
              <p>
                {{ __('Lainnya') }}
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="adminMore">
              <ul class="nav">
                <li class="@if (request()->routeIs('profile.edit')) active @endif">
                  <a href="{{ route('profile.edit') }}">
                    <i class="now-ui-icons users_single-02"></i>
                    <p>{{ __('Profil Saya') }}</p>
                  </a>
                </li>
                <li>
                  <a href="{{ route('logout') }}"
                     onclick="event.preventDefault(); document.getElementById('logout-form-admin').submit();">
                    <i class="now-ui-icons media-1_button-power"></i>
                    <p>{{ __('Logout') }}</p>
                  </a>
                  <form id="logout-form-admin" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                  </form>
                </li>
              </ul>
            </div>
          </li>

        <!-- SISWA MENU: Show only if user is logged in with siswa role -->
        @elseif (auth()->user() && auth()->user()->role === 'siswa')
          <li class="nav-section">
            <span class="sidebar-mini-icon">
              <i class="now-ui-icons users_single-02"></i>
            </span>
            <span class="sidebar-normal">{{ __('Siswa') }}</span>
          </li>

          <li class="@if (request()->routeIs('siswa.dashboard')) active @endif">
            <a href="{{ route('siswa.dashboard') }}">
              <i class="now-ui-icons design_app"></i>
              <p>{{ __('Dashboard') }}</p>
            </a>
          </li>

          <li class="@if (request()->routeIs('siswa.aspirasi.*')) active @endif">
            <a href="{{ route('siswa.aspirasi.index') }}">
              <i class="now-ui-icons education_atom"></i>
              <p>{{ __('Aspirasi Saya') }}</p>
            </a>
          </li>
          
          <li class="@if (request()->routeIs('siswa.notifikasi.*')) active @endif">
            <a href="{{ route('siswa.notifikasi.index') }}">
              <i class="now-ui-icons ui-1_bell-53"></i>
              <p>{{ __('Notifikasi') }}</p>
              @if(!empty($notificationCount) && $notificationCount > 0)
                <span class="badge badge-danger">{{ $notificationCount }}</span>
              @endif
            </a>
          </li>

          <li class="@if (request()->routeIs('siswa.activity-log.*')) active @endif">
            <a href="{{ route('siswa.activity-log.index') }}">
              <i class="now-ui-icons business_badge"></i>
              <p>{{ __('Activity Log') }}</p>
            </a>
          </li>

          <li>
            <a data-toggle="collapse" href="#siswaMore" aria-expanded="false">
              <i class="now-ui-icons ui-1_settings-gear-63"></i>
              <p>
                {{ __('Lainnya') }}
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="siswaMore">
              <ul class="nav">

                {{-- Profil Saya --}}
                <li class="@if (request()->routeIs('profile.edit')) active @endif">
                  <a href="{{ route('profile.edit') }}">
                    <i class="now-ui-icons users_single-02"></i>
                    <p>{{ __('Profil Saya') }}</p>
                  </a>
                </li>

                {{-- Logout --}}
                <li>
                  <a href="{{ route('logout') }}"
                     onclick="event.preventDefault(); document.getElementById('logout-form-siswa').submit();">
                    <i class="now-ui-icons media-1_button-power"></i>
                    <p>{{ __('Logout') }}</p>
                  </a>
                  <form id="logout-form-siswa" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                  </form>
                </li>

              </ul>
            </div>
          </li>
        @endif
      @endauth
    </ul>
  </div>

  <!-- Footer dengan Logout -->
  @auth
    <div class="sidebar-background" style="margin-top: auto; padding-top: 30px; border-top: 1px solid rgb #007bff)">
      <ul class="nav">
        <li>
          <a href="{{ route('logout') }}"
             onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
             style="color: #007bff">
            <i class="now-ui-icons arrows-1_share-66"></i>
            <p>{{ __('Logout') }}</p>
          </a>
        </li>
      </ul>
    </div>
  @endauth
</div>

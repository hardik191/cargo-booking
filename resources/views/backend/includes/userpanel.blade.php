  @php
      $user_details = Auth()->user();
    //   ccd($user_details);
      //    echo $user_details['name']; die();

      if ($user_details['user_image'] != '' || $user_details['user_image'] != null) {
            $image = asset('storage/uploads/userprofile/' . $user_details->user_image);
      } else {
          $image = url('backend/upload/userprofile/default.jpg');
      }
      $roles = Auth::user()->getRoleNames();
  @endphp
  <!--begin::User menu-->
  <div class="app-navbar-item ms-1 ms-md-4" id="kt_header_user_menu_toggle">
      <!--begin::Menu wrapper-->
      <div class="d-flex align-items-center cursor-pointer symbol symbol-35px"
      data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
      data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">

     <img src="{{ $image }}" class="rounded-3" alt="user" />

     <div class="ms-2"> <!-- Add margin for spacing -->
         <span>{{ $user_details['name'] }}</span><br />
         <small>({{ $roles[0] }})</small> <!-- Display roles next to the image -->
     </div>
 </div>
      <!--begin::User account menu-->
      <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
          data-kt-menu="true">
          <!--begin::Menu item-->
          <div class="menu-item px-3">
              <div class="menu-content d-flex align-items-center px-3">
                  <!--begin::Avatar-->
                  <div class="symbol symbol-50px me-5">
                      <img alt="Logo" src="{{ $image }}" />
                  </div>
                  <!--end::Avatar-->
                  <!--begin::Username-->
                  <div class="d-flex flex-column">
                      <div class="fw-bold d-flex align-items-center fs-5">{{ $user_details['name'] }}
                          {{-- <span
                            class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">Pro</span> --}}
                      </div>
                      <a href="#"
                          class="fw-semibold text-muted text-hover-primary fs-7">{{ $user_details['email'] }}</a>
                  </div>
                  <!--end::Username-->
              </div>
          </div>
          <!--end::Menu item-->
          <!--begin::Menu separator-->
          <div class="separator my-2"></div>
          <!--end::Menu separator-->
          <!--begin::Menu item-->
          {{-- @can('update profile') --}}
          <div class="menu-item px-5">
              <a href="{{ route('update-profile') }}" class="menu-link px-5">My Profile</a>
          </div>
          {{-- @endcan --}}

          @can('audit list')
            <div class="menu-item px-5">
                <a href="{{ route('audit') }}" class="menu-link px-5">Audit</a>
            </div>
          @endcan

            <div class="menu-item px-5">
                <a href="{{ route('change-password') }}" class="menu-link px-5">Change Password</a>
            </div>

          @can('setting system-setting')
            <div class="menu-item px-5">
                <a href="{{ route('system-setting') }}" class="menu-link px-5">System Setting</a>
            </div>
          @endcan
          <!--end::Menu item-->

          <!--begin::Menu item-->

            <div class="menu-item px-5">
                <a href="{{route('logout')}}" class="menu-link px-5">Sign Out</a>
            </div>

          <!--end::Menu item-->
      </div>
      <!--end::User account menu-->
      <!--end::Menu wrapper-->
  </div>
  <!--end::User menu-->

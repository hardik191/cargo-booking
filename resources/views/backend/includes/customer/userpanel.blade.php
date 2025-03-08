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
  <div class="app-navbar-item ms-1 ms-md-4" id="kt_header_user_menu_toggle">
      <div class="d-flex align-items-center cursor-pointer symbol symbol-35px"
      data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
      data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">

     <img src="{{ $image }}" class="rounded-3" alt="user" />

     <div class="ms-2"> 
         <span>{{ $user_details['name'] }}</span><br />
         
         <small>({{ $roles[0] }})</small> 
     </div>
 </div>
      <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
          data-kt-menu="true">
          <div class="menu-item px-3">
              <div class="menu-content d-flex align-items-center px-3">
                  <div class="symbol symbol-50px me-5">
                      <img alt="Logo" src="{{ $image }}" />
                  </div>
                  <div class="d-flex flex-column">
                      <div class="fw-bold d-flex align-items-center fs-5">{{ $user_details['name'] }}
                          {{-- <span
                            class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">Pro</span> --}}
                      </div>
                      <a href="#"
                          class="fw-semibold text-muted text-hover-primary fs-7">{{ $user_details['email'] }}</a>
                  </div>
              </div>
          </div>
          <div class="separator my-2"></div>
          {{-- @can('update profile') --}}
          <div class="menu-item px-5">
              <a href="{{ route('update-profile') }}" class="menu-link px-5">My Profile</a>
          </div>
          {{-- @endcan --}}

            <div class="menu-item px-5">
                <a href="{{ route('change-password') }}" class="menu-link px-5">Change Password</a>
            </div>
    
            <div class="menu-item px-5">
                <a href="{{route('logout')}}" class="menu-link px-5">Sign Out</a>
            </div>

      </div>
  </div>

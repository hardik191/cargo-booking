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
    {{-- notifiction --}}
        <div class="app-navbar-item ms-1 ms-md-4">
            <div class="btn notification-btn-count btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end" id="kt_menu_item_wow">
                <i class="ki-duotone ki-notification-on" style="font-size: 30px;">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                    <span class="path4"></span>
                    <span class="path5"></span>
                </i>
                <span class="opacity-75 notification-count">
                    {{ count(auth()->user()->unreadNotifications) > 99 ? '99+' : count(auth()->user()->unreadNotifications) }}
                </span>
            </div>

            <div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" data-kt-menu="true" id="kt_menu_notifications">
                <div class="d-flex flex-column bgi-no-repeat rounded-top" style="background-image:url('{{asset('backend/media/misc/menu-header-bg.jpg')}}')">
                    <h3 class="text-white fw-semibold px-9 mt-10 mb-6">Notifications
                    {{-- <span class="fs-8 opacity-75 ps-3">{{count(auth()->user()->unreadNotifications)}}</span> --}}
                </h3>

                </div>
                <div class="tab-content">

                    @if(count(auth()->user()->notifications)>0)
                        <div class="scroll-y mh-325px my-5">
                            @foreach (auth()->user()->notifications as $notification)
                            {{-- @php
                                ccd($notification);
                            @endphp --}}
                                <div class="d-flex flex-stack py-4 onclick-read-notification {{$notification->read_at == null ? 'notification-unread' : '' }}   px-8" data-id="{{$notification->id}}" >
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-35px me-4">
                                            @if ($notification->type == 'App\Notifications\CreateIndentNotification')
                                                <span class="symbol-label bg-light-primary">
                                                    <svg fill="#000000" width="25px" height="25px" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><path d="m74 42a2 2 0 0 1 2 1.85v28.15a6 6 0 0 1 -5.78 6h-40.22a6 6 0 0 1 -6-5.78v-28.22a2 2 0 0 1 1.85-2zm-15.5 8.34-.12.1-11.45 12.41-5.2-5a1.51 1.51 0 0 0 -2-.1l-.11.1-2.14 1.92a1.2 1.2 0 0 0 -.1 1.81l.1.11 7.33 6.94a3.07 3.07 0 0 0 2.14.89 2.81 2.81 0 0 0 2.13-.89l5.92-6.29.43-.44.42-.45.55-.58.21-.22.42-.44 5.62-5.93a1.54 1.54 0 0 0 .08-1.82l-.08-.1-2.14-1.92a1.51 1.51 0 0 0 -2.01-.1zm15.5-28.34a6 6 0 0 1 6 6v6a2 2 0 0 1 -2 2h-56a2 2 0 0 1 -2-2v-6a6 6 0 0 1 6-6z"/></svg>
                                                </span>
                                            @elseif ($notification->type == 'App\Notifications\PlantHeadUpdateNotification')
                                                <span class="symbol-label bg-light-primary">
                                                    <svg fill="#000000" width="25px" height="25px" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><path d="m74 42a2 2 0 0 1 2 1.85v28.15a6 6 0 0 1 -5.78 6h-40.22a6 6 0 0 1 -6-5.78v-28.22a2 2 0 0 1 1.85-2zm-15.5 8.34-.12.1-11.45 12.41-5.2-5a1.51 1.51 0 0 0 -2-.1l-.11.1-2.14 1.92a1.2 1.2 0 0 0 -.1 1.81l.1.11 7.33 6.94a3.07 3.07 0 0 0 2.14.89 2.81 2.81 0 0 0 2.13-.89l5.92-6.29.43-.44.42-.45.55-.58.21-.22.42-.44 5.62-5.93a1.54 1.54 0 0 0 .08-1.82l-.08-.1-2.14-1.92a1.51 1.51 0 0 0 -2.01-.1zm15.5-28.34a6 6 0 0 1 6 6v6a2 2 0 0 1 -2 2h-56a2 2 0 0 1 -2-2v-6a6 6 0 0 1 6-6z"/></svg>
                                                </span>
                                            @elseif ($notification->type == 'App\Notifications\StoreManagerUpdateNotification')
                                                <span class="symbol-label bg-light-primary">
                                                    <svg fill="#000000" width="25px" height="25px" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><path d="m74 42a2 2 0 0 1 2 1.85v28.15a6 6 0 0 1 -5.78 6h-40.22a6 6 0 0 1 -6-5.78v-28.22a2 2 0 0 1 1.85-2zm-15.5 8.34-.12.1-11.45 12.41-5.2-5a1.51 1.51 0 0 0 -2-.1l-.11.1-2.14 1.92a1.2 1.2 0 0 0 -.1 1.81l.1.11 7.33 6.94a3.07 3.07 0 0 0 2.14.89 2.81 2.81 0 0 0 2.13-.89l5.92-6.29.43-.44.42-.45.55-.58.21-.22.42-.44 5.62-5.93a1.54 1.54 0 0 0 .08-1.82l-.08-.1-2.14-1.92a1.51 1.51 0 0 0 -2.01-.1zm15.5-28.34a6 6 0 0 1 6 6v6a2 2 0 0 1 -2 2h-56a2 2 0 0 1 -2-2v-6a6 6 0 0 1 6-6z"/></svg>
                                                </span>
                                            @endif

                                        </div>
                                        <div class="mb-0 me-2">
                                            @php
                                                if(isset($notification->data['route'])){
                                                    if(isset($notification->data['parameter']) && !empty($notification->data['parameter'])){
                                                        $redirect_route = route($notification->data['route'], $notification->data['parameter']);
                                                    } else {
                                                        $redirect_route = route($notification->data['route']);
                                                    }
                                                }else{
                                                    $redirect_route = 'javascript:;';
                                                }
                                            @endphp
                                            <a href="{{$redirect_route}}" class="fs-6 text-gray-800 text-hover-primary fw-bold">
                                                @if ($notification->type == 'App\Notifications\CreateIndentNotification')
                                                    Indent Create
                                                @elseif ($notification->type == 'App\Notifications\PlantHeadUpdateNotification')
                                                    Plant Head Update Indent
                                                @elseif ($notification->type == 'App\Notifications\StoreManagerUpdateNotification')
                                                    Store Manager Update Indent
                                                @endif
                                                <span class="badge {{ $notification->read_at == null ? 'badge-light' : 'badge-secondary' }} fs-8">{{date_formate($notification->created_at)}}</span>

                                            <div class="text-gray-500 fs-7">  {!! $notification->data['message'] !!}</div>
                                        </a>
                                        </div>
                                    </div>

                                </div>
                            @endforeach
                        </div>

                        @else
                        <div class="d-flex flex-column px-9">

                            <div class="pt-10 pb-0">

                                <h3 class="text-gray-900 text-center fw-bold">No Notifications Yet</h3>

                                <div class="text-center text-gray-600 fw-semibold pt-1">You have no notifications right now. <br>Come back later.</div>

                            </div>
                            <div class="text-center px-4">
                                <img class="mw-100 mh-200px" alt="image" src="{{asset('backend/media/misc/notification.png')}}">
                            </div>
                        </div>
                        @endif


                </div>
            </div>
        </div>
    {{-- end notifiction --}}

<div class="app-navbar-item ms-1 ms-md-4" id="kt_header_user_menu_toggle">
    <div class="d-flex align-items-center cursor-pointer symbol symbol-35px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">

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

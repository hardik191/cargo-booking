<!--begin::Toolbar-->
<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <!--begin::Toolbar container-->

    <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <!--begin::Title-->
            <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">{{ $header['title'] }}</h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">

                @php
                    $count = count($header['breadcrumb']);
                    $temp = 1;
                @endphp
                @foreach($header['breadcrumb'] as $key => $value)

                    @php
                        $value = (empty($value)) ? 'javascript:;' : $value;
                    @endphp

                    @if($temp!=$count)

                        <li class="breadcrumb-item text-muted">
                            <a href="{{ $value }}" class="text-muted text-hover-primary">
                                @if($temp == 1)
                                    <i class="fs-1x fa fa-home me-3"></i>{{ $key }}
                                @else
                                    {{ $key }}
                                @endif
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                    @else

                        <li class="breadcrumb-item">{{ $key }}</li>

                    @endif

                    @php
                        $temp = $temp+1;
                    @endphp
                @endforeach
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="d-flex align-items-center gap-2 gap-lg-3">
            <!--begin::Filter menu-->
            <div class="m-0">
                <!--begin::Menu toggle-->

                <!--end::Menu toggle-->
                <!--begin::Menu 1-->

                <!--end::Menu 1-->
            </div>
            <!--end::Filter menu-->
            <!--begin::Secondary button-->
            <!--end::Secondary button-->
            <!--begin::Primary button-->
            <!--end::Primary button-->
        </div>
        <!--end::Actions-->
    </div>
    <!--end::Toolbar container-->
</div>

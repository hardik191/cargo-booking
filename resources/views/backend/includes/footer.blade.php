 <!--begin::Javascript-->
 <script>
    var defaultThemeMode = "light";
    var themeMode;
    if (document.documentElement) {
        if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
            themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
        } else {
            if (localStorage.getItem("data-bs-theme") !== null) {
                themeMode = localStorage.getItem("data-bs-theme");
            } else {
                themeMode = defaultThemeMode;
            }
        }
        if (themeMode === "system") {
            themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
        }
        document.documentElement.setAttribute("data-bs-theme", themeMode);
    }
</script>

 <script>
    var hostUrl = "{{ asset('/') }}";
    var baseurl = "{{ asset('/') }}";
</script>

<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="{{ asset('backend/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('backend/js/scripts.bundle.js') }}"></script>

@if (!empty($pluginjs))
    @foreach ($pluginjs as $value)
        <script src="{{ asset('backend/js/'.$value) }}" type="text/javascript"></script>
    @endforeach
@endif

@if (!empty($widgetjs))
    @foreach ($widgetjs as $value)
        <script src="{{ asset('backend/'.$value) }}" type="text/javascript"></script>
    @endforeach
@endif

@if (!empty($js))
@foreach ($js as $value)
    <script src="{{ asset('backend/js/customjs/'.$value) }}" type="text/javascript"></script>
@endforeach
@endif
<script type="text/javascript">
    jQuery(document).ready(function () {
        $('#loader').show();
        $('#loader').fadeOut(2000);
    });
    </script>

<script>

    jQuery(document).ready(function () {
        @if (!empty($funinit))
                @foreach ($funinit as $value)
                    {{  $value }}
                @endforeach
        @endif
    });
</script>

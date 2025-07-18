@include('partials.header')
<main class="py-4">
    {{-- <div class="extra-side-bar col-md-9">
        @include('partials.messages')
    </div> --}}
    <div class="main-bar">
        @include('partials.navbar')
        @yield('content')
    </div>
</main>
</div>

<script src="{{asset('/resources/assets/js/core/popper.min.js')}}"></script>
<script src="{{asset('/resources/assets/js/core/bootstrap.min.js')}}"></script>
<script src="{{asset('/resources/assets/js/plugins/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('/resources/assets/js/plugins/smooth-scrollbar.min.js')}}"></script>
<script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
            damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
</script>

<script>
    function updateFavicon() {
        const isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        const favicon = document.getElementById('favicon');

        if (favicon) {
            favicon.href = isDark ? '/favicon-dark.png' : '/favicon-light.png';
        }
    }

    // Run on page load
    updateFavicon();

    // Listen for changes in theme
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', updateFavicon);
</script>

{{-- Preloader --}}
<script>
    window.addEventListener('load', function () {
        const preloader = document.getElementById('page-preloader');
        if (preloader) {
            preloader.style.display = 'none';
        }
    });
</script>

{{-- Full Calendar JS --}}

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: '/events-feed',
            eventClick: function (info) {
                alert(
                    'Event: ' + info.event.title +
                    '\nDescription: ' + info.event.extendedProps.description +
                    '\nStarts: ' + info.event.start
                );
            }
        });

        calendar.render();
    });
</script>



<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
<script src="{{ asset('/resources/assets/js/soft-ui-dashboard.js')}}"></script>
<script src="{{ asset('/resources/assets/js/soft-ui-dashboard.min.js')}}"></script>

<script src="https://kit.fontawesome.com/ce9709e331.js" crossorigin="anonymous"></script>

<!-- jQuery (required by Toastr) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- FullCalendar JS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>


<script>
    @if(Session::has('success'))
        toastr.success("{{ Session::get('success') }}");
    @endif

    @if(Session::has('error'))
        toastr.error("{{ Session::get('error') }}");
    @endif

    @if(Session::has('info'))
        toastr.info("{{ Session::get('info') }}");
    @endif

    @if(Session::has('warning'))
        toastr.warning("{{ Session::get('warning') }}");
    @endif
</script>

</body>

</html>
@include('partials.header')
<main class="py-4">
    <div class="extra-side-bar col-md-9">
        @include('partials.messages')
    </div>
    <div>
        @yield('content')
    </div>
</main>
</div>

<script src="https://kit.fontawesome.com/ce9709e331.js" crossorigin="anonymous"></script>

{{-- Preloader --}}
<script>
    window.addEventListener('load', function () {
        const preloader = document.getElementById('page-preloader');
        if (preloader) {
            preloader.style.display = 'none';
        }
    });
</script>

{{-- Login button Preloader --}}
<script>
    const loginBtn = document.getElementById('login-btn');
    if (loginBtn) {
        loginBtn.closest('form').addEventListener('submit', function () {
            loginBtn.disabled = true;
            loginBtn.querySelector('.btn-text').textContent = 'Logging in...';
            loginBtn.querySelector('.spinner-border').classList.remove('d-none');
        });
    }
</script>


</body>

</html>
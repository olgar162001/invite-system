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
    
</body>
</html>
<!DOCTYPE html>
<html lang="en">

@include('layouts.home.header')

<body>
    @include('layouts.home.navbar')

    @yield('content')

    @include('layouts.home.footer')
</body>

</html>

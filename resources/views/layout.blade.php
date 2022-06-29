<!doctype html>
<html lang="en">
<head>
    @include('layout.head')
</head>
<body>

<header>
    @include('layout.header')
</header>

<main class="m-4">
    @yield('content')
</main>

<footer>
    @include('layout.footer')
</footer>

@include('layout.script')
@yield('js')

</body>
</html>

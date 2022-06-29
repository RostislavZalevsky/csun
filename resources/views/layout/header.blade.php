<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="{{ route('home') }}">CSUN</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="CSUN">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item @if (\Illuminate\Support\Facades\Request::routeIs('home')) active @endif">
                <a class="nav-link" href="{{ route('home') }}">Home @if (\Illuminate\Support\Facades\Request::routeIs('home')) <span class="sr-only">(current)</span> @endif</a>
            </li>
            <li class="nav-item @if (\Illuminate\Support\Facades\Request::routeIs('classes')) active @endif">
                <a class="nav-link" href="{{ route('classes') }}">Classes @if (\Illuminate\Support\Facades\Request::routeIs('home')) <span class="sr-only">(current)</span> @endif</a>
            </li>
        </ul>
    </div>
</nav>

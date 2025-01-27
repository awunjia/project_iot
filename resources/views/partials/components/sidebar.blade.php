<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link @if(Request::is('home')) active @else collapsed @endif" href="{{ route('home') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link @if(Request::is('devices.index')) active @else collapsed @endif" href="{{ route('devices.index') }}">
                <i class="bi bi-cpu"></i>
                <span>Devices</span>
            </a>
        </li><!-- End Devices Nav -->

        <li class="nav-item">
            <a class="nav-link @if(Request::is('sensors.index')) active @else collapsed @endif" href="{{ route('sensors.index') }}">
                <i class="bi bi-thermometer-half"></i>
                <span>Sensors</span>
            </a>
        </li><!-- End Sensors Nav -->


    </ul>

</aside><!-- End Sidebar-->
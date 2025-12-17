<aside class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        {{-- <div>
            <img src="{{ asset('assets/images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
        </div> --}}
        <div>
            <h4 class="logo-text">E-Voting</h4>
        </div>
        <div class="toggle-icon ms-auto"> <i class="bi bi-list"></i></div>
    </div>

    <!--navigation-->
    <ul class="metismenu" id="menu">

        {{-- DASHBOARD --}}
        <li>
            <a href="{{ route('dashboard') }}">
                <div class="parent-icon"><i class="bi bi-speedometer2"></i></div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>

        {{-- EVENT MANAGEMENT --}}
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-calendar-event-fill"></i></div>
                <div class="menu-title">Event</div>
            </a>
            <ul>
                <li><a href="{{ route('events.index') }}"><i class="bi bi-circle"></i>Daftar Event</a></li>
                <li><a href="{{ route('events.create') }}"><i class="bi bi-circle"></i>Buat Event Baru</a></li>
            </ul>
        </li>

        {{-- CANDIDATE --}}
        <li>
            <a href="{{ route('candidates.index') }}">
                <div class="parent-icon"><i class="bi bi-people-fill"></i></div>
                <div class="menu-title">Kandidat</div>
            </a>
        </li>

        {{-- VOTER TOKEN --}}
        <li>
            <a href="{{ route('voter-tokens.index') }}">
                <div class="parent-icon"><i class="bi bi-key-fill"></i></div>
                <div class="menu-title">Voter Token</div>
            </a>
        </li>

        {{-- VOTES / RESULT --}}
        <li>
            <a href="{{ route('votes.index') }}">
                <div class="parent-icon"><i class="bi bi-bar-chart-line-fill"></i></div>
                <div class="menu-title">Hasil Voting</div>
            </a>
        </li>

        {{-- SUBSCRIPTION --}}
        <li class="menu-label">Subscription</li>

        <li>
            <a href="{{ route('plans.index') }}">
                <div class="parent-icon"><i class="bi bi-gem"></i></div>
                <div class="menu-title">Daftar Paket</div>
            </a>
        </li>

        <li>
            <a href="{{ route('subscriptions.index') }}">
                <div class="parent-icon"><i class="bi bi-bag-check-fill"></i></div>
                <div class="menu-title">Langgananku</div>
            </a>
        </li>

        <li>
            <a href="{{ route('payments.index') }}">
                <div class="parent-icon"><i class="bi bi-cash-stack"></i></div>
                <div class="menu-title">Pembayaran</div>
            </a>
        </li>

        {{-- ADMIN ONLY --}}
        @if (auth()->user()->role === 'admin')
            <li class="menu-label">Admin</li>

            <li>
                <a href="{{ route('users.index') }}">
                    <div class="parent-icon"><i class="bi bi-person-badge-fill"></i></div>
                    <div class="menu-title">Users</div>
                </a>
            </li>

            <li>
                <a href="{{ route('plans.management') }}">
                    <div class="parent-icon"><i class="bi bi-sliders"></i></div>
                    <div class="menu-title">Kelola Paket</div>
                </a>
            </li>
        @endif

        {{-- SETTINGS --}}
        <li class="menu-label">Settings</li>

        <li>
            <a href="{{ route('profile.index') }}">
                <div class="parent-icon"><i class="bi bi-gear-fill"></i></div>
                <div class="menu-title">Pengaturan Akun</div>
            </a>
        </li>

        <li>
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <div class="parent-icon"><i class="bi bi-box-arrow-right"></i></div>
                <div class="menu-title">Logout</div>
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" hidden>
                @csrf
            </form>
        </li>

    </ul>
    <!--end navigation-->
</aside>

<aside class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <h4 class="logo-text">E-Voting</h4>
        <div class="toggle-icon ms-auto">
            <i class="bi bi-list"></i>
        </div>
    </div>

    <ul class="metismenu" id="menu">
        @if(auth()->user()->role === 'customer')

        {{-- DASHBOARD --}}
        <li>
            <a href="{{ route('dashboard') }}">
                <div class="parent-icon"><i class="bi bi-speedometer2"></i></div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>

        {{-- ================= CUSTOMER AREA ================= --}}
        <li class="menu-label">Event</li>

        <li>
            <a href="{{ route('events.index') }}">
                <div class="parent-icon"><i class="bi bi-calendar-event-fill"></i></div>
                <div class="menu-title">Event Saya</div>
            </a>
        </li>

        <li>
            <a href="{{ route('events.create') }}">
                <div class="parent-icon"><i class="bi bi-plus-circle-fill"></i></div>
                <div class="menu-title">Buat Event</div>
            </a>
        </li>

        <li>
            <a href="{{ route('candidates.index') }}">
                <div class="parent-icon"><i class="bi bi-people-fill"></i></div>
                <div class="menu-title">Kandidat</div>
            </a>
        </li>

        <li>
            <a href="{{ route('voter-tokens.index') }}">
                <div class="parent-icon"><i class="bi bi-key-fill"></i></div>
                <div class="menu-title">Token Pemilih</div>
            </a>
        </li>

        <li>
            <a href="{{ route('votes.index') }}">
                <div class="parent-icon"><i class="bi bi-bar-chart-fill"></i></div>
                <div class="menu-title">Hasil Voting</div>
            </a>
        </li>

        {{-- ================= SUBSCRIPTION ================= --}}
        <li class="menu-label">Subscription</li>

        <li>
            <a href="{{ route('plans.index') }}">
                <div class="parent-icon"><i class="bi bi-gem"></i></div>
                <div class="menu-title">Paket</div>
            </a>
        </li>

        <li>
            <a href="{{ route('subscriptions.index') }}">
                <div class="parent-icon"><i class="bi bi-bag-check-fill"></i></div>
                <div class="menu-title">Langganan Saya</div>
            </a>
        </li>

        <li>
            <a href="{{ route('payments.index') }}">
                <div class="parent-icon"><i class="bi bi-cash-stack"></i></div>
                <div class="menu-title">Pembayaran</div>
            </a>
        </li>
        @endif

        {{-- ================= ADMIN AREA ================= --}}
        @if(auth()->user()->role === 'admin')
            <li class="menu-label">Admin Panel</li>

            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <div class="parent-icon"><i class="bi bi-graph-up"></i></div>
                    <div class="menu-title">Dashboard Admin</div>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.events.index') }}">
                    <div class="parent-icon"><i class="bi bi-calendar2-week-fill"></i></div>
                    <div class="menu-title">Semua Event</div>
                </a>
            </li>

            <li>
                <a href="{{ route('candidates.admin.index') }}">
                    <div class="parent-icon"><i class="bi bi-people-fill"></i></div>
                    <div class="menu-title">Semua Kandidat</div>
                </a>
            </li>

            <li>
                <a href="">
                    <div class="parent-icon"><i class="bi bi-key-fill"></i></div>
                    <div class="menu-title">Semua Token</div>
                </a>
            </li>

            <li>
                <a href="">
                    <div class="parent-icon"><i class="bi bi-bar-chart-line-fill"></i></div>
                    <div class="menu-title">Rekap Voting</div>
                </a>
            </li>

            <li>
                <a href="">
                    <div class="parent-icon"><i class="bi bi-cash-coin"></i></div>
                    <div class="menu-title">Pembayaran (Midtrans)</div>
                </a>
            </li>

            <li>
                <a href="">
                    <div class="parent-icon"><i class="bi bi-journal-check"></i></div>
                    <div class="menu-title">Langganan User</div>
                </a>
            </li>

            <li>
                <a href="{{ route('subscription-plans.index') }}">
                    <div class="parent-icon"><i class="bi bi-sliders"></i></div>
                    <div class="menu-title">Kelola Paket</div>
                </a>
            </li>

            <li>
                <a href="{{ route('users.index') }}">
                    <div class="parent-icon"><i class="bi bi-people"></i></div>
                    <div class="menu-title">Manajemen User</div>
                </a>
            </li>
        @endif

        {{-- ================= ACCOUNT ================= --}}
        <li class="menu-label">Akun</li>

        <li>
            <a href="{{ route('profile.index') }}">
                <div class="parent-icon"><i class="bi bi-person-circle"></i></div>
                <div class="menu-title">Profil</div>
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
</aside>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Event - {{ $event->title }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
        }

        /* Header */
        .header {
            text-align: center;
            padding: 30px 0;
            border-bottom: 3px solid #0d6efd;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 24px;
            color: #0d6efd;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 14px;
            color: #666;
        }

        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 11px;
            margin: 15px 0;
        }

        .status-ended {
            background: #d1ecf1;
            color: #0c5460;
        }

        .status-active {
            background: #d4edda;
            color: #155724;
        }

        /* Info Section */
        .info-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .info-section h2 {
            font-size: 16px;
            color: #0d6efd;
            margin-bottom: 15px;
            border-bottom: 2px solid #0d6efd;
            padding-bottom: 8px;
        }

        .info-grid {
            display: table;
            width: 100%;
        }

        .info-row {
            display: table-row;
        }

        .info-label {
            display: table-cell;
            font-weight: bold;
            color: #666;
            padding: 8px 10px;
            width: 35%;
        }

        .info-value {
            display: table-cell;
            padding: 8px 10px;
        }

        /* Statistics Cards */
        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 25px;
        }

        .stats-row {
            display: table-row;
        }

        .stat-card {
            display: table-cell;
            text-align: center;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 8px;
            width: 25%;
        }

        .stat-card:nth-child(2) {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }

        .stat-card:nth-child(3) {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .stat-card:nth-child(4) {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .stat-number {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 11px;
            opacity: 0.9;
        }

        /* Candidate Table */
        .candidate-section {
            margin-bottom: 25px;
        }

        .candidate-section h2 {
            font-size: 16px;
            color: #0d6efd;
            margin-bottom: 15px;
            border-bottom: 2px solid #0d6efd;
            padding-bottom: 8px;
        }

        .candidate-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .candidate-table th {
            background: #0d6efd;
            color: white;
            padding: 12px 8px;
            text-align: left;
            font-size: 11px;
            font-weight: bold;
        }

        .candidate-table td {
            padding: 12px 8px;
            border-bottom: 1px solid #dee2e6;
        }

        .candidate-table tr:last-child td {
            border-bottom: none;
        }

        .candidate-table tr:hover {
            background: #f8f9fa;
        }

        .rank-badge {
            display: inline-block;
            background: #6c757d;
            color: white;
            padding: 4px 10px;
            border-radius: 12px;
            font-weight: bold;
            font-size: 10px;
        }

        .winner-badge {
            display: inline-block;
            background: #ffc107;
            color: #000;
            padding: 4px 10px;
            border-radius: 12px;
            font-weight: bold;
            font-size: 10px;
        }

        .progress-bar-container {
            width: 100%;
            height: 20px;
            background: #e9ecef;
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            background: #0d6efd;
            text-align: center;
            color: white;
            font-size: 10px;
            line-height: 20px;
            font-weight: bold;
        }

        .progress-bar.winner {
            background: #ffc107;
            color: #000;
        }

        /* Chart Section */
        .chart-section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }

        .chart-section h2 {
            font-size: 16px;
            color: #0d6efd;
            margin-bottom: 15px;
            border-bottom: 2px solid #0d6efd;
            padding-bottom: 8px;
        }

        .chart-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }

        .chart-item {
            display: table-cell;
            width: 50%;
            padding: 10px;
        }

        .chart-item img {
            width: 100%;
            height: auto;
            border: 1px solid #dee2e6;
            border-radius: 8px;
        }

        .chart-full {
            width: 100%;
            text-align: center;
            margin-top: 20px;
        }

        .chart-full img {
            width: 100%;
            max-width: 800px;
            height: auto;
            border: 1px solid #dee2e6;
            border-radius: 8px;
        }

        /* Footer */
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #dee2e6;
            text-align: center;
            color: #666;
            font-size: 10px;
        }

        /* Page Break */
        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>

    {{-- HEADER --}}
    <div class="header">
        <h1>LAPORAN REKAP EVENT VOTING</h1>
        <p>{{ $event->title }}</p>
        <div class="status-badge {{ $isEnded ? 'status-ended' : 'status-active' }}">
            {{ $isEnded ? 'EVENT SELESAI' : 'EVENT BERLANGSUNG' }}
        </div>
        <p style="margin-top: 10px; font-size: 11px;">
            Dicetak pada: {{ now()->format('d F Y, H:i') }} WIB
        </p>
    </div>

    {{-- INFORMASI EVENT --}}
    <div class="info-section">
        <h2>📋 Informasi Event</h2>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Judul Event:</div>
                <div class="info-value">{{ $event->title }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Penyelenggara:</div>
                <div class="info-value">{{ $event->owner->name }} ({{ $event->owner->email }})</div>
            </div>
            <div class="info-row">
                <div class="info-label">Waktu Mulai:</div>
                <div class="info-value">{{ $event->start_time->format('d F Y, H:i') }} WIB</div>
            </div>
            <div class="info-row">
                <div class="info-label">Waktu Selesai:</div>
                <div class="info-value">{{ $event->end_time->format('d F Y, H:i') }} WIB</div>
            </div>
            @if ($event->description)
                <div class="info-row">
                    <div class="info-label">Deskripsi:</div>
                    <div class="info-value">{{ $event->description }}</div>
                </div>
            @endif
        </div>
    </div>

    {{-- STATISTIK RINGKASAN --}}
    <div class="stats-grid">
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-number">{{ $totalVotes }}</div>
                <div class="stat-label">Total Suara Masuk</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $candidates->count() }}</div>
                <div class="stat-label">Jumlah Kandidat</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $winner?->votes_count ?? 0 }}</div>
                <div class="stat-label">Suara Tertinggi</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">
                    {{ $totalVotes > 0 ? number_format((($winner?->votes_count ?? 0) / $totalVotes) * 100, 1) : 0 }}%
                </div>
                <div class="stat-label">Persentase Pemenang</div>
            </div>
        </div>
    </div>

    {{-- DAFTAR KANDIDAT & PEROLEHAN SUARA --}}
    <div class="candidate-section">
        <h2>👥 Daftar Kandidat & Perolehan Suara</h2>
        <table class="candidate-table">
            <thead>
                <tr>
                    <th width="8%">Rank</th>
                    <th width="30%">Nama Kandidat</th>
                    <th width="15%">Suara</th>
                    <th width="12%">Persentase</th>
                    <th width="35%">Progress</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($candidates as $index => $candidate)
                    @php
                        $percentage = $totalVotes > 0 ? round(($candidate->votes_count / $totalVotes) * 100, 2) : 0;
                        $isWinner = $winner && $winner->id === $candidate->id;
                        $rank = $index + 1;
                    @endphp
                    <tr>
                        <td>
                            @if ($isWinner)
                                <span class="winner-badge">🏆 #{{ $rank }}</span>
                            @else
                                <span class="rank-badge">#{{ $rank }}</span>
                            @endif
                        </td>
                        <td><strong>{{ $candidate->name }}</strong></td>
                        <td><strong>{{ $candidate->votes_count }}</strong> suara</td>
                        <td><strong>{{ $percentage }}%</strong></td>
                        <td>
                            <div class="progress-bar-container">
                                <div class="progress-bar {{ $isWinner ? 'winner' : '' }}"
                                    style="width: {{ $percentage }}%">
                                    {{ $percentage }}%
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- PAGE BREAK --}}
    <div class="page-break"></div>

    {{-- GRAFIK VISUALISASI --}}
    <div class="chart-section">
        <h2>📊 Grafik Visualisasi Data</h2>

        <div class="chart-grid">
            <div class="chart-item">
                <h3 style="text-align: center; margin-bottom: 10px; font-size: 13px;">Distribusi Suara</h3>
                <img src="{{ $chartImages['pie'] }}" alt="Pie Chart">
            </div>
            <div class="chart-item">
                <h3 style="text-align: center; margin-bottom: 10px; font-size: 13px;">Perbandingan Kandidat</h3>
                <img src="{{ $chartImages['bar'] }}" alt="Bar Chart">
            </div>
        </div>

        <div class="chart-full">
            <h3 style="margin-bottom: 15px; font-size: 14px;">Timeline Perolehan Suara</h3>
            <img src="{{ $chartImages['line'] }}" alt="Line Chart">
        </div>
    </div>

    {{-- FOOTER --}}
    <div class="footer">
        <p>Dokumen ini dibuat secara otomatis oleh Sistem Voting</p>
        <p>© {{ now()->year }} - Semua hak dilindungi</p>
    </div>

</body>

</html>

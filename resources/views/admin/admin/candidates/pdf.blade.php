<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Kandidat - {{ $candidate->name }}</title>
    <style>
        @page {
            margin: 0;
            padding: 0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', 'Helvetica', Arial, sans-serif;
            font-size: 10pt;
            line-height: 1.6;
            color: #2c3e50;
            background: #ffffff;
        }

        .page {
            padding: 40px 50px;
        }

        /* Header */
        .header {
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 3px solid #1a1a1a;
        }

        .header-top {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }

        .header-left {
            display: table-cell;
            vertical-align: middle;
        }

        .header-right {
            display: table-cell;
            text-align: right;
            vertical-align: middle;
        }

        .doc-title {
            font-size: 24pt;
            font-weight: 700;
            color: #1a1a1a;
            letter-spacing: -0.5px;
            margin-bottom: 5px;
        }

        .doc-subtitle {
            font-size: 10pt;
            color: #7f8c8d;
            font-weight: 400;
        }

        .doc-number {
            font-size: 9pt;
            color: #95a5a6;
            margin-bottom: 3px;
        }

        .doc-date {
            font-size: 9pt;
            color: #7f8c8d;
        }

        /* Status Badge */
        .status-section {
            margin-bottom: 35px;
        }

        .status-badge {
            display: inline-block;
            padding: 10px 20px;
            font-size: 10pt;
            font-weight: 600;
            letter-spacing: 0.5px;
            border-radius: 4px;
        }

        .badge-winner {
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #10b981;
        }

        .badge-loser {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #ef4444;
        }

        .badge-ongoing {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #f59e0b;
        }

        /* Candidate Profile */
        .profile-section {
            margin-bottom: 35px;
            padding: 25px;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid #1a1a1a;
        }

        .profile-grid {
            display: table;
            width: 100%;
        }

        .profile-left {
            display: table-cell;
            width: 180px;
            vertical-align: top;
            text-align: center;
            padding-right: 25px;
        }

        .profile-right {
            display: table-cell;
            vertical-align: top;
        }

        .candidate-photo {
            width: 140px;
            height: 140px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #e5e7eb;
            margin-bottom: 10px;
        }

        .candidate-name {
            font-size: 18pt;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
            line-height: 1.2;
        }

        .candidate-desc {
            font-size: 9pt;
            color: #6b7280;
            font-style: italic;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        /* Stats Grid */
        .stats-grid {
            display: table;
            width: 100%;
            margin-top: 15px;
        }

        .stat-item {
            display: table-cell;
            width: 50%;
            padding: 15px;
            text-align: center;
            background: #ffffff;
            border-radius: 6px;
        }

        .stat-item:first-child {
            margin-right: 10px;
        }

        .stat-value {
            font-size: 28pt;
            font-weight: 700;
            color: #1a1a1a;
            line-height: 1;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 8pt;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }

        /* Section */
        .section {
            margin-bottom: 30px;
        }

        .section-header {
            font-size: 12pt;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #e5e7eb;
            letter-spacing: -0.3px;
        }

        /* Info Grid */
        .info-grid {
            display: table;
            width: 100%;
            border-collapse: collapse;
        }

        .info-row {
            display: table-row;
        }

        .info-label {
            display: table-cell;
            padding: 12px 15px;
            font-size: 9pt;
            color: #6b7280;
            font-weight: 600;
            width: 35%;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
        }

        .info-value {
            display: table-cell;
            padding: 12px 15px;
            font-size: 9pt;
            color: #1f2937;
            background: #ffffff;
            border: 1px solid #e5e7eb;
        }

        /* Progress Bar */
        .progress-container {
            background: #e5e7eb;
            height: 35px;
            border-radius: 6px;
            overflow: hidden;
            position: relative;
            margin-top: 10px;
        }

        .progress-fill {
            height: 100%;
            background: #1a1a1a;
            display: flex;
            align-items: center;
            padding-left: 15px;
            color: #ffffff;
            font-weight: 700;
            font-size: 10pt;
        }

        /* Table */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .data-table thead th {
            padding: 12px 10px;
            text-align: center;
            font-size: 9pt;
            font-weight: 700;
            color: #374151;
            background: #f3f4f6;
            border: 1px solid #d1d5db;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .data-table tbody td {
            padding: 12px 10px;
            text-align: center;
            font-size: 9pt;
            color: #1f2937;
            border: 1px solid #e5e7eb;
            background: #ffffff;
        }

        .data-table tbody tr:first-child {
            background: #ecfdf5;
        }

        .data-table tbody tr:first-child td {
            font-weight: 600;
            color: #065f46;
        }

        .highlight {
            color: #1a1a1a;
            font-weight: 700;
        }

        .text-muted {
            color: #6b7280;
            font-size: 8pt;
        }

        /* Footer */
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
        }

        .footer-text {
            font-size: 8pt;
            color: #9ca3af;
            line-height: 1.8;
        }

        .footer-confidential {
            font-size: 7pt;
            color: #d1d5db;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 5px;
        }

        /* Utilities */
        .text-center {
            text-align: center;
        }

        .mb-10 {
            margin-bottom: 10px;
        }

        .status-active {
            color: #059669;
            font-weight: 700;
        }

        .status-ended {
            color: #6b7280;
            font-weight: 700;
        }
    </style>
</head>

<body>
    <div class="page">
        {{-- HEADER --}}
        <div class="header">
            <div class="header-top">
                <div class="header-left">
                    <div class="doc-title">Laporan Kandidat</div>
                    <div class="doc-subtitle">Hasil Voting & Statistik</div>
                </div>
                <div class="header-right">
                    <div class="doc-number">DOC-{{ str_pad($candidate->id, 6, '0', STR_PAD_LEFT) }}</div>
                    <div class="doc-date">{{ now()->format('d F Y') }}</div>
                </div>
            </div>
        </div>

        {{-- STATUS BADGE --}}
        <div class="status-section">
            @if ($isEnded)
                @if ($isWinner)
                    <span class="status-badge badge-winner">✓ PEMENANG</span>
                @else
                    <span class="status-badge badge-loser">TIDAK MENANG</span>
                @endif
            @else
                <span class="status-badge badge-ongoing">● BERLANGSUNG</span>
            @endif
        </div>

        {{-- CANDIDATE PROFILE --}}
        <div class="profile-section">
            <div class="profile-grid">
                <div class="profile-left">
                    @if ($candidate->photo)
                        <img src="{{ public_path('storage/' . $candidate->photo) }}" class="candidate-photo"
                            alt="Foto">
                    @endif
                </div>
                <div class="profile-right">
                    <div class="candidate-name">{{ $candidate->name }}</div>

                    @if ($candidate->description)
                        <div class="candidate-desc">{{ $candidate->description }}</div>
                    @endif

                    <div class="stats-grid">
                        <div class="stat-item">
                            <div class="stat-value">{{ $candidateVotes }}</div>
                            <div class="stat-label">Total Suara</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">{{ $percentage }}%</div>
                            <div class="stat-label">Persentase</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- EVENT INFORMATION --}}
        <div class="section">
            <div class="section-header">Informasi Event</div>
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">Judul Event</div>
                    <div class="info-value">{{ $candidate->event->title }}</div>
                </div>
                @if ($candidate->event->description)
                    <div class="info-row">
                        <div class="info-label">Deskripsi</div>
                        <div class="info-value">{{ $candidate->event->description }}</div>
                    </div>
                @endif
                <div class="info-row">
                    <div class="info-label">Penyelenggara</div>
                    <div class="info-value">
                        {{ $candidate->event->owner->name }}
                        <span class="text-muted">({{ $candidate->event->owner->email }})</span>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Periode</div>
                    <div class="info-value">
                        {{ $candidate->event->start_time->format('d M Y, H:i') }} -
                        {{ $candidate->event->end_time->format('d M Y, H:i') }} WIB
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Status</div>
                    <div class="info-value">
                        @if ($isEnded)
                            <span class="status-ended">SELESAI</span>
                        @else
                            <span class="status-active">AKTIF</span>
                        @endif
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Total Pemilih</div>
                    <div class="info-value"><strong>{{ number_format($totalVotes) }}</strong> suara</div>
                </div>
            </div>
        </div>

        {{-- VOTE PERCENTAGE --}}
        <div class="section">
            <div class="section-header">Persentase Suara</div>
            <div class="progress-container">
                <div class="progress-fill" style="width: {{ $percentage }}%;">
                    {{ $percentage }}% ({{ $candidateVotes }} suara)
                </div>
            </div>
        </div>

        {{-- COMPARISON TABLE --}}
        <div class="section">
            <div class="section-header">Ranking Kandidat</div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 10%;">Rank</th>
                        <th style="width: 45%;">Nama Kandidat</th>
                        <th style="width: 20%;">Jumlah Suara</th>
                        <th style="width: 25%;">Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($allCandidates->sortByDesc('votes_count')->values() as $index => $cand)
                        <tr>
                            <td>
                                @if ($index === 0)
                                    <strong>🏆 #{{ $index + 1 }}</strong>
                                @else
                                    #{{ $index + 1 }}
                                @endif
                            </td>
                            <td style="text-align: left;">
                                <strong>{{ $cand->name }}</strong>
                                @if ($cand->id === $candidate->id)
                                    <span style="color: #1a1a1a;"> (Laporan ini)</span>
                                @endif
                            </td>
                            <td>{{ number_format($cand->votes_count) }}</td>
                            <td>
                                <strong>{{ $totalVotes > 0 ? round(($cand->votes_count / $totalVotes) * 100, 2) : 0 }}%</strong>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- FOOTER --}}
        <div class="footer">
            <div class="footer-text">
                Dokumen ini digenerate secara otomatis pada {{ now()->format('d F Y') }} pukul
                {{ now()->format('H:i:s') }} WIB
            </div>
            <div class="footer-confidential">
                Confidential Document - Sistem Voting Online
            </div>
        </div>
    </div>
</body>

</html>

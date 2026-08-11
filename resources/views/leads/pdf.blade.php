<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Leads</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0 0 0;
            color: #555;
        }
        .filter-info {
            margin-bottom: 15px;
            font-size: 11px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th {
            background-color: #f2f2f2;
            padding: 8px;
            text-align: left;
        }
        td {
            padding: 8px;
        }
        .text-center {
            text-align: center;
        }
        .badge {
            padding: 3px 6px;
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
            border: 1px solid #000;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Data Leads</h1>
        <p>CRM Internal - Tanggal Cetak: {{ \Carbon\Carbon::now()->format('d M Y H:i') }}</p>
    </div>

    <div class="filter-info">
        <strong>Filter Aktif:</strong>
        Status: {{ $request->status ?? 'Semua' }} |
        Source: {{ $request->source ?? 'Semua' }} |
        Pencarian: {{ $request->search ?? 'Tidak ada' }}
    </div>

    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="15%">Nama</th>
                <th width="15%">Perusahaan</th>
                <th width="12%">Telepon</th>
                <th width="15%">Email</th>
                <th width="10%">Status</th>
                <th width="10%">Source</th>
                <th width="10%">Tanggal</th>
                <th width="10%">PIC (Marketing)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($leads as $index => $lead)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $lead->name }}</td>
                <td>{{ $lead->company ?? '-' }}</td>
                <td>{{ $lead->phone }}</td>
                <td>{{ $lead->email ?? '-' }}</td>
                <td class="text-center">
                    <span class="badge">{{ $lead->status }}</span>
                </td>
                <td>{{ $lead->source ?? '-' }}</td>
                <td>{{ $lead->created_at->format('d M Y') }}</td>
                <td>{{ $lead->marketing->name ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center">Tidak ada data leads yang sesuai dengan filter.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>

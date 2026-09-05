<!DOCTYPE html>
<html>
<head>

    <meta charset="UTF-8">

    <title>Laporan Kunjungan</title>

    <style>

        @page {
            margin: 25px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #111827;
        }

        .header {
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
        }

        .header p {
            margin-top: 5px;
            color: #6b7280;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f3f4f6;
            font-weight: bold;
            padding: 7px;
            border: 1px solid #d1d5db;
            text-align: left;
        }

        td {
            padding: 7px;
            border: 1px solid #d1d5db;
            vertical-align: top;
        }

        .center {
            text-align: center;
        }

        .footer {
            margin-top: 15px;
            font-size: 9px;
            color: #6b7280;
        }

    </style>

</head>

<body>

    <div class="header">

        <h1>
            LAPORAN KUNJUNGAN SALES
        </h1>

        <p>
            Sales Visit Report
        </p>

        <p>
            Dicetak:
            {{ now()->format('d/m/Y H:i') }}
        </p>

    </div>


    <table>

        <thead>

            <tr>

                <th width="4%" class="center">
                    No
                </th>

                <th width="9%">
                    Tanggal
                </th>

                <th width="7%">
                    Jam
                </th>

                <th width="12%">
                    Sales
                </th>

                <th width="16%">
                    Instansi
                </th>

                <th width="12%">
                    PIC
                </th>

                <th width="10%">
                    Telepon
                </th>

                <th width="10%">
                    Jenis
                </th>

                <th width="10%">
                    Hasil
                </th>

                <th width="15%">
                    Catatan
                </th>

            </tr>

        </thead>


        <tbody>

            @forelse($visits as $index => $visit)

                <tr>

                    <td class="center">
                        {{ $index + 1 }}
                    </td>

                    <td>
                        {{ $visit->visit_date?->format('d/m/Y') ?? '-' }}
                    </td>

                    <td>
                        {{ $visit->visit_time ?? '-' }}
                    </td>

                    <td>
                        {{ $visit->sales->name ?? '-' }}
                    </td>

                    <td>
                        {{ $visit->institution->name ?? '-' }}
                    </td>

                    <td>
                        {{ $visit->institution->pic_name ?? '-' }}
                    </td>

                    <td>
                        {{ $visit->institution->phone ?? '-' }}
                    </td>

                    <td>
                        {{ $visit->type->name ?? '-' }}
                    </td>

                    <td>
                        {{ $visit->result->name ?? '-' }}
                    </td>

                    <td>
                        {{ $visit->notes ?? '-' }}
                    </td>

                </tr>

            @empty

                <tr>

                    <td
                        colspan="10"
                        class="center"
                    >
                        Tidak ada data kunjungan.

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>


    <div class="footer">

        Total data:
        {{ $visits->count() }}
        kunjungan.

    </div>

</body>
</html>
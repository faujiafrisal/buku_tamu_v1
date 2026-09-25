<?php

namespace App\Exports;

use App\Models\Guest;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class GuestHistoryExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithEvents
{
    protected ?string $search;
    protected int $rowNumber = 0;

    public function __construct(?string $search = null)
    {
        $this->search = $search;
    }

    public function collection(): \Illuminate\Support\Enumerable
    {
        $query = Guest::query();

        if (!empty($this->search)) {
            $search = $this->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('asal_instansi', 'like', "%{$search}%")
                    ->orWhere('bidang_orang_ditemui', 'like', "%{$search}%")
                    ->orWhere('no_whatsapp', 'like', "%{$search}%")
                    ->orWhere('bidang_tujuan', 'like', "%{$search}%")
                    ->orWhere('keperluan', 'like', "%{$search}%");
            });
        }

        return $query->latest()->get();
    }

    public function title(): string
    {
        return 'History Kunjungan';
    }

    public function headings(): array
    {
        return [
            'No.',
            'Nama Lengkap',
            'Asal Instansi/Perusahaan',
            'Bidang / Orang Ditemui',
            'Gender',
            'Usia',
            'Rombongan',
            'Layanan & Keperluan',
            'No WhatsApp',
            'Waktu Presensi (WITA)',
        ];
    }

    public function map($guest): array
    {
        $this->rowNumber++;

        // 1. Format Layanan & Keperluan (+ Jawaban Tambahan if present, exactly as in History Admin)
        $keperluanText = $guest->keperluan ?? '-';

        if (!empty($guest->jawaban_tambahan) && is_array($guest->jawaban_tambahan)) {
            $extraAnswers = [];
            foreach ($guest->jawaban_tambahan as $ans) {
                $p = trim($ans['pertanyaan'] ?? '');
                $j = trim($ans['jawaban'] ?? '');
                if ($p !== '' && $j !== '') {
                    $extraAnswers[] = "• {$p}: {$j}";
                }
            }
            if (!empty($extraAnswers)) {
                $keperluanText .= "\n\n[Jawaban Tambahan]:\n" . implode("\n", $extraAnswers);
            }
        }

        // 2. Format WhatsApp strictly as string to prevent scientific notation
        $wa = $guest->no_whatsapp ? "'" . $guest->no_whatsapp : '-';

        // 3. Format Time Asia/Makassar (WITA)
        $waktu = $guest->created_at
            ? $guest->created_at->setTimezone('Asia/Makassar')->format('d/m/Y H:i:s') . ' WITA'
            : '-';

        return [
            $this->rowNumber,
            $guest->nama ?? '-',
            $guest->asal_instansi ?? '-',
            $guest->bidang_orang_ditemui ?? '-',
            $guest->jenis_kelamin ?? '-',
            $guest->usia ? $guest->usia . ' Thn' : '-',
            $guest->jumlah_rombongan ?? '-',
            $keperluanText,
            $wa,
            $waktu,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                /** @var Worksheet $sheet */
                $sheet = $event->sheet->getDelegate();

                $highestRow = $sheet->getHighestRow();

                // Enable AutoFilter on header row A1:J1
                $sheet->setAutoFilter('A1:J1');

                // Freeze Header Row
                $sheet->freezePane('A2');

                // Header Styling
                $sheet->getStyle('A1:J1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'FFFFFF'],
                        'size' => 11,
                        'name' => 'Calibri',
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '1E3A8A'], // Navy Blue
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_MEDIUM,
                            'color' => ['rgb' => '0F172A'],
                        ],
                    ],
                ]);
                $sheet->getRowDimension(1)->setRowHeight(28);

                // Explicit Column Widths matching History Admin layout
                $widths = [
                    'A' => 8,   // No.
                    'B' => 25,  // Nama Lengkap
                    'C' => 28,  // Asal Instansi/Perusahaan
                    'D' => 28,  // Bidang / Orang Ditemui
                    'E' => 15,  // Gender
                    'F' => 10,  // Usia
                    'G' => 16,  // Rombongan
                    'H' => 45,  // Layanan & Keperluan
                    'I' => 18,  // No WhatsApp
                    'J' => 24,  // Waktu Presensi (WITA)
                ];

                foreach ($widths as $col => $width) {
                    $sheet->getColumnDimension($col)->setWidth($width);
                }

                // Data Rows Styling
                if ($highestRow > 1) {
                    $dataRange = "A2:J{$highestRow}";
                    $sheet->getStyle($dataRange)->applyFromArray([
                        'font' => [
                            'size' => 10,
                            'name' => 'Calibri',
                        ],
                        'alignment' => [
                            'vertical' => Alignment::VERTICAL_CENTER,
                        ],
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => ['rgb' => 'CBD5E1'],
                            ],
                        ],
                    ]);

                    // Alignments
                    $sheet->getStyle("A2:A{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // No
                    $sheet->getStyle("E2:G{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Gender, Usia, Rombongan
                    $sheet->getStyle("I2:J{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // WA, Waktu

                    // Text Wrap for long columns
                    $sheet->getStyle("B2:D{$highestRow}")->getAlignment()->setWrapText(true);
                    $sheet->getStyle("H2:H{$highestRow}")->getAlignment()->setWrapText(true);
                }
            },
        ];
    }
}

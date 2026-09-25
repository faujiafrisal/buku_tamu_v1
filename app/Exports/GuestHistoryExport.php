<?php

namespace App\Exports;

use App\Models\Guest;
use App\Models\FormQuestion;
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
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class GuestHistoryExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithEvents
{
    protected ?string $search;
    protected array $customQuestions = [];
    protected int $rowNumber = 0;

    public function __construct(?string $search = null)
    {
        $this->search = $search;

        // Fetch all active/custom questions from database for headers
        $questions = FormQuestion::whereNull('system_key')
            ->orderBy('urutan', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        foreach ($questions as $q) {
            $this->customQuestions[] = [
                'id' => $q->id,
                'pertanyaan' => $q->pertanyaan,
            ];
        }
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
        $headers = [
            'No.',
            'Nama Lengkap',
            'Asal Instansi/Perusahaan',
            'Bidang / Orang yang Ditemui',
            'Jenis Kelamin',
            'Usia',
            'Jumlah Rombongan',
            'Layanan & Keperluan',
            'No. WhatsApp',
        ];

        foreach ($this->customQuestions as $cq) {
            $headers[] = $cq['pertanyaan'];
        }

        $headers[] = 'Waktu Presensi';

        return $headers;
    }

    public function map($guest): array
    {
        $this->rowNumber++;

        // Format WhatsApp strictly as string with leading apostrophe so Excel keeps formatting
        $wa = $guest->no_whatsapp ? "'" . $guest->no_whatsapp : '-';

        $row = [
            $this->rowNumber,
            $guest->nama ?? '-',
            $guest->asal_instansi ?? '-',
            $guest->bidang_orang_ditemui ?? '-',
            $guest->jenis_kelamin ?? '-',
            $guest->usia ? $guest->usia . ' Thn' : '-',
            $guest->jumlah_rombongan ?? '-',
            $guest->keperluan ?? '-',
            $wa,
        ];

        // Process custom questions answers
        $jawabanTambahan = is_array($guest->jawaban_tambahan) ? $guest->jawaban_tambahan : [];
        $ansMapByQId = [];
        $ansMapByPertanyaan = [];

        foreach ($jawabanTambahan as $item) {
            if (isset($item['question_id'])) {
                $ansMapByQId[$item['question_id']] = $item['jawaban'] ?? '-';
            }
            if (isset($item['pertanyaan'])) {
                $ansMapByPertanyaan[trim($item['pertanyaan'])] = $item['jawaban'] ?? '-';
            }
        }

        foreach ($this->customQuestions as $cq) {
            $ans = '-';
            if (isset($ansMapByQId[$cq['id']])) {
                $ans = $ansMapByQId[$cq['id']];
            } elseif (isset($ansMapByPertanyaan[trim($cq['pertanyaan'])])) {
                $ans = $ansMapByPertanyaan[trim($cq['pertanyaan'])];
            }
            $row[] = ($ans !== null && $ans !== '') ? $ans : '-';
        }

        // Time format Asia/Makassar
        $waktu = $guest->created_at
            ? $guest->created_at->setTimezone('Asia/Makassar')->format('d/m/Y H:i:s')
            : '-';

        $row[] = $waktu;

        return $row;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                /** @var Worksheet $sheet */
                $sheet = $event->sheet->getDelegate();

                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();
                $highestColumnIndex = Coordinate::columnIndexFromString($highestColumn);

                // Enable AutoFilter on header row
                $sheet->setAutoFilter("A1:{$highestColumn}1");

                // Freeze Header Row
                $sheet->freezePane('A2');

                // Header Styling
                $headerRange = "A1:{$highestColumn}1";
                $sheet->getStyle($headerRange)->applyFromArray([
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

                // Data Rows Styling
                if ($highestRow > 1) {
                    $dataRange = "A2:{$highestColumn}{$highestRow}";
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

                    // Alignments per column
                    $sheet->getStyle("A2:A{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // No
                    $sheet->getStyle("E2:G{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Gender, Usia, Rombongan
                    $sheet->getStyle("I2:I{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // WhatsApp
                    $sheet->getStyle("{$highestColumn}2:{$highestColumn}{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Waktu

                    // Text wrap for long text columns
                    $sheet->getStyle("B2:D{$highestRow}")->getAlignment()->setWrapText(true);
                    $sheet->getStyle("H2:H{$highestRow}")->getAlignment()->setWrapText(true);

                    // Row Heights for data
                    for ($r = 2; $r <= $highestRow; $r++) {
                        $sheet->getRowDimension($r)->setRowHeight(22);
                    }
                }

                // Auto Column Widths
                for ($col = 1; $col <= $highestColumnIndex; $col++) {
                    $colLetter = Coordinate::stringFromColumnIndex($col);
                    $sheet->getColumnDimension($colLetter)->setAutoSize(true);
                }
            },
        ];
    }
}

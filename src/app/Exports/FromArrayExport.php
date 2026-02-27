<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\RichText\RichText;

class FromArrayExport implements FromArray, WithHeadings, WithStyles, WithTitle, WithColumnWidths, WithEvents
{
    protected array $data;
    protected string $filename;

    public function __construct(array $data, string $filename = '')
    {
        $this->data = $data;
        $this->filename = $filename;
    }

    public function array(): array
    {
        return $this->data;
    }

    public function headings(): array
{
    if (empty($this->data) || !array_key_exists(0, $this->data)) {
        return [];
    }
    return array_keys($this->data[0]);
}

public function columnWidths(): array
{
    if (empty($this->data) || !array_key_exists(0, $this->data)) {
        return [];
    }

    $widths = [];
    $columns = array_keys($this->data[0]);

    foreach ($columns as $index => $column) {
        $col = chr(65 + $index); // A, B, C ...
        switch (strtolower($column)) {
            case 'id pelaporan':        $widths[$col] = 20; break;
            case 'nis':                 $widths[$col] = 15; break;
            case 'nama siswa':          $widths[$col] = 25; break;
            case 'kategori':            $widths[$col] = 20; break;
            case 'lokasi':              $widths[$col] = 30; break;
            case 'keterangan':          $widths[$col] = 40; break;
            case 'status':              $widths[$col] = 15; break;
            case 'feedback':            $widths[$col] = 35; break;
            case 'progress perbaikan':  $widths[$col] = 20; break;
            case 'tanggal':             $widths[$col] = 20; break;
            default:                    $widths[$col] = 20; break;
        }
    }

    return $widths;
}

    public function title(): string
    {
        return $this->filename ?: 'Laporan';
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            // Style untuk header
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4472C4'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ],
            // Style untuk semua data
            'A1:Z1000' => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'D3D3D3'],
                    ],
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $highestRow = $sheet->getHighestDataRow();
                $highestColumn = $sheet->getHighestColumn();

                // Skip jika tidak ada data
                if ($highestRow < 1 || empty($this->data) || !isset($this->data[0])) {
                    return;
                }

                // Auto-filter untuk header
                if ($highestColumn !== 'A') {
                    $sheet->setAutoFilter('A1:' . $highestColumn . '1');
                }

                // Freeze pane untuk header
                $sheet->freezePane('A2');

                // Style untuk status badges
                if (!empty($this->data) && isset($this->data[0])) {
                    $statusColumn = null;
                    foreach (array_keys($this->data[0]) as $index => $column) {
                        if (strtolower($column) === 'status') {
                            $statusColumn = chr(65 + $index); // A, B, C, etc.
                            break;
                        }
                    }

                    if ($statusColumn) {
                        for ($row = 2; $row <= $highestRow; $row++) {
                            $cellValue = $sheet->getCell($statusColumn . $row)->getValue();
                            $color = $this->getStatusColor($cellValue);
                            
                            $sheet->getStyle($statusColumn . $row)->applyFromArray([
                                'font' => [
                                    'bold' => true,
                                    'color' => ['rgb' => $color['text']],
                                ],
                                'fill' => [
                                    'fillType' => Fill::FILL_SOLID,
                                    'startColor' => ['rgb' => $color['bg']],
                                ],
                                'alignment' => [
                                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                                ],
                            ]);
                        }
                    }
                }

                // Add title di atas tabel
                $sheet->insertNewRowBefore(1, 2);
                $sheet->mergeCells('A1:' . $highestColumn . '1');
                $sheet->setCellValue('A1', $this->filename ?: 'LAPORAN ASPIRASI');
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 16,
                        'color' => ['rgb' => '000000'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Add tanggal di baris kedua
                $sheet->mergeCells('A2:' . $highestColumn . '2');
                $sheet->setCellValue('A2', 'Dicetak pada: ' . date('d/m/Y H:i:s'));
                $sheet->getStyle('A2')->applyFromArray([
                    'font' => [
                        'italic' => true,
                        'color' => ['rgb' => '666666'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                // Row height untuk title
                $sheet->getRowDimension(1)->setRowHeight(25);
                $sheet->getRowDimension(2)->setRowHeight(20);

                // Row height untuk data
                for ($row = 3; $row <= $highestRow + 2; $row++) {
                    $sheet->getRowDimension($row)->setRowHeight(20);
                }
            },
        ];
    }

    private function getStatusColor($status): array
    {
        $colors = [
            'Menunggu' => ['bg' => 'FFF2CC', 'text' => '856404'],
            'Diproses' => ['bg' => 'CCE5FF', 'text' => '004085'],
            'Selesai' => ['bg' => 'D4EDDA', 'text' => '155724'],
            'Ditolak' => ['bg' => 'F8D7DA', 'text' => '721C24'],
        ];

        return $colors[$status] ?? ['bg' => 'FFFFFF', 'text' => '000000'];
    }
}
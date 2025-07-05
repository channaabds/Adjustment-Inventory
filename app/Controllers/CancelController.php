<?php

namespace App\Controllers;

use App\Models\AllCancelModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class CancelController extends BaseController
{
    public function index()
    {
        $model = new AllCancelModel();
        $data['cancels'] = $model->findAll();
        return view('History/alldata_cancellot', $data);
    }

    public function ajax_list()
    {
        $model = new AllCancelModel();
        $data = $model->findAll();
        return $this->response->setJSON($data);
    }

    public function export()
    {
        $model = new AllCancelModel();
        $data = $model->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Define header row
        $headers = ['No', 'Department', 'PIC', 'Tanggal', 'Part Number From', 'Part Number To', 'Quantity', 'Lot Number', 'Warehouse From', 'Warehouse To', 'Remark', 'Adjust PIC'];
        $sheet->fromArray($headers, NULL, 'A1');

        // Populate data rows with auto-incremented 'No'
        $rows = [];
        $no = 1; // Start numbering from 1
        foreach ($data as $item) {
            $rows[] = [
                $no++, // Auto-incremented number
                $item['department'],
                $item['pic'],
                $item['tanggal'],
                $item['part_number_from'],
                $item['part_number_to'],
                $item['qty'],
                $item['lot_number'],
                $item['warehouse_from'],
                $item['warehouse_to'],
                $item['remark'],
                $item['adjust_pic'],
            ];
        }
        $sheet->fromArray($rows, NULL, 'A2');

        // Apply styles for header
        $headerStyleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => 'FFFF0000'], // Red color
            ],
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFFFF'], // White color
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];

        // Apply styles for data
        $dataStyleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => 'FFFFFFFF'], // White color
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];

        // Apply header style
        $sheet->getStyle('A1:L1')->applyFromArray($headerStyleArray);

        // Apply border and fill style to all data cells
        $sheet->getStyle('A2:L' . (count($rows) + 1))->applyFromArray($dataStyleArray);

        $writer = new Xlsx($spreadsheet);
        $filename = 'data-cancel-lot.xlsx';

        // Set headers for the file download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit();
    }
}

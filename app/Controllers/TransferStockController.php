<?php

namespace App\Controllers;

use App\Models\TransferStockModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class TransferStockController extends BaseController
{
    protected $transferStockModel;

    public function __construct()
    {
        $this->transferStockModel = new TransferStockModel();
    }

    public function index()
    {
        $startDate = $this->request->getGet('startDate');
        $endDate = $this->request->getGet('endDate');
        $status = $this->request->getGet('status');

        $filters = [];
        if ($startDate) {
            $filters['date >='] = $startDate;
        }
        if ($endDate) {
            $filters['date <='] = $endDate;
        }
        if ($status) {
            $filters['status'] = $status;
        }

        $data = $this->transferStockModel->where($filters)->findAll();

        $data['filters'] = $filters;
        return view('transfer_stock/index', $data);
    }

    public function export()
    {
        $startDate = $this->request->getGet('startDate');
        $endDate = $this->request->getGet('endDate');
        $status = $this->request->getGet('status');

        $filters = [
            'adjust_pic' => 'Approved Leader'
        ];
        if ($startDate) {
            $filters['tanggal>='] = $startDate; // Ganti 'date_column' dengan nama kolom yang benar
        }
        if ($endDate) {
            $filters['tanggal <='] = $endDate; // Ganti 'date_column' dengan nama kolom yang benar
        }
        if ($status) {
            $filters['status'] = $status;
        }

        $data = $this->transferStockModel->where($filters)->findAll();

        if (empty($data)) {
            return $this->response->setStatusCode(404)->setBody('No data found');
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Department');
        $sheet->setCellValue('C1', 'PIC');
        $sheet->setCellValue('D1', 'Part Number From');
        $sheet->setCellValue('E1', 'Part Number To');
        $sheet->setCellValue('F1', 'Qty');
        $sheet->setCellValue('G1', 'Lot Number From');
        $sheet->setCellValue('H1', 'Lot Number To');
        $sheet->setCellValue('I1', 'RN From');
        $sheet->setCellValue('J1', 'RN To');
        $sheet->setCellValue('K1', 'Whs From');
        $sheet->setCellValue('L1', 'Whs To');
        $sheet->setCellValue('M1', 'Status');
        $sheet->setCellValue('N1', 'Keterangan');
        $sheet->setCellValue('O1', 'Adjust PIC');

        $row = 2;
        foreach ($data as $key => $item) {
            $sheet->setCellValue('A' . $row, $key + 1);
            $sheet->setCellValue('B' . $row, $item['department']);
            $sheet->setCellValue('C' . $row, $item['pic']);
            $sheet->setCellValue('D' . $row, $item['part_number_from']);
            $sheet->setCellValue('E' . $row, $item['part_number_to']);
            $sheet->setCellValue('F' . $row, $item['qty']);
            $sheet->setCellValue('G' . $row, $item['lot_number_from']);
            $sheet->setCellValue('H' . $row, $item['lot_number_to']);
            $sheet->setCellValue('I' . $row, $item['rn_from']);
            $sheet->setCellValue('J' . $row, $item['rn_to']);
            $sheet->setCellValue('K' . $row, $item['warehouse_from']);
            $sheet->setCellValue('L' . $row, $item['warehouse_to']);
            $sheet->setCellValue('M' . $row, $item['status']);
            $sheet->setCellValue('N' . $row, $item['remark']);
            $sheet->setCellValue('O' . $row, $item['adjust_pic']);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        // Format nama file dengan filter
        $filename = 'Transfer_Stock_' .
            ($startDate ? 'Dari_' . date('d-m-Y', strtotime($startDate)) : 'TanpaTanggal') . '_' .
            ($endDate ? 'Sampai_' . date('d-m-Y', strtotime($endDate)) : 'TanpaTanggal') . '_' .
            ($status ? 'Status_' . urlencode($status) : 'TanpaStatus') . '_' .
            date('d-m-Y_His') . '.xlsx';

        // Set headers and send the file to the browser
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }


}

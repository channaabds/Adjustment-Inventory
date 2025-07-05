<?php

namespace App\Controllers;

use App\Models\CancelLotModel;
use App\Models\TransferStockModel;
use App\Models\InventoryModel;
use App\Models\HistoryModel;
use App\Models\UserModel;
use App\Models\AllCancelModel;
use App\Models\TransferStockHistoryModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PICController extends BaseController
{
    protected $adjustmentModel;
    protected $transferStockModel;
    protected $cancelLotModel;
    protected $historyModel;
    protected $userModel;
    protected $allCancelModel;
    protected $transferStockHistoryModel;

    public function __construct()
    {
        $this->adjustmentModel = new InventoryModel();
        $this->transferStockModel = new TransferStockModel();
        $this->cancelLotModel = new CancelLotModel();
        $this->historyModel = new HistoryModel();
        $this->allCancelModel = new AllCancelModel();
        $this->transferStockHistoryModel = new TransferStockHistoryModel();
    }
    public function dashboard()
    {
        $userRole = session()->get('role');
        $username = session()->get('username');

        // Daftar departemen yang relevan untuk masing-masing peran
        $departments = [];

        // Menentukan departemen berdasarkan peran
        switch ($userRole) {
            case 'LEADERMFG1':
            case 'MFG1':
                $departments = ['MFG1'];
                break;
            case 'LEADERMFG2':
            case 'MFG2':
                $departments = ['MFG2'];
                break;
            case 'LEADERQC':
            case 'USER':
                $departments = ['QC'];
                break;
            case 'CS':
            case 'USER':
                $departments = ['Delivery'];
                break;
            case 'PIC':
            case 'PIC2':
                // Menampilkan semua departemen untuk PIC dan PIC2
                $departments = ['MFG1', 'MFG2', 'QC', 'Delivery'];
                break;
            default:
                return view('errors/html/error_404', ['message' => 'Role tidak dikenal']);
        }

        // Inisialisasi array untuk menyimpan hasil hitung
        $data = [
            'adjustmentInventoryCount' => 0,
            'transferStockCount' => 0,
            'cancelLotCount' => 0,
            'waitingApprovedCount' => 0,
            'approvedCount' => 0,
            'disapprovedCount' => 0,
        ];

        foreach ($departments as $department) {
            // Hitung data berdasarkan departemen
            $data['adjustmentInventoryCount'] += $this->adjustmentModel->where('department', $department)->countAll();
            $data['transferStockCount'] += $this->transferStockModel->where('department', $department)->countAll();
            $data['cancelLotCount'] += $this->cancelLotModel->where('department', $department)->countAll();

            // Hitung jumlah yang menunggu persetujuan
            $data['waitingApprovedCount'] += $this->adjustmentModel
                ->where('department', $department)
                ->where('adjust_pic IS NULL')
                ->countAllResults();
            $data['waitingApprovedCount'] += $this->transferStockModel
                ->where('department', $department)
                ->where('adjust_pic IS NULL')
                ->countAllResults();
            $data['waitingApprovedCount'] += $this->cancelLotModel
                ->where('department', $department)
                ->where('adjust_pic IS NULL')
                ->countAllResults();

            // Hitung jumlah yang disetujui
            $data['approvedCount'] += $this->adjustmentModel
                ->where('department', $department)
                ->where('adjust_pic', 'approved')
                ->countAllResults();
            $data['approvedCount'] += $this->transferStockModel
                ->where('department', $department)
                ->where('adjust_pic', 'approved')
                ->countAllResults();
            $data['approvedCount'] += $this->cancelLotModel
                ->where('department', $department)
                ->where('adjust_pic', 'approved')
                ->countAllResults();

            // Hitung jumlah yang ditolak
            $data['disapprovedCount'] += $this->adjustmentModel
                ->where('department', $department)
                ->like('adjust_pic', 'Disapproved')
                ->countAllResults();
            $data['disapprovedCount'] += $this->transferStockModel
                ->where('department', $department)
                ->like('adjust_pic', 'Disapproved')
                ->countAllResults();
            $data['disapprovedCount'] += $this->cancelLotModel
                ->where('department', $department)
                ->like('adjust_pic', 'Disapproved')
                ->countAllResults();
        }

        // Mengirim data ke view
        return view('PIC/pic_dashboard', $data);
    }

    public function index()
    {
        // Ambil peran pengguna dari sesi
        $role = session()->get('role');

        // Tentukan data berdasarkan peran
        switch ($role) {
            case 'LEADERMFG1':
                // Ambil data hanya untuk departemen MFG1 dan adjust_pic yang NULL
                $data['adjustment'] = $this->adjustmentModel
                    ->where('department', 'MFG1')
                    ->where('adjust_pic', NULL)
                    ->findAll();
                break;
            case 'LEADERMFG2':
                // Ambil data hanya untuk departemen MFG2 dan adjust_pic yang NULL
                $data['adjustment'] = $this->adjustmentModel
                    ->where('department', 'MFG2')
                    ->where('adjust_pic', NULL)
                    ->findAll();
                break;
            case 'LEADERQC':
                // Ambil data hanya untuk departemen QC dan adjust_pic yang NULL
                $data['adjustment'] = $this->adjustmentModel
                    ->where('department', 'QC')
                    ->where('adjust_pic', NULL)
                    ->findAll();
                break;
            case 'CS':
                // Ambil data hanya untuk departemen DELIVERY
                $data['adjustment'] = $this->adjustmentModel
                    ->where('department', 'DELIVERY')
                    ->findAll();
                break;
            case 'PIC':
                // Untuk role PIC, hanya ambil data yang telah disetujui oleh Leader
                $data['adjustment'] = $this->adjustmentModel
                    ->where('adjust_pic', 'Approved Leader')
                    ->findAll();
                break;
            default:
                // Untuk peran lain, ambil semua data
                $data['adjustment'] = $this->adjustmentModel->findAll();
                break;
        }

        return view('PIC/pic_view', $data);
    }

    public function bulkApproveAdjustByLeader()
    {
        $userRole = session()->get('role');

        if (in_array($userRole, ['LEADERMFG1', 'LEADERMFG2', 'LEADERQC', 'CS']) && $this->request->isAJAX()) {
            $ids = $this->request->getPost('ids');

            if (empty($ids)) {
                return $this->response->setJSON(['success' => false, 'message' => 'Tidak ada item yang dipilih']);
            }

            foreach ($ids as $id) {
                $item = $this->adjustmentModel->find($id);

                if ($item) {
                    $canApprove = false;
                    $adjustPicValue = '';

                    switch ($userRole) {
                        case 'LEADERMFG1':
                        case 'LEADERMFG2':
                            if ($item['status'] === 'MIN') {
                                $canApprove = empty($item['adjust_pic']);
                                $adjustPicValue = 'Approved Leader';
                            }
                            break;
                        case 'LEADERQC':
                            if ($item['department'] === 'QC') {
                                $canApprove = empty($item['adjust_pic']);
                                $adjustPicValue = 'Approved Leader';
                            }
                            break;
                        case 'CS':
                            if ($item['department'] === 'DELIVERY') {
                                $canApprove = empty($item['adjust_pic']);
                                $adjustPicValue = 'Approved Leader';
                            }
                            break;
                    }

                    if ($canApprove) {
                        $this->adjustmentModel->update($id, ['adjust_pic' => $adjustPicValue]);
                    } else {
                        return $this->response->setJSON(['success' => false, 'message' => 'Beberapa item tidak dapat disetujui']);
                    }
                } else {
                    return $this->response->setJSON(['success' => false, 'message' => 'Beberapa data tidak ditemukan']);
                }
            }

            return $this->response->setJSON(['success' => true, 'message' => 'Semua data berhasil disetujui']);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized access or invalid request']);
    }

    public function bulkDisapproveAdjustByLeader()
    {
        $userRole = session()->get('role');

        if (in_array($userRole, ['LEADERMFG1', 'LEADERMFG2', 'LEADERQC', 'CS']) && $this->request->isAJAX()) {
            $ids = $this->request->getPost('ids');
            $reason = $this->request->getPost('reason');

            if (empty($ids) || empty($reason)) {
                return $this->response->setJSON(['success' => false, 'message' => 'Tidak ada item yang dipilih atau alasan penolakan tidak diberikan']);
            }

            foreach ($ids as $id) {
                $item = $this->adjustmentModel->find($id);

                if ($item) {
                    $canDisapprove = false;
                    $adjustPicValue = '';

                    switch ($userRole) {
                        case 'LEADERMFG1':
                        case 'LEADERMFG2':
                            if ($item['status'] === 'MIN') {
                                $canDisapprove = empty($item['adjust_pic']);
                                $adjustPicValue = 'Disapproved Leader: ' . $reason;
                            }
                            break;
                        case 'LEADERQC':
                            if ($item['department'] === 'QC') {
                                $canDisapprove = empty($item['adjust_pic']);
                                $adjustPicValue = 'Disapproved Leader: ' . $reason;
                            }
                            break;
                        case 'CS':
                            if ($item['department'] === 'DELIVERY') {
                                $canDisapprove = empty($item['adjust_pic']);
                                $adjustPicValue = 'Disapproved Leader: ' . $reason;
                            }
                            break;
                    }

                    if ($canDisapprove) {
                        $data = [
                            'department' => $item['department'],
                            'pic' => $item['pic'],
                            'tanggal' => $item['tanggal'],
                            'part_number' => $item['part_number'],
                            'qty' => $item['qty'],
                            'lot_number' => $item['lot_number'],
                            'rn' => $item['rn'],
                            'location' => $item['location'],
                            'status' => $item['status'],
                            'remark' => $item['remark'],
                            'adjust_pic' => $adjustPicValue,
                            'created_at' => date('Y-m-d H:i:s')
                        ];

                        $this->historyModel->insert($data);
                        $this->adjustmentModel->delete($id);
                    } else {
                        return $this->response->setJSON(['success' => false, 'message' => 'Beberapa item tidak dapat ditolak']);
                    }
                } else {
                    return $this->response->setJSON(['success' => false, 'message' => 'Beberapa data tidak ditemukan']);
                }
            }

            return $this->response->setJSON(['success' => true, 'message' => 'Semua data berhasil ditolak']);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized access or invalid request']);
    }

    public function bulkApproveAdjustByPIC()
    {
        $userRole = session()->get('role');

        if ($userRole === 'PIC' && $this->request->isAJAX()) {
            $ids = $this->request->getPost('ids');

            if (empty($ids)) {
                return $this->response->setJSON(['success' => false, 'message' => 'Tidak ada item yang dipilih']);
            }

            foreach ($ids as $id) {
                $item = $this->adjustmentModel->find($id);

                if ($item) {
                    if (strpos($item['adjust_pic'], 'Approved Leader') !== false) {
                        $currentDate = date('Y-m-d H:i:s');

                        $this->adjustmentModel->update($id, [
                            'adjust_pic' => 'Approved PIC',
                            'pic_action_date' => $currentDate
                        ]);

                        $data = [
                            'department' => $item['department'],
                            'pic' => $item['pic'],
                            'tanggal' => $item['tanggal'],
                            'part_number' => $item['part_number'],
                            'qty' => $item['qty'],
                            'lot_number' => $item['lot_number'],
                            'rn' => $item['rn'],
                            'location' => $item['location'],
                            'status' => $item['status'],
                            'remark' => $item['remark'],
                            'adjust_pic' => 'Approved PIC',
                            'created_at' => $item['created_at'],
                            'pic_action_date' => $currentDate
                        ];

                        $this->historyModel->insert($data);
                        $this->adjustmentModel->delete($id);
                    } else {
                        return $this->response->setJSON(['success' => false, 'message' => 'Data belum di-disapprove oleh Leader']);
                    }
                } else {
                    return $this->response->setJSON(['success' => false, 'message' => 'Beberapa data tidak ditemukan']);
                }
            }

            return $this->response->setJSON(['success' => true, 'message' => 'Semua data berhasil di-approve oleh PIC']);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized access or invalid request']);
    }

    public function bulkDisapproveAdjustByPIC()
    {
        $userRole = session()->get('role');
        log_message('debug', 'User Role: ' . $userRole);

        if ($userRole === 'PIC' && $this->request->isAJAX()) {
            $ids = $this->request->getPost('ids');
            $reason = $this->request->getPost('reason');

            log_message('debug', 'IDs: ' . $ids);
            log_message('debug', 'Reason: ' . $reason);

            if (!empty($ids) && !empty($reason)) {
                $ids = explode(',', $ids);
                $allSuccess = true;
                $message = 'Data berhasil di-disapprove oleh PIC';

                foreach ($ids as $id) {
                    $item = $this->adjustmentModel->find($id);
                    log_message('debug', 'Processing ID: ' . $id);
                    log_message('debug', 'Item: ' . print_r($item, true));

                    if ($item) {
                        if (strpos($item['adjust_pic'], 'Approved Leader') !== false) {
                            $currentDate = date('Y-m-d H:i:s');
                            $updateResult = $this->adjustmentModel->update($id, [
                                'adjust_pic' => 'Disapproved PIC: ' . $reason,
                                'pic_action_date' => $currentDate
                            ]);

                            log_message('debug', 'Update Result for ID ' . $id . ': ' . $updateResult);

                            if ($updateResult) {
                                $data = [
                                    'department' => $item['department'],
                                    'pic' => $item['pic'],
                                    'tanggal' => $item['tanggal'],
                                    'part_number' => $item['part_number'],
                                    'qty' => $item['qty'],
                                    'lot_number' => $item['lot_number'],
                                    'rn' => $item['rn'],
                                    'location' => $item['location'],
                                    'status' => $item['status'],
                                    'remark' => $item['remark'],
                                    'adjust_pic' => 'Disapproved PIC: ' . $reason,
                                    'created_at' => $item['created_at'],
                                    'pic_action_date' => $currentDate
                                ];

                                $insertResult = $this->historyModel->insert($data);
                                log_message('debug', 'Insert Result: ' . $insertResult);

                                if ($insertResult) {
                                    $deleteResult = $this->adjustmentModel->delete($id);
                                    log_message('debug', 'Delete Result for ID ' . $id . ': ' . $deleteResult);

                                    if (!$deleteResult) {
                                        $allSuccess = false;
                                        $message = 'Gagal menghapus data dengan ID: ' . $id;
                                        break;
                                    }
                                } else {
                                    $allSuccess = false;
                                    $message = 'Gagal memindahkan data dengan ID: ' . $id;
                                    break;
                                }
                            } else {
                                $allSuccess = false;
                                $message = 'Gagal mengupdate status pada ID: ' . $id;
                                break;
                            }
                        } else {
                            $allSuccess = false;
                            $message = 'Data dengan ID ' . $id . ' belum di-approve oleh Leader';
                            break;
                        }
                    } else {
                        $allSuccess = false;
                        $message = 'Data dengan ID ' . $id . ' tidak ditemukan';
                        break;
                    }
                }

                return $this->response->setJSON(['success' => $allSuccess, 'message' => $message]);
            }

            return $this->response->setJSON(['success' => false, 'message' => 'Tidak ada item yang dipilih atau alasan penolakan kosong']);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Request tidak valid']);
    }






    public function approveAdjustByLeader($id)
    {
        $userRole = session()->get('role');

        if ($userRole === 'LEADERMFG2' || $userRole === 'PIC2' || $userRole === 'LEADERQC' || $userRole === 'CS') {
            if ($this->request->isAJAX()) {
                $item = $this->adjustmentModel->find($id);

                if ($item) {
                    $canApprove = false;
                    $adjustPicValue = '';

                    // Tentukan kondisi berdasarkan role
                    switch ($userRole) {
                        case 'LEADERMFG2':
                            if ($item['status'] === 'MIN') {
                                $canApprove = empty($item['adjust_pic']);
                                $adjustPicValue = 'Approved Leader';
                            }
                            break;
                        case 'PIC2':
                            if (in_array($item['status'], ['OK', 'NG', 'PEND'])) {
                                $canApprove = empty($item['adjust_pic']);
                                $adjustPicValue = 'Approved Leader';
                            }
                            break;

                        case 'LEADERQC':
                            if ($item['department'] === 'QC') {
                                $canApprove = empty($item['adjust_pic']);
                                $adjustPicValue = 'Approved Leader';
                            }
                            break;

                        case 'CS':
                            if ($item['department'] === 'DELIVERY') {
                                $canApprove = empty($item['adjust_pic']);
                                $adjustPicValue = 'Approved Leader';
                            }
                            break;
                        default:
                            $canApprove = false;
                            break;
                    }

                    if ($canApprove) {
                        $updateResult = $this->adjustmentModel->update($id, ['adjust_pic' => $adjustPicValue]);
                        if ($updateResult) {
                            return $this->response->setJSON(['success' => true, 'message' => 'Data berhasil di-Approved!']);
                        } else {
                            return $this->response->setJSON(['success' => false, 'message' => 'Gagal memperbarui status']);
                        }
                    } else {
                        return $this->response->setJSON(['success' => false, 'message' => 'Data tidak sesuai untuk diproses']);
                    }
                } else {
                    return $this->response->setJSON(['success' => false, 'message' => 'Data tidak ditemukan']);
                }
            }
            return $this->response->setJSON(['success' => false, 'message' => 'Request tidak valid']);
        }
        return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized access']);
    }


    public function disapproveAdjustByLeader($id)
    {
        $userRole = session()->get('role');

        if ($userRole === 'LEADERMFG2' || $userRole === 'PIC2' || $userRole === 'LEADERQC' || $userRole === 'CS') {
            if ($this->request->isAJAX()) {
                $reason = $this->request->getPost('reason');
                $item = $this->adjustmentModel->find($id);

                if ($item) {
                    $canDisapprove = false;
                    $adjustPicValue = '';

                    // Tentukan kondisi berdasarkan role
                    switch ($userRole) {
                        case 'LEADERMFG2':
                            if ($item['status'] === 'MIN') {
                                $canDisapprove = empty($item['adjust_pic']);
                                $adjustPicValue = 'Disapproved Leader: ' . $reason;
                            }
                            break;
                        case 'PIC2':
                            if (in_array($item['status'], ['OK', 'NG', 'PEND'])) {
                                $canDisapprove = empty($item['adjust_pic']);
                                $adjustPicValue = 'Disapproved Leader: ' . $reason;
                            }
                            break;
                        case 'LEADERQC':
                            if ($item['department'] === 'QC') {
                                $canDisapprove = empty($item['adjust_pic']);
                                $adjustPicValue = 'Disapproved Leader: ' . $reason;
                            }
                            break;
                        case 'CS':
                            if ($item['department'] === 'DELIVERY') {
                                $canDisapprove = empty($item['adjust_pic']);
                                $adjustPicValue = 'Disapproved Leader: ' . $reason;
                            }
                            break;
                        default:
                            $canDisapprove = false;
                            break;
                    }

                    if ($canDisapprove) {
                        $data = [
                            'department' => $item['department'],
                            'pic' => $item['pic'],
                            'tanggal' => $item['tanggal'],
                            'part_number' => $item['part_number'],
                            'qty' => $item['qty'],
                            'lot_number' => $item['lot_number'],
                            'rn' => $item['rn'],
                            'location' => $item['location'],
                            'status' => $item['status'],
                            'remark' => $item['remark'],
                            'adjust_pic' => $adjustPicValue,
                            'created_at' => date('Y-m-d H:i:s')
                        ];

                        $insertResult = $this->historyModel->insert($data);
                        if ($insertResult) {
                            $deleteResult = $this->adjustmentModel->delete($id);
                            if ($deleteResult) {
                                return $this->response->setJSON(['success' => true, 'message' => 'Data berhasil ditolak dan dihapus']);
                            } else {
                                return $this->response->setJSON(['success' => false, 'message' => 'Gagal menghapus data']);
                            }
                        } else {
                            return $this->response->setJSON(['success' => false, 'message' => 'Gagal memindahkan data']);
                        }
                    } else {
                        return $this->response->setJSON(['success' => false, 'message' => 'Data sudah diproses atau tidak sesuai untuk diproses']);
                    }
                } else {
                    return $this->response->setJSON(['success' => false, 'message' => 'Data tidak ditemukan']);
                }
            }
            return $this->response->setJSON(['success' => false, 'message' => 'Request tidak valid']);
        }
        return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized access']);
    }


    public function approveAdjustByPIC($id)
    {
        $userRole = session()->get('role');
        if ($userRole === 'PIC') {
            if ($this->request->isAJAX()) {
                $item = $this->adjustmentModel->find($id);

                if ($item) {
                    if (strpos($item['adjust_pic'], 'Approved Leader') !== false) {
                        $currentDate = date('Y-m-d H:i:s');

                        // Update status to 'Approved PIC' and set pic_action_date
                        $updateResult = $this->adjustmentModel->update($id, [
                            'adjust_pic' => 'Approved PIC',
                            'pic_action_date' => $currentDate
                        ]);

                        if ($updateResult) {
                            $data = [
                                'department' => $item['department'],
                                'pic' => $item['pic'],
                                'tanggal' => $item['tanggal'],
                                'part_number' => $item['part_number'],
                                'qty' => $item['qty'],
                                'lot_number' => $item['lot_number'],
                                'rn' => $item['rn'],
                                'location' => $item['location'],
                                'status' => $item['status'],
                                'remark' => $item['remark'],
                                'adjust_pic' => 'Approved PIC',
                                'created_at' => $item['created_at'],
                                'pic_action_date' => $currentDate // Set action date in history
                            ];

                            $insertResult = $this->historyModel->insert($data);
                            if ($insertResult) {
                                $deleteResult = $this->adjustmentModel->delete($id);
                                if ($deleteResult) {
                                    return $this->response->setJSON(['success' => true, 'message' => 'Data berhasil di-approve oleh PIC']);
                                } else {
                                    return $this->response->setJSON(['success' => false, 'message' => 'Gagal menghapus data']);
                                }
                            } else {
                                return $this->response->setJSON(['success' => false, 'message' => 'Gagal memindahkan data']);
                            }
                        } else {
                            return $this->response->setJSON(['success' => false, 'message' => 'Gagal mengupdate status']);
                        }
                    } else {
                        return $this->response->setJSON(['success' => false, 'message' => 'Data belum di-disapprove oleh Leader']);
                    }
                } else {
                    return $this->response->setJSON(['success' => false, 'message' => 'Data tidak ditemukan']);
                }
            }
            return $this->response->setJSON(['success' => false, 'message' => 'Request tidak valid']);
        }
        return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized access']);
    }




    public function disapproveAdjustByPIC($id)
    {
        $userRole = session()->get('role');
        if ($userRole === 'PIC') {
            if ($this->request->isAJAX()) {
                $reason = $this->request->getPost('reason');
                $item = $this->adjustmentModel->find($id);

                if ($item) {
                    if (strpos($item['adjust_pic'], 'Approved Leader') !== false) {
                        $currentDate = date('Y-m-d H:i:s');

                        // Update status to 'Disapproved PIC' and set pic_action_date
                        $updateResult = $this->adjustmentModel->update($id, [
                            'adjust_pic' => 'Disapproved PIC: ' . $reason,
                            'pic_action_date' => $currentDate
                        ]);

                        if ($updateResult) {
                            $data = [
                                'department' => $item['department'],
                                'pic' => $item['pic'],
                                'tanggal' => $item['tanggal'],
                                'part_number' => $item['part_number'],
                                'qty' => $item['qty'],
                                'lot_number' => $item['lot_number'],
                                'rn' => $item['rn'],
                                'location' => $item['location'],
                                'status' => $item['status'],
                                'remark' => $item['remark'],
                                'adjust_pic' => 'Disapproved PIC: ' . $reason,
                                'created_at' => $item['created_at'],
                                'pic_action_date' => $currentDate // Set action date in history
                            ];

                            $insertResult = $this->historyModel->insert($data);
                            if ($insertResult) {
                                $deleteResult = $this->adjustmentModel->delete($id);
                                if ($deleteResult) {
                                    return $this->response->setJSON(['success' => true, 'message' => 'Data berhasil di-disapprove oleh PIC']);
                                } else {
                                    return $this->response->setJSON(['success' => false, 'message' => 'Gagal menghapus data']);
                                }
                            } else {
                                return $this->response->setJSON(['success' => false, 'message' => 'Gagal memindahkan data']);
                            }
                        } else {
                            return $this->response->setJSON(['success' => false, 'message' => 'Gagal mengupdate status']);
                        }
                    } else {
                        return $this->response->setJSON(['success' => false, 'message' => 'Data belum di-approve oleh Leader']);
                    }
                } else {
                    return $this->response->setJSON(['success' => false, 'message' => 'Data tidak ditemukan']);
                }
            }
            return $this->response->setJSON(['success' => false, 'message' => 'Request tidak valid']);
        }
        return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized access']);
    }





    public function transferStock()
    {
        $userRole = session()->get('role');

        // Jika peran adalah LEADERMFG1, redirect dengan pesan error
        if ($userRole === 'LEADERMFG1') {
            return redirect()->to('/pic')->with('message', 'Unauthorized access.');
        }

        // Tentukan data berdasarkan peran
        switch ($userRole) {
            case 'PIC':
                // Untuk peran PIC, ambil data yang telah disetujui oleh Leader
                $data['transferStocks'] = $this->transferStockModel
                    ->where('adjust_pic', 'Approved Leader')
                    ->findAll();
                break;
            default:
                // Untuk peran selain PIC, ambil data dengan adjust_pic yang NULL
                $data['transferStocks'] = $this->transferStockModel
                    ->where('adjust_pic IS NULL OR adjust_pic =', '')
                    ->findAll();
                break;
        }

        return view('PIC/pic_transfer_stock_view', $data);
    }


    public function approveTransferByLeaderBulk()
    {
        $userRole = session()->get('role');
        if (in_array($userRole, ['LEADERQC'])) {
            if ($this->request->isAJAX()) {
                $ids = $this->request->getPost('ids');

                if (empty($ids) || !is_array($ids)) {
                    return $this->response->setJSON(['success' => false, 'message' => 'ID tidak valid']);
                }

                $success = true;
                $message = '';

                foreach ($ids as $id) {
                    $item = $this->transferStockModel->find($id);

                    if (empty($item['adjust_pic'])) {
                        $updateResult = $this->transferStockModel->update($id, ['adjust_pic' => 'Approved Leader']);
                        if (!$updateResult) {
                            $success = false;
                            $message .= 'Gagal mengupdate status untuk ID: ' . $id . '. ';
                        }
                    } else {
                        $success = false;
                        $message .= 'Data sudah diproses oleh Leader untuk ID: ' . $id . '. ';
                    }
                }

                if ($success) {
                    return $this->response->setJSON(['success' => true, 'message' => 'Data berhasil di-approve oleh Leader']);
                } else {
                    return $this->response->setJSON(['success' => false, 'message' => $message]);
                }
            }
            return redirect()->to('/pic/transferStock')->with('message', 'Unauthorized access.');
        }
        return redirect()->to('/pic/transferStock')->with('message', 'Unauthorized access.');
    }

    public function disapproveTransferByLeaderBulk()
    {
        $userRole = session()->get('role');
        if (in_array($userRole, ['LEADERQC'])) {
            if ($this->request->isAJAX()) {
                $ids = $this->request->getPost('ids');
                $reason = $this->request->getPost('reason');

                if (empty($ids) || !is_array($ids) || empty($reason)) {
                    return $this->response->setJSON(['success' => false, 'message' => 'Data tidak valid']);
                }

                $success = true;
                $message = '';

                foreach ($ids as $id) {
                    $item = $this->transferStockModel->find($id);

                    if ($item && empty($item['adjust_pic'])) {
                        $Data = [
                            'department' => $item['department'],
                            'pic' => $item['pic'],
                            'tanggal' => $item['tanggal'],
                            'part_number_from' => $item['part_number_from'],
                            'part_number_to' => $item['part_number_to'],
                            'qty' => $item['qty'],
                            'lot_number_from' => $item['lot_number_from'],
                            'lot_number_to' => $item['lot_number_to'],
                            'rn_from' => $item['rn_from'],
                            'rn_to' => $item['rn_to'],
                            'warehouse_from' => $item['warehouse_from'],
                            'warehouse_to' => $item['warehouse_to'],
                            'status' => $item['status'],
                            'remark' => $item['remark'],
                            'adjust_pic' => 'Disapproved Leader: ' . $reason,
                            'created_at' => date('Y-m-d H:i:s')
                        ];

                        $insertResult = $this->transferStockHistoryModel->insert($Data);
                        if (!$insertResult) {
                            $success = false;
                            $message .= 'Gagal memindahkan data untuk ID: ' . $id . '. ';
                        }

                        $deleteResult = $this->transferStockModel->delete($id);
                        if (!$deleteResult) {
                            $success = false;
                            $message .= 'Gagal menghapus data untuk ID: ' . $id . '. ';
                        }
                    } else {
                        $success = false;
                        $message .= 'Data tidak ditemukan atau sudah diproses oleh Leader untuk ID: ' . $id . '. ';
                    }
                }

                if ($success) {
                    return $this->response->setJSON(['success' => true, 'message' => 'Data berhasil di-disapprove oleh Leader']);
                } else {
                    return $this->response->setJSON(['success' => false, 'message' => $message]);
                }
            }
            return redirect()->to('/pic/transferStock')->with('message', 'Unauthorized access.');
        }
        return redirect()->to('/pic/transferStock')->with('message', 'Unauthorized access.');
    }

    public function approveTransferByPICBulk()
    {
        $userRole = session()->get('role');
        if ($userRole === 'PIC') {
            if ($this->request->isAJAX()) {
                $ids = $this->request->getPost('ids');

                if (empty($ids) || !is_array($ids)) {
                    return $this->response->setJSON(['success' => false, 'message' => 'ID tidak valid']);
                }

                $success = true;
                $message = '';

                foreach ($ids as $id) {
                    $item = $this->transferStockModel->find($id);

                    if (!$item) {
                        $success = false;
                        $message .= 'Data tidak ditemukan untuk ID: ' . $id . '. ';
                    } elseif (strpos($item['adjust_pic'], 'Approved Leader') !== false) {
                        $updateResult = $this->transferStockModel->update($id, [
                            'adjust_pic' => 'Approved PIC',
                            'pic_action_date' => date('Y-m-d H:i:s')
                        ]);

                        if (!$updateResult) {
                            $success = false;
                            $message .= 'Gagal mengupdate status untuk ID: ' . $id . '. ';
                        }

                        $data = [
                            'department' => $item['department'],
                            'pic' => $item['pic'],
                            'tanggal' => $item['tanggal'],
                            'part_number_from' => $item['part_number_from'],
                            'part_number_to' => $item['part_number_to'],
                            'qty' => $item['qty'],
                            'lot_number_from' => $item['lot_number_from'],
                            'lot_number_to' => $item['lot_number_to'],
                            'rn_from' => $item['rn_from'],
                            'rn_to' => $item['rn_to'],
                            'warehouse_from' => $item['warehouse_from'],
                            'warehouse_to' => $item['warehouse_to'],
                            'status' => $item['status'],
                            'remark' => $item['remark'],
                            'adjust_pic' => 'Approved PIC',
                            'created_at' => $item['created_at'],
                            'pic_action_date' => date('Y-m-d H:i:s')
                        ];

                        $insertResult = $this->transferStockHistoryModel->insert($data);
                        if (!$insertResult) {
                            $success = false;
                            $message .= 'Gagal memindahkan data untuk ID: ' . $id . '. ';
                        }

                        $deleteResult = $this->transferStockModel->delete($id);
                        if (!$deleteResult) {
                            $success = false;
                            $message .= 'Gagal menghapus data untuk ID: ' . $id . '. ';
                        }
                    } else {
                        $success = false;
                        $message .= 'Data belum di-disapprove oleh Leader untuk ID: ' . $id . '. ';
                    }
                }

                if ($success) {
                    return $this->response->setJSON(['success' => true, 'message' => 'Data berhasil di-approve oleh PIC']);
                } else {
                    return $this->response->setJSON(['success' => false, 'message' => $message]);
                }
            }
            return $this->response->setJSON(['success' => false, 'message' => 'Request tidak valid']);
        }
        return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized access']);
    }

    public function disapproveTransferByPICBulk()
    {
        $userRole = session()->get('role');
        if ($userRole === 'PIC') {
            if ($this->request->isAJAX()) {
                $ids = $this->request->getPost('ids');
                $reason = $this->request->getPost('reason');

                if (empty($ids) || !is_array($ids) || empty($reason)) {
                    return $this->response->setJSON(['success' => false, 'message' => 'Data tidak valid']);
                }

                $success = true;
                $message = '';

                foreach ($ids as $id) {
                    $item = $this->transferStockModel->find($id);

                    if (!$item) {
                        $success = false;
                        $message .= 'Data tidak ditemukan untuk ID: ' . $id . '. ';
                    } elseif (strpos($item['adjust_pic'], 'Approved Leader') !== false) {
                        $updateResult = $this->transferStockModel->update($id, [
                            'adjust_pic' => 'Disapproved PIC: ' . $reason,
                            'pic_action_date' => date('Y-m-d H:i:s')
                        ]);

                        if (!$updateResult) {
                            $success = false;
                            $message .= 'Gagal mengupdate status untuk ID: ' . $id . '. ';
                        }

                        $data = [
                            'department' => $item['department'],
                            'pic' => $item['pic'],
                            'tanggal' => $item['tanggal'],
                            'part_number_from' => $item['part_number_from'],
                            'part_number_to' => $item['part_number_to'],
                            'qty' => $item['qty'],
                            'lot_number_from' => $item['lot_number_from'],
                            'lot_number_to' => $item['lot_number_to'],
                            'rn_from' => $item['rn_from'],
                            'rn_to' => $item['rn_to'],
                            'warehouse_from' => $item['warehouse_from'],
                            'warehouse_to' => $item['warehouse_to'],
                            'status' => $item['status'],
                            'remark' => $item['remark'],
                            'adjust_pic' => 'Disapproved PIC: ' . $reason,
                            'created_at' => $item['created_at'],
                            'pic_action_date' => date('Y-m-d H:i:s')
                        ];

                        $insertResult = $this->transferStockHistoryModel->insert($data);
                        if (!$insertResult) {
                            $success = false;
                            $message .= 'Gagal memindahkan data untuk ID: ' . $id . '. ';
                        }

                        $deleteResult = $this->transferStockModel->delete($id);
                        if (!$deleteResult) {
                            $success = false;
                            $message .= 'Gagal menghapus data untuk ID: ' . $id . '. ';
                        }
                    } else {
                        $success = false;
                        $message .= 'Data belum di-approve oleh Leader untuk ID: ' . $id . '. ';
                    }
                }

                if ($success) {
                    return $this->response->setJSON(['success' => true, 'message' => 'Data berhasil di-disapprove oleh PIC']);
                } else {
                    return $this->response->setJSON(['success' => false, 'message' => $message]);
                }
            }
            return $this->response->setJSON(['success' => false, 'message' => 'Request tidak valid']);
        }
        return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized access']);
    }





    public function approveTransferByLeader($id)
    {
        $userRole = session()->get('role');
        if (in_array($userRole, ['LEADERQC'])) {
            if ($this->request->isAJAX()) {
                $item = $this->transferStockModel->find($id);

                // Cek apakah adjust_pic kosong
                if (empty($item['adjust_pic'])) {
                    $updateResult = $this->transferStockModel->update($id, ['adjust_pic' => 'Approved Leader']);
                    if ($updateResult) {
                        return $this->response->setJSON(['success' => true, 'message' => 'Data berhasil di-approve oleh Leader']);
                    } else {
                        return $this->response->setJSON(['success' => false, 'message' => 'Gagal mengupdate status']);
                    }
                } else {
                    return $this->response->setJSON(['success' => false, 'message' => 'Data sudah diproses oleh Leader']);
                }
            }
            return redirect()->to('/pic/transferStock')->with('message', 'Data berhasil di-approve oleh Leader');
        }
        return redirect()->to('/pic/transferStock')->with('message', 'Unauthorized access.');
    }


    public function disapproveTransferByLeader($id)
    {
        // Cek role pengguna
        $userRole = session()->get('role');
        if (in_array($userRole, ['LEADERQC'])) {
            // Cek apakah ini permintaan AJAX
            if ($this->request->isAJAX()) {
                // Ambil alasan dari post data
                $reason = $this->request->getPost('reason');
                // Temukan data berdasarkan ID
                $item = $this->transferStockModel->find($id);

                // Cek apakah data ditemukan dan status adjust_pic kosong
                if ($item && empty($item['adjust_pic'])) {
                    // Persiapkan data untuk dimasukkan ke tabel transfer_stock_history
                    $Data = [
                        'department' => $item['department'],
                        'pic' => $item['pic'],
                        'tanggal' => $item['tanggal'],
                        'part_number_from' => $item['part_number_from'],
                        'part_number_to' => $item['part_number_to'],
                        'qty' => $item['qty'],
                        'lot_number_from' => $item['lot_number_from'],
                        'lot_number_to' => $item['lot_number_to'],
                        'rn_from' => $item['rn_from'],
                        'rn_to' => $item['rn_to'],
                        'warehouse_from' => $item['warehouse_from'],
                        'warehouse_to' => $item['warehouse_to'],
                        'status' => $item['status'],
                        'remark' => $item['remark'],
                        'adjust_pic' => 'Disapproved Leader: ' . $reason,
                        'created_at' => date('Y-m-d H:i:s')
                    ];

                    // Insert data ke transfer_stock_history
                    $insertResult = $this->transferStockHistoryModel->insert($Data);
                    if (!$insertResult) {
                        return $this->response->setJSON(['success' => false, 'message' => 'Gagal memindahkan data']);
                    }

                    // Hapus data dari tabel transfer_stock
                    $deleteResult = $this->transferStockModel->delete($id);
                    if (!$deleteResult) {
                        return $this->response->setJSON(['success' => false, 'message' => 'Gagal menghapus data']);
                    }

                    // Kirimkan respon sukses
                    return $this->response->setJSON(['success' => true, 'message' => 'Data berhasil di-disapprove oleh Leader dan dihapus']);
                } else {
                    // Data tidak ditemukan atau sudah diproses
                    return $this->response->setJSON(['success' => false, 'message' => 'Data tidak ditemukan atau sudah diproses oleh Leader']);
                }
            }
            // Redirect jika bukan AJAX
            return redirect()->to('/pic/transferStock')->with('message', 'Data berhasil di-disapprove oleh Leader');
        }
        // Redirect jika akses tidak sah
        return redirect()->to('/pic/transferStock')->with('message', 'Unauthorized access.');
    }

    public function approveTransferByPIC($id)
    {
        $userRole = session()->get('role');

        if ($userRole === 'PIC') {
            if ($this->request->isAJAX()) {
                $item = $this->transferStockModel->find($id);

                if (!$item) {
                    return $this->response->setJSON(['success' => false, 'message' => 'Data tidak ditemukan']);
                }

                if (strpos($item['adjust_pic'], 'Approved Leader') !== false) {
                    $updateResult = $this->transferStockModel->update($id, [
                        'adjust_pic' => 'Approved PIC',
                        'pic_action_date' => date('Y-m-d H:i:s') // Menambahkan tanggal dan waktu aksi PIC
                    ]);
                    if (!$updateResult) {
                        return $this->response->setJSON(['success' => false, 'message' => 'Gagal mengupdate status']);
                    }

                    $data = [
                        'department' => $item['department'],
                        'pic' => $item['pic'],
                        'tanggal' => $item['tanggal'],
                        'part_number_from' => $item['part_number_from'],
                        'part_number_to' => $item['part_number_to'],
                        'qty' => $item['qty'],
                        'lot_number_from' => $item['lot_number_from'],
                        'lot_number_to' => $item['lot_number_to'],
                        'rn_from' => $item['rn_from'],
                        'rn_to' => $item['rn_to'],
                        'warehouse_from' => $item['warehouse_from'],
                        'warehouse_to' => $item['warehouse_to'],
                        'status' => $item['status'],
                        'remark' => $item['remark'],
                        'adjust_pic' => 'Approved PIC',
                        'created_at' => $item['created_at'],
                        'pic_action_date' => date('Y-m-d H:i:s') // Menambahkan tanggal dan waktu aksi PIC
                    ];

                    $insertResult = $this->transferStockHistoryModel->insert($data);
                    if (!$insertResult) {
                        return $this->response->setJSON(['success' => false, 'message' => 'Gagal memindahkan data']);
                    }

                    $deleteResult = $this->transferStockModel->delete($id);
                    if (!$deleteResult) {
                        return $this->response->setJSON(['success' => false, 'message' => 'Gagal menghapus data']);
                    }

                    return $this->response->setJSON(['success' => true, 'message' => 'Data berhasil di-approve oleh PIC']);
                } else {
                    return $this->response->setJSON(['success' => false, 'message' => 'Data belum di-disapprove oleh Leader']);
                }
            }

            return $this->response->setJSON(['success' => false, 'message' => 'Request tidak valid']);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized access']);
    }



    public function disapproveTransferByPIC($id)
    {
        $userRole = session()->get('role');
        if ($userRole === 'PIC') {
            if ($this->request->isAJAX()) {
                $reason = $this->request->getPost('reason');
                $item = $this->transferStockModel->find($id);

                if (!$item) {
                    return $this->response->setJSON(['success' => false, 'message' => 'Data tidak ditemukan']);
                }

                if (strpos($item['adjust_pic'], 'Approved Leader') !== false) {
                    $updateResult = $this->transferStockModel->update($id, [
                        'adjust_pic' => 'Disapproved PIC: ' . $reason,
                        'pic_action_date' => date('Y-m-d H:i:s') // Menambahkan tanggal dan waktu aksi PIC
                    ]);
                    if (!$updateResult) {
                        return $this->response->setJSON(['success' => false, 'message' => 'Gagal mengupdate status']);
                    }

                    $data = [
                        'department' => $item['department'],
                        'pic' => $item['pic'],
                        'tanggal' => $item['tanggal'],
                        'part_number_from' => $item['part_number_from'],
                        'part_number_to' => $item['part_number_to'],
                        'qty' => $item['qty'],
                        'lot_number_from' => $item['lot_number_from'],
                        'lot_number_to' => $item['lot_number_to'],
                        'rn_from' => $item['rn_from'],
                        'rn_to' => $item['rn_to'],
                        'warehouse_from' => $item['warehouse_from'],
                        'warehouse_to' => $item['warehouse_to'],
                        'status' => $item['status'],
                        'remark' => $item['remark'],
                        'adjust_pic' => 'Disapproved PIC: ' . $reason,
                        'created_at' => $item['created_at'],
                        'pic_action_date' => date('Y-m-d H:i:s') // Menambahkan tanggal dan waktu aksi PIC
                    ];

                    $insertResult = $this->transferStockHistoryModel->insert($data);
                    if (!$insertResult) {
                        return $this->response->setJSON(['success' => false, 'message' => 'Gagal memindahkan data']);
                    }

                    $deleteResult = $this->transferStockModel->delete($id);
                    if (!$deleteResult) {
                        return $this->response->setJSON(['success' => false, 'message' => 'Gagal menghapus data']);
                    }

                    return $this->response->setJSON(['success' => true, 'message' => 'Data berhasil di-disapprove oleh PIC']);
                } else {
                    return $this->response->setJSON(['success' => false, 'message' => 'Data belum di-approve oleh Leader']);
                }
            }
            return $this->response->setJSON(['success' => false, 'message' => 'Request tidak valid']);
        }
        return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized access']);
    }



    public function cancelLot()
    {
        $userRole = session()->get('role');

        // Filter data cancel lot berdasarkan role pengguna
        switch ($userRole) {
            case 'LEADERMFG1':
            case 'MFG1':
                // Untuk LEADERMFG1 dan MFG1, ambil data dari departemen MFG1 dengan adjust_pic NULL
                $data['cancelLots'] = $this->cancelLotModel
                    ->where('department', 'MFG1')
                    ->where('adjust_pic IS NULL OR adjust_pic =', '')
                    ->findAll();
                break;
            case 'LEADERMFG2':
            case 'MFG2':
                // Untuk LEADERMFG2 dan MFG2, ambil data dari departemen MFG2 dengan adjust_pic NULL
                $data['cancelLots'] = $this->cancelLotModel
                    ->where('department', 'MFG2')
                    ->where('adjust_pic IS NULL OR adjust_pic =', '')
                    ->findAll();
                break;
            case 'LEADERQC':
            case 'USER':
                // Untuk LEADERQC dan USER, ambil data dari departemen QC dengan adjust_pic NULL
                $data['cancelLots'] = $this->cancelLotModel
                    ->where('department', 'QC')
                    ->where('adjust_pic IS NULL OR adjust_pic =', '')
                    ->findAll();
                break;
            case 'CS':
                // Untuk CS, ambil data dari departemen DELIVERY dengan adjust_pic NULL
                $data['cancelLots'] = $this->cancelLotModel
                    ->where('department', 'DELIVERY')
                    ->where('adjust_pic IS NULL OR adjust_pic =', '')
                    ->findAll();
                break;
            case 'PIC':
                // Untuk role PIC, ambil data dengan status adjust_pic = 'Approved Leader'
                $data['cancelLots'] = $this->cancelLotModel
                    ->where('adjust_pic', 'Approved Leader')
                    ->findAll();
                break;
            default:
                // Jika role tidak dikenali atau tidak termasuk dalam filter khusus, ambil semua data
                $data['cancelLots'] = $this->cancelLotModel->findAll();
                break;
        }

        return view('PIC/pic_cancel_lot_view', $data);
    }



    public function approveByLeader($id)
    {
        $userRole = session()->get('role');
        if (in_array($userRole, ['LEADERMFG1', 'LEADERMFG2', 'LEADERQC', 'CS'])) {
            if ($this->request->isAJAX()) {
                $item = $this->cancelLotModel->find($id);

                // Check if adjust_pic is empty
                if (empty($item['adjust_pic'])) {
                    $this->cancelLotModel->update($id, ['adjust_pic' => 'Approved Leader']);
                    return $this->response->setJSON(['success' => true, 'message' => 'Data berhasil di-approve oleh Leader']);
                } else {
                    return $this->response->setJSON(['success' => false, 'message' => 'Data sudah diproses oleh Leader']);
                }
            }
            return redirect()->to('/pic/cancelLot')->with('message', 'Data berhasil di-approve oleh Leader');
        }
        return redirect()->to('/pic/cancelLot')->with('message', 'Unauthorized access.');
    }
    public function disapproveByLeader($id)
    {
        // Cek role pengguna
        $userRole = session()->get('role');
        if (in_array($userRole, ['LEADERMFG1', 'LEADERMFG2', 'LEADERQC', 'PIC2', 'CS'])) {
            // Cek apakah ini permintaan AJAX
            if ($this->request->isAJAX()) {
                // Ambil alasan dari post data
                $reason = $this->request->getPost('reason');
                // Temukan data berdasarkan ID
                $item = $this->cancelLotModel->find($id);

                // Cek apakah data ditemukan dan status adjust_pic kosong
                if ($item && empty($item['adjust_pic'])) {
                    // Persiapkan data untuk dimasukkan ke tabel tb_allcancel
                    $tbAllcancelData = [
                        'department' => $item['department'],
                        'pic' => $item['pic'],
                        'tanggal' => $item['tanggal'],
                        'part_number_from' => $item['part_number_from'],
                        'part_number_to' => $item['part_number_to'],
                        'qty' => $item['qty'],
                        'lot_number' => $item['lot_number'],
                        'warehouse_from' => $item['warehouse_from'],
                        'warehouse_to' => $item['warehouse_to'],
                        'remark' => $item['remark'],
                        'adjust_pic' => 'Disapproved Leader: ' . $reason,
                        'created_at' => date('Y-m-d H:i:s')
                    ];

                    // Insert data ke tb_allcancel
                    $insertResult = $this->allCancelModel->insert($tbAllcancelData);
                    if (!$insertResult) {
                        return $this->response->setJSON(['success' => false, 'message' => 'Gagal memindahkan data']);
                    }

                    // Hapus data dari tabel cancel_lot
                    $deleteResult = $this->cancelLotModel->delete($id);
                    if (!$deleteResult) {
                        return $this->response->setJSON(['success' => false, 'message' => 'Gagal menghapus data']);
                    }

                    // Kirimkan respon sukses
                    return $this->response->setJSON(['success' => true, 'message' => 'Data berhasil di-disapprove oleh Leader dan dihapus']);
                } else {
                    // Data tidak ditemukan atau sudah diproses
                    return $this->response->setJSON(['success' => false, 'message' => 'Data tidak ditemukan atau sudah diproses oleh Leader']);
                }
            }
            // Redirect jika bukan AJAX
            return redirect()->to('/pic/cancelLot')->with('message', 'Data berhasil di-disapprove oleh Leader');
        }
        // Redirect jika akses tidak sah
        return redirect()->to('/pic/cancelLot')->with('message', 'Unauthorized access.');
    }

    public function approveByPIC($id)
    {
        $userRole = session()->get('role');

        if ($userRole === 'PIC') {
            if ($this->request->isAJAX()) {
                $item = $this->cancelLotModel->find($id);

                // Ensure data is found
                if (!$item) {
                    return $this->response->setJSON(['success' => false, 'message' => 'Data tidak ditemukan']);
                }

                // Check if status is already 'Approved Leader'
                if (strpos($item['adjust_pic'], 'Approved Leader') !== false) {
                    $currentDate = date('Y-m-d H:i:s');

                    // Update status to 'Approved PIC' and set PIC action date
                    $updateData = [
                        'adjust_pic' => 'Approved PIC',
                        'pic_action_date' => $currentDate
                    ];
                    if (!$this->cancelLotModel->update($id, $updateData)) {
                        return $this->response->setJSON(['success' => false, 'message' => 'Gagal mengupdate status']);
                    }

                    // Prepare data to insert into tb_allcancel
                    $data = [
                        'department' => $item['department'],
                        'pic' => $item['pic'],
                        'tanggal' => $item['tanggal'],
                        'part_number_from' => $item['part_number_from'],
                        'part_number_to' => $item['part_number_to'],
                        'qty' => $item['qty'],
                        'lot_number' => $item['lot_number'],
                        'warehouse_from' => $item['warehouse_from'],
                        'warehouse_to' => $item['warehouse_to'],
                        'remark' => $item['remark'],
                        'pic_action_date' => $currentDate,
                        'adjust_pic' => 'Approved PIC'
                    ];

                    // Insert data into tb_allcancel
                    if (!$this->allCancelModel->insert($data)) {
                        return $this->response->setJSON(['success' => false, 'message' => 'Gagal memindahkan data']);
                    }

                    // Delete data from cancel_lot
                    if (!$this->cancelLotModel->delete($id)) {
                        return $this->response->setJSON(['success' => false, 'message' => 'Gagal menghapus data']);
                    }

                    return $this->response->setJSON(['success' => true, 'message' => 'Data berhasil di-approve oleh PIC']);
                } else {
                    return $this->response->setJSON(['success' => false, 'message' => 'Data belum di-approve oleh Leader']);
                }
            }

            return $this->response->setJSON(['success' => false, 'message' => 'Request tidak valid']);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized access']);
    }


    public function disapproveByPIC($id)
    {
        $userRole = session()->get('role');

        if ($userRole === 'PIC') {
            if ($this->request->isAJAX()) {
                $reason = $this->request->getPost('reason');
                $item = $this->cancelLotModel->find($id);

                // Ensure data is found
                if (!$item) {
                    return $this->response->setJSON(['success' => false, 'message' => 'Data tidak ditemukan']);
                }

                // Check if status is already 'Approved Leader'
                if (strpos($item['adjust_pic'], 'Approved Leader') !== false) {
                    $currentDate = date('Y-m-d H:i:s');

                    // Update status to 'Disapproved PIC' and set PIC action date
                    $updateData = [
                        'adjust_pic' => 'Disapproved PIC',
                        'pic_action_date' => $currentDate
                    ];
                    if (!$this->cancelLotModel->update($id, $updateData)) {
                        return $this->response->setJSON(['success' => false, 'message' => 'Gagal mengupdate status']);
                    }

                    // Prepare data to insert into tb_allcancel
                    $data = [
                        'department' => $item['department'],
                        'pic' => $item['pic'],
                        'tanggal' => $item['tanggal'],
                        'part_number_from' => $item['part_number_from'],
                        'part_number_to' => $item['part_number_to'],
                        'qty' => $item['qty'],
                        'lot_number' => $item['lot_number'],
                        'warehouse_from' => $item['warehouse_from'],
                        'warehouse_to' => $item['warehouse_to'],
                        'remark' => $item['remark'],
                        'pic_action_date' => $currentDate,
                        'adjust_pic' => 'Disapproved PIC: ' . $reason,
                        'created_at' => $item['created_at']
                    ];

                    // Insert data into tb_allcancel
                    if (!$this->allCancelModel->insert($data)) {
                        return $this->response->setJSON(['success' => false, 'message' => 'Gagal memindahkan data']);
                    }

                    // Delete data from cancel_lot
                    if (!$this->cancelLotModel->delete($id)) {
                        return $this->response->setJSON(['success' => false, 'message' => 'Gagal menghapus data']);
                    }

                    return $this->response->setJSON(['success' => true, 'message' => 'Data berhasil di-disapprove oleh PIC']);
                } else {
                    return $this->response->setJSON(['success' => false, 'message' => 'Data belum di-approve oleh Leader']);
                }
            }

            return $this->response->setJSON(['success' => false, 'message' => 'Request tidak valid']);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized access']);
    }

    public function approveSelectedByLeader()
    {
        $userRole = session()->get('role');

        // Verifikasi role pengguna
        if (in_array($userRole, ['LEADERMFG1', 'LEADERMFG2', 'LEADERQC', 'CS'])) {
            if ($this->request->isAJAX()) {
                $ids = $this->request->getPost('ids');

                // Validasi data IDs
                if (is_array($ids) && !empty($ids)) {
                    // Persiapkan data untuk pembaruan batch
                    $updateData = [];
                    foreach ($ids as $id) {
                        $updateData[] = [
                            'id' => $id, // ID entri yang akan diperbarui
                            'adjust_pic' => 'Approved Leader'
                        ];
                    }

                    // Lakukan pembaruan batch
                    $result = $this->cancelLotModel->updateBatch($updateData, 'id');

                    if ($result) {
                        return $this->response->setJSON(['success' => true, 'message' => 'Data berhasil di-approve oleh Leader']);
                    } else {
                        return $this->response->setJSON(['success' => false, 'message' => 'Gagal mengupdate data']);
                    }
                }

                return $this->response->setJSON(['success' => false, 'message' => 'Data tidak valid']);
            }

            return $this->response->setJSON(['success' => false, 'message' => 'Request tidak valid']);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized access']);
    }


    public function disapproveSelectedByLeader()
    {
        $userRole = session()->get('role');

        if (in_array($userRole, ['LEADERMFG1', 'LEADERMFG2', 'LEADERQC', 'CS'])) {
            if ($this->request->isAJAX()) {
                $ids = $this->request->getPost('ids');
                $reason = $this->request->getPost('reason');

                if (is_array($ids) && !empty($ids) && $reason) {
                    foreach ($ids as $id) {
                        $item = $this->cancelLotModel->find($id);

                        if ($item && empty($item['adjust_pic'])) {
                            $tbAllcancelData = [
                                'department' => $item['department'],
                                'pic' => $item['pic'],
                                'tanggal' => $item['tanggal'],
                                'part_number_from' => $item['part_number_from'],
                                'part_number_to' => $item['part_number_to'],
                                'qty' => $item['qty'],
                                'lot_number' => $item['lot_number'],
                                'warehouse_from' => $item['warehouse_from'],
                                'warehouse_to' => $item['warehouse_to'],
                                'remark' => $item['remark'],
                                'adjust_pic' => 'Disapproved Leader: ' . $reason,
                                'created_at' => date('Y-m-d H:i:s')
                            ];

                            $this->allCancelModel->insert($tbAllcancelData);
                            $this->cancelLotModel->delete($id);
                        }
                    }

                    return $this->response->setJSON(['success' => true, 'message' => 'Data berhasil di-disapprove oleh Leader']);
                }

                return $this->response->setJSON(['success' => false, 'message' => 'Data tidak valid atau alasan tidak disediakan']);
            }
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized access']);
    }

    public function approveSelectedByPIC()
    {
        $userRole = session()->get('role');

        if ($userRole === 'PIC') {
            if ($this->request->isAJAX()) {
                $ids = $this->request->getPost('ids');

                if (is_array($ids) && !empty($ids)) {
                    $currentDate = date('Y-m-d H:i:s');

                    foreach ($ids as $id) {
                        $item = $this->cancelLotModel->find($id);

                        if ($item && strpos($item['adjust_pic'], 'Approved Leader') !== false) {
                            $updateData = [
                                'adjust_pic' => 'Approved PIC',
                                'pic_action_date' => $currentDate
                            ];
                            $this->cancelLotModel->update($id, $updateData);

                            $data = [
                                'department' => $item['department'],
                                'pic' => $item['pic'],
                                'tanggal' => $item['tanggal'],
                                'part_number_from' => $item['part_number_from'],
                                'part_number_to' => $item['part_number_to'],
                                'qty' => $item['qty'],
                                'lot_number' => $item['lot_number'],
                                'warehouse_from' => $item['warehouse_from'],
                                'warehouse_to' => $item['warehouse_to'],
                                'remark' => $item['remark'],
                                'pic_action_date' => $currentDate,
                                'adjust_pic' => 'Approved PIC'
                            ];
                            $this->allCancelModel->insert($data);
                            $this->cancelLotModel->delete($id);
                        }
                    }

                    return $this->response->setJSON(['success' => true, 'message' => 'Data berhasil di-approve oleh PIC']);
                }

                return $this->response->setJSON(['success' => false, 'message' => 'Data tidak valid']);
            }
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized access']);
    }

    public function disapproveSelectedByPIC()
    {
        $userRole = session()->get('role');

        if ($userRole === 'PIC') {
            if ($this->request->isAJAX()) {
                $ids = $this->request->getPost('ids');
                $reason = $this->request->getPost('reason');

                if (is_array($ids) && !empty($ids) && $reason) {
                    $currentDate = date('Y-m-d H:i:s');

                    foreach ($ids as $id) {
                        $item = $this->cancelLotModel->find($id);

                        if ($item && strpos($item['adjust_pic'], 'Approved Leader') !== false) {
                            $updateData = [
                                'adjust_pic' => 'Disapproved PIC',
                                'pic_action_date' => $currentDate
                            ];
                            $this->cancelLotModel->update($id, $updateData);

                            $data = [
                                'department' => $item['department'],
                                'pic' => $item['pic'],
                                'tanggal' => $item['tanggal'],
                                'part_number_from' => $item['part_number_from'],
                                'part_number_to' => $item['part_number_to'],
                                'qty' => $item['qty'],
                                'lot_number' => $item['lot_number'],
                                'warehouse_from' => $item['warehouse_from'],
                                'warehouse_to' => $item['warehouse_to'],
                                'remark' => $item['remark'],
                                'pic_action_date' => $currentDate,
                                'adjust_pic' => 'Disapproved PIC: ' . $reason,
                                'created_at' => $item['created_at']
                            ];
                            $this->allCancelModel->insert($data);
                            $this->cancelLotModel->delete($id);
                        }
                    }

                    return $this->response->setJSON(['success' => true, 'message' => 'Data berhasil di-disapprove oleh PIC']);
                }

                return $this->response->setJSON(['success' => false, 'message' => 'Data tidak valid atau alasan tidak disediakan']);
            }
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized access']);
    }




    public function export($type)
    {
        // Retrieve filter parameters from the request
        $minDate = $this->request->getGet('minDate');
        $maxDate = $this->request->getGet('maxDate');
        $status = $this->request->getGet('status');

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Define filename with dynamic values
        $filename = 'adjustment-inventory_' .
            date('Ymd', strtotime($minDate)) . '_' .
            date('Ymd', strtotime($maxDate)) . '_' .
            urlencode($status) . '.xlsx';

        switch ($type) {
            case 'inventory':
                // Apply filters to the query
                $builder = $this->adjustmentModel->builder();

                if ($minDate) {
                    $builder->where('tanggal >=', $minDate);
                }
                if ($maxDate) {
                    $builder->where('tanggal <=', $maxDate);
                }
                if ($status) {
                    $builder->where('status', $status);
                }

                $data = $builder->get()->getResultArray();

                // Set header row
                $sheet->setCellValue('A1', 'No')
                    ->setCellValue('B1', 'Department')
                    ->setCellValue('C1', 'Part Number')
                    ->setCellValue('D1', 'Tanggal')
                    ->setCellValue('E1', 'Quantity')
                    ->setCellValue('F1', 'No. Lot/RN')
                    ->setCellValue('G1', 'Location')
                    ->setCellValue('H1', 'Status')
                    ->setCellValue('I1', 'Remark')
                    ->setCellValue('J1', 'Adjust PIC');

                $row = 2;
                foreach ($data as $item) {
                    $sheet->setCellValue('A' . $row, $item['id'])
                        ->setCellValue('B' . $row, $item['department'])
                        ->setCellValue('C' . $row, $item['part_number'])
                        ->setCellValue('D' . $row, $item['tanggal'])
                        ->setCellValue('E' . $row, $item['qty'])
                        ->setCellValue('F' . $row, $item['lot_number'])
                        ->setCellValue('G' . $row, $item['location'])
                        ->setCellValue('H' . $row, $item['status'])
                        ->setCellValue('I' . $row, $item['remark'])
                        ->setCellValue('J' . $row, $item['adjust_pic']);
                    $row++;
                }
                break;

            default:
                return redirect()->to('/pic')->with('message', 'Invalid export type');
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }


    public function exportFilteredData()
    {
        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');

        // Validasi tanggal
        if (!$startDate || !$endDate) {
            return redirect()->back()->with('message', 'Tanggal mulai dan selesai diperlukan.');
        }

        // Ambil data berdasarkan rentang tanggal
        $data = $this->cancelLotModel->getFilteredData($startDate, $endDate);

        // Set headers untuk ekspor CSV
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="cancel_lot_filtered.csv"');

        $output = fopen('php://output', 'w');
        // Menulis header CSV
        fputcsv($output, ['No', 'Department', 'Tanggal', 'Part Number From', 'Part Number To', 'Quantity', 'Lot Number', 'Warehouse From', 'Remark', 'Adjust PIC']);

        // Menulis data CSV
        foreach ($data as $row) {
            fputcsv($output, $row);
        }

        fclose($output);
        exit();
    }




}

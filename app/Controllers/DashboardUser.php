<?php

namespace App\Controllers;

use App\Models\InventoryModel;
use App\Models\TransferStockModel;
use App\Models\CancelLotModel;

class DashboardUser extends BaseController
{

    // public function index()
    // {
    //     $inventoryModel = new InventoryModel();
    //     $transferStockModel = new TransferStockModel();
    //     $cancelLotModel = new CancelLotModel();

    //     // Hitung data waiting approved
    //     $waitingApprovedItems = $inventoryModel->where('adjust_pic IS NULL', null, false)->countAllResults();
    //     $waitingApprovedItemsTransfer = $transferStockModel->where('adjust_pic IS NULL', null, false)->countAllResults();
    //     $waitingApprovedItemsCancelLot = $cancelLotModel->where('adjust_pic IS NULL', null, false)->countAllResults();

    //     // Hitung data approved
    //     $approvedItems = $inventoryModel->where('adjust_pic', 'approved')->countAllResults();
    //     $approvedItemsTransfer = $transferStockModel->where('adjust_pic', 'approved')->countAllResults();
    //     $approvedItemsCancelLot = $cancelLotModel->where('adjust_pic', 'approved')->countAllResults();

    //     // Hitung data disapproved
    //     $disapprovedItems = $inventoryModel->like('adjust_pic', 'disapproved')->countAllResults();
    //     $disapprovedItemsTransfer = $transferStockModel->like('adjust_pic', 'disapproved')->countAllResults();
    //     $disapprovedItemsCancelLot = $cancelLotModel->like('adjust_pic', 'disapproved')->countAllResults();

    //     return view('dashboard', [
    //         'waitingApprovedItems' => $waitingApprovedItems,
    //         'waitingApprovedItemsTransfer' => $waitingApprovedItemsTransfer,
    //         'waitingApprovedItemsCancelLot' => $waitingApprovedItemsCancelLot,
    //         'approvedItems' => $approvedItems,
    //         'approvedItemsTransfer' => $approvedItemsTransfer,
    //         'approvedItemsCancelLot' => $approvedItemsCancelLot,
    //         'disapprovedItems' => $disapprovedItems,
    //         'disapprovedItemsTransfer' => $disapprovedItemsTransfer,
    //         'disapprovedItemsCancelLot' => $disapprovedItemsCancelLot,
    //     ]);
    // }

    public function waitingApproved()
    {
        $inventoryModel = new InventoryModel();
        $waitingApprovedItems = $inventoryModel->where('adjust_pic IS NULL', null, false)->findAll();

        $transferStockModel = new TransferStockModel();
        $waitingApprovedItemsTransfer = $transferStockModel->where('adjust_pic IS NULL', null, false)->findAll();

        $cancelLotModel = new CancelLotModel();
        $waitingApprovedItemsCancelLot = $cancelLotModel->where('adjust_pic IS NULL', null, false)->findAll();

        return view('waiting_approved', [
            'waitingApprovedItems' => $waitingApprovedItems,
            'waitingApprovedItemsTransfer' => $waitingApprovedItemsTransfer,
            'waitingApprovedItemsCancelLot' => $waitingApprovedItemsCancelLot
        ]);
    }

    public function approved()
    {
        $inventoryModel = new InventoryModel();
        $approvedItems = $inventoryModel->where('adjust_pic', 'approved')->findAll();

        $transferStockModel = new TransferStockModel();
        $approvedItemsTransfer = $transferStockModel->where('adjust_pic', 'approved')->findAll();

        $cancelLotModel = new CancelLotModel();
        $approvedItemsCancelLot = $cancelLotModel->where('adjust_pic', 'approved')->findAll();

        return view('approved', [
            'approvedItems' => $approvedItems,
            'approvedItemsTransfer' => $approvedItemsTransfer,
            'approvedItemsCancelLot' => $approvedItemsCancelLot
        ]);
    }

    public function disapproved()
    {
        $inventoryModel = new InventoryModel();
        $disapprovedItems = $inventoryModel->like('adjust_pic', 'disapproved')->findAll();

        $transferStockModel = new TransferStockModel();
        $disapprovedItemsTransfer = $transferStockModel->like('adjust_pic', 'disapproved')->findAll();

        $cancelLotModel = new CancelLotModel();
        $disapprovedItemsCancelLot = $cancelLotModel->like('adjust_pic', 'disapproved')->findAll();

        return view('disapproved', [
            'disapprovedItems' => $disapprovedItems,
            'disapprovedItemsTransfer' => $disapprovedItemsTransfer,
            'disapprovedItemsCancelLot' => $disapprovedItemsCancelLot
        ]);
    }
}

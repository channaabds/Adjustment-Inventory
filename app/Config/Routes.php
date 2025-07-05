<?php

namespace Config;


use CodeIgniter\Config\BaseConfig;

$routes = Services::routes();

$routes->get('/register', 'Register::index');
$routes->post('/register/save', 'Register::save');

// modifikasi
// $routes->get('/login', 'Login::index');
// $routes->post('/login/auth', 'Login::auth');
// $routes->get('/logout', 'Login::logout');
// $routes->get('/dashboard', 'Dashboard::index'); // Assuming you have a Dashboard controller
// $routes->get('/generate-password', 'PasswordGenerator::generate');
// $routes->get('/create-admin', 'UserSeeder::createAdmin');
// $routes->get('/create-users', 'UserSeeder::createUsers');
$routes->get('alldata', 'AllDataController::index');
$routes->get('/alldata', 'AllDataController::index');


$routes->get('/', 'LoginController::index');
$routes->get('/logout', 'LoginController::index');
$routes->get('/login', 'LoginController::index');
$routes->post('/login/authenticate', 'LoginController::authenticate');
// $routes->get('/dashboard', 'DashboardController::index');

$routes->get('/inventory', 'InventoryController::index');
$routes->get('/inventory/transfer', 'InventoryController::transferStock');

$routes->post('/inventory/save', 'InventoryController::save');
$routes->get('/inventory/getPartNumbers', 'InventoryController::getPartNumbers');
$routes->get('/inventory/getLocations', 'InventoryController::getLocations');

$routes->get('/', 'InventoryController::index');
$routes->get('/inventory', 'InventoryController::index');
$routes->post('/inventory/save', 'InventoryController::save');
$routes->post('/inventory/saveTransferStock', 'InventoryController::saveTransferStock');
$routes->get('/inventory/getPartNumbers', 'InventoryController::getPartNumbers');
$routes->get('/inventory/getLocations', 'InventoryController::getLocations'); // Tambahkan rute ini
$routes->get('/inventory/edit/(:num)', 'InventoryController::edit/$1');
$routes->post('/inventory/update', 'InventoryController::update');
$routes->get('/inventory/delete/(:num)', 'InventoryController::delete/$1');

// $routes->get('transfer-stock/edit/(:num)', 'TransferStockController::edit/$1');
// $routes->post('transfer-stock/update/(:num)', 'TransferStockController::update/$1');
// $routes->get('transfer-stock/delete/(:num)', 'TransferStockController::delete/$1');

$routes->get('inventory/transfer/edit/(:num)', 'InventoryController::editTransferStock/$1');
$routes->get('inventory/transfer/delete/(:num)', 'InventoryController::deleteTransferStock/$1');
$routes->post('inventory/updateTransferStock', 'InventoryController::updateTransferStock');// yoi

$routes->get('/inventory/cancelLot', 'InventoryController::cancelLot');
$routes->post('/inventory/saveCancelLot', 'InventoryController::saveCancelLot');

$routes->get('/inventory/cancel', 'InventoryController::cancelLot');
$routes->post('/inventory/saveCancelLot', 'InventoryController::saveCancelLot');
$routes->get('/inventory/cancel/edit/(:num)', 'InventoryController::editCancelLot/$1');
$routes->post('/inventory/cancel/update/(:num)', 'InventoryController::updateCancelLot/$1');
$routes->get('/inventory/cancel/delete/(:num)', 'InventoryController::deleteCancelLot/$1');
$routes->post('/inventory/updateCancelLot', 'InventoryController::updateCancelLot');

$routes->get('inventory/getPartNumberToAndWarehouse', 'InventoryController::getPartNumberToAndWarehouse');
$routes->get('inventory/getPartNumberTo', 'InventoryController::getPartNumberTo');
$routes->post('/inventory/getWarehouseByItemCode', 'InventoryController::getWarehouseByItemCode'); // baru

$routes->get('inventory/cancel/edit/(:segment)', 'Inventory::editCancelLot/$1');
$routes->post('inventory/updateCancelLot/(:segment)', 'Inventory::updateCancelLot/$1');
$routes->get('inventory/getPartNumbers', 'Inventory::getPartNumbers');
$routes->get('inventory/getPartNumberTo', 'Inventory::getPartNumberTo');
$routes->get('inventory/getLocations', 'Inventory::getLocations');

// $routes->get('user/dashboard', 'DashboardController::index');

$routes->get('/pic', 'PICController::index');
$routes->get('/pic/adjustment', 'PICController::index');
$routes->get('/pic/dashboard', 'PICController::dashboard', ['filter' => 'auth:LEADERMFG1,LEADERMFG2,PIC2,LEADERQC,IT,PIC,CS']);
$routes->get('/pic/adjustment/(:num)', 'PICController::adjust/$1');
// $routes->post('/pic/adjustment/approve/(:num)', 'PICController::approve/$1');
// $routes->post('/pic/adjustment/disapprove/(:num)', 'PICController::disapprove/$1');
$routes->get('/pic/transferStock', 'PICController::transferStock');
$routes->post('/pic/transferStock/approve/(:num)', 'PICController::approveTransferStock/$1');
$routes->post('/pic/transferStock/disapprove/(:num)', 'PICController::disapproveTransferStock/$1');

$routes->get('/pic/transferStock/approve/(:num)', 'PICController::approveTransferStock/$1');
$routes->post('/pic/transferStock/disapprove/(:num)', 'PICController::disapproveTransferStock/$1');

$routes->post('pic/transferStock/approveTransferStock/(:num)', 'PICController::approveTransferStock/$1');
$routes->post('pic/transferStock/disapproveTransferStock/(:num)', 'PICController::disapproveTransferStock/$1');
$routes->get('export/(:segment)', 'PICController::export/$1');


// Rute untuk Cancel Lot
$routes->get('pic/cancelLot', 'PICController::cancelLot');
$routes->post('pic/cancelLot/approve/(:num)', 'PICController::approveCancelLot/$1');
$routes->post('pic/cancelLot/disapprove/(:num)', 'PICController::disapproveCancelLot/$1');
$routes->post('inventory/getPartNumberSuggestions', 'InventoryController::getPartNumberSuggestions'); // baru
$routes->post('inventory/getPartNumberDetails', 'InventoryController::getPartNumberDetails'); // baru
$routes->post('inventory/getWarehouseToByPartNumberTo', 'InventoryController::getWarehouseToByPartNumberTo'); // baru
$routes->post('/inventory/getWarehouseByItemCode', 'InventoryController::getWarehouseByItemCode'); // baru

// waiting approved, approved, disapproved
// $routes->get('/dashboard', 'DashboardController::index');
$routes->get('/dashboard/waiting_approved', 'DashboardController::waitingApproved');
$routes->get('/dashboard/approved', 'DashboardController::approved');
$routes->get('/dashboard/disapproved', 'DashboardController::disapproved');




// $routes->get('PIC/pic_dashboard', 'PICController::dashboard');
$routes->post('PIC/pic/adjustment/approve/(:num)', 'PICController::approve/$1');
$routes->get('PIC/pic', 'PICController::index');
$routes->get('PIC/pic/adjust/(:num)', 'PICController::adjust/$1');
$routes->post('PIC/pic/update/(:num)', 'PICController::update/$1');
$routes->post('PIC/pic/approve/(:num)', 'PICController::approve/$1');
$routes->post('PIC/pic/disapprove/(:num)', 'PICController::disapprove/$1');
$routes->get('PIC/pic/transferStock', 'PICController::transferStock');
$routes->post('PIC/pic/transferStock/approve/(:num)', 'PICController::approveTransferStock/$1');
$routes->post('PIC/pic/transferStock/disapprove/(:num)', 'PICController::disapproveTransferStock/$1');



$routes->get('PIC/pic/cancelLot', 'PICController::cancelLot');
// $routes->post('PIC/pic/cancelLot/approve/(:num)', 'PICController::approveCancelLot/$1');
// $routes->post('PIC/pic/cancelLot/disapprove/(:num)', 'PICController::disapproveCancelLot/$1');
// Rute untuk Leader actions
$routes->post('PIC/pic/cancelLot/approve/(:num)', 'PICController::approveCancelLot/$1');
$routes->post('PIC/pic/cancelLot/disapprove/(:num)', 'PICController::disapproveCancelLot/$1');

// Rute untuk PIC actions
$routes->post('PIC/pic/cancelLot/picApprove/(:num)', 'PICController::picApproveCancelLot/$1');
$routes->post('PIC/pic/cancelLot/picDisapprove/(:num)', 'PICController::picDisapproveCancelLot/$1');


$routes->post('PIC/pic/approveSelected', 'PICController::approveSelected');
$routes->post('PIC/pic/disapproveSelected', 'PICController::disapproveSelected');


$routes->get('history', 'HistoryAdjustController::index');
$routes->get('api/history', 'HistoryAdjustController::getHistoryData');


$routes->post('PICController/approve/(:num)', 'PICController::approve/$1');
$routes->post('PICController/disapprove', 'PICController::disapprove');

$routes->get('inventory/review/(:num)', 'InventoryController::reviewPic/$1');

$routes->post('PIC/pic/approve/(:num)', 'PICController::approve/$1');


$routes->get('/pic/cancelLot', 'PICController::cancelLot');

// Rute untuk menyetujui Cancel Lot berdasarkan peran
$routes->post('/pic/approveByRole/(:num)/(:alpha)', 'PICController::approveByRole/$1/$2');

// Rute untuk menolak Cancel Lot berdasarkan peran
$routes->post('/pic/disapproveByRole/(:num)/(:alpha)', 'PICController::disapproveByRole/$1/$2');


//try
// Rute untuk Cancel Lot
$routes->post('pic/approveByLeader/(:num)', 'PICController::approveByLeader/$1');
$routes->post('pic/disapproveByLeader/(:num)', 'PICController::disapproveByLeader/$1');
$routes->post('pic/approveByPIC/(:num)', 'PICController::approveByPIC/$1');
$routes->post('pic/disapproveByPIC/(:num)', 'PICController::disapproveByPIC/$1');
// Bulk actions for Leaders
$routes->post('pic/approveSelectedByLeader', 'PICController::approveSelectedByLeader');
$routes->post('pic/disapproveSelectedByLeader', 'PICController::disapproveSelectedByLeader');

// Bulk actions for PIC
$routes->post('pic/approveSelectedByPIC', 'PICController::approveSelectedByPIC');
$routes->post('pic/disapproveSelectedByPIC', 'PICController::disapproveSelectedByPIC');

//alddat cancel lot
$routes->get('cancels', 'CancelController::index');
$routes->get('cancels/ajax_list', 'CancelController::ajax_list');
$routes->get('cancels/export', 'CancelController::export'); //Export Excel

$routes->get('/pic/exportFilteredData', 'PICController::exportFilteredData');




// Route for filtered cancel lot data (for DataTable AJAX)
$routes->get('getFilteredCancelLots', 'PICController::getFilteredCancelLots');

// Route for exporting filtered cancel lots
$routes->get('exportFilteredCancelLots', 'PICController::exportFilteredCancelLots');

//rute action untuk transfer stock
$routes->post('/pic/transferStock/approveTransferByLeader/(:num)', 'PICController::approveTransferByLeader/$1');
$routes->post('/pic/transferStock/disapproveTransferByLeader/(:num)', 'PICController::disapproveTransferByLeader/$1');
$routes->post('/pic/transferStock/approveTransferByPIC/(:num)', 'PICController::approveTransferByPIC/$1');
$routes->post('/pic/transferStock/disapproveTransferByPIC/(:num)', 'PICController::disapproveTransferByPIC/$1');
$routes->get('/transfer-stock-history', 'TransferStockHistoryController::index');
$routes->get('pic/transferStock/export', 'TransferStockController::export');

$routes->post('/pic/transferStock/approveTransferByLeaderBulk', 'PICController::approveTransferByLeaderBulk');
$routes->post('/pic/transferStock/disapproveTransferByLeaderBulk', 'PICController::disapproveTransferByLeaderBulk');
$routes->post('/pic/transferStock/approveTransferByPICBulk', 'PICController::approveTransferByPICBulk');
$routes->post('/pic/transferStock/disapproveTransferByPICBulk', 'PICController::disapproveTransferByPICBulk');



//routes untuk adjusment
$routes->post('pic/adjustment/approveAdjustByLeader/(:num)', 'PICController::approveAdjustByLeader/$1');

// Route for disapproving adjustment by Leader
$routes->post('pic/adjustment/disapproveAdjustByLeader/(:num)', 'PICController::disapproveAdjustByLeader/$1');

// Route for approving adjustment by PIC
$routes->post('pic/adjustment/approveAdjustByPIC/(:num)', 'PICController::approveAdjustByPIC/$1');

// Route for disapproving adjustment by PIC
$routes->post('pic/adjustment/disapproveAdjustByPIC/(:num)', 'PICController::disapproveAdjustByPIC/$1');

$routes->post('pic/adjustment/bulkApproveAdjustByLeader', 'PICController::bulkApproveAdjustByLeader');
$routes->post('pic/adjustment/bulkDisapproveAdjustByLeader', 'PICController::bulkDisapproveAdjustByLeader');
$routes->post('pic/adjustment/bulkApproveAdjustByPIC', 'PICController::bulkApproveAdjustByPIC');
$routes->post('pic/adjustment/bulkDisapproveAdjustByPIC', 'PICController::bulkDisapproveAdjustByPIC');

// $routes->get('PIC/pic_dashboard', 'PICController::dashboard', ['filter' => 'auth:LEADERMFG1,LEADERMFG2,PIC2']);
$routes->get('/dashboard', 'DashboardController::index', ['filter' => 'auth:MFG1,MFG2,USER']);

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Custom fonts for this template -->
    <link href="<?= base_url('sb2/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?= base_url('sb2/css/sb-admin-2.min.css') ?>" rel="stylesheet">

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">

    <!-- jQuery UI CSS -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">

    <!-- jQuery UI JS -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <!-- Tambahkan di bagian head atau sebelum penutup body tag -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/corejs-typeahead/1.3.1/typeahead.bundle.min.js"></script>

    <!-- menyimpan BaseURL -->
    <script>
        var baseUrl = '<?= base_url() ?>'; // Menyimpan base URL CodeIgniter
    </script>

    <!-- Adjusment Autocomplete -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- SweetAlert2 JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    <!-- SweetAlert2 JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>




    <style>
        .ui-autocomplete {
            max-height: 200px;
            /* Atur tinggi maksimum dropdown */
            overflow-y: auto;
            /* Tambahkan scroll jika isi melebihi tinggi maksimum */
            overflow-x: hidden;
            /* Sembunyikan scroll horizontal jika tidak diperlukan */
            z-index: 10000;
            /* Pastikan dropdown berada di atas elemen lainnya */
        }


        .fa-check-circle {
            color: #28a745;
            /* Hijau untuk checklist */
            animation: checkmark 1s ease;
        }

        @keyframes checkmark {
            0% {
                transform: scale(0);
                opacity: 0;
            }

            50% {
                transform: scale(1.1);
                opacity: 1;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Custom animation for the success modal */
        .modal.fade .modal-dialog {
            transform: translateY(-100px);
            transition: transform 0.5s ease-out;
        }

        .modal.show .modal-dialog {
            transform: translateY(0);
        }
    </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <?= $this->include('Navbar/navigation') ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column content-wrapper">
            <!-- Main Content -->
            <div id="content">
                <?= $this->include('Navbar/topbar') ?>
                <?= $this->renderSection('Navbar/content') ?>
            </div>
            <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger" href="<?= base_url('/logout') ?>">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Success</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <div class="alert alert-success">
                        <i class="fa fa-check-circle" style="font-size: 3rem;"></i>
                        <p class="mt-3">Data berhasil disimpan!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal Update Adjusment-->
    <div class="modal fade" id="successModalUpdate" tabindex="-1" role="dialog" aria-labelledby="successModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Update Successful</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <div class="alert alert-success" role="alert">
                        <i class="fa fa-check-circle fa-3x"></i>
                        <p>Data Adjusmet Inventory berhasil di Update, silakan bisa di cek kembali
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Success Modal Update Transfer-->
    <div class="modal fade" id="successModalUpdateTransfer" tabindex="-1" role="dialog"
        aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="background-color: #f2f2f2; color: #333;">
                <div class="modal-header" style="background-color: #d9d9d9;">
                    <h5 class="modal-title" id="successModalLabel">Update Successful</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <div class="alert alert-success" role="alert"
                        style="background-color: #f2f2f2; color: #333; border: none;">
                        <i class="fa fa-check-circle fa-3x" style="color: #28a745;"></i> <!-- Tetap hijau -->
                        <p>Data Transfer Stock berhasil di Update, silakan bisa di cek kembali !</p>
                    </div>
                </div>
                <div class="modal-footer" style="background-color: #d9d9d9;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Success Modal Update Cancel -->
    <div class="modal fade" id="successModalUpdateCancel" tabindex="-1" role="dialog"
        aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="background-color: #f8d7da; color: #721c24;">
                <div class="modal-header" style="background-color: #f5c6cb;">
                    <h5 class="modal-title" id="successModalLabel">Update Successful</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <div class="alert alert-success" role="alert"
                        style="background-color: #f8d7da; color: #721c24; border: none;">
                        <i class="fa fa-check-circle fa-3x" style="color: #28a745;"></i> <!-- Tetap hijau -->
                        <p>Data Cancel Lot berhasil di Update, silakan bisa di cek kembali !</p>
                    </div>
                </div>
                <div class="modal-footer" style="background-color: #f5c6cb;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>




    <!-- Bootstrap core JavaScript -->
    <script src="<?= base_url('sb2/vendor/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('sb2/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

    <!-- Core plugin JavaScript -->
    <script src="<?= base_url('sb2/vendor/jquery-easing/jquery.easing.min.js') ?>"></script>

    <!-- Custom scripts for all pages -->
    <script src="<?= base_url('sb2/js/sb-admin-2.min.js') ?>"></script>

    <!-- Page level plugins -->
    <script src="<?= base_url('sb2/vendor/chart.js/Chart.min.js') ?>"></script>

    <!-- Page level custom scripts -->
    <script src="<?= base_url('sb2/js/demo/chart-area-demo.js') ?>"></script>
    <script src="<?= base_url('sb2/js/demo/chart-pie-demo.js') ?>"></script>

    <!-- DataTables JavaScript -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>

    <!-- jQuery UI JavaScript for Autocomplete -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <!-- Custom script to initialize DataTables and Autocomplete -->
    <script>

        // flash sukses update
        <?php if (session()->getFlashdata('success')): ?>
            $(document).ready(function () {
                $('#successModalUpdate').modal('show');
            });
        <?php endif; ?>
        // flash sukses update Transfer
        <?php if (session()->getFlashdata('successTransfer')): ?>
            $(document).ready(function () {
                $('#successModalUpdateTransfer').modal('show');
            });
        <?php endif; ?>
        // flash sukses update Transfer
        <?php if (session()->getFlashdata('successCancel')): ?>
            $(document).ready(function () {
                $('#successModalUpdateCancel').modal('show');
            });
        <?php endif; ?>

        // flash sukses save
        <?php if (session()->getFlashdata('message')): ?>
            $(document).ready(function () {
                $('#successModal').modal('show');
            });
        <?php endif; ?>

        $(document).ready(function () {
            // Initialize DataTables
            $('#adjustmentInventoryTable').DataTable();
            $('#transferStockTable').DataTable();
            $('#cancelLotTable').DataTable();
            $('#approvedInventoryTable').DataTable();
            $('#approvedTransferStockTable').DataTable();
            $('#approvedCancelLotTable').DataTable();
            $('#disapprovedInventoryTable').DataTable();
            $('#disapprovedTransferStockTable').DataTable();
            $('#disapprovedCancelLotTable').DataTable();
        });

        // Autocomplete for Part Number Adjusment
        $('#part_number').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: baseUrl + "/inventory/getPartNumbers", // Gunakan baseUrl di sini
                    data: { term: request.term },
                    dataType: "json",
                    success: function (data) {
                        response(data);
                    }
                });
            },
            minLength: 2,
            select: function (event, ui) {
                $('#part_number').val(ui.item.value); // Set the input value
                fetchWarehouseByItemCode(ui.item.value); // Fetch warehouse by selected part number
                return false; // Prevent redirect to search page
            }
        });

        // part number from Transfer
        $('#part_number_from_transfer').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: baseUrl + "/inventory/getPartNumbers", // Gunakan baseUrl di sini
                    data: { term: request.term },
                    dataType: "json",
                    success: function (data) {
                        response(data);
                    }
                });
            },
            minLength: 2,
            select: function (event, ui) {
                $('#part_number_from_transfer').val(ui.item.value); // Set the input value
                fetchWarehouseFromByItemCode(ui.item.value); // Fetch warehouse by selected part number
                return false; // Prevent redirect to search page
            }
        });

        // part number from Cancel
        $('#part_number_from').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: baseUrl + "/inventory/getPartNumbers", // Gunakan baseUrl di sini
                    data: { term: request.term },
                    dataType: "json",
                    success: function (data) {
                        response(data);
                    }
                });
            },
            minLength: 2,
            select: function (event, ui) {
                $('#part_number_from').val(ui.item.value); // Set the input value
                fetchWarehouseByItemCode(ui.item.value); // Fetch warehouse by selected part number
                return false; // Prevent redirect to search page
            }
        });

        // part number to Transfer
        $('#part_number_to_transfer').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: baseUrl + "/inventory/getPartNumbers", // Gunakan baseUrl di sini
                    data: { term: request.term },
                    dataType: "json",
                    success: function (data) {
                        response(data);
                    }
                });
            },
            minLength: 2,
            select: function (event, ui) {
                $('#part_number_to_transfer').val(ui.item.value); // Set the input value
                fetchWarehouseToByItemCode(ui.item.value); // Fetch warehouse by selected part number
                return false; // Prevent redirect to search page
            }
        });

        // part number to Cancel
        $('#part_number_to').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: baseUrl + "/inventory/getPartNumbers", // Gunakan baseUrl di sini
                    data: { term: request.term },
                    dataType: "json",
                    success: function (data) {
                        response(data);
                    }
                });
            },
            minLength: 2,
            select: function (event, ui) {
                $('#part_number_to').val(ui.item.value); // Set the input value
                fetchWarehouseByItemCode(ui.item.value); // Fetch warehouse by selected part number
                return false; // Prevent redirect to search page
            }
        });

        // Autocomplete for Warehouse Adjusment
        $('#location').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: baseUrl + "/inventory/getLocations",
                    data: { term: request.term },
                    dataType: "json",
                    success: function (data) {
                        response(data);
                    }
                });
            },
            minLength: 2,
            select: function (event, ui) {
                $('#location').val(ui.item.value); // Set the input value
                return false; // Prevent redirect to search page
            }
        });

        // Autocomplete warehouse_from transfer
        $('#warehouse_from_transfer').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: baseUrl + "/inventory/getLocations",
                    data: { term: request.term },
                    dataType: "json",
                    success: function (data) {
                        response(data);
                    }
                });
            },
            minLength: 2,
            select: function (event, ui) {
                $('#warehouse_from_transfer').val(ui.item.value); // Set the input value
                return false; // Prevent redirect to search page
            }
        });

        // Autocomplet warehouse_from Cancel
        $('#warehouse_from').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: baseUrl + "/inventory/getLocations",
                    data: { term: request.term },
                    dataType: "json",
                    success: function (data) {
                        response(data);
                    }
                });
            },
            minLength: 2,
            select: function (event, ui) {
                $('#warehouse_from').val(ui.item.value); // Set the input value
                return false; // Prevent redirect to search page
            }
        });

        // Autocomplet warehouse_to transfer
        $('#warehouse_to_transfer').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: baseUrl + "/inventory/getLocations",
                    data: { term: request.term },
                    dataType: "json",
                    success: function (data) {
                        response(data);
                    }
                });
            },
            minLength: 2,
            select: function (event, ui) {
                $('#warehouse_to_transfer').val(ui.item.value); // Set the input value
                return false; // Prevent redirect to search page
            }
        });

        // Autocomplet warehouse_to cancel
        $('#warehouse_to').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: baseUrl + "/inventory/getLocations",
                    data: { term: request.term },
                    dataType: "json",
                    success: function (data) {
                        response(data);
                    }
                });
            },
            minLength: 2,
            select: function (event, ui) {
                $('#warehouse_to').val(ui.item.value); // Set the input value
                return false; // Prevent redirect to search page
            }
        });


        // Function to fetch warehouse by part number
        function fetchWarehouseByItemCode(partNumber) {
            if (partNumber.length > 0) {
                $.ajax({
                    url: "<?= base_url('/inventory/getWarehouseByItemCode') ?>",
                    method: "POST",
                    data: { itemCode: partNumber },
                    success: function (response) {
                        $('#location').empty();
                        if (response.length > 0) {
                            $.each(response, function (index, value) {
                                $('#location').append('<option value="' + value.WhsCode + '">' + value.WhsCode + '</option>');
                            });
                        } else {
                            $('#location').append('<option value="">No Warehouse Available</option>');
                        }
                    }
                });
            }
        }

        // automatic warehouse from untuk transfer Stock
        function fetchWarehouseFromByItemCode(partNumber) {
            if (partNumber.length > 0) {
                $.ajax({
                    url: "<?= base_url('/inventory/getWarehouseByItemCode') ?>",
                    method: "POST",
                    data: { itemCode: partNumber },
                    success: function (response) {
                        $('#warehouse_from').empty();
                        if (response.length > 0) {
                            $.each(response, function (index, value) {
                                $('#warehouse_from').append('<option value="' + value.WhsCode + '">' + value.WhsCode + '</option>');
                            });
                        } else {
                            $('#warehouse_from').append('<option value="">No Warehouse Available</option>');
                        }
                    }
                });
            }
        }
        // automatic warehouse to untuk transfer stock
        function fetchWarehouseToByItemCode(partNumber) {
            if (partNumber.length > 0) {
                $.ajax({
                    url: "<?= base_url('/inventory/getWarehouseByItemCode') ?>",
                    method: "POST",
                    data: { itemCode: partNumber },
                    success: function (response) {
                        $('#warehouse_to').empty();
                        if (response.length > 0) {
                            $.each(response, function (index, value) {
                                $('#warehouse_to').append('<option value="' + value.WhsCode + '">' + value.WhsCode + '</option>');
                            });
                        } else {
                            $('#warehouse_to').append('<option value="">No Warehouse Available</option>');
                        }
                    }
                });
            }
        }


        // Edit modal
        $(document).ready(function () {
            // Initialize Autocomplete for Part Number in Edit Modal
            $('#edit_part_number').autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: baseUrl + "/inventory/getPartNumbers", // Gunakan baseUrl di sini
                        data: { term: request.term },
                        dataType: "json",
                        success: function (data) {
                            response(data);
                        }
                    });
                },
                minLength: 2,
                select: function (event, ui) {
                    $('#edit_part_number').val(ui.item.value); // Set the input value
                    // Trigger event to update warehouse dropdown
                    updateWarehouse(ui.item.value);
                    return false; // Prevent redirect to search page
                }
            });

            // Initialize Autocomplete for Warehouse in Edit Modal
            $('#edit_location').autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: baseUrl + "/inventory/getLocations",
                        data: { term: request.term },
                        dataType: "json",
                        success: function (data) {
                            response(data);
                        }
                    });
                },
                minLength: 2,
                select: function (event, ui) {
                    $('#edit_location').val(ui.item.value); // Set the input value
                    return false; // Prevent redirect to search page
                }
            });

            // Function to update warehouse options based on part number
            function updateWarehouse(partNumber) {
                if (partNumber.length > 0) {
                    $.ajax({
                        url: "<?= base_url('/inventory/getWarehouseByItemCode') ?>",
                        method: "POST",
                        data: { itemCode: partNumber },
                        success: function (response) {
                            $('#edit_location').empty();
                            if (response.length > 0) {
                                $.each(response, function (index, value) {
                                    $('#edit_location').append('<option value="' + value.WhsCode + '">' + value.WhsCode + '</option>');
                                });
                            } else {
                                $('#edit_location').append('<option value="">No Warehouse Available</option>');
                            }
                        }
                    });
                }
            }

            // Set data to edit modal
            $('#editModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var id = button.data('id');
                var department = button.data('department');
                var pic = button.data('pic');
                var part_number = button.data('part_number');
                var qty = button.data('qty');
                var lot_number = button.data('lot_number');
                var rn = button.data('rn');
                var location = button.data('location');
                var status = button.data('status');
                var remark = button.data('remark');

                var modal = $(this);
                modal.find('#edit_id').val(id);
                modal.find('#edit_department').val(department);
                modal.find('#edit_pic').val(pic);
                modal.find('#edit_part_number').val(part_number);
                modal.find('#edit_qty').val(qty);
                modal.find('#edit_lot_number').val(lot_number);
                modal.find('#edit_rn').val(rn);
                modal.find('#edit_location').val(location);
                modal.find('#edit_status').val(status);
                modal.find('#edit_remark').val(remark);

                // Update warehouse dropdown based on part number
                updateWarehouse(part_number);
            });
        });


        // edit modal untuk transfer stock
        $(document).ready(function () {
            $('#editTransferStockModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var id = button.data('id');
                var department = button.data('department');
                var pic = button.data('pic');
                var part_number_from = button.data('part_number_from');
                var part_number_to = button.data('part_number_to');
                var qty = button.data('qty');
                var lot_number_from = button.data('lot_number_from');
                var lot_number_to = button.data('lot_number_to');
                var rn_from = button.data('rn_from');
                var rn_to = button.data('rn_to');
                var warehouse_from = button.data('warehouse_from');
                var warehouse_to = button.data('warehouse_to');
                var status = button.data('status');
                var remark = button.data('remark');

                var modal = $(this);
                modal.find('#edit_transfer_id').val(id);
                modal.find('#edit_department').val(department);
                modal.find('#edit_pic').val(pic);
                modal.find('#edit_part_number_from').val(part_number_from);
                modal.find('#edit_part_number_to').val(part_number_to);
                modal.find('#edit_qty').val(qty);
                modal.find('#edit_lot_number_from').val(lot_number_from);
                modal.find('#edit_lot_number_to').val(lot_number_to);
                modal.find('#edit_rn_from').val(rn_from);
                modal.find('#edit_rn_to').val(rn_to);
                modal.find('#edit_warehouse_from').val(warehouse_from);
                modal.find('#edit_warehouse_to').val(warehouse_to);
                modal.find('#edit_status').val(status);
                modal.find('#edit_remark').val(remark);

                // Update warehouse dropdown based on part number
                updateWarehouseFrom(part_number_from);
                updateWarehouseTo(part_number_to);

                // Initialize autocomplete for Part Number From
                $('#edit_part_number_from').autocomplete({
                    source: function (request, response) {
                        $.ajax({
                            url: baseUrl + "/inventory/getPartNumbers", // Gunakan baseUrl di sini
                            data: { term: request.term },
                            dataType: "json",
                            success: function (data) {
                                response(data);
                            }
                        });
                    },
                    minLength: 2,
                    select: function (event, ui) {
                        $('#edit_part_number_from').val(ui.item.value); // Set the input value
                        // Trigger event to update warehouse dropdown
                        updateWarehouseFrom(ui.item.value);
                        return false; // Prevent redirect to search page
                    }
                });

                // Initialize autocomplete for Part Number To
                $('#edit_part_number_to').autocomplete({
                    source: function (request, response) {
                        $.ajax({
                            url: baseUrl + "/inventory/getPartNumbers", // Gunakan baseUrl di sini
                            data: { term: request.term },
                            dataType: "json",
                            success: function (data) {
                                response(data);
                            }
                        });
                    },
                    minLength: 2,
                    select: function (event, ui) {
                        $('#edit_part_number_to').val(ui.item.value); // Set the input value
                        // Trigger event to update warehouse dropdown
                        updateWarehouseTo(ui.item.value);
                        return false; // Prevent redirect to search page
                    }
                });

                // Initialize autocomplete for Warehouse From
                $('#edit_warehouse_from').autocomplete({
                    source: function (request, response) {
                        $.ajax({
                            url: '<?= base_url('inventory/getLocations') ?>',
                            dataType: 'json',
                            data: {
                                term: request.term
                            },
                            success: function (data) {
                                response(data);
                            }
                        });
                    },
                    minLength: 2 // Tampilkan saran saat 2 karakter pertama diketik
                });

                function updateWarehouseFrom(partNumber) {
                    if (partNumber.length > 0) {
                        $.ajax({
                            url: "<?= base_url('/inventory/getWarehouseByItemCode') ?>",
                            method: "POST",
                            data: { itemCode: partNumber },
                            success: function (response) {
                                $('#edit_warehouse_from').empty();
                                if (response.length > 0) {
                                    $.each(response, function (index, value) {
                                        $('#edit_warehouse_from').append('<option value="' + value.WhsCode + '">' + value.WhsCode + '</option>');
                                    });
                                } else {
                                    $('#edit_warehouse_from').append('<option value="">No Warehouse Available</option>');
                                }
                            }
                        });
                    }
                }

                function updateWarehouseTo(partNumber) {
                    if (partNumber.length > 0) {
                        $.ajax({
                            url: "<?= base_url('/inventory/getWarehouseByItemCode') ?>",
                            method: "POST",
                            data: { itemCode: partNumber },
                            success: function (response) {
                                $('#edit_warehouse_to').empty();
                                if (response.length > 0) {
                                    $.each(response, function (index, value) {
                                        $('#edit_warehouse_to').append('<option value="' + value.WhsCode + '">' + value.WhsCode + '</option>');
                                    });
                                } else {
                                    $('#edit_warehouse_to').append('<option value="">No Warehouse Available</option>');
                                }
                            }
                        });
                    }
                }

                // Initialize autocomplete for Warehouse To
                $('#edit_warehouse_to').autocomplete({
                    source: function (request, response) {
                        $.ajax({
                            url: '<?= base_url('inventory/getLocations') ?>',
                            dataType: 'json',
                            data: {
                                term: request.term
                            },
                            success: function (data) {
                                response(data);
                            }
                        });
                    },
                    minLength: 2 // Tampilkan saran saat 2 karakter pertama diketik
                });
            });


        });

        // edit modal untuk cancel lot
        $(document).ready(function () {
            // Existing autocomplete code

            // Function to initialize and show the edit modal
            $('#editModalCancel').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var id = button.data('id');
                var department = button.data('department');
                var pic = button.data('pic');
                var partNumberFrom = button.data('part_number_from');
                var partNumberTo = button.data('part_number_to');
                var qty = button.data('qty');
                var lotNumber = button.data('lot_number');
                var warehouseFrom = button.data('warehouse_from');
                var warehouseTo = button.data('warehouse_to');
                var remark = button.data('remark');

                var modal = $(this);
                modal.find('#edit_id').val(id);
                modal.find('#edit_department').val(department);
                modal.find('#edit_pic').val(pic);
                modal.find('#edit_part_number_from').val(partNumberFrom);
                modal.find('#edit_part_number_to').val(partNumberTo);
                modal.find('#edit_qty').val(qty);
                modal.find('#edit_lot_number').val(lotNumber);
                modal.find('#edit_warehouse_from').val(warehouseFrom);
                modal.find('#edit_warehouse_to').val(warehouseTo);
                modal.find('#edit_remark').val(remark);

                // Initialize autocomplete in the edit modal
                $('#edit_part_number_from').autocomplete({
                    source: function (request, response) {
                        $.ajax({
                            url: '<?= base_url('inventory/getPartNumberSuggestions') ?>',
                            method: 'POST',
                            data: { term: request.term },
                            dataType: 'json',
                            success: function (data) {
                                response($.map(data, function (item) {
                                    return {
                                        label: item.label,
                                        value: item.value
                                    };
                                }));
                            }
                        });
                    },
                    select: function (event, ui) {
                        $('#edit_part_number_from').val(ui.item.value);
                        fetchPartNumberDetails(ui.item.value);
                        return false;
                    }
                });

                $('#edit_part_number_to').autocomplete({
                    source: function (request, response) {
                        $.ajax({
                            url: '<?= base_url('inventory/getPartNumberSuggestions') ?>',
                            method: 'POST',
                            data: { term: request.term },
                            dataType: 'json',
                            success: function (data) {
                                response($.map(data, function (item) {
                                    return {
                                        label: item.label,
                                        value: item.value
                                    };
                                }));
                            }
                        });
                    },
                    select: function (event, ui) {
                        $('#edit_part_number_to').val(ui.item.value);
                        fetchWarehouseToByPartNumberTo(ui.item.value);
                        return false;
                    }
                });

                function fetchPartNumberDetails(partNumberFrom) {
                    $.ajax({
                        url: '<?= base_url('inventory/getPartNumberDetails') ?>',
                        method: 'POST',
                        data: { part_number_from: partNumberFrom },
                        dataType: 'json',
                        success: function (response) {
                            if (response.success) {
                                $('#edit_part_number_to').val(response.part_number_to);
                                $('#edit_warehouse_from').val(response.warehouse_from);
                                $('#edit_warehouse_to').val(response.warehouse_to);
                                $('#edit_part_number_to').trigger('change');
                            } else {
                                alert(response.message);
                            }
                        }
                    });
                }

                function fetchWarehouseToByPartNumberTo(partNumberTo) {
                    $.ajax({
                        url: '<?= base_url('inventory/getWarehouseToByPartNumberTo') ?>',
                        method: 'POST',
                        data: { part_number_to: partNumberTo },
                        dataType: 'json',
                        success: function (response) {
                            if (response.success) {
                                $('#edit_warehouse_to').val(response.warehouse_to);
                            } else {
                                alert(response.message);
                            }
                        }
                    });
                }

                $('#edit_part_number_to').on('change', function () {
                    var partNumberTo = $(this).val();
                    fetchWarehouseToByPartNumberTo(partNumberTo);
                });
            });
        });

        // edit modal untuk cancel lot di Waiting Approve
        $(document).ready(function () {
            // Existing autocomplete code

            // Function to initialize and show the edit modal
            $('#editModalCancelWaiting').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var id = button.data('id');
                var department = button.data('department');
                var pic = button.data('pic');
                var partNumberFrom = button.data('part_number_from');
                var partNumberTo = button.data('part_number_to');
                var qty = button.data('qty');
                var lotNumber = button.data('lot_number');
                var warehouseFrom = button.data('warehouse_from');
                var warehouseTo = button.data('warehouse_to');
                var remark = button.data('remark');

                var modal = $(this);
                modal.find('#edit_id').val(id);
                modal.find('#edit_department').val(department);
                modal.find('#edit_pic').val(pic);
                modal.find('#edit_part_number_from_waiting').val(partNumberFrom);
                modal.find('#edit_part_number_to_waiting').val(partNumberTo);
                modal.find('#edit_qty').val(qty);
                modal.find('#edit_lot_number').val(lotNumber);
                modal.find('#edit_warehouse_from_waiting').val(warehouseFrom);
                modal.find('#edit_warehouse_to_waiting').val(warehouseTo);
                modal.find('#edit_remark').val(remark);

                // Initialize autocomplete in the edit modal
                $('#edit_part_number_from_waiting').autocomplete({
                    source: function (request, response) {
                        $.ajax({
                            url: '<?= base_url('inventory/getPartNumberSuggestions') ?>',
                            method: 'POST',
                            data: { term: request.term },
                            dataType: 'json',
                            success: function (data) {
                                response($.map(data, function (item) {
                                    return {
                                        label: item.label,
                                        value: item.value
                                    };
                                }));
                            }
                        });
                    },
                    select: function (event, ui) {
                        $('#edit_part_number_from_waiting').val(ui.item.value);
                        fetchPartNumberDetails(ui.item.value);
                        return false;
                    }
                });

                $('#edit_part_number_to_waiting').autocomplete({
                    source: function (request, response) {
                        $.ajax({
                            url: '<?= base_url('inventory/getPartNumberSuggestions') ?>',
                            method: 'POST',
                            data: { term: request.term },
                            dataType: 'json',
                            success: function (data) {
                                response($.map(data, function (item) {
                                    return {
                                        label: item.label,
                                        value: item.value
                                    };
                                }));
                            }
                        });
                    },
                    select: function (event, ui) {
                        $('#edit_part_number_to_waiting').val(ui.item.value);
                        fetchWarehouseToByPartNumberTo(ui.item.value);
                        return false;
                    }
                });

                function fetchPartNumberDetails(partNumberFrom) {
                    $.ajax({
                        url: '<?= base_url('inventory/getPartNumberDetails') ?>',
                        method: 'POST',
                        data: { part_number_from: partNumberFrom },
                        dataType: 'json',
                        success: function (response) {
                            if (response.success) {
                                $('#edit_part_number_to_waiting').val(response.part_number_to);
                                $('#edit_warehouse_from_waiting').val(response.warehouse_from);
                                $('#edit_warehouse_to_waiting').val(response.warehouse_to);
                                $('#edit_part_number_to_waiting').trigger('change');
                            } else {
                                alert(response.message);
                            }
                        }
                    });
                }

                function fetchWarehouseToByPartNumberTo(partNumberTo) {
                    $.ajax({
                        url: '<?= base_url('inventory/getWarehouseToByPartNumberTo') ?>',
                        method: 'POST',
                        data: { part_number_to: partNumberTo },
                        dataType: 'json',
                        success: function (response) {
                            if (response.success) {
                                $('#edit_warehouse_to_waiting').val(response.warehouse_to);
                            } else {
                                alert(response.message);
                            }
                        }
                    });
                }

                $('#edit_part_number_to_waiting').on('change', function () {
                    var partNumberTo = $(this).val();
                    fetchWarehouseToByPartNumberTo(partNumberTo);
                });
            });
        });


        // sweet alert hapus data
        $(document).ready(function () {
            // SweetAlert untuk konfirmasi hapus
            $(document).on('click', '.btn-delete', function (e) {
                e.preventDefault(); // Mencegah tindakan default dari tombol

                var href = $(this).attr('href'); // Ambil URL dari atribut href tombol

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data ini akan dihapus dan tidak dapat dikembalikan.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal',
                    showLoaderOnConfirm: true, // Tampilkan loader saat mengkonfirmasi
                    preConfirm: () => {
                        return fetch(href, {
                            method: 'GET'
                        }).then(response => {
                            if (!response.ok) {
                                throw new Error('Gagal menghapus data');
                            }
                            return response.json(); // Ambil response JSON jika berhasil
                        }).catch(error => {
                            Swal.showValidationMessage(`Request gagal: ${error}`);
                        });
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Data telah dihapus.',
                            icon: 'success',
                            confirmButtonText: 'Oke',
                            timer: 2000 // Notifikasi akan hilang setelah 2 detik
                        }).then(() => {
                            // Refresh halaman atau arahkan kembali setelah 2 detik
                            location.reload(); // Memuat ulang halaman untuk melihat perubahan
                        });
                    }
                });
            });
        });

        // automatic PN and WH by Cancelot
        $(document).ready(function () {
            // Autocomplete for part_number_from
            $('#part_number_from').autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: '<?= base_url('inventory/getPartNumberSuggestions') ?>',
                        method: 'POST',
                        data: { term: request.term },
                        dataType: 'json',
                        success: function (data) {
                            response($.map(data, function (item) {
                                return {
                                    label: item.label,
                                    value: item.value
                                };
                            }));
                        }
                    });
                },
                select: function (event, ui) {
                    // Set the value of the input field
                    $('#part_number_from').val(ui.item.value);

                    // Trigger change event to fetch other details
                    fetchPartNumberDetails(ui.item.value);
                    return false;
                }

            });

            // Autocomplete for part_number_to
            $('#part_number_to').autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: '<?= base_url('inventory/getPartNumberSuggestions') ?>',
                        method: 'POST',
                        data: { term: request.term },
                        dataType: 'json',
                        success: function (data) {
                            response($.map(data, function (item) {
                                return {
                                    label: item.label,
                                    value: item.value
                                };
                            }));
                        }
                    });
                },
                select: function (event, ui) {
                    // Set the value of the input field
                    $('#part_number_to').val(ui.item.value);

                    // Trigger change event to fetch warehouse_to
                    fetchWarehouseToByPartNumberTo(ui.item.value);
                    return false;
                }
            });
            // Handle input change event (for scanner or manual input)
            $('#part_number_from').on('change', function () {
                var partNumber = $(this).val();
                if (partNumber.length > 0) {
                    fetchPartNumberDetails(partNumber);
                }
            });

            // Function to fetch part number details
            function fetchPartNumberDetails(partNumberFrom) {
                $.ajax({
                    url: '<?= base_url('inventory/getPartNumberDetails') ?>',
                    method: 'POST',
                    data: { part_number_from: partNumberFrom },
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            $('#part_number_to').val(response.part_number_to);
                            $('#warehouse_from').val(response.warehouse_from);
                            $('#warehouse_to').val(response.warehouse_to);

                            // Trigger change event on part_number_to
                            $('#part_number_to').trigger('change');
                        } else {
                            alert(response.message);
                        }
                    }
                });
            }

            // Function to fetch warehouse_to by part_number_to
            function fetchWarehouseToByPartNumberTo(partNumberTo) {
                $.ajax({
                    url: '<?= base_url('inventory/getWarehouseToByPartNumberTo') ?>',
                    method: 'POST',
                    data: { part_number_to: partNumberTo },
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            $('#warehouse_to').val(response.warehouse_to);
                        } else {
                            alert(response.message);
                        }
                    }
                });
            }

            // Event listener for change on part_number_to
            $('#part_number_to').on('change', function () {
                var partNumberTo = $(this).val();
                fetchWarehouseToByPartNumberTo(partNumberTo);
            });
        });

        // automatic department to status
        document.addEventListener('DOMContentLoaded', function () {
            // Cek apakah elemen dengan ID 'department' dan 'status' ada di halaman
            const departmentSelect = document.querySelector('#department');
            const statusSelect = document.querySelector('#status');
            // Cek apakah elemen dengan ID 'edit_department' dan 'edit_status' ada di halaman
            const editDepartmentSelect = document.querySelector('#edit_department');
            const editStatusSelect = document.querySelector('#edit_status');
            // Cek apakah elemen dengan ID 'edit_department_transfer' dan 'edit_status_transfer' ada di halaman
            const editDepartmentTransferSelect = document.querySelector('#edit_department_transfer');
            const editStatusTransferSelect = document.querySelector('#edit_status_transfer');


            function updateStatusOptions(department, statusSelect, selectedStatus) {
                const options = {
                    MFG1: ['PEND'],
                    MFG2: ['MIN', 'PEND', 'NG'],
                    QC: ['PEND', 'NG', 'OK', 'MIN', 'PLUS'],
                    DELIVERY: ['MIN']
                };

                // Kosongkan opsi yang ada sebelumnya
                statusSelect.innerHTML = '';

                // Tambahkan opsi default jika department adalah QC, MFG2, atau PPIC
                if (department === 'QC' || department === 'MFG2' || department === 'DELIVERY') {
                    statusSelect.appendChild(new Option('--- Select Status ---', ''));
                }

                // Tambahkan opsi baru berdasarkan department
                if (options[department]) {
                    options[department].forEach(status => {
                        const option = new Option(status, status);
                        statusSelect.appendChild(option);

                        // Set status yang dipilih jika sesuai dengan opsi yang ada
                        if (status === selectedStatus) {
                            statusSelect.value = status;
                        }
                    });
                }
            }

            // Update opsi status ketika department berubah (untuk input modal)
            if (departmentSelect && statusSelect) {
                departmentSelect.addEventListener('change', function () {
                    updateStatusOptions(departmentSelect.value, statusSelect, '');
                });

                // Inisialisasi opsi status saat halaman dimuat
                updateStatusOptions(departmentSelect.value, statusSelect, '');
            }

            // Update opsi status ketika department berubah (untuk edit modal)
            if (editDepartmentSelect && editStatusSelect) {
                editDepartmentSelect.addEventListener('change', function () {
                    updateStatusOptions(editDepartmentSelect.value, editStatusSelect, '');
                });

                // Inisialisasi opsi status saat halaman dimuat
                updateStatusOptions(editDepartmentSelect.value, editStatusSelect, '');
            }

            // Update opsi status ketika department berubah (untuk edit transfer stock modal)
            if (editDepartmentTransferSelect && editStatusTransferSelect) {
                editDepartmentTransferSelect.addEventListener('change', function () {
                    updateStatusOptions(editDepartmentTransferSelect.value, editStatusTransferSelect, '');
                });

                // Inisialisasi opsi status saat halaman dimuat
                updateStatusOptions(editDepartmentTransferSelect.value, editStatusTransferSelect, '');
            }

            // Event listener untuk membuka edit modal
            if (editDepartmentSelect && editStatusSelect) {
                $('#editModal').on('show.bs.modal', function (event) {
                    const button = $(event.relatedTarget); // Tombol yang memicu modal
                    const department = button.data('department'); // Ambil info dari atribut data-*
                    const status = button.data('status'); // Ambil info dari atribut data-*

                    // Set nilai department select
                    editDepartmentSelect.value = department;

                    // Update opsi status berdasarkan department
                    updateStatusOptions(department, editStatusSelect, status);
                });

                // Edit modal untuk transfer stock
                $('#editTransferStockModal').on('show.bs.modal', function (event) {
                    const button = $(event.relatedTarget); // Tombol yang memicu modal
                    const department = button.data('department'); // Ambil info dari atribut data-*
                    const status = button.data('status'); // Ambil info dari atribut data-*

                    // Set nilai department select
                    editDepartmentSelect.value = department;

                    // Update opsi status berdasarkan department
                    updateStatusOptions(department, editStatusSelect, status);
                });
            }

            // edit waiting transfer
            if (editDepartmentTransferSelect && editStatusTransferSelect) {
                $('#editTransferStockModal').on('show.bs.modal', function (event) {
                    const button = $(event.relatedTarget); // Tombol yang memicu modal
                    const department = button.data('department'); // Ambil info dari atribut data-*
                    const status = button.data('status'); // Ambil info dari atribut data-*

                    // Set nilai department select
                    editDepartmentTransferSelect.value = department;

                    // Update opsi status berdasarkan department
                    updateStatusOptions(department, editStatusTransferSelect, status);
                });
            }
        });


        // handle button auto hide per menu
        $(document).ready(function () {
            var currentTable = 'adjustmentInventoryTable';

            function resetTableFilter() {
                var table = $('#' + currentTable).DataTable();
                table.search('').columns().search('').draw();
            }

            function showSection(sectionToShow) {
                $('#adjustmentInventorySection').toggle(sectionToShow === 'adjustmentInventory');
                $('#transferStockSection').toggle(sectionToShow === 'transferStock');
                $('#cancelLotSection').toggle(sectionToShow === 'cancelLot');
            }

            $('#dateFilter').on('change', function () {
                var selectedDate = $(this).val();
                filterTableByDate(selectedDate);
            });

            $('#resetFilterBtn').on('click', function () {
                $('#dateFilter').val('');
                resetTableFilter();
            });

            $('#showAdjustmentInventory').on('click', function () {
                currentTable = 'adjustmentInventoryTable';
                showSection('adjustmentInventory');
            });

            $('#showTransferStock').on('click', function () {
                currentTable = 'transferStockTable';
                showSection('transferStock');
            });

            $('#showCancelLot').on('click', function () {
                currentTable = 'cancelLotTable';
                showSection('cancelLot');
            });

            // Initialize DataTables
            $('#adjustmentInventoryTable').DataTable();
            $('#transferStockTable').DataTable();
            $('#cancelLotTable').DataTable();
            $('#approvedInventoryTable').DataTable();

            // Default to showing Adjustment Inventory section
            showSection('adjustmentInventory');
        });

        // scanner part number
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('part_number').addEventListener('input', function (e) {
                const input = e.target.value;

                // Tambahkan delay sebelum memproses input
                setTimeout(function () {
                    const parts = input.split(';');

                    console.log('Parts:', parts); // Debugging output untuk melihat hasil pemisahan

                    if (parts.length >= 6) {
                        // Ambil bagian dari input
                        const rn = parts[0].trim();            // Bagian ke-1 adalah RN
                        const partNumber = parts[3].trim();    // Bagian ke-4 adalah part number
                        const quantityRaw = parts[4].trim();   // Bagian ke-5 adalah quantity
                        const lotNumber = parts[5].trim();     // Bagian ke-6 adalah lot number

                        // Hapus bagian desimal dari quantity
                        const quantity = parseInt(quantityRaw.split('.')[0], 10);

                        // Set nilai input lain dengan data yang diambil
                        document.getElementById('rn').value = rn;
                        document.getElementById('part_number').value = partNumber; // Isi part number
                        document.getElementById('qty').value = quantity;           // Isi quantity
                        document.getElementById('lot_number').value = lotNumber;   // Isi lot number

                        // Panggil fetchWarehouseByItemCode setelah data diisi
                        fetchWarehouseByItemCode(partNumber);
                    } else {
                        console.error('Input tidak sesuai format yang diharapkan.');
                    }
                }, 100); // Delay 100ms sebelum memproses
            });
        });


        // scanner part number from pada transfer stock
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('part_number_from_transfer').addEventListener('input', function (e) {
                const input = e.target.value;

                // delay sebelum memproses input
                setTimeout(function () {
                    const parts = input.split(';');

                    console.log('Parts:', parts); // Debugging output untuk melihat hasil pemisahan

                    if (parts.length >= 6) {
                        // Ambil bagian dari input
                        const rn = parts[0].trim();            // Bagian ke-1 adalah RN
                        const partNumber = parts[3].trim();    // Bagian ke-4 adalah part number
                        const quantityRaw = parts[4].trim();   // Bagian ke-5 adalah quantity
                        const lotNumber = parts[5].trim();     // Bagian ke-6 adalah lot number

                        // Hapus bagian desimal dari quantity
                        const quantity = parseInt(quantityRaw.split('.')[0], 10);

                        // Set nilai input lain dengan data yang diambil
                        document.getElementById('rn_from_transfer').value = rn;
                        document.getElementById('part_number_from_transfer').value = partNumber; // Isi part number
                        document.getElementById('qty').value = quantity;           // Isi quantity
                        document.getElementById('lot_number_from_transfer').value = lotNumber;   // Isi lot number

                        // Panggil fetchWarehouseByItemCode setelah data diisi
                        fetchWarehouseFromByItemCode(partNumber);

                    } else {
                        console.error('Input tidak sesuai format yang diharapkan.');
                    }
                }, 100); // Delay 100ms sebelum memproses
            });
        });

        // scanner part number from pada transfer stock
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('part_number_to_transfer').addEventListener('input', function (e) {
                const input = e.target.value;

                // delay sebelum memproses input
                setTimeout(function () {
                    const parts = input.split(';');

                    console.log('Parts:', parts); // Debugging output untuk melihat hasil pemisahan

                    if (parts.length >= 6) {
                        // Ambil bagian dari input
                        const rn = parts[0].trim();            // Bagian ke-1 adalah RN
                        const partNumber = parts[3].trim();    // Bagian ke-4 adalah part number
                        const lotNumber = parts[5].trim();     // Bagian ke-6 adalah lot number

                        // Set nilai input lain dengan data yang diambil
                        document.getElementById('rn_to_transfer').value = rn;
                        document.getElementById('part_number_to_transfer').value = partNumber; // Isi part number
                        document.getElementById('lot_number_to_transfer').value = lotNumber;   // Isi lot number

                        // Panggil fetchWarehouseByItemCode setelah data diisi
                        fetchWarehouseToByItemCode(partNumber);

                    } else {
                        console.error('Input tidak sesuai format yang diharapkan.');
                    }
                }, 100); // Delay 100ms sebelum memproses
            });
        });

        // scanner part number from pada Cancel Lot
        document.addEventListener('DOMContentLoaded', function () {
            // Event listener untuk part_number_from
            document.getElementById('part_number_from').addEventListener('input', function (e) {
                // Tambahkan setTimeout dengan penundaan 200ms
                setTimeout(function () {
                    const input = e.target.value;
                    const parts = input.split(';');

                    console.log('Parts (part_number_from):', parts); // Debugging output untuk melihat hasil pemisahan

                    if (parts.length >= 6) {
                        // Ambil bagian dari input
                        const partNumber = parts[3].trim();    // Bagian ke-4 adalah part number
                        const quantityRaw = parts[4].trim();   // Bagian ke-5 adalah quantity

                        // Hapus bagian desimal dari quantity
                        const quantity = parseInt(quantityRaw.split('.')[0], 10);

                        // Set nilai input lain dengan data yang diambil
                        document.getElementById('part_number_from').value = partNumber; // Isi part number
                        document.getElementById('qty').value = quantity;           // Isi quantity

                        // Simpan part number untuk digunakan saat memindai lot_number
                        document.getElementById('part_number_from').dataset.partNumber = partNumber;

                        // Trigger change event untuk part_number_from
                        $('#part_number_from').trigger('change');

                        // Sesuaikan batasan lot_number berdasarkan part_number
                        adjustLotNumberConstraints(partNumber);
                    } else {
                        console.error('Input tidak sesuai format yang diharapkan untuk part_number_from.');
                    }
                }, 100); // Penundaan 200ms
            });

            // scanner untuk lot_number pada cancel lot
            document.getElementById('lot_number').addEventListener('input', function (e) {
                // Tambahkan setTimeout dengan penundaan 200ms
                setTimeout(function () {
                    const input = e.target.value;
                    const parts = input.split(';');

                    console.log('Parts (lot_number):', parts); // Debugging output untuk melihat hasil pemisahan

                    const partNumber = document.getElementById('part_number_from').dataset.partNumber;

                    if (parts.length >= 6) {
                        let lotNumber;
                        if (partNumber.includes('A01')) {
                            lotNumber = parts[0].trim();  // Jika part number mengandung 'A01', ambil indeks ke-0
                        } else {
                            lotNumber = parts[5].trim();  // Jika tidak, ambil indeks ke-5
                        }

                        // Set nilai lot number input dengan data yang diambil
                        document.getElementById('lot_number').value = lotNumber; // Isi lot number
                    } else {
                        console.error('Input tidak sesuai format yang diharapkan untuk lot number.');
                    }
                }, 100); // Penundaan 200ms
            });

            // Fungsi untuk menyesuaikan batasan input lot_number
            function adjustLotNumberConstraints(partNumber) {
                var lotNumberInput = document.getElementById('lot_number');
                var lotNumberHelp = document.getElementById('lotNumberHelp');

                if (partNumber.includes('A01')) {
                    lotNumberInput.setAttribute('maxlength', '8');
                    lotNumberInput.setAttribute('minlength', '8');
                    lotNumberHelp.textContent = 'No. Lot/RN harus berisi tepat 8 digit jika Part Number mengandung A01.';
                } else {
                    lotNumberInput.removeAttribute('maxlength');
                    lotNumberInput.removeAttribute('minlength');
                    lotNumberHelp.textContent = '';
                }
            }

            // Validasi input lot_number
            document.getElementById('lot_number').addEventListener('input', function () {
                var lotNumber = this.value;
                var partNumber = document.getElementById('part_number_from').value;

                // Hanya validasi panjang jika part number mengandung 'A01'
                if (partNumber.includes('A01') && lotNumber.length !== 8) {
                    this.setCustomValidity('No. Lot/RN harus berisi tepat 8 digit.');
                } else {
                    this.setCustomValidity('');
                }
            });
        });






    </script>

    <?= $this->renderSection('content') ?>

</body>

</html>
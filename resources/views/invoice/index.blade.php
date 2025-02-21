<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sales Invoice</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>

   <!-- Navbar -->
   <nav class="navbar navbar-expand-lg navbar-light bg-black shadow-sm py-3">
        <div class="container-fluid px-5">
            <!-- Logo/Brand -->
            <a class="navbar-brand fw-bold text-white" href="#">Sales Invoice</a>
            <!-- Create Invoice Button -->
            <div class="d-flex">
                <button type="button" class="btn btn-primary"data-bs-toggle="modal" data-bs-target="#createInvoiceModal">Create Invoice</button>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4">
        <!-- Invoice List Table -->
        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Invoice #</th>
                            <th scope="col">Date</th>
                            <th scope="col">Customer</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Sample Invoice Row -->
                        <tr>
                            <td>#1001</td>
                            <td>2023-10-01</td>
                            <td>John Doe</td>
                            <td>$500.00</td>
                            <td>
                                <span class="badge bg-success">Paid</span>
                            </td>

                            <td>
                                <a href="#" class="btn btn-sm btn-primary">View</a>
                                <a href="#" class="btn btn-sm btn-primary">Edit</a>
                                <a href="#" class="btn btn-sm btn-danger">Delete</a>

                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Create Invoice Modal -->
    <div class="modal fade" id="createInvoiceModal" tabindex="-1" aria-labelledby="createInvoiceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="createInvoiceModalLabel">Create Invoice</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    <form action="" method="POST" enctype="multipart/form-data" id="invoiceForm">
                        @csrf
                   
                        <!-- Customer Details -->
                        <div class="mb-3">
                            <label for="customerName" class="form-label">Customer Name</label>
                            <input type="text" name="customer" class="form-control" id="customerName" required>
                        </div>
                        <div class="mb-3">
                            <label for="invoiceDate" class="form-label">Due Date</label>
                            <input type="date" name="date" class="form-control" id="invoiceDate" required>
                        </div>

                        <!-- Invoice Items Table -->
                        <div class="mb-3">
                            <label class="form-label">Invoice Items</label>
                            <table class="table table-bordered" id="itemsTable">
                                <thead>
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Total Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Rows will be added dynamically -->
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-sm btn-secondary" id="addItem">
                                <i class="bi bi-plus"></i> Add Item
                            </button>
                        </div>

                        <!-- Grand Total -->
                        <div class="mb-3">
                            <label for="grandTotal" class="form-label">Grand Total</label>
                            <input type="text" class="form-control" id="grandTotal" readonly>
                        </div>


                        <div class="mb-3">
                            <label for="grandTotal" class="form-label">Upload file (excel or pdf only)</label>
                            <input type="file" class="form-control" id="file" name="file" required>
                        </div>
                    </form>
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="invoiceForm" class="btn btn-primary">Save Invoice</button>
                </div>
            </div>
        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

    <script>
        // Add Item Row
        document.getElementById('addItem').addEventListener('click', function () {
            const tableBody = document.querySelector('#itemsTable tbody');
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td><input type="text" class="form-control item-name" required></td>
                <td><input type="number" class="form-control quantity" min="1" required></td>
                <td><input type="number" class="form-control unit-price" step="0.01" min="0" required></td>
                <td><input type="text" class="form-control total-amount" readonly></td>
                <td><button type="button" class="btn btn-sm btn-danger remove-item"><i class="bi bi-trash"></i></button></td>
            `;
            tableBody.appendChild(newRow);

            // Add event listeners for quantity and unit price inputs
            const quantityInput = newRow.querySelector('.quantity');
            const unitPriceInput = newRow.querySelector('.unit-price');
            const totalAmountInput = newRow.querySelector('.total-amount');

            const calculateTotal = () => {
                const quantity = parseFloat(quantityInput.value) || 0;
                const unitPrice = parseFloat(unitPriceInput.value) || 0;
                totalAmountInput.value = (quantity * unitPrice).toFixed(2);
                updateGrandTotal();
            };

            quantityInput.addEventListener('input', calculateTotal);
            unitPriceInput.addEventListener('input', calculateTotal);

            // Remove Item Row
            newRow.querySelector('.remove-item').addEventListener('click', function () {
                tableBody.removeChild(newRow);
                updateGrandTotal();
            });
        });

        // Update Grand Total
        function updateGrandTotal() {
            const totalAmounts = document.querySelectorAll('.total-amount');
            let grandTotal = 0;
            totalAmounts.forEach(input => {
                grandTotal += parseFloat(input.value) || 0;
            });
            document.getElementById('grandTotal').value = grandTotal.toFixed(2);
        }
    </script>
  </body>
</html>
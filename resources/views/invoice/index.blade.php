<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sales Invoice</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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

    
    @if ($errors->any())
                           

                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul>
                                    @foreach ($errors->all() as $error)
                                        <li><strong>{{ $error }}</strong></li>
                                    @endforeach
                                </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif


    @if (session('success'))
        

        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ session('success') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>

    @endif

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


                        @foreach($invoices as $invoice)
                        <tr>
                            <td>{{$invoice->invoice_number}}</td>
                            <td>{{$invoice->due_date}}</td>
                            <td>{{$invoice->customer_name}}</td>
                            <td>{{$invoice->grand_total}}</td>
                            <td>
                                <!-- <span class="badge bg-success">Paid</span> -->

                                @if($invoice->status == 'pending')
                                <span class="badge bg-warning text-dark">{{$invoice->status}}</span>
                                @elseif($invoice->status == 'draft')
                                <span class="badge bg-secondary">{{$invoice->status}}</span>
                                @elseif($invoice->status == 'sent')
                                <span class="badge bg-primary">{{$invoice->status}}</span>
                                @elseif($invoice->status == 'paid')
                                <span class="badge bg-success">{{$invoice->status}}</span>
                                @elseif($invoice->status == 'canceled')
                                <span class="badge bg-danger">{{$invoice->status}}</span>
                                @endif
                            </td>

                            <td>

                            <a href="{{ route('invoice.show', $invoice->invoice_number) }}" class="btn btn-sm btn-primary">View</a>
                                <a href="#" class="btn btn-sm btn-warning">Edit</a>
                                <a href="#" class="btn btn-sm btn-danger">Delete</a>

                                @if($invoice->uploadUrl)
                                <a href="{{$invoice->uploadUrl}}"target="_blank" class="btn btn-sm btn-info text-light" download><i class="fa fa-download text-light"></i> Attachment</a>
                                @endif
                            </td>
                        </tr>

                        @endforeach
                        
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
                    <form action="{{ route('invoice.store') }}" method="POST" enctype="multipart/form-data" id="invoiceForm">
                        @csrf
                   
                       
                      <div class="row mb-3">
                        <div class="col">
                                <label for="customerName" class="form-label">Customer Name</label>
                                <input type="text" name="customer_name" class="form-control" id="customerName" required>
                            </div>

                            <div class="col">
                                <label for="invoiceDate" class="form-label">Due Date</label>
                                <input type="date" name="due_date" class="form-control" id="invoiceDate" required>
                            </div>
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

                        <input type="hidden" name="items" id="itemsInput">


                        <!-- Grand Total -->
                        <div class="mb-3">
                            <label for="grandTotal" class="form-label">Grand Total</label>
                            <input type="text"name="grand_total" class="form-control" id="grandTotal" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" class="form-control" id="status" required>
                                <option value="">Select Status</option>
                                <option value="pending">Pending</option>
                                <option value="draft">Draft</option>
                                <option value="sent">Sent</option>
                                <option value="paid">Paid</option>
                                <option value="canceled">Canceled</option>
                            </select>
                        </div>


                        <div class="mb-3">
                            <label for="grandTotal" class="form-label">Upload file <span><small>optional (images, pdf, excel only)</small></span></label>
                            <input type="file" class="form-control" id="file" name="file">
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
                <td><button type="button" class="btn btn-sm btn-danger remove-item"><i class="fa fa-trash"></i></button></td>
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
    <script>
         document.getElementById('invoiceForm').addEventListener('submit', function (e) {
    // Prevent form submission until items are processed
    e.preventDefault();

    // Collect items data
    const items = [];
    document.querySelectorAll('#itemsTable tbody tr').forEach(row => {
        const itemName = row.querySelector('.item-name').value;
        const quantity = row.querySelector('.quantity').value;
        const unitPrice = row.querySelector('.unit-price').value;
        const totalAmount = row.querySelector('.total-amount').value;

        items.push({
            item_name: itemName,
            quantity: quantity,
            unit_price: unitPrice,
            total_amount: totalAmount,
        });
    });

    // Populate the hidden input with JSON data
    document.getElementById('itemsInput').value = JSON.stringify(items);

    // Submit the form
    this.submit();
});
    </script>
  </body>
</html>
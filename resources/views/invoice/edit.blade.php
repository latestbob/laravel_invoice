
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
            <a class="navbar-brand fw-bold text-white" href="/">Sales Invoice</a>
            <!-- Create Invoice Button -->
            <div class="d-flex">
                <a href="/" class="btn btn-primary">Back</a>
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

    <div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom-0">
            <div class="row">
                <div class="col-md-6">
                    <h2 class="fw-bold">Edit Invoice</h2>
                    <p class="text-muted mb-0">Invoice #{{ $invoice->invoice_number }}</p>
                    <p class="text-muted">Date: {{ $invoice->due_date }}</p>
                </div>
                <div class="col-md-6 text-end">
                <p class="mb-0"><strong>Sales Invoice</strong></p>
                    <p class="text-muted mb-0">123 Milverton Road</p>
                    <p class="text-muted mb-0">Lagos, Nigeria</p>
                    <p class="text-muted">edidiongbobson@gmail.com</p>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{route('invoice.update', $invoice->invoice_number)}}" method="POST"enctype="multipart/form-data" id="invoiceForm">
                @csrf
                @method('PUT')

                <!-- Customer Details -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5 class="fw-bold">Bill To:</h5>
                        <input type="text" class="form-control" name="customer_name" value="{{ $invoice->customer_name }}" required>
                    </div>
                    <div class="col-md-6 text-end">
                        <h5 class="fw-bold">Invoice Total:</h5>
                        <p class="h4 text-primary">N{{ number_format($invoice->grand_total, 2) }}</p>
                    </div>
                </div>
                <!-- Invoice Status -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5 class="fw-bold">Status:</h5>
                        <select class="form-select" name="status" required>
                            <option value="pending" {{ $invoice->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="draft" {{ $invoice->status == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="sent" {{ $invoice->status == 'sent' ? 'selected' : '' }}>Sent</option>
                            <option value="paid" {{ $invoice->status == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="canceled" {{ $invoice->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                        </select>
                    </div>
                </div>

                <!-- Invoice Items Table -->
                <div class="table-responsive mb-4">
                    <table class="table table-bordered" id="itemsTable">
                        <thead class="bg-light">
                            <tr>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoice->items as $index => $item)
                                <tr>
                                    <td>
                                        <input type="text" class="form-control item-name" name="items[{{ $index }}][item_name]" value="{{ $item['item_name'] }}" readonly>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control quantity" name="items[{{ $index }}][quantity]" value="{{ $item['quantity'] }}" min="1" readonly>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control unit-price" name="items[{{ $index }}][unit_price]" value="{{ $item['unit_price'] }}" step="0.01" min="0" readonly>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control total-amount" value="{{ $item['total_amount'] }}" readonly>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger remove-item">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-sm btn-secondary" id="addItem">
                        <i class="bi bi-plus"></i> Add Item
                    </button>
                </div>

                <div class="row mb-3">

                <div class="col">
                            <label for="grandTotal" class="form-label">Grand Total</label>
                            <input type="text"name="grand_total"value="{{$invoice->grand_total}}" class="form-control" id="grandTotal" readonly>
                        </div>
                <div class="col">
                            <label for="grandTotal" class="form-label">Upload file <span><small>optional (images, docx, excel only)</small></span></label>
                            <input type="file" class="form-control" id="file" name="file">
                        </div>
                </div>

                


                <!-- Grand Total -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <p class="text-muted">Thank you for your business!</p>
                    </div>
                    <div class="col-md-6">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th class="bg-light">Subtotal</th>
                                        <td>N <span id="subtotal">{{ number_format($invoice->grand_total, 2) }}</span></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Tax (0%)</th>
                                        <td>N0.00</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Grand Total</th>
                                        <td class="fw-bold">N <span id="grand">{{ number_format($invoice->grand_total, 2) }}</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Hidden Input for Items (to be populated dynamically) -->

                
                <input type="hidden" name="items" id="itemsInput"value="{{json_encode($invoice->items)}}">
                

                <!-- Submit Button -->
                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-2"></i>Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript for Dynamic Item Addition and Calculation -->



<script>
    let itemIndex = document.querySelectorAll('#itemsTable tbody tr').length;

// Function to update grand total
function updateGrandTotal() {
    let total = 0;
    document.querySelectorAll('.total-amount').forEach(input => {
        total += parseFloat(input.value) || 0;
    });
    document.getElementById('grand').textContent = total.toFixed(2);
    document.getElementById('grandTotal').value = total.toFixed(2);
}

// Function to add new item row
document.getElementById('addItem').addEventListener('click', function () {
    const tableBody = document.querySelector('#itemsTable tbody');
    const newRow = document.createElement('tr');

    newRow.innerHTML = `
        <td>
            <input type="text" class="form-control item-name" required>
        </td>
        <td>
            <input type="number" class="form-control quantity" min="1" required>
        </td>
        <td>
            <input type="number" class="form-control unit-price" step="0.01" min="0" required>
        </td>
        <td>
            <input type="text" class="form-control total-amount" readonly>
        </td>
        <td>
            <button type="button" class="btn btn-sm btn-danger remove-item">
                <i class="fa fa-trash"></i>
            </button>
        </td>
    `;

    
    tableBody.appendChild(newRow);

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

    // Remove item button
    newRow.querySelector('.remove-item').addEventListener('click', function () {
        newRow.remove();
        updateGrandTotal();
    });

    itemIndex++;
});

// Update itemsInput field before form submission

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
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

 
    
  </body>
</html>
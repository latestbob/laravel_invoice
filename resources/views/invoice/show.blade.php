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

    <div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom-0">
            <div class="row">
                <div class="col-md-6">
                    <h2 class="fw-bold">Invoice</h2>
                    <p class="text-muted mb-0">Invoice #{{ $invoice->invoice_number }}</p>
                    <p class="text-muted">Due Date: {{ $invoice->due_date }}</p>
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
            <!-- Customer Details -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5 class="fw-bold">Bill To:</h5>
                    <p class="mb-0">{{ $invoice->customer_name }}</p>
                </div>
                <div class="col-md-6 text-end">
                    <h5 class="fw-bold">Invoice Total:</h5>
                    <p class="h4 text-primary">N{{ number_format($invoice->grand_total, 2) }}</p>
                </div>
            </div>

            <!-- Invoice Items Table -->
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="bg-light">
                        <tr>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoice->items as $item)
                            <tr>
                                <td>{{ $item['item_name'] }}</td>
                                <td>{{ $item['quantity'] }}</td>
                                <td>N{{ number_format($item['unit_price'], 2) }}</td>
                                <td>N{{ number_format($item['total_amount'], 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Totals -->
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
                                    <td>N{{ number_format($invoice->grand_total, 2) }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Tax (0%)</th>
                                    <td>N0.00</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Grand Total</th>
                                    <td class="fw-bold">N{{ number_format($invoice->grand_total, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

 
    </script>
  </body>
</html>
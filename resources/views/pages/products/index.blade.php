@extends('layouts.app')

@section('title', 'Product Table')

@push('style')
    <!-- Include DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.6/css/jquery.dataTables.min.css">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Product Table</h1>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-primary mb-3" data-toggle="modal"
                                data-target="#createProductModal">
                                <i class="fa-solid fa-plus" style="color: #ffffff;"></i> Create Product
                            </button>

                            <button type="button" class="btn btn-secondary mb-3" data-toggle="modal"
                                data-target="#stockInModal">
                                <i class="fa-solid fa-box" style="color: #ffffff;"></i> Add Stock
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table id="products-table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>Kategori</th>
                                        <th>Supplier</th>
                                        <th>Modal</th>
                                        <th>Harga</th>
                                        <th>Stok</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $counter = 1;
                                    @endphp
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>{{ $counter++ }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->category->name }}</td>
                                            <td>{{ optional($product->supplier)->name }}</td>
                                            <td>{{ 'Rp ' . number_format($product->harga_modal, 0, ',', '.') }}</td>
                                            <td>{{ 'Rp ' . number_format($product->price, 0, ',', '.') }}</td>
                                            <td>{{ $product->stock }}</td>
                                            <td>
                                                @if ($product->stock == 0)
                                                    <span class="badge badge-secondary">Habis</span>
                                                @elseif ($product->stock < 5)
                                                    <span class="badge badge-warning">Mau Habis</span>
                                                @else
                                                    <span class="badge badge-success">Ready</span>
                                                @endif
                                            </td>

                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('products.show', $product->id) }}"
                                                        class="btn btn-primary btn-sm mr-2" title="View Detail">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-warning btn-sm edit-product mr-2"
                                                        data-toggle="modal"
                                                        data-target="#editProductModal{{ $product->id }}"
                                                        data-product-id="{{ $product->id }}" data-backdrop="false">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </button>

                                                    <form id="delete-form-{{ $product->id }}"
                                                        action="{{ route('products.destroy', $product->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm delete-product"
                                                            onclick="deleteProduct(event, {{ $product->id }})">
                                                            <i class="fa-solid fa-trash-can"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Modal for creating product -->
    <div class="modal fade" id="createProductModal" tabindex="-1" role="dialog" aria-labelledby="createProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createProductModalLabel">Create Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="categories_id">Category</label>
                                    <select name="categories_id" id="categories_id" class="form-control" required>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="supplier_id">Supplier</label>
                                    <select name="supplier_id" id="supplier_id" class="form-control" required>
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="price">Modal</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input type="text" name="harga_modal" id="harga_modal" class="form-control"
                                            required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">.00</span>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="price">Harga</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="text" name="price" id="price" class="form-control" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">.00</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="stock">Stock</label>
                                <input type="text" name="stock" id="stock" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Status</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="status" value="ready" class="selectgroup-input"
                                            checked="">
                                        <span class="selectgroup-button">Ready</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="status" value="habis" class="selectgroup-input">
                                        <span class="selectgroup-button">Habis</span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" class="form-control"></textarea>
                            </div>
                        </div>
                        
                    </div>
                    <button type="submit" class="btn btn-primary">Create Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for adding stock -->
    <div class="modal fade" id="stockInModal" tabindex="-1" role="dialog" aria-labelledby="stockInModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="stockInModalLabel">Add Stock</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="stockInForm">
                        @csrf
                        <div class="form-group">
                            <label for="product_id">Product</label>
                            <select name="product_id" id="product_id" class="form-control" required>
                                <option value="">Select Product</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="supplier_id">Supplier</label>
                            <select name="supplier_id" id="supplier_id" class="form-control" required>
                                <option value="">Select Supplier</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" name="quantity" id="quantity" class="form-control" min="1"
                                required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Stock</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals for editing products -->
    @foreach ($products as $product)
        <!-- Modal for editing product -->
        <div class="modal fade" id="editProductModal{{ $product->id }}" tabindex="-1" role="dialog"
            aria-labelledby="editProductModalLabel{{ $product->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProductModalLabel{{ $product->id }}">Edit Product</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <form id="editProductForm{{ $product->id }}"
                                    action="{{ route('products.update', $product->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="edit_name{{ $product->id }}">Name</label>
                                        <input type="text" name="name" id="edit_name{{ $product->id }}"
                                            class="form-control" value="{{ $product->name }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_categories_id{{ $product->id }}">Categoy</label>
                                        <select name="categories_id" id="edit_categories_id{{ $product->id }}"
                                            class="form-control" required>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ $category->id == $product->category_id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_supplier_id{{ $product->id }}">Supplier</label>
                                        <select name="supplier_id" id="edit_supplier_id{{ $product->id }}"
                                            class="form-control" required>
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}"
                                                    {{ $supplier->id == $product->supplier_id ? 'selected' : '' }}>
                                                    {{ $supplier->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_harga_modal{{$product->id}}">Modal</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp</span>
                                            </div>
                                            <input type="text" name="harga_modal" id="edit_harga_modal{{ $product->id }}" class="form-control"
                                            value="{{ $product->harga_modal }}" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text">.00</span>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_price{{ $product->id }}">Harga</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input type="text" name="price" id="edit_price{{ $product->id }}"
                                            class="form-control" value="{{ $product->price }}" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">.00</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="edit_stock{{ $product->id }}">Stock</label>
                                    <input type="text" name="stock" id="edit_stock{{ $product->id }}"
                                        class="form-control" value="{{ $product->stock }}" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Status</label>
                                    <div class="selectgroup w-100">
                                        <label class="selectgroup-item">
                                            <input type="radio" name="status" value="ready"
                                                class="selectgroup-input" id="edit_status_active{{ $product->id }}"
                                                {{ $product->status == 'ready' ? 'checked' : '' }}>
                                            <span class="selectgroup-button">Ready</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="status" value="habis"
                                                class="selectgroup-input" id="edit_status_inactive{{ $product->id }}"
                                                {{ $product->status == 'habis' ? 'checked' : '' }}>
                                            <span class="selectgroup-button">Habis</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="edit_description{{ $product->id }}">Description</label>
                                    <textarea name="description" id="edit_description{{ $product->id }}" class="form-control">{{ $product->description }}</textarea>
                                </div>
                            </div>
                            
                            
                        </div>
                        <button type="submit" class="btn btn-primary">Update Product</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@push('scripts')
    <!-- Include SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- Include DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.6/js/jquery.dataTables.min.js"></script>

    <script>
        function deleteProduct(event, productId) {
            event.preventDefault(); // Prevent default form submission

            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this product!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the delete form
                    $('#delete-form-' + productId).submit();
                }
            });
        }

        $(document).ready(function() {
            // Function to handle displaying Sweet Alert for errors
            function showErrorAlert(errorMessage) {
                Swal.fire({
                    title: 'Error!',
                    html: errorMessage,
                    icon: 'error'
                });
            }

            // Handle success message after deletion
            var successMessage = '{{ session('success') }}';
            if (successMessage) {
                Swal.fire({
                    title: 'Success!',
                    text: successMessage,
                    icon: 'success',
                    timer: 2000 // Set the timer for auto-close
                });
            }

            // Ajax setup for handling errors
            $.ajaxSetup({
                error: function(xhr) {
                    var errorMessage = '';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        // If there are validation errors, display validation error message
                        var errors = xhr.responseJSON.errors;
                        errorMessage = '<ul>';
                        $.each(errors, function(key, value) {
                            errorMessage += '<li>' + value + '</li>';
                        });
                        errorMessage += '</ul>';
                    } else if (xhr.responseJSON && xhr.responseJSON.error) {
                        // If there is an error message, display it
                        errorMessage = xhr.responseJSON.error;
                    } else {
                        // If no defined error message, display a generic error message
                        errorMessage = 'An error occurred. Please try again later.';
                    }
                    // Show the error message using Sweet Alert
                    showErrorAlert(errorMessage);
                }
            });

            // Handle stock addition form submission with AJAX
            $('#stockInForm').on('submit', function(event) {
                event.preventDefault();
                $.ajax({
                    url: '{{ route('stock.store') }}',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#stockInModal').modal('hide');
                        Swal.fire({
                            title: 'Success!',
                            text: 'Stock has been added successfully.',
                            icon: 'success',
                            timer: 2000
                        }).then(() => {
                            location.reload(); // Reload the page to reflect the changes
                        });
                    }
                });
            });
        });
    </script>
@endpush

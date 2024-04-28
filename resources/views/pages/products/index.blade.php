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
                <h1>Products Table</h1>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        <!-- Button trigger modal for creating user -->
                        <button type="button" class="btn btn-primary mb-3" data-toggle="modal"
                            data-target="#createProductModal">
                            <i class="fa-solid fa-plus" style="color: #ffffff;"></i> Create Product
                        </button>

                        <div class="table-responsive">
                            <table id="products-table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Tags</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $count = 1; @endphp
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>{{ $count }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ optional($product->category)->name }}</td>
                                            <td>{{ number_format($product->price, 0, ',', '.') }}</td>
                                            <td>{{ $product->tags }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <!-- Button trigger modal for editing product -->
                                                    <button type="button" class="btn btn-warning btn-sm edit-product mr-2"
                                                        data-toggle="modal"
                                                        data-target="#editProductModal{{ $product->id }}"
                                                        data-product-id="{{ $product->id }}" data-backdrop="false">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </button>
                                                    <!-- Delete Product Form -->
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
                                        @php $count++; @endphp
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
        <!-- Modal content goes here -->
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createUserModalLabel">Add Products</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Form for creating product -->
                                <form action="{{ route('products.store') }}" method="POST">
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

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="text" name="price" id="price" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="tags">Tags</label>
                                    <input type="text" name="tags" id="tags" class="form-control">
                                </div>

                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" class="form-control" cols="50" rows="5"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create User</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>

    <!-- Modals for editing products -->
    @foreach ($products as $product)
        <div class="modal fade" id="editProductModal{{ $product->id }}" tabindex="-1" role="dialog"
            aria-labelledby="editProductModalLabel{{ $product->id }}" aria-hidden="true">
            <!-- Modal content goes here -->
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProductModalLabel{{ $product->id }}">Edit Product</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Form for editing product -->
                                    <form action="{{ route('products.update', $product->id) }}" method="POST">
                                        @csrf
                                        @method('PUT') <!-- Gunakan metode PUT untuk mengirimkan permintaan pembaruan -->
                    
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="categories_id">Category</label>
                                            <select name="categories_id" id="categories_id" class="form-control" required>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="price">Price</label>
                                        <input type="text" name="price" id="price" class="form-control" value="{{ $product->price }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="tags">Tags</label>
                                        <input type="text" name="tags" id="tags" class="form-control" value="{{ $product->tags }}">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea name="description" id="description" class="form-control" cols="50" rows="5">{{ $product->description }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Product</button>
                    </div>
                    </form>
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

            // Handle modal for editing product
            $('.edit-product').click(function() {
                var productId = $(this).data('product-id');
                $('#editProductModal' + productId).modal({
                    show: true,
                    backdrop: false
                });
            });
        });
    </script>
@endpush

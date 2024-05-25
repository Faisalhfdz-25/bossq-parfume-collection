@extends('layouts.app')

@section('title', 'Product Table')

@push('style')
    <!-- Include DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap5.min.css">
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
                                        <label for="edit_harga_modal{{ $product->id }}">Modal</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp</span>
                                            </div>
                                            <input type="text" name="harga_modal"
                                                id="edit_harga_modal{{ $product->id }}" class="form-control"
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
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.min.js"></script>


    <script>
        $(document).ready(function() {
            $('#products-table').DataTable({
                "pagingType": "full_numbers",
                "lengthMenu": [10, 25, 50, 75, 100],
                "language": {
                    "search": "Cari:",
                    "lengthMenu": "Tampilkan _MENU_ entri",
                    "info": "Menampilkan _START_ hingga _END_ dari _TOTAL_ entri",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Berikutnya",
                        "previous": "Sebelumnya"
                    }
                }
            });

            // $('.detail-button').click(function() {
            //     var kode = $(this).data('id');
            //     $.ajax({
            //         url: '/konfirmasi-belanja/detail/' + kode,
            //         method: 'GET',
            //         success: function(data) {
            //             var rows = '';
            //             data.forEach(function(item) {
            //                 var status = '';
            //                 if (item.acc === 1) {
            //                     status =
            //                         '<button class="btn btn-sm btn-success">Di Setujui</button>';
            //                 } else if (item.acc === 0) {
            //                     status =
            //                         '<button class="btn btn-sm btn-danger">Tidak Disetujui</button>';
            //                 } else {
            //                     status =
            //                         '<button class="btn btn-sm btn-warning">Belum Disetujui</button>';
            //                 }

            //                 rows += '<tr>' +
            //                     '<td>' + item.products.name + '</td>' +
            //                     '<td>' + item.qty + '</td>' +
            //                     '<td>' + item.harga + '</td>' +
            //                     '<td>' + item.tempat + '</td>' +
            //                     '<td>' + item.sub_total + '</td>' +
            //                     '<td>' + status + '</td>' +
            //                     '<td>' +
            //                     '<button type="button" class="btn btn-primary btn-sm edit-status-button" data-toggle="modal" data-target="#editStatusModal" data-detail-id="' +
            //                     item.id + '">' +
            //                     '<i class="fa-solid fa-pen-to-square"></i> Ubah Status' +
            //                     '</button>' +
            //                     '</td>' +
            //                     '</tr>';
            //             });
            //             $('#detail-table-body').html(rows);
            //         }
            //     });
            // });

            // Penanganan ketika tombol 'Ubah Status' diklik
            // $(document).on('click', '.edit-status-button', function() {
            //     var detailId = $(this).data('detail-id');
            //     $('#editStatusModal').modal('show');
            //     $('#editStatusModal').data('detail-id', detailId);
            // });

            // Penanganan ketika tombol 'Simpan' di modal diklik untuk mengubah status
            $('#saveStatusButton').click(function() {
                var detailId = $('#editStatusModal').data('detail-id');
                var newStatus = $("input[name='acc']:checked").val();
                $.ajax({
                    url: '/konfirmasi-belanja/ubah-status',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: detailId,
                        acc: newStatus
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $('#editStatusModal').modal('hide');
                            Swal.fire('Berhasil!', 'Status berhasil diubah.', 'success').then(
                                function() {
                                    location
                                        .reload(); // Refresh tampilan setelah berhasil mengubah status
                                });
                        } else {
                            Swal.fire('Gagal!', 'Terjadi kesalahan saat mengubah status.',
                                'error');
                        }
                    },
                    error: function(err) {
                        Swal.fire('Error!', 'Terjadi kesalahan saat menghubungi server.',
                            'error');
                    }
                });
            });
        });
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
    </script>
@endpush

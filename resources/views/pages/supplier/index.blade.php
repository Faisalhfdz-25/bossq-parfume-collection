@extends('layouts.app')

@section('title', 'Supplier Table')

@push('style')
    <!-- Include DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.6/css/jquery.dataTables.min.css">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Supplier Table</h1>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        <!-- Button trigger modal for creating supplier -->
                        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#createSupplierModal">
                            <i class="fa-solid fa-plus" style="color: #ffffff;"></i> Create Supplier
                        </button>

                        <div class="table-responsive">
                            <table id="suppliers-table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $count = 1; @endphp
                                    @foreach ($suppliers as $supplier)
                                        <tr>
                                            <td>{{ $count }}</td>
                                            <td>{{ $supplier->name }}</td>
                                            <td>{{ $supplier->address }}</td>
                                            <td>{{ $supplier->email }}</td>
                                            <td>{{ $supplier->phone }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <!-- Button trigger modal for editing supplier -->
                                                    <button type="button" class="btn btn-warning btn-sm edit-supplier mr-2"
                                                        data-toggle="modal" data-target="#editSupplierModal{{ $supplier->id }}"
                                                        data-supplier-id="{{ $supplier->id }}" data-backdrop="false">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </button>
                                                    <!-- Delete Supplier Form -->
                                                    <form id="delete-form-{{ $supplier->id }}"
                                                        action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm delete-supplier"
                                                            onclick="deleteSupplier(event, {{ $supplier->id }})">
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

    <!-- Modal for creating supplier -->
    <div class="modal fade" id="createSupplierModal" tabindex="-1" role="dialog" aria-labelledby="createSupplierModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createSupplierModalLabel">Create Supplier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Form for creating supplier -->
                                <form action="{{ route('suppliers.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <input type="text" name="address" id="address" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" id="email" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input type="text" name="phone" id="phone" class="form-control">
                                    </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Supplier</button>
                </div>
            </div>
            
        </form>
        </div>
    </div>

    <!-- Modal for editing supplier -->
    @foreach ($suppliers as $supplier)
        <div class="modal fade" id="editSupplierModal{{ $supplier->id }}" tabindex="-1" role="dialog"
            aria-labelledby="editSupplierModalLabel{{ $supplier->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editSupplierModalLabel{{ $supplier->id }}">Edit Supplier</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- Form for editing supplier -->
                                    <form id="edit-form-{{ $supplier->id }}"
                                        action="{{ route('suppliers.update', $supplier->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="edit_name{{ $supplier->id }}">Name</label>
                                            <input type="text" name="name" id="edit_name{{ $supplier->id }}"
                                                class="form-control" value="{{ $supplier->name }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="edit_address{{ $supplier->id }}">Address</label>
                                            <input type="text" name="address" id="edit_address{{ $supplier->id }}"
                                                class="form-control" value="{{ $supplier->address }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="edit_email{{ $supplier->id }}">Email</label>
                                            <input type="email" name="email" id="edit_email{{ $supplier->id }}"
                                                class="form-control" value="{{ $supplier->email }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="edit_phone{{ $supplier->id }}">Phone</label>
                                            <input type="text" name="phone" id="edit_phone{{ $supplier->id }}"
                                                class="form-control" value="{{ $supplier->phone }}">
                                        </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Supplier</button>
                    </div>
                </div>
            </form>
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
        function deleteSupplier(event, supplierId) {
            event.preventDefault(); // Prevent default form submission

            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this supplier!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the delete form
                    $('#delete-form-' + supplierId).submit();
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

            // Initialize DataTables
            $('#suppliers-table').DataTable();

            // Handle modal for editing supplier
            $('.edit-supplier').click(function() {
                var supplierId = $(this).data('supplier-id');
                $('#editSupplierModal' + supplierId).modal({
                    show: true,
                    backdrop: false
                });
            });
        });
    </script>
@endpush

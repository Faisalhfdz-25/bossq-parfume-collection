@extends('layouts.app')

@section('title', 'Product Categories Table')

@push('style')
    <!-- Include DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.6/css/jquery.dataTables.min.css">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Product Categories Table</h1>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        <!-- Button trigger modal for creating category -->
                        <button type="button" class="btn btn-primary mb-3" data-toggle="modal"
                            data-target="#createCategoryModal">
                            <i class="fa-solid fa-plus" style="color: #ffffff;"></i> Create Category
                        </button>

                        <div class="table-responsive">
                            <table id="categories-table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $count = 1; @endphp
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td>{{ $count }}</td>
                                            <td>{{ $category->name }}</td>
                                            <td><img src="{{ Storage::url($category->url) }}" alt="{{ $category->name }}" style="max-width: 100px; max-height: 100px;"></td>

                                            <td>
                                                <div class="d-flex">
                                                    <!-- Button trigger modal for editing category -->
                                                    <button type="button" class="btn btn-warning btn-sm edit-category mr-2"
                                                        data-toggle="modal"
                                                        data-target="#editCategoryModal{{ $category->id }}"
                                                        data-category-id="{{ $category->id }}" data-backdrop="false">
                                                        Edit
                                                    </button>
                                                    <!-- Delete Category Form -->
                                                    <form id="delete-form-{{ $category->id }}"
                                                        action="{{ route('categories.destroy', $category->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm delete-category"
                                                            onclick="deleteCategory(event, {{ $category->id }})">
                                                            Delete
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

    <!-- Modal for creating category -->
    <div class="modal fade" id="createCategoryModal" tabindex="-1" role="dialog" aria-labelledby="createCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createCategoryModalLabel">Add Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Form for creating category -->
                                <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="url">Image URL</label>
                                        <input type="file" name="url" id="url" class="form-control" required>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Category</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modals for editing categories -->
    @foreach ($categories as $category)
        <div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1" role="dialog"
            aria-labelledby="editCategoryModalLabel{{ $category->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCategoryModalLabel{{ $category->id }}">Edit Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Form for editing category -->
                                    <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" name="name" id="name" class="form-control" value="{{ $category->name }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="url">Image URL</label>
                                            <input type="file" name="url" id="url" class="form-control">
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Category</button>
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
        function deleteCategory(event, categoryId) {
            event.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this category!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#delete-form-' + categoryId).submit();
                }
            });
        }

        $(document).ready(function() {
            var successMessage = '{{ session('success') }}';
            if (successMessage) {
                Swal.fire({
                    title: 'Success!',
                    text: successMessage,
                    icon: 'success',
                    timer: 2000
                });
            }

            $('.edit-category').click(function() {
                var categoryId = $(this).data('category-id');
                $('#editCategoryModal' + categoryId).modal({
                    show: true,
                    backdrop: false
                });
            });
        });
    </script>
@endpush

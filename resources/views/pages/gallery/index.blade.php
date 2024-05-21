@extends('layouts.app')

@section('title', 'Product Galleries Table')

@push('style')
    <!-- Include DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.6/css/jquery.dataTables.min.css">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Product Galleries Table</h1>
            </div>

            <div class="section-body">
                <div class="card">  
                    <div class="card-body">
                        <!-- Button trigger modal for creating gallery -->
                        <button type="button" class="btn btn-primary mb-3" data-toggle="modal"
                            data-target="#createGalleryModal">
                            <i class="fa-solid fa-plus" style="color: #ffffff;"></i> Add Gallery
                        </button>

                        <div class="table-responsive">
                            <table id="galleries-table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $count = 1; @endphp
                                    @foreach ($galleries as $gallery)
                                        <tr>
                                            <td>{{ $count }}</td>
                                            <td>{{ $gallery->product->name }}</td>
                                            <td><img src="{{ Storage::url($gallery->url) }}" alt="Gallery Image" style="max-width: 100px;"></td>

                                            <td>
                                                <div class="d-flex">
                                                    <!-- Button trigger modal for editing gallery -->
                                                    <button type="button" class="btn btn-warning btn-sm edit-gallery mr-2"
                                                        data-toggle="modal"
                                                        data-target="#editGalleryModal{{ $gallery->id }}"
                                                        data-gallery-id="{{ $gallery->id }}">
                                                        Edit
                                                    </button>
                                                    <!-- Delete Gallery Form -->
                                                    <form id="delete-form-{{ $gallery->id }}"
                                                        action="{{ route('product-galleries.destroy', $gallery->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm delete-gallery"
                                                            onclick="deleteGallery(event, {{ $gallery->id }})">
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

    <!-- Modal for creating gallery -->
    <div class="modal fade" id="createGalleryModal" tabindex="-1" role="dialog" aria-labelledby="createGalleryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createGalleryModalLabel">Add Gallery</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <!-- Form for creating gallery -->
                                <form action="{{ route('product-galleries.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="products_id">Product</label>
                                        <select name="products_id" id="products_id" class="form-control" required>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="url">Image</label>
                                        <input type="file" name="url" id="url" class="form-control" required>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Gallery</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals for editing galleries -->
    @foreach ($galleries as $gallery)
        <div class="modal fade" id="editGalleryModal{{ $gallery->id }}" tabindex="-1" role="dialog"
            aria-labelledby="editGalleryModalLabel{{ $gallery->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editGalleryModalLabel{{ $gallery->id }}">Edit Gallery</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <!-- Form for editing gallery -->
                                    <form action="{{ route('product-galleries.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="products_id">Product</label>
                                            <select name="products_id" id="products_id" class="form-control" required>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}" @if($product->id == $gallery->products_id) selected @endif>{{ $product->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="url">Image</label>
                                            <input type="file" name="url" id="url" class="form-control">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Gallery</button>
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
        function deleteGallery(event, galleryId) {
            event.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this gallery!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#delete-form-' + galleryId).submit();
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

            $('.edit-gallery').click(function() {
                var galleryId = $(this).data('gallery-id');
                $('#editGalleryModal' + galleryId).modal({
                    show: true,
                    backdrop: false
                });
            });
        });
    </script>
@endpush

@extends('layouts.app')

@section('title', 'Product Detail')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Product Detail</h1>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-8">
                                <h3 class="text-center"><i class="fa-solid fa-bag-shopping"></i> {{ $product->name }}</h3>
                                <hr>
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        {{-- <div class="d-flex justify-content-between"> --}}
                                        <h6 class="label">Description:</h6>
                                        <span class="value text-end">{{ $product->description }}</span>
                                        {{-- </div> --}}
                                    </li>
                                    <li class="list-group-item">

                                        <div class="d-flex justify-content-between">
                                            <span class="label">Price:</span>
                                            <span class="value text-end">Rp
                                                {{ number_format($product->price, 0, ',', '.') }}</span>
                                        </div>

                                    </li>
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-between">
                                            <span class="label">Stock:</span>
                                            <span class="value">{{ $product->stock }}</span>
                                        </div>

                                    </li>
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-between">
                                            <span class="label">Suplier</span>
                                            <span class="value">{{ optional($product->supplier)->name }}</span>
                                        </div>

                                    </li>
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-between">
                                            <span class="label">Status:</span>
                                            <span class="value">{!! $product->status == 'ready'
                                                ? '<span class="badge badge-success">Ready</span>'
                                                : '<span class="badge badge-secondary">Habis</span>' !!}</span>
                                        </div>

                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>Gallery</h4>
                            <!-- Button trigger modal for creating gallery -->
                            <button type="button" class="btn btn-primary mb-3" data-toggle="modal"
                                data-target="#createGalleryModal"data-backdrop="false" data-keyboard="false">
                                <i class="fa-solid fa-plus" style="color: #ffffff;"></i> Add Gallery
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table-bordered table-md table">
                                    <tr>
                                        <th>#</th>

                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                    @php $count = 1; @endphp
                                    @foreach ($galleries as $gallery)
                                        <tr>
                                            <td>{{ $count }}</td>

                                            <td><img src="{{ asset('storage/' . $gallery->url) }}" alt="Gallery Image"
                                                    style="max-width: 100px;"></td>


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
                                                        {{-- action="{{ route('product-galleries.destroy', $gallery->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE') --}}
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

                                </table>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <nav class="d-inline-block">
                                <ul class="pagination mb-0">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1"><i
                                                class="fas fa-chevron-left"></i></a>
                                    </li>
                                    <li class="page-item active"><a class="page-link" href="#">1 <span
                                                class="sr-only">(current)</span></a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">2</a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Modal for creating gallery -->
            <div class="modal fade" id="createGalleryModal" tabindex="-1" role="dialog"
                aria-labelledby="createGalleryModalLabel" aria-hidden="true">
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
                                        <form action="{{url('gallery/simpan')}}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            {{--  --}}
                                            <div class="form-group">
                                                <label for="url">Image</label>
                                                <input type="file" name="url" id="url" class="form-control"
                                                    required>
                                            </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Gallery</button>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </section>
    </div>
@endsection

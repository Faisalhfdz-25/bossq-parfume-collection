@extends('layouts.app')

@section('title', 'Create Landing Page')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Create Landing Page</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item active">Create Landing Page</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Full Summernote</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('landing_pages.store') }}" method="POST" enctype="multipart/form-data" id="landingPageForm">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Title</label>
                                        <div class="col-sm-12 col-md-7">
                                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}">
                                            @error('title')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Banner</label>
                                        <div class="col-sm-12 col-md-7">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input @error('banner_image') is-invalid @enderror" id="banner_image" name="banner_image">
                                                <label class="custom-file-label" for="banner_image">Choose file</label>
                                                <img id="banner_image_preview" src="#" alt="Banner Preview" class="img-fluid d-none mt-3 mb-3 preview-image" style="max-width: 50px; ">
                                                @error('banner_image')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Instagram Photo</label>
                                        <div class="col-sm-12 col-md-7">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input @error('instagram_photos') is-invalid @enderror" id="instagram_photos" name="instagram_photos[]" multiple>
                                                <label class="custom-file-label" for="instagram_photos">Choose file</label>
                                                <div id="instagram_photos_preview" class="img-fluid d-none mt-3 mb-3 preview-image" style="max-width: 50px; "></div>
                                                @error('instagram_photos')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Video</label>
                                        <div class="col-sm-12 col-md-7">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input @error('video') is-invalid @enderror" id="video" name="video">
                                                <label class="custom-file-label" for="video">Choose file</label>
                                                <span id="video_label" class="d-block mt-2 mb-3" ></span>
                                                @error('video')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Single Photo</label>
                                        <div class="col-sm-12 col-md-7">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input @error('single_photo') is-invalid @enderror" id="single_photo" name="single_photo">
                                                <label class="custom-file-label" for="single_photo">Choose file</label>
                                                <img id="single_photo_preview" src="#" alt="Single Photo Preview" class="img-fluid d-none mt-3 mb-3 preview-image" style="max-width: 50px; ">
                                                @error('single_photo')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Price</label>
                                        <div class="input-group mb-3 col-sm-12 col-md-7">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp.</span>
                                            </div>
                                            <input type="text" class="form-control" name="product_price" aria-label="Amount (to the nearest dollar)">
                                            <div class="input-group-append">
                                                <span class="input-group-text">.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Content</label>
                                        <div class="col-sm-12 col-md-7">
                                            <textarea class="summernote form-control @error('content') is-invalid @enderror" name="content">{{ old('content') }}</textarea>
                                            @error('content')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                        <div class="col-sm-12 col-md-7">
                                            <button type="submit" class="btn btn-primary">Create</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="{{ asset('library/summernote/dist/summernote-bs4.js') }}"></script>
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Initialize Summernote -->
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 300
            });

            // Image upload handler for Banner Image
            $('#banner_image').change(function() {
                readURL(this, '#banner_image_preview');
            });

            // Image upload handler for Instagram Photo
            $('#instagram_photos').change(function() {
                readMultipleURL(this, '#instagram_photos_preview');
            });

            // Image upload handler for Single Photo
            $('#single_photo').change(function() {
                readURL(this, '#single_photo_preview');
            });

            // Video upload handler
            $('#video').change(function() {
                var fileName = $(this).val();
                $('#video_label').text(fileName.split('\\').pop());
            });

            // Function to read and display image preview
            function readURL(input, previewElement) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $(previewElement).attr('src', e.target.result).removeClass('d-none');
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            // Function to read and display multiple image previews
            function readMultipleURL(input, previewElement) {
                if (input.files && input.files.length > 0) {
                    $(previewElement).empty();
                    for (var i = 0; i < input.files.length; i++) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            $('<img>').attr('src', e.target.result).addClass('img-fluid').appendTo(previewElement);
                        }
                        reader.readAsDataURL(input.files[i]);
                    }
                }
            }
        });
    </script>
@endpush

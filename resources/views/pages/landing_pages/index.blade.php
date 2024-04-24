@extends('layouts.app')

@section('title', 'Table')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Title</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Components</a></div>
                    <div class="breadcrumb-item">Title</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Komponen Landing Page</h2>
                <p class="section-lead">Silahkan Untuk mengatur Komponen untuk landing page anda</p>

                <a href="{{ route('landing_pages.create') }}" class="btn btn-primary mb-3"><i class="fa-solid fa-plus"></i></a>

                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <h4>Simple Table</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table-bordered table-md table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Title</th>
                                                <th>Banner</th>
                                                {{-- <th>Instagram Photo</th>
                                                <th>Single Photo</th> --}}
                                                <th>Video</th>
                                                <th>Created At</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($landingPages as $landingPage)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $landingPage->title }}</td>
                                                    <td><img src="{{ asset('storage/landing_page_images/' . $landingPage->banner_image_url) }}" alt="Banner Image" style="max-width: 100px;"></td>
                                                    {{-- <td>
                                                        @if ($landingPage->instagram_photo_url)
                                                            <img src="{{ asset('storage/landing_page_images/' . $landingPage->instagram_photo_url) }}"
                                                                alt="Instagram Photo" style="max-width: 100px;">
                                                        @else
                                                            No Instagram photo available
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($landingPage->single_photo_url)
                                                            <img src="{{ asset('storage/landing_page_images/' . $landingPage->single_photo_url) }}"
                                                                alt="Single Photo" style="max-width: 100px;">
                                                        @else
                                                            No single photo available
                                                        @endif
                                                    </td> --}}
                                                    <td>
                                                        @if ($landingPage->video_url)
                                                            <a href="{{ asset('storage/landing_page_video/' . $landingPage->video_url) }}"
                                                                target="_blank">Watch Video</a>
                                                        @else
                                                            No video available
                                                        @endif
                                                    </td>
                                                    <td>{{ $landingPage->created_at->format('Y-m-d') }}</td>
                                                    <td>
                                                        <div class="badge badge-success">Active</div>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('landing_pages.edit', $landingPage->id) }}"
                                                            class="btn btn-warning"><i class="fa-regular fa-pen-to-square"></i></a>
                                                        <form
                                                            action="{{ route('landing_pages.destroy', $landingPage->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger"
                                                                onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa-regular fa-trash-can"></i></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
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

                {{-- <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Sortable Table</h4>
                                <div class="card-header-action">
                                    <form>
                                        <div class="input-group">
                                            <input type="text"
                                                class="form-control"
                                                placeholder="Search">
                                            <div class="input-group-btn">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table-striped table"
                                        id="sortable-table">
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                    <i class="fas fa-th"></i>
                                                </th>
                                                <th>Task Name</th>
                                                <th>Progress</th>
                                                <th>Members</th>
                                                <th>Due Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="sort-handler">
                                                        <i class="fas fa-th"></i>
                                                    </div>
                                                </td>
                                                <td>Create a mobile app</td>
                                                <td class="align-middle">
                                                    <div class="progress"
                                                        data-height="4"
                                                        data-toggle="tooltip"
                                                        title="100%">
                                                        <div class="progress-bar bg-success"
                                                            data-width="100"></div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <img alt="image"
                                                        src="{{ asset('img/avatar/avatar-5.png') }}"
                                                        class="rounded-circle"
                                                        width="35"
                                                        data-toggle="tooltip"
                                                        title="Wildan Ahdian">
                                                </td>
                                                <td>2018-01-20</td>
                                                <td>
                                                    <div class="badge badge-success">Completed</div>
                                                </td>
                                                <td><a href="#"
                                                        class="btn btn-secondary">Detail</a></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="sort-handler">
                                                        <i class="fas fa-th"></i>
                                                    </div>
                                                </td>
                                                <td>Redesign homepage</td>
                                                <td class="align-middle">
                                                    <div class="progress"
                                                        data-height="4"
                                                        data-toggle="tooltip"
                                                        title="0%">
                                                        <div class="progress-bar"
                                                            data-width="0"></div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <img alt="image"
                                                        src="{{ asset('img/avatar/avatar-1.png') }}"
                                                        class="rounded-circle"
                                                        width="35"
                                                        data-toggle="tooltip"
                                                        title="Nur Alpiana">
                                                    <img alt="image"
                                                        src="{{ asset('img/avatar/avatar-3.png') }}"
                                                        class="rounded-circle"
                                                        width="35"
                                                        data-toggle="tooltip"
                                                        title="Hariono Yusup">
                                                    <img alt="image"
                                                        src="{{ asset('img/avatar/avatar-4.png') }}"
                                                        class="rounded-circle"
                                                        width="35"
                                                        data-toggle="tooltip"
                                                        title="Bagus Dwi Cahya">
                                                </td>
                                                <td>2018-04-10</td>
                                                <td>
                                                    <div class="badge badge-info">Todo</div>
                                                </td>
                                                <td><a href="#"
                                                        class="btn btn-secondary">Detail</a></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="sort-handler">
                                                        <i class="fas fa-th"></i>
                                                    </div>
                                                </td>
                                                <td>Backup database</td>
                                                <td class="align-middle">
                                                    <div class="progress"
                                                        data-height="4"
                                                        data-toggle="tooltip"
                                                        title="70%">
                                                        <div class="progress-bar bg-warning"
                                                            data-width="70"></div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <img alt="image"
                                                        src="{{ asset('img/avatar/avatar-1.png') }}"
                                                        class="rounded-circle"
                                                        width="35"
                                                        data-toggle="tooltip"
                                                        title="Rizal Fakhri">
                                                    <img alt="image"
                                                        src="{{ asset('img/avatar/avatar-2.png') }}"
                                                        class="rounded-circle"
                                                        width="35"
                                                        data-toggle="tooltip"
                                                        title="Hasan Basri">
                                                </td>
                                                <td>2018-01-29</td>
                                                <td>
                                                    <div class="badge badge-warning">In Progress</div>
                                                </td>
                                                <td><a href="#"
                                                        class="btn btn-secondary">Detail</a></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="sort-handler">
                                                        <i class="fas fa-th"></i>
                                                    </div>
                                                </td>
                                                <td>Input data</td>
                                                <td class="align-middle">
                                                    <div class="progress"
                                                        data-height="4"
                                                        data-toggle="tooltip"
                                                        title="100%">
                                                        <div class="progress-bar bg-success"
                                                            data-width="100"></div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <img alt="image"
                                                        src="{{ asset('img/avatar/avatar-2.png') }}"
                                                        class="rounded-circle"
                                                        width="35"
                                                        data-toggle="tooltip"
                                                        title="Rizal Fakhri">
                                                    <img alt="image"
                                                        src="{{ asset('img/avatar/avatar-5.png') }}"
                                                        class="rounded-circle"
                                                        width="35"
                                                        data-toggle="tooltip"
                                                        title="Isnap Kiswandi">
                                                    <img alt="image"
                                                        src="{{ asset('img/avatar/avatar-4.png') }}"
                                                        class="rounded-circle"
                                                        width="35"
                                                        data-toggle="tooltip"
                                                        title="Yudi Nawawi">
                                                    <img alt="image"
                                                        src="{{ asset('img/avatar/avatar-1.png') }}"
                                                        class="rounded-circle"
                                                        width="35"
                                                        data-toggle="tooltip"
                                                        title="Khaerul Anwar">
                                                </td>
                                                <td>2018-01-16</td>
                                                <td>
                                                    <div class="badge badge-success">Completed</div>
                                                </td>
                                                <td><a href="#"
                                                        class="btn btn-secondary">Detail</a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/components-table.js') }}"></script>
@endpush

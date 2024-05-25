@extends('layouts.app')

@section('title', 'Detail')

@push('style')
    <!-- Include DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.6/css/jquery.dataTables.min.css">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail</h1>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-body">

                        <div class="table-responsive">
                            <table id="suppliers-table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama Produk</th>
                                        <th>Qty</th>
                                        <th>Harga</th>
                                        <th>Tempat</th>
                                        <th>Sub Total</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($dataDetail as $item)
                                        <tr>
                                            <td>{{ $item->products->name }}</td>
                                            <td>{{ $item->qty }}</td>
                                            <td>{{ $item->harga }}</td>
                                            <td>{{ $item->tempat }}</td>
                                            <td>{{ $item->sub_total }}</td>
                                            <td>

                                                @if ($item->acc === 1)
                                                    <button class="btn btn-sm btn-success">Di Setujui</button>
                                                @elseif ($item->acc === 0)
                                                    <button class="btn btn-sm btn-danger">Tidak
                                                        Disetujui</button>
                                                @else
                                                    <button class="btn btn-sm btn-warning">Belum
                                                        Disetujui</button>
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm "
                                                    data-toggle="modal" data-target="#editStatus{{ $item->id }}"
                                                    data-detail-id="{{ $item->id }}" data-backdrop="false">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                    Ubah Status
                                                </button>
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

    <!-- Modals for editing products -->
    @foreach ($dataDetail as $item)
        <!-- Modal for editing product -->
        <div class="modal fade" id="editStatus{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="editProductModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editStatusModalLabel{{ $item->id }}">Edit Status</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <form method="POST" action="/konfirmasi-belanja/ubahStatus" novalidate enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label class="form-label">Status</label>
                                        <div class="selectgroup w-100">
                                            <label class="selectgroup-item">
                                                <input type="radio" name="acc" value="1"
                                                    class="selectgroup-input"
                                                    {{ $item->acc == 1 ? 'checked' : '' }}>
                                                <span class="selectgroup-button">Di Setujui</span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="acc" value="0"
                                                    class="selectgroup-input" 
                                                    {{ $item->acc == 0 ? 'checked' : '' }}>
                                                <span class="selectgroup-button">Tidak Disetujui</span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="acc" value=""
                                                    class="selectgroup-input" 
                                                    {{ is_null($item->acc) ? 'checked' : '' }}>
                                                <span class="selectgroup-button">Belum Disetujui</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Update Status</button>
                                    </div>
                                    
                                </form>
                            </div>
                        </div>

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
        $(document).ready(function() {

            function calculateSubtotal() {
                var harga = parseFloat($('#harga').val()) || 0;
                var qty = parseInt($('#qty').val()) || 0;
                var subtotal = harga * qty;
                $('#sub_total').val(subtotal);
            }


            $('#productList').change(function() {
                var selectedOption = $(this).find('option:selected');
                var harga = selectedOption.data('harga');
                var tempat = selectedOption.data('tempat');

                $('#harga').val(harga);
                $('#tempat').val(tempat);


                calculateSubtotal();
            });


            $('#qty').on('input', function() {
                calculateSubtotal();
            });
        });

    </script>



    @if (session('Save'))
        <script>
            Swal.fire('Berhasil!', 'Data Status Berhasil Di ubah', 'success');
        </script>
    @endif
@endpush

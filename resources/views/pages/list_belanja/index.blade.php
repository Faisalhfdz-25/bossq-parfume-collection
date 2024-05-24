@extends('layouts.app')

@section('title', 'List Belanja')

@push('style')
    <!-- Include DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.6/css/jquery.dataTables.min.css">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>List Belanja</h1>
            </div>

            <div class="section-body">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <form method="post" action="{{ url('list-belanja/ajukan') }}" novalidate
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Kode</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="kode"
                                                    value="{{ $kode }}" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Tanggal</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="tanggal"
                                                    value="{{ $tgl }}" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Total</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="total"
                                                    value="{{ $total }}" readonly>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="d-flex justify-content-end">
                                            <button type="submit" class="btn btn-md btn-primary"><i class="fa fa-paper-plane"></i>
                                                Ajukan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <!-- Button trigger modal for creating supplier -->
                                    <button type="button" class="btn btn-primary mb-3" data-toggle="modal"
                                        data-target="#exampleModalSize">
                                        <i class="fa-solid fa-plus" style="color: #ffffff;"></i> Tambah
                                    </button>

                                    <div class="table-responsive">
                                        <table id="suppliers-table" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Nama Produk</th>
                                                    <th>Qty</th>
                                                    <th>Harga</th>
                                                    <th>Tempat</th>
                                                    <th>Sub Total</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($detail as $item)
                                                    <tr>
                                                        <td>{{ $item->products->name }}</td>
                                                        <td>{{ $item->qty }}</td>
                                                        <td>{{ $item->harga }}</td>
                                                        <td>{{ $item->tempat }}</td>
                                                        <td>{{ $item->sub_total }}</td>
                                                        <td>
                                                            @if ($item->acc == 1)
                                                                <button class="btn btn-sm btn-success">Di Setujui</button>
                                                            @else
                                                                <button class="btn btn-sm btn-danger">Tidak
                                                                    Disetujui</button>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a class="btn btn-sm btn-danger" href="javascript:void(0);"
                                                                onclick="hapus('{{ $item->id }}')">Delete</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- Form Kode -->

            </div>
        </section>
    </div>

    <div class="modal fade" id="exampleModalSize" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card mb-3">
                        <form method="post" action="{{ url('list-belanja/simpan') }}" novalidate
                            enctype="multipart/form-data">
                            @csrf
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Kode</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="kode"
                                                value="{{ $kode }}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Produk List</label>
                                        <div class="col">
                                            {{-- <input type="number" class="form-control" name="id_inventory" value="{{ $inventory->id }}"> --}}
                                            <select class="form-control selectpicker" id="productList" name="products_id">
                                                <option value="" selected disabled>Pilih Produk</option>
                                                @foreach ($products as $item)
                                                    <option value="{{ $item->id }}"
                                                        data-harga="{{ $item->harga_modal }}"
                                                        data-tempat="{{ $item->supplier->name }}">{{ $item->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Harga</label>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control" name="harga" id="harga"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">tempat</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="tempat" id="tempat"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">QTY</label>
                                        <div class="col">
                                            <div class="input-group">
                                                <input type="number" class="form-control" id="qty"
                                                    name="qty">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Sub Total</label>
                                        <div class="col">
                                            <div class="input-group">
                                                <input type="number" class="form-control" id="sub_total"
                                                    name="sub_total" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


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


        function hapus(id) {
            Swal.fire({
                title: 'Yakin?',
                text: "Mau menghapus Data ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#FF2C2C',
                confirmButtonText: 'Ya, Hapus aja!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ 'list-belanja/hapus' }}",
                        type: "post",
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: id
                        },
                        dataType: "json",
                        success: function(data) {
                            if (data) {
                                Swal.fire('Berhasil!', 'Data Inventory berhasil dihapus.', 'success');
                                location.reload();
                            } else {
                                Swal.fire('Gagal!',
                                    'Data Inventory gagal dihapus, silahkan refresh halaman ini kemudian coba lagi.',
                                    'error');
                                location.reload();
                            }
                        },
                        error: function(err) {
                            Swal.fire('Error!', 'Lihat errornya di console.', 'error');
                            location.reload();
                        }
                    });
                }
            })
        }
    </script>



    @if (session('Save'))
        <script>
            Swal.fire('Berhasil!', 'Data Berhasil Berhasil Disimpan.', 'success');
        </script>
    @endif
@endpush

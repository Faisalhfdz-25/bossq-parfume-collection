@extends('layouts.app')

@section('title', 'Barang Masuk')

@push('style')
    <!-- Include DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap5.min.css">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Barang Masuk Table</h1>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        <!-- Button trigger modal for creating supplier -->
                        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#exampleModalSize">
                            <i class="fa-solid fa-plus" style="color: #ffffff;"></i> Tambah barang
                        </button>

                        <div class="table-responsive">
                            <table id="barang-masuk-table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th>Tanggal</th>
                                        <th>QTY</th>
                                        <th>Harga Perunit</th>
                                        <th>Total </th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            
                                            <td>{{ $item->product->name }}</td>
                                            <td>{{ $item->tanggal }}</td>
                                            <td>{{ $item->qty}}</td>
                                            <td>{{ $item->harga_per_unit }}</td>
                                            <td>{{ $item->total_harga }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    {{-- <!-- Button trigger modal for editing supplier -->
                                                    <button type="button" class="btn btn-warning btn-sm edit-supplier mr-2"
                                                        data-toggle="modal" data-target="#editSupplierModal{{ $item->id }}"
                                                        data-supplier-id="{{ $item->id }}" data-backdrop="false">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </button> --}}
                                                    <!-- Delete Supplier Form -->
                                                    <form id="delete-form-{{ $item->id }}"
                                                        action="{{ route('suppliers.destroy', $item->id) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm delete-supplier"
                                                            onclick="deleteSupplier(event, {{ $item->id }})">
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
                        <form method="post" action="/barang-masuk/simpan" novalidate
                            enctype="multipart/form-data">
                            @csrf
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Tanggal</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="tanggal"
                                                value="{{ $tanggal }}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Produk List</label>
                                        <div class="col">
                                            
                                            <select class="form-control selectpicker"  name="products_id">
                                                <option value="" selected disabled>Pilih Produk</option>
                                                @foreach ($products as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Supplier List</label>
                                        <div class="col">
                                            
                                            <select class="form-control selectpicker"  name="suppliers_id">
                                                <option value="" selected disabled>Pilih Suplier</option>
                                                @foreach ($supplier as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Harga</label>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control" name="harga_per_unit" id="harga">
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
                                                <input type="number" class="form-control" id="total_harga"
                                                    name="total_harga" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Catatan</label>
                                        <div class="col">
                                            <div class="input-group">
                                                <input type="text" class="form-control" 
                                                    name="catatan" >
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
                    
                </div>
            </form>
            </div>
        </div>
    </div>

   
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#barang-masuk-table').DataTable({
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
            function calculateSubtotal() {
                var harga = parseFloat($('#harga').val()) || 0;
                var qty = parseInt($('#qty').val()) || 0;
                var subtotal = harga * qty;
                $('#total_harga').val(subtotal);
            }


            


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

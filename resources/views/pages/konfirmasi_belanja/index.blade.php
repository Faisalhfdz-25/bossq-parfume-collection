@extends('layouts.app')

@section('title', 'Konfirmasi Belanja')

@push('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap5.min.css">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Konfirmasi Belanja</h1>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="list-belanja-table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Tanggal</th>
                                        <th>Total Items</th>
                                        <th>Total Pembayaran</th>
                                        {{-- <th>Status</th> --}}
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td><a href="#">{{ $item->kode }}</a></td>
                                            <td>{{ $item->tanggal }}</td>
                                            <td>{{ $item->total_items }}</td>
                                            <td>{{ $item->total_payment }}</td>
                                            {{-- <td>
                                                @if ($item->detail_acc === 1)
                                                    <button class="btn btn-sm btn-success">Di Setujui</button>
                                                @elseif ($item->detail_acc === 0)
                                                    <button class="btn btn-sm btn-danger">Tidak Disetujui</button>
                                                @else
                                                    <button class="btn btn-sm btn-warning">Belum Disetujui</button>
                                                @endif
                                            </td> --}}
                                            <td>
                                                <div class="d-flex">
                                                    <button class="btn btn-info btn-md detail-button"
                                                        data-id="{{ $item->kode }}">
                                                        <i class="fa-solid fa-eye"></i>
                                                        Detail
                                                    </button>

                                                    <button class="btn btn-primary btn-md print-button"
                                                        data-id="{{ $item->kode }}">
                                                        <i class="fa-solid fa-print"></i>
                                                        Print
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="detail-table" class="table table-bordered">
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
                                <tbody id="detail-table-body">
                                    <!-- Data detail akan diisi di sini -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Modal Ubah Status -->
                <div class="modal fade" id="editStatusModal" tabindex="-1" role="dialog"
                    aria-labelledby="editStatusModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editStatusModalLabel">Ubah Status</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="form-label">Status</label>
                                    <div class="selectgroup w-100">
                                        <label class="selectgroup-item">
                                            <input type="radio" name="acc" value="1" class="selectgroup-input">
                                            <span class="selectgroup-button">Di Setujui</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="acc" value="0" class="selectgroup-input">
                                            <span class="selectgroup-button">Tidak Disetujui</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="acc" value="null" class="selectgroup-input">
                                            <span class="selectgroup-button">Belum Disetujui</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                <button type="button" class="btn btn-primary" id="saveStatusButton">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#list-belanja-table').DataTable({
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

            $('.detail-button').click(function() {
                var kode = $(this).data('id');
                $.ajax({
                    url: '/konfirmasi-belanja/detail/' + kode,
                    method: 'GET',
                    success: function(data) {
                        var rows = '';
                        data.forEach(function(item) {
                            var status = '';
                            if (item.acc === 1) {
                                status =
                                    '<button class="btn btn-sm btn-success">Di Setujui</button>';
                            } else if (item.acc === 0) {
                                status =
                                    '<button class="btn btn-sm btn-danger">Tidak Disetujui</button>';
                            } else {
                                status =
                                    '<button class="btn btn-sm btn-warning">Belum Disetujui</button>';
                            }

                            rows += '<tr>' +
                                '<td>' + item.products.name + '</td>' +
                                '<td>' + item.qty + '</td>' +
                                '<td>' + item.harga + '</td>' +
                                '<td>' + item.tempat + '</td>' +
                                '<td>' + item.sub_total + '</td>' +
                                '<td>' + status + '</td>' +
                                '<td>' +
                                '<button type="button" class="btn btn-primary btn-sm edit-status-button" data-toggle="modal" data-backdrop="false" data-target="#editStatusModal" data-detail-id="' +
                                item.id + '">' +
                                '<i class="fa-solid fa-pen-to-square"></i> Ubah Status' +
                                '</button>' +
                                '</td>' +
                                '</tr>';
                        });
                        $('#detail-table-body').html(rows);
                    }
                });
            });

            // Penanganan ketika tombol 'Ubah Status' diklik
            $(document).on('click', '.edit-status-button', function() {
                var detailId = $(this).data('detail-id');
                $('#editStatusModal').modal('show');
                $('#editStatusModal').data('detail-id', detailId);
            });

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
                            Swal.fire('Berhasil!', 'Status berhasil diubah.', 'success');
                            location.reload();
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
            $('.print-button').click(function() {
                var kode = $(this).data('id');
                window.open('/konfirmasi-belanja/print-pdf/' + kode, '_blank');
            });
        });
    </script>
    @if (session('Save'))
        <script>
            Swal.fire('Berhasil!', 'Data Berhasil Disimpan.', 'success');
        </script>
    @endif
@endpush

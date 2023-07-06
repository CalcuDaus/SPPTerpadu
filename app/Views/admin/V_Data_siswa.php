<?= $this->extend('/admin/V_Dashboard'); ?>
<?= $this->section('title') ?>Master Siswa | Kelola Data Siswa<?= $this->endSection(); ?>
<?= $this->section('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">Aplikasi Pembayaran SPP Terpadu</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= site_url('dashboard'); ?>">Master Siswa</a></li>
            <li class="breadcrumb-item active" aria-current="page">Kelola Data Siswa</li>
        </ol>
    </div>
</div>
<!-- End Page Header -->

<!-- Row -->
<div class="row sidemenu-height">
    <div class="col-lg-12">
        <div class="card custom-card">
            <div class="card-header">
                <h6 class="main-content-label mb-1">Data Seluruh Siswa</h6>
                <p class="text-muted card-sub-title">Silahkan Kelola Data Siswa Pada Halaman Ini...</p>
            </div>
            <div class="card-body">
                <a href="<?= site_url('siswa/form_siswa'); ?>/ <?= encrypt_url('Tambah'); ?>" style="margin-left: 15px;" class="btn btn-primary btn-sm mb-2"><i class="fa fa-plus"></i> Tambah</a>
                <button type="button" data-bs-target="#modalCetak" data-bs-toggle="modal" class="btn btn-secondary btn-sm mb-2"><i class="fa fa-print"></i> Cetak</button>
                <div class="table-responsive">
                    <table class="table table-bordered" id="example1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NISN</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Jurusan</th>
                                <th>Kelola</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($siswa as $data) {
                            ?>
                                <tr>
                                    <td><?= $no; ?></td>
                                    <td><?= $data['NISN']; ?></td>
                                    <td><?= $data['Nama']; ?></td>
                                    <td><?= $data['Kelas']; ?></td>
                                    <td><?= $data['Jurusan']; ?></td>
                                    <td>
                                        <a href="<?= site_url('siswa/detil_siswa/') . encrypt_url($data['NISN']); ?>" title="Detil" class="btn btn-primary btn-sm"><i class="fa fa-clone"></i></a>
                                        <a href="<?= site_url('siswa/form_siswa/') . encrypt_url('Perbarui') . '/' . encrypt_url($data['NISN']); ?>" title="Edit" class="btn btn-secondary btn-sm"><i class="fa fa-pencil"></i></a>
                                        <a onclick="swal({
                                            title: 'Ingin Menghapus Siswa <?= $data['Nama']; ?> ?',
                                            text: 'Data yang dihapus tidak dapat dikembalikan !',
                                            type: 'warning',
                                            showCancelButton: true,
                                            confirmButtonClass: 'btn-danger',
                                            confirmButtonText: 'Ya, Hapus',
                                            cancelButtonText: 'Tidak, Batalkan Hapus',
                                            closeOnConfirm: false,
                                            closeOnCancel: false
                                            },
                                            function(isConfirm) {
                                            if (isConfirm) {
                                                document.location = '<?= base_url('siswa/hapus_siswa'); ?>/<?php echo encrypt_url($data['NISN']); ?>';
                                                swal('Siswa', 'Siswa Berhasil Dihapus !.', 'success');
                                            } else {
                                                swal('Siswa', 'Siswa Batal Dihapus !', 'error');
                                            }
                                            });" href="#" title="Hapus" class="btn btn-danger btn-sm"><i class="fa fa-times"></i></a>
                                    </td>
                                </tr>
                            <?php
                                $no++;
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <p class="text-muted"><i class="fa fa-desktop"></i> Aplikasi Pembayaran SPP Terpadu</p>
            </div>
        </div>
    </div>
</div>
<!-- End Row -->
<?= form_open(site_url('siswa/cetak_siswa'), 'enctype="multipart/form-data"'); ?>
<div class="modal fade" id="modalCetak" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"><i class="fa fa-users"></i> Cetak Data Siswa</h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning" role="alert">
                    <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                        <span aria-hidden="true">&times;</span></button>
                    <strong>Perhatian !</strong> <br> Silahkan pilih kelas ataupun jurusan untuk mencetak data siswa,
                    kosongkan keduanya apabila ingin mencetak seluruh data siswa.
                </div>
                <?= csrf_field(); ?>
                <div class="form-group">
                    <label class="form-label">Kelas</label>
                    <select name="Kelas" class="form-control select2">
                        <option label="-- Pilih Kelas --"></option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Jurusan</label>
                    <select name="Jurusan" class="form-control select2">
                        <option label="-- Pilih Jurusan --"></option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Format <span class="tx-danger">*</span></label>
                    <select class="form-control" name="Cetak" required>
                        <option value="">-- Pilih Format--</option>
                        <option value="Pdf">PDF ---Portable Document Format</option>
                        <option value="Excel">Excel --Microsoft Excel</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-primary" type="submit"><i class="fa fa-print"></i> Cetak</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button"><i class="fa fa-times"></i> Tutup</button>
            </div>
        </div>
    </div>
</div>
<?= form_close(); ?>
<?= $this->endSection(); ?>
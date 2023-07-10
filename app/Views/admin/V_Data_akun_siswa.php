<?= $this->extend('/admin/V_Dashboard'); ?>
<?= $this->section('title') ?>Master Pengguna | Kelola Akun Siswa<?= $this->endSection(); ?>
<?= $this->section('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">Aplikasi Pembayaran SPP Terpadu</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= site_url('dashboard'); ?>">Master Pengguna</a></li>
            <li class="breadcrumb-item active" aria-current="page">Kelola Akun Siswa</li>
        </ol>
    </div>
</div>
<!-- End Page Header -->

<!-- Row -->
<div class="row sidemenu-height">
    <div class="col-lg-12">
        <div class="card custom-card">
            <div class="card-header">
                <h6 class="main-content-label mb-1">Data Seluruh Akun Siswa</h6>
                <p class="text-muted card-sub-title">Silahkan Kelola Akun Siswa Pada Halaman Ini...</p>
            </div>
            <div class="card-body">
                <a href="<?= site_url('pengguna/form_akun_siswa/') . encrypt_url('Tambah'); ?>" style="margin-left: 15px;" class="btn btn-primary btn-sm mb-2"><i class="fa fa-plus"></i> Tambah</a>
                <div class="table-responsive">

                    <table class="table table-bordered" id="example2">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID Akun</th>
                                <th>NISN</th>
                                <th>Nama Pengguna</th>
                                <th>Aktivasi</th>
                                <th>Kelola</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($akun_siswa as $dt_akun) :
                            ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $dt_akun['IDAkun']; ?></td>
                                    <td><?= $dt_akun['NISN']; ?></td>
                                    <td><?= $dt_akun['NamaPengguna']; ?></td>
                                    <?php
                                    if ($dt_akun['Aktivasi'] == 'Y') {
                                        $color = 'success';
                                        $teks = 'Aktif';
                                    } else {
                                        $color = 'danger';
                                        $teks = 'Blokir';
                                    }
                                    ?>
                                    <td><span class="badge bg-<?= $color; ?>"><i class="fa fa-user"></i>
                                            <?= $teks; ?></span>
                                    </td>
                                    <td>
                                        <?php
                                        if ($dt_akun['Aktivasi'] == 'Y') {
                                        ?>
                                            <a href="<?= site_url('pengguna/blokir_pengguna/') . encrypt_url($dt_akun['IDAkun']) . '/' . encrypt_url('Blokir'); ?>" title="Blokir" class="btn btn-warning btn-sm"><i class="fa fa-lock"></i></a>
                                        <?php
                                        } else {
                                        ?>
                                            <a href="<?= site_url('pengguna/blokir_pengguna/') . encrypt_url($dt_akun['IDAkun']) . '/' . encrypt_url('bukaBlokir'); ?>" title="Aktifkan" class="btn btn-success btn-sm"><i class="fa fa-check"></i></a>
                                        <?php
                                        }
                                        ?>
                                        <a href="<?= site_url('pengguna/form_akun_siswa/') . encrypt_url('Perbarui') . '/' . encrypt_url($dt_akun['IDAkun']); ?>" title="Edit" class="btn btn-secondary btn-sm"><i class="fa fa-pencil"></i></a>
                                        <a onclick="swal({
                                            title: 'Ingin Menghapus Siswa <?= $dt_akun['NamaPengguna']; ?> ?',
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
                                                document.location = '<?= base_url('pengguna/hapus_pengguna'); ?>/<?php echo encrypt_url($dt_akun['IDAkun']); ?>';
                                                swal('Pengguna', 'Pengguna Berhasil Dihapus !.', 'success');
                                            } else {
                                                swal('Pengguna', 'Pengguna Batal Dihapus !', 'error');
                                            }
                                            });" href="#" title="Hapus" class="btn btn-danger btn-sm"><i class="fa fa-times"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
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
<?= $this->endSection(); ?>
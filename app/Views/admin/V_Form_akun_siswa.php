<?= $this->extend('/admin/V_Dashboard'); ?>
<?= $this->section('title') ?>Master Pengguna | <?= $status_form; ?> Data Akun Siswa<?= $this->endSection(); ?>
<?= $this->section('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">Aplikasi Pembayaran SPP Terpadu</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Master Pengguna</li>
            <li class="breadcrumb-item"><a href="<?= site_url('siswa/data_siswa'); ?>">Kelola Data Akun
                    Siswa</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $status_form; ?> Data Akun Siswa</li>
        </ol>
    </div>
</div>
<!-- End Page Header -->

<!-- Row -->
<div class="row sidemenu-height">
    <div class="col-lg-12">
        <div class="card custom-card">
            <div class="card-header">
                <h6 class="main-content-label mb-1"><?= $status_form; ?> Data Akun Siswa</h6>
                <p class="text-muted card-sub-title">Aplikasi Pembayaran SPP Terpadu</p>
            </div>
            <div class="card-body">
                <div class="alert alert-warning" role="alert">
                    <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                        <span aria-hidden="true">&times;</span></button>
                    <strong>Perhatian !</strong> Harap teliti dalam pengisian data Akun siswa. Isilah data
                    sesuai dengan inputan yang tersedia dalam formulir tambah data Akun siswa
                </div>

                <form action="<?= site_url('pengguna/simpan_siswa/') . encrypt_url($status_form); ?>" method="POST"
                    enctype="multipart/form-data" data-parsley-validate="">
                    <?= csrf_field(); ?>
                    <div class="row row-sm">
                        <div class="col-lg-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="form-label">ID Akun Siswa <span class="tx-danger">*</span></label>
                                <label class="text-label">ID Akun Siswa Terbuat Otomatis Oleh Sistem...</label>
                                <input class="form-control" name="IDAkun" placeholder="ID Akun Siswa" required
                                    autocomplete="off" type="text" maxlength="12" value="<?= $akun_siswa['IDAkun']; ?>"
                                    readonly>
                            </div>
                            <div class="form-group">
                                <label class="form-label">NISN <span class="tx-danger">*</span></label>
                                <input class="form-control" name="NISN" placeholder="NISN" required autocomplete="off"
                                    type="text" maxlength="35" value="<?= $akun_siswa['NISN']; ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Nama Pengguna <span class="tx-danger">*</span></label>
                                <input class="form-control" name="NamaPengguna" placeholder="Nama Pengguna" required
                                    autocomplete="off" type="text" maxlength="20"
                                    value="<?= $akun_siswa['NamaPengguna']; ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Kata Sandi <span class="tx-danger">*</span></label>
                                <input class="form-control" name="KataSandi" placeholder="Kata Sandi" required
                                    autocomplete="off" type="password" value="<?= $akun_siswa['KataSandi']; ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Aktivasi <span class="tx-danger">*</span></label>
                                <select class="form-control" name="Aktivasi" required>
                                    <option value="" disabled selected>-- Pilih Akvitasi --</option>
                                    <option value="Y" <?= ($akun_siswa['Aktivasi'] == 'Y') ? 'selected' : '' ; ?>>Aktif
                                    </option>
                                    <option value="N" <?= ($akun_siswa['Aktivasi'] == 'N') ? 'selected' : '' ; ?>>Blokir
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <a href="<?= site_url('pengguna/akun_siswa'); ?>" class="btn btn-sm btn-warning"
                                type="button"><i class="fa fa-reply"></i> Kembali</a>
                            <button class="btn btn-sm btn-secondary" type="reset"><i class="fa fa-recycle"></i>
                                Batal</button>
                            <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-save"></i>
                                Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <p class="text-muted"><i class="fa fa-desktop"></i> Aplikasi Pembayaran SPP Terpadu</p>
            </div>
        </div>
    </div>
</div>
<!-- End Row -->
<?= $this->endSection(); ?>
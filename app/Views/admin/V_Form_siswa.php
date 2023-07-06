<?= $this->extend('/admin/V_Dashboard'); ?>
<?= $this->section('title') ?>Master Siswa | <?= $status_form; ?> Data Siswa<?= $this->endSection(); ?>
<?= $this->section('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">Aplikasi Pembayaran SPP Terpadu</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Master Siswa</li>
            <li class="breadcrumb-item"><a href="<?= site_url('siswa/data_siswa'); ?>">Kelola Data Siswa</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $status_form; ?> Data Siswa</li>
        </ol>
    </div>
</div>
<!-- End Page Header -->

<!-- Row -->
<div class="row sidemenu-height">
    <div class="col-lg-12">
        <div class="card custom-card">
            <div class="card-header">
                <h6 class="main-content-label mb-1"><?= $status_form; ?> Data Siswa</h6>
                <p class="text-muted card-sub-title">Aplikasi Pembayaran SPP Terpadu</p>
            </div>
            <div class="card-body">
                <div class="alert alert-warning" role="alert">
                    <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                        <span aria-hidden="true">&times;</span></button>
                    <strong>Perhatian !</strong> Harap teliti dalam pengisian data siswa/i. Isilah data sesuai dengan
                    inputan yang tersedia dalam formulir tambah data siswa
                </div>
                <form action="<?= site_url('siswa/simpan_siswa/') . encrypt_url($status_form); ?>" method="POST" enctype="multipart/form-data" data-parsley-validate="">
                    <?= csrf_field(); ?>
                    <div class="row row-sm">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">NISN <span class="tx-danger">*</span></label>
                                <input class="form-control" name="NISN" value="<?= $dt_siswa['NISN']; ?>" placeholder="NISN" required autocomplete="off" type="text" maxlength="20">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Nama <span class="tx-danger">*</span></label>
                                <input class="form-control" name="Nama" value="<?= $dt_siswa['Nama']; ?>" placeholder="Nama Lengkap" required autocomplete="off" type="text" maxlength="35">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tempat Lahir <span class="tx-danger">*</span></label>
                                <input class="form-control" name="TempatLahir" value="<?= $dt_siswa['TempatLahir']; ?>" placeholder="Tempat Lahir" required autocomplete="off" type="text" maxlength="100">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tanggal Lahir <span class="tx-danger">*</span></label>
                                <input class="form-control" placeholder="Tanggal Lahir" value="<?= $dt_siswa['TanggalLahir']; ?>" type="text" id="datepicker-date" autocomplete="off" name="TanggalLahir" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Jenis Kelamin <span class="tx-danger">*</span></label>
                                <select name="JenisKelamin" class="form-control" required>
                                    <option value="">-- Pilih Jenis Kelamin-- </option>
                                    <option value="LK" <?= ($dt_siswa['JenisKelamin'] == 'LK') ? 'selected' : ''; ?>>
                                        Laki-Laki</option>
                                    <option value="PR" <?= ($dt_siswa['JenisKelamin'] == 'PR') ? 'selected' : ''; ?>>
                                        Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Agama <span class="tx-danger">*</span></label>
                                <select name="Agama" class="form-control select2" required>
                                    <option label="-- Pilih Agama --"></option>
                                    <option value="Islam" <?= $dt_siswa['Agama'] == 'Islam' ? 'selected' : ''; ?>>Islam
                                    </option>
                                    <option value="Protestan" <?= $dt_siswa['Agama'] == 'Protestan' ? 'selected' : ''; ?>>Protestan</option>
                                    <option value="Khatolik" <?= $dt_siswa['Agama'] == 'Khatolik' ? 'selected' : ''; ?>>
                                        Khatolik</option>
                                    <option value="Budha" <?= $dt_siswa['Agama'] == 'Budha' ? 'selected' : ''; ?>>Budha
                                    </option>
                                    <option value="Hindu" <?= $dt_siswa['Agama'] == 'Hindu' ? 'selected' : ''; ?>>Hindu
                                    </option>
                                    <option value="Konghucu" <?= $dt_siswa['Agama'] == 'Konghucu' ? 'selected' : ''; ?>>
                                        Konghucu</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Alamat <span class="tx-danger">*</span></label>
                                <textarea name="Alamat" style="height: 198px;" class="form-control" required autocomplete="off"><?= $dt_siswa['Alamat']; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Kelas <span class="tx-danger">*</span></label>
                                <select name="Kelas" class="form-control select2" required>
                                    <option label="-- Pilih Kelas --"></option>
                                    <?php
                                    foreach ($kelas as $dt_kelas) {
                                    ?>
                                        <option value="<?= $dt_kelas['IDKelas']; ?>" <?= ($dt_siswa['Kelas'] == $dt_kelas['IDKelas']) ? 'selected' : ''; ?>>
                                            <?= $dt_kelas['Kelas']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Jurusan <span class="tx-danger">*</span></label>
                                <select name="Jurusan" class="form-control select2" required>
                                    <option label="-- Pilih Jurusan --"></option>
                                    <?php
                                    foreach ($jurusan as $dt_jurusan) {
                                    ?>
                                        <option value="<?= $dt_jurusan['IDJurusan']; ?>" <?= ($dt_jurusan['IDJurusan'] == $dt_siswa['Jurusan']) ? 'selected' : ''; ?>>
                                            <?= $dt_jurusan['Jurusan']; ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tahun Ajaran <span class="tx-danger">*</span></label>
                                <select name="TahunAjaran" class="form-control select2" required>
                                    <option label="-- Pilih Tahun --"></option>
                                    <?php foreach ($tahun_ajaran as $dt_tahun_ajaran) : ?>
                                        <option value="<?= $dt_tahun_ajaran['IDTahunAjaran']; ?>" <?= ($dt_siswa['TahunAjaran'] == $dt_tahun_ajaran['IDTahunAjaran']) ? 'selected' : ''; ?>>
                                            <?= $dt_tahun_ajaran['TahunAjaran']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <a href="<?= site_url('siswa/data_siswa'); ?>" class="btn btn-sm btn-warning" type="button"><i class="fa fa-reply"></i> Kembali</a>
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
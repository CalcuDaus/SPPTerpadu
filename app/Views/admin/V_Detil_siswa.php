<?= $this->extend('/admin/V_Dashboard'); ?>
<?= $this->section('title') ?>Master Siswa | Kelola Data Siswa<?= $this->endSection(); ?>
<?= $this->section('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">Aplikasi Pembayaran SPP Terpadu</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Master Siswa</li>
            <li class="breadcrumb-item"><a href="<?= site_url('siswa/data_siswa'); ?>">Kelola Data Siswa</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detil Data Siswa</li>
        </ol>
    </div>
</div>
<!-- End Page Header -->

<!-- Row -->
<div class="row sidemenu-height">
    <div class="col-lg-12">
        <div class="card custom-card">
            <div class="card-header">
                <h6 class="main-content-label mb-1">Agus Suparto</h6>
                <p class="text-muted card-sub-title">NISN. </p>
            </div>
            <div class="card-body">
                <div class="panel panel-primary tabs-style-3">
                    <div class="tab-menu-heading">
                        <div class="tabs-menu ">
                            <!-- Tabs -->
                            <ul class="nav panel-tabs">
                                <li class=""><a href="#biodata" class="active" data-bs-toggle="tab"> <i
                                            class="fa fa-user"></i> Biodata</a></li>
                                <li><a href="#spp" data-bs-toggle="tab"> Tagihan SPP</a></li>
                                <li><a href="#lainnya" data-bs-toggle="tab"> Tagihan Lainnya</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="panel-body tabs-menu-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="biodata">
                                <div class="">
                                    <table class="table table-striped">
                                        <tr>
                                            <td width="200px">NISN</td>
                                            <td><?= $dt_siswa['NISN']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Nama Lengkap</td>
                                            <td><?= $dt_siswa['Nama']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Tempat Tanggal Lahir</td>
                                            <td><?= $dt_siswa['TempatLahir']; ?>,
                                                <?= date_change($dt_siswa['TanggalLahir']); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Agama & Jenis Kelamin</td>
                                            <td><?= $dt_siswa['Agama']; ?>, <?= $dt_siswa['JenisKelamin']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Kelas & Jurusan</td>
                                            <td><?= $dt_siswa['Kelas']; ?> <?= $dt_siswa['Jurusan']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Alamat</td>
                                            <td><?= $dt_siswa['Alamat']; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Tahun Ajaran</td>
                                            <td><?= $dt_siswa['TahunAjaran']; ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="spp">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <td>No</td>
                                                <td>Tagihan Yang Sudah DiBayar</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Januari</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="lainnya">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <td>No</td>
                                                <td>Kode Tagihan</td>
                                                <td>Nama Tagihan</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>00213142453</td>
                                                <td>Januari</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="btn btn-warning btn-sm mt-3" type="button" onclick="window.history.back();"><i
                        class="fa fa-reply"></i> Kembali</button>
            </div>
            <div class="card-footer">
                <p class="text-muted"><i class="fa fa-desktop"></i> Aplikasi Pembayaran SPP Terpadu</p>
            </div>
        </div>
    </div>
</div>
<!-- End Row -->
<?= $this->endSection(); ?>
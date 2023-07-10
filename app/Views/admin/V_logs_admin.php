<?= $this->extend('/admin/V_Dashboard'); ?>
<?= $this->section('title') ?>Master Siswa | Logs Administrator<?= $this->endSection(); ?>
<?= $this->section('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">Aplikasi Pembayaran SPP Terpadu</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Master Logs Administrator</li>
            <li class="breadcrumb-item"><a href="<?= site_url('siswa/data_siswa'); ?>">Kelola Data Logs
                    Administrator</a></li>
        </ol>
    </div>
</div>
<!-- End Page Header -->
<!-- Row -->
<div class="row sidemenu-height">
    <div class="col-lg-12">
        <div class="card custom-card">
            <div class="card-header">
                <h6 class="main-content-label mb-1"> Data Logs Administrator</h6>
                <p class="text-muted card-sub-title">Aplikasi Pembayaran SPP Terpadu</p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="example1" style="font-size: 14px;">
                        <thead>
                            <tr>
                                <th>Administrator</th>
                                <th>Waktu</th>
                                <th>Aktivitas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($logs as $log) :
                            ?>
                            <tr>
                                <td><?= $log['NamaLengkap']; ?></td>
                                <td><?= $log['Waktu']; ?></td>
                                <td><?= $log['Aktivitas']; ?></td>
                            </tr>
                            <?php
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <p class="text-muted"> <i class="fa fa-desktop"></i> Aplikasi Pembayaran SPP Terpadu</p>
            </div>
        </div>
    </div>
</div>

<!-- End Row -->

<?= $this->endSection(); ?>
<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AutentifikasiModel;
use App\Models\LogsModel;
use App\Models\PenggunaModel;
use PHPUnit\Framework\MockObject\Rule\Parameters;
use SebastianBergmann\Type\Parameter;

class Pengguna extends BaseController
{
    // Deklarasi variabel library, helper dan lain lain
    protected $validation;
    protected $session;
    protected $MAuthAdmin;
    protected $MLogs;
    protected $MPengguna;

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->MAuthAdmin = new AutentifikasiModel();
        $this->MLogs = new LogsModel();
        $this->MPengguna = new PenggunaModel();
    }
    public function akun_administrator()
    {
        $data = array(
            'session' => \Config\Services::session(),
            'administrator' => $this->MAuthAdmin->orderBy('created_at', 'DESC')->findAll(),
        );
        return view('admin/V_Data_akun_administrator', $data);
    }

    public function form_akun_administrator($parameter = null, $idadmin = null)
    {
        if (decrypt_url($parameter) == 'Tambah') {
            $status_form = 'Tambah';
            $dt_akun_administrator = array(
                'IDAkunAdmin' => rand(),
                'NamaLengkap' => '',
                'NamaPengguna' => '',
                'KataSandi' => '',
                'Status' => '',
                'Aktivasi' => '',
                'Foto' => '',
            );
        } elseif (decrypt_url($parameter) == 'Perbarui') {
            $status_form = 'Perbarui';
            $cari_akun_admin = $this->MAuthAdmin->find(decrypt_url($idadmin));
            $dt_akun_administrator = array(
                'IDAkunAdmin' => $cari_akun_admin['IDAkunAdmin'],
                'NamaLengkap' => $cari_akun_admin['NamaLengkap'],
                'NamaPengguna' => $cari_akun_admin['NamaPengguna'],
                'KataSandi' => '',
                'Status' => $cari_akun_admin['Status'],
                'Aktivasi' => $cari_akun_admin['Aktivasi'],
                'Foto' => $cari_akun_admin['Foto']
            );
        } else {
            $this->session->setFlashdata('pesan', '<script>window.onload = function() {
                    swal({
                        title: "Data Akun Administrator",
                        text: "Parameter Tidak Valid !",
                        type: "error",
                        confirmButtonColor: "#57a94f"
                    });
                }</script>');
            // Arahkan halaman website jika parameter tidak valid
            return redirect()->to(site_url('siswa/data_kelas'));
        }

        $data = array(
            'session' => \Config\Services::session(),
            'status_form' => $status_form,
            'akun_admin' => $dt_akun_administrator
        );
        return view('/admin/V_Form_akun_administrator', $data);
    }

    // Kelola Akun Siswa
    public function akun_siswa()
    {
        $data = array(
            'akun_siswa' => $this->MPengguna->orderBy('IDAkun', 'ASC')->findAll(),
            'session' => \Config\Services::session()
        );
        return view('admin/V_Data_akun_siswa', $data);
    }
    public function form_akun_siswa($parameter = null, $idsiswa = null)
    {
        if (decrypt_url($parameter) == 'Tambah') {
            $status_form = 'Tambah';
            $dt_akun_siswa = array(
                'IDAkun' => rand(),
                'NISN' => '',
                'NamaPengguna' => '',
                'KataSandi' => '',
                'Aktivasi' => ''
            );
        } elseif (decrypt_url($parameter) == 'Perbarui') {
            $status_form = 'Perbarui';
            $cari_akun_siswa = $this->MPengguna->find(decrypt_url($idsiswa));
            $dt_akun_siswa = array(
                'IDAkun' => $cari_akun_siswa['IDAkun'],
                'NISN' => $cari_akun_siswa['NISN'],
                'NamaPengguna' => $cari_akun_siswa['NamaPengguna'],
                'KataSandi' => $cari_akun_siswa['KataSandi'],
                'Aktivasi' => $cari_akun_siswa['Aktivasi']
            );
        } else {
            $this->session->setFlashdata('pesan', '<script>window.onload = function() {
                swal({
                    title: "Data Akun Siswa",
                    text: "Parameter Tidak Valid !",
                    type: "error",
                    confirmButtonColor: "#57a94f"
                });
            }</script>');
            return redirect()->to(site_url('pengguna/akun_siswa'));
        }
        $data = array(
            'status_form' => $status_form,
            'akun_siswa' => $dt_akun_siswa,
            'session' => \Config\Services::session(),
        );

        return view('/admin/V_Form_akun_siswa', $data);
    }
    public function simpan_siswa($parameter = null)
    {
        // Terapkan aturan dalam validasi
        $this->validation->setRules([
            'IDAkun' => 'required',
            'NISN' => 'required|numeric',
            'NamaPengguna' => 'required',
            'KataSandi' => 'required'
        ]);
        // Buat sebuah variabel untuk menjalankan validasi
        $validasi = $this->validation->withRequest($this->request)->run();
        // Cek apakah validasi sesuai dengan aturan ?
        if ($validasi) {
            //buat variabel array untuk menampung input dari pengguna
            if (decrypt_url($parameter) == 'Tambah') {
                //jika parameter post merupakan tambah
                $parameters = array(
                    'IDAkun' => encode_php_tags(htmlentities($this->request->getVar('IDAkun'))),
                    'NISN' => encode_php_tags(htmlentities($this->request->getVar('NISN'))),
                    'NamaPengguna' => encode_php_tags(htmlentities($this->request->getVar('NamaPengguna'))),
                    'KataSandi' => encode_php_tags(htmlentities($this->request->getVar('KataSandi'))),
                    'Aktivasi' => encode_php_tags(htmlentities($this->request->getVar('Aktivasi')))
                );
                // Jalan Sebuah query untuk menyimpan data Pengguna
                $SQL = $this->MPengguna->insert($parameters);
                $param_aktivitas = 'Menambahkan';
            } elseif (decrypt_url($parameter) == 'Perbarui') {
                // jika parameter post merupakan perbarui
                $parameters = array(
                    'IDAkun' => encode_php_tags(htmlentities($this->request->getVar('IDAkun'))),
                    'NISN' => encode_php_tags(htmlentities($this->request->getVar('NISN'))),
                    'NamaPengguna' => encode_php_tags(htmlentities($this->request->getVar('NamaPengguna'))),
                    'KataSandi' => encode_php_tags(htmlentities($this->request->getVar('KataSandi'))),
                    'Aktivasi' => encode_php_tags(htmlentities($this->request->getVar('Aktivasi')))
                );
                // Jalan Sebuah query untuk memperbarui data Pengguna
                $SQL = $this->MPengguna->save($parameters);
                $param_aktivitas = "Memperbarui";
            } else {
                $this->session->setFlashdata('pesan', '
                <script>window.onload = function() {
                    swal({
                        title: "Data Kelas",
                        text: "Parameter Tidak Valid !",
                        type: "error",
                        confirmButtonColor: "#57a94f"
                    });
                }</script>
                ');
                // Arahkan halaman website jika halaman tidak valid
                redirect()->to(site_url('pengguna/akun_siswa'));
            }
            // Cek Apakah query berjalan ?
            if ($SQL == 0 || true) {
                // buat sebuah variabel untuk menampung logs aktivitas pada pengguna
                $aktivitas = '[Info] : ' . $this->session->get('NamaLengkap') . 'Telah ' . $param_aktivitas . ' Pengguna baru pada tanggal ' . date('d-F-Y H:i:s') . ' parameters = ' . json_encode($parameters);
                $logs = array(
                    'IDAkunAdmin' => $this->session->get('IDAkunAdmin'),
                    'Waktu' => date('Y-m-d H:i:s'),
                    'Aktivitas' => $aktivitas
                );
                // Simpan Logs Aktivitas kedalam database
                $this->MLogs->insert($logs);
                $this->session->setFlashdata('pesan', '<script>window.onload = function() {
                    swal({
                        title: "Data Akun Siswa",
                        text: "Akun Berhasil Di Simpan!",
                        type: "success",
                        confirmButtonColor: "#57a94f"
                    });
                }</script>');
                // arahkan halaman website ke data pengguna
                return redirect()->to(site_url('pengguna/akun_siswa'));
            } else {
                $this->session->setFlashdata('pesan', '
                <script>window.onload = function() {
                    swal({
                        title: "Data Pengguna",
                        text: "Data Pengguna Gagal Disimpan !",
                        type: "error",
                        confirmButtonColor: "#57a94f"
                    });
                }</script>
                ');
                return redirect()->to(site_url('pengguna/akun_siswa'));
            }
        } else {
            $this->session->setFlashdata('pesan', '<script>window.onload = function() {
                swal({
                    title: "Data Kelas",
                    text: "Data Tidak Valid !",
                    type: "error",
                    confirmButtonColor: "#57a94f"
                });
            }</script>');
            // Arahkan halaman website jika tidak valid
            return redirect()->to(site_url('pengguna/akun_siswa'));
        }
    }
    public function blokir_pengguna($IDPengguna, $parameter)
    {
        // cek paramter
        if (decrypt_url($parameter) == 'Blokir') {
            // blokir akun pengguna
            $parameters = array(
                'IDAkun' => decrypt_url($IDPengguna),
                'Aktivasi' => 'N'
            );
            $SQL = $this->MPengguna->save($parameters);
            if ($SQL) {
                // simpan log 
                $aktivitas = '[Info] : ' . $this->session->get('NamaLengkap') . ' Telah Memblokir Akun Pada Tanggal ' . date('d-F-Y H:i:s') . ' Parameters = ' . json_encode($parameters);
                $logs = array(
                    'IDAkunAdmin' => $this->session->get('NamaLengkap'),
                    'Waktu' => date('Y-m-d H:i:s'),
                    'Aktivitas' => $aktivitas
                );
                $this->MLogs->insert($logs);
                $this->session->setFlashdata('pesan', '<script>window.onload = function() {
                swal({
                    title: "Data Akun Siswa",
                    text: "Akun Berhasil Di Blokir!",
                    type: "success",
                    confirmButtonColor: "#57a94f"
                });
            }</script>');
                return redirect()->to(site_url('pengguna/akun_siswa'));
            } else {
                $this->session->setFlashdata('pesan', '<script>window.onload = function() {
                swal({
                    title: "Data Akun Siswa",
                    text: "Akun Gagal Di Blokir!",
                    type: "error",
                    confirmButtonColor: "#57a94f"
                });
            }</script>');
                return redirect()->to(site_url('pengguna/akun_siswa'));
            }
        } elseif (decrypt_url($parameter) == 'bukaBlokir') {
            // buka blokir akun pengguna
            $parameters = array(
                'IDAkun' => decrypt_url($IDPengguna),
                'Aktivasi' => 'Y'
            );
            $SQL = $this->MPengguna->save($parameters);
            if ($SQL) {
                // simpan log 
                $aktivitas = '[Info] : ' . $this->session->get('NamaLengkap') . ' Telah Memblokir Akun ' . ' Telah Memblokir Akun Pada Tanggal ' . date('d-F-Y H:i:s') . ' Parameters = ' . json_encode($parameters);
                $logs = array(
                    'IDAkunAdmin' => $this->session->get('NamaLengkap'),
                    'Waktu' => date('Y-m-d H:i:s'),
                    'Aktivitas' => $aktivitas
                );
                $this->MLogs->insert($logs);
                $this->session->setFlashdata('pesan', '<script>window.onload = function() {
                swal({
                    title: "Data Akun Siswa",
                    text: "Akun Berhasil Di Aktifkan!",
                    type: "success",
                    confirmButtonColor: "#57a94f"
                });
            }</script>');
                return redirect()->to(site_url('pengguna/akun_siswa'));
            } else {
                $this->session->setFlashdata('pesan', '<script>window.onload = function() {
                swal({
                    title: "Data Akun Siswa",
                    text: "Akun Gagal Di Aktifkan!",
                    type: "error",
                    confirmButtonColor: "#57a94f"
                });
            }</script>');
                return redirect()->to(site_url('pengguna/akun_siswa'));
            }
        } else {
            $this->session->setFlashdata('pesan', '<script>window.onload = function() {
                swal({
                    title: "Data Akun Siswa",
                    text: "Parameter Tidak Valid",
                    type: "error",
                    confirmButtonColor: "#57a94f"
                });
            }</script>');
            return redirect()->to(site_url('pengguna/akun_siswa'));
        }
    }

    public function hapus_pengguna($parameter)
    {
        $this->MPengguna->delete(decrypt_url($parameter));
        // simpan logs aktivitas 
        $aktivitas = '[Info] : ' . $this->session->get('NamaLengkap') . ' Telah Menghapus Pengguna Pada Tanggal : ' . date('d-F-Y H:i:s');
        $logs = array(
            'IDAkunAdmin' => $this->session->get('IDAkunAdmin'),
            'Waktu' => date('Y-m-d H:i:s'),
            'Aktivitas' => $aktivitas
        );
        $this->MLogs->insert($logs);
        return redirect()->to(site_url('pengguna/akun_siswa'));
    }
}

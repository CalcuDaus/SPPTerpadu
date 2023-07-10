<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\JurusanModel;
use App\Models\KelasModel;
use App\Models\SiswaModel;
use App\Models\LogsModel;
use App\Models\TahunAjaranModel;

class Siswa extends BaseController
{

    // Deklarasi variabel library, helper dan lain lain
    protected $validation;
    protected $session;
    // Deklarasi variabel untuk model
    protected $MSiswa;
    protected $MKelas;
    protected $MJurusan;
    protected $MTahunAjaran;
    protected $MLogs;

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->MSiswa = new SiswaModel();
        $this->MKelas = new KelasModel();
        $this->MJurusan = new JurusanModel();
        $this->MTahunAjaran = new TahunAjaranModel();
        $this->MLogs = new LogsModel();
    }

    // Kelola data siswa

    public function data_siswa()
    {
        $data = array(
            'session' => \Config\Services::session(),
            'siswa' => $this->MSiswa->join('t_kelas', 't_kelas.IDKelas = t_siswa.IDKelas', 'left')->join('t_jurusan', 't_jurusan.IDJurusan = t_siswa.IDJurusan', 'left')->orderBy('NISN', 'ASC')->findAll()
        );
        return view('/admin/V_Data_siswa', $data);
    }

    public function form_siswa($parameter = null, $nisn = null)
    {
        if (decrypt_url($parameter) == 'Tambah') {
            $status_form = 'Tambah';
            $dt_siswa = array(
                'NISN' => '',
                'Nama' => '',
                'TempatLahir' => '',
                'TanggalLahir' => '',
                'JenisKelamin' => '',
                'Agama' => '',
                'Alamat' => '',
                'Kelas' => '',
                'Jurusan' => '',
                'TahunAjaran' => ''
            );
        } elseif (decrypt_url($parameter) == 'Perbarui') {
            $status_form = 'Perbarui';
            $cari_siswa = $this->MSiswa->find(decrypt_url($nisn));
            $dt_siswa = array(
                'NISN' => $cari_siswa['NISN'],
                'Nama' => $cari_siswa['Nama'],
                'TempatLahir' => $cari_siswa['TempatLahir'],
                'TanggalLahir' => $cari_siswa['TanggalLahir'],
                'JenisKelamin' => $cari_siswa['JenisKelamin'],
                'Agama' => $cari_siswa['Agama'],
                'Alamat' => $cari_siswa['Alamat'],
                'Kelas' => $cari_siswa['IDKelas'],
                'Jurusan' => $cari_siswa['IDJurusan'],
                'TahunAjaran' => $cari_siswa['IDTahunAjaran']
            );
        } else {
            return redirect()->to(site_url('siswa/data_siswa'));
        }
        $data = array(
            'session' => \Config\Services::session(),
            'status_form' => $status_form,
            'kelas' => $this->MKelas->orderBy('Kelas', 'ASC')->findAll(),
            'jurusan' => $this->MJurusan->orderBy('Jurusan', 'ASC')->findAll(),
            'tahun_ajaran' => $this->MTahunAjaran->orderBy('TahunAjaran', 'ASC')->findAll(),
            'dt_siswa' => $dt_siswa
        );
        return view('/admin/V_Form_siswa', $data);
    }
    public function simpan_siswa($parameter = null)
    {
        // Terapkan aturan dalam validasi
        $this->validation->setRules([
            'NISN' => 'required|integer',
            'Nama' => 'required',
            'TempatLahir' => 'required',
            'TanggalLahir' => 'required',
            'JenisKelamin' => 'required',
            'Agama' => 'required',
            'Alamat' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',
            'TahunAjaran' => 'required'
        ]);
        // buat variabel untuk menjalankan validasi
        $validasi = $this->validation->withRequest($this->request)->run();
        // cek apakah data tervalidasi sesuai dengan aturan ?
        if ($validasi) {
            // buat sebuah variabel untuk menampung inputan pengguna 
            if (decrypt_url($parameter) == 'Tambah') {
                // jika parameter post merupakan tambah 


                $parameters = array(
                    'NISN' => encode_php_tags(htmlentities($this->request->getVar('NISN'))),
                    'Nama' => encode_php_tags(htmlentities($this->request->getVar('Nama'))),
                    'TempatLahir' => encode_php_tags(htmlentities($this->request->getVar('TempatLahir'))),
                    'TanggalLahir' => date_change(encode_php_tags(htmlentities($this->request->getVar('TanggalLahir')))),
                    'JenisKelamin' => encode_php_tags(htmlentities($this->request->getVar('JenisKelamin'))),
                    'Agama' => encode_php_tags(htmlentities($this->request->getVar('Agama'))),
                    'Alamat' => encode_php_tags(htmlentities($this->request->getVar('Alamat'))),
                    'IDKelas' => encode_php_tags(htmlentities($this->request->getVar('Kelas'))),
                    'IDJurusan' => encode_php_tags(htmlentities($this->request->getVar('Jurusan'))),
                    'IDTahunAjaran' => encode_php_tags(htmlentities($this->request->getVar('TahunAjaran'))),
                    'IDAkunAdmin' => encode_php_tags(htmlentities($this->session->get('IDAkunAdmin')))
                );
                // jalan sebuah query untuk menyimpan data siswa
                $SQL = $this->MSiswa->insert($parameters);
                $param_aktivitas = "Menambahkan";
            } elseif (decrypt_url($parameter) == 'Perbarui') {
                // jika parameter post merupakan perbarui
                $parameters = array(
                    'NISN' => encode_php_tags(htmlentities($this->request->getVar('NISN'))),
                    'Nama' => encode_php_tags(htmlentities($this->request->getVar('Nama'))),
                    'TempatLahir' => encode_php_tags(htmlentities($this->request->getVar('TempatLahir'))),
                    'TanggalLahir' => encode_php_tags(htmlentities($this->request->getVar('TanggalLahir'))),
                    'JenisKelamin' => encode_php_tags(htmlentities($this->request->getVar('JenisKelamin'))),
                    'Agama' => encode_php_tags(htmlentities($this->request->getVar('Agama'))),
                    'Alamat' => encode_php_tags(htmlentities($this->request->getVar('Alamat'))),
                    'IDKelas' => encode_php_tags(htmlentities($this->request->getVar('Kelas'))),
                    'IDJurusan' => encode_php_tags(htmlentities($this->request->getVar('Jurusan'))),
                    'IDTahunAjaran' => encode_php_tags(htmlentities($this->request->getVar('TahunAjaran'))),
                    'IDAkunAdmin' => encode_php_tags(htmlentities($this->session->get('IDAkunAdmin')))
                );
                // jalan sebuah query untuk memperbarui data siswa
                $SQL = $this->MSiswa->save($parameters);
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
                return redirect()->to(site_url('siswa/data_siswa'));
            }
            // cek apakah query berjalan ?
            if ($SQL) {
                //buat sebuah variabel untuk menampung logs aktivitas dari pengguna
                $aktivitas = '[info] : ' . $this->session->get('NamaLengkap') . ' Telah ' . $param_aktivitas . ' Siswa Baru Pada Tanggal : ' . date('d-F-Y H:i:s') . ' parameters = ' . json_encode($parameters);
                $logs = array(
                    'IDAkunAdmin' => $this->session->get('IDAkunAdmin'),
                    'Waktu' => date('Y-m-d H:i:s'),
                    'Aktivitas' => $aktivitas
                );
                // simpan logs akitvitas ke dalam database
                $this->MLogs->insert($logs);
                // tampilkan pesan berhasil 
                $this->session->setFlashdata('pesan', '<script>window.onload = function() {
                    swal({
                        title: "Data Siswa",
                        text: "Data Siswa Berhasil Disimpan !",
                        type: "success",
                        confirmButtonColor: "#57a94f"
                    });
                }</script>');
                // arahkan website ke halaman data siswa 
                return redirect()->to(site_url('siswa/data_siswa'));
            }
        } else {
            $this->session->setFlashdata('pesan', '<script>window.onload = function() {
                swal({
                    title: "Data Siswa",
                    text: "Data Tidak Valid !",
                    type: "error",
                    confirmButtonColor: "#57a94f"
                });
            }</script>');
            // Arahkan halaman website jika tidak valid
            return redirect()->to(site_url('siswa/data_siswa'));
        }
    }
    public  function hapus_siswa($NISNSiswa = null)
    {
        $parameter = array('NISN' => decrypt_url($NISNSiswa));
        $SQL = $this->MSiswa->delete($parameter);
        // cek apakah SQL berjalan ?
        if ($SQL) {
            // buat sebuah variabel untuk menghapus data aktivitas pada pengguna 
            $aktivitas = '[Info] : ' . $this->session->get('NamaLengkap') . 'Telah Menghapus siswa pada tanggal ' . date('d-F-Y H:i:s') . ' Parameter =' . json_encode($parameter);
            $logs = array(
                'IDAkunAdmin' => $this->session->get('IDAkunAdmin'),
                'Waktu' => date('Y-m-d H:i:s'),
                'Aktivitas' => $aktivitas
            );
            // simpan aktivitas pengguna ke dalam database
            $this->MLogs->insert($logs);

            return redirect()->to(site_url('siswa/data_siswa'));
        } else {
            $this->session->setFlashdata('pesan', '
            <script>window.onload = function() {
                swal({
                    title: "Data Siswa",
                    text: "Data Siswa Gagal Dihapus !",
                    type: "success",
                    confirmButtonColor: "#57a94f"
                });
            }</script>
            ');
            return redirect()->to(site_url('siswa/data_siswa'));
        }
    }

    public function detil_siswa($parameter = null)
    {
        $data = array(
            'session' => \Config\Services::session(),
            'dt_siswa' => $this->MSiswa->join('t_kelas', 't_kelas.IDKelas = t_siswa.IDKelas', 'left')->join('t_jurusan', 't_jurusan.IDJurusan = t_siswa.IDJurusan', 'left')->join('t_tahun_ajaran', 't_tahun_ajaran.IDTahunAjaran = t_siswa.IDTahunAjaran', 'left')->find(decrypt_url($parameter))
        );
        return view('/admin/V_Detil_siswa', $data);
    }
    // Kelola data kelas

    public function data_kelas()
    {
        $data = array(
            'session' => \Config\Services::session(),
            'kelas' => $this->MKelas->select('t_kelas.*, t_akun_admin.NamaLengkap')->join('t_akun_admin', 't_akun_admin.IDAkunAdmin = t_kelas.IDAkunAdmin', 'left')->orderBy('Kelas', 'ASC')->findAll(),
        );
        return view('/admin/V_Data_kelas', $data);
    }

    public function form_kelas($parameter = null, $idkelas = null)
    {
        if (decrypt_url($parameter) == 'Tambah') {
            $status_form = 'Tambah';
            $dt_kelas = array('IDKelas' => 'K' . rand(), 'NamaKelas' => '');
        } elseif (decrypt_url($parameter) == 'Perbarui') {
            $status_form = 'Perbarui';
            $cari_kelas = $this->MKelas->find(decrypt_url($idkelas));
            $dt_kelas = array('IDKelas' => $cari_kelas['IDKelas'], 'NamaKelas' => $cari_kelas['Kelas']);
        } else {
            $this->session->setFlashdata('pesan', '<script>window.onload = function() {
                    swal({
                        title: "Data Kelas",
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
            'kelas' => $dt_kelas
        );
        return view('/admin/V_Form_kelas', $data);
    }

    public function simpan_kelas($parameter = null)
    {
        // Terapkan aturan dalam validasi
        $this->validation->setRules([
            'IDKelas' => 'required',
            'Kelas' => 'required'
        ]);

        // Buat sebuah variabel untuk menjalankan validasi
        $validasi = $this->validation->withRequest($this->request)->run();

        // cek apakah data tervalidasi sesuai dengan aturan ?
        if ($validasi) {
            // Buat sebuah variabel array yang menampung input data dari pengguna
            if (decrypt_url($parameter) == 'Tambah') {
                // Jika parameter post merupakan 'Tambah'
                $parameters = array(
                    'IDKelas' => encode_php_tags(htmlentities($this->request->getVar('IDKelas'))),
                    'Kelas' => encode_php_tags(htmlentities($this->request->getVar('Kelas'))),
                    'IDAkunAdmin' => $this->session->get('IDAkunAdmin')
                );
                // Jalan sebuah query untuk menyimpan data kelas
                $SQL = $this->MKelas->insert($parameters);
                $param_aktivitas = 'menambahkan';
            } elseif (decrypt_url($parameter) == 'Perbarui') {
                // Jika parameter post merupakan 'Perbarui'
                $parameters = array(
                    'IDKelas' => encode_php_tags(htmlentities($this->request->getVar('IDKelas'))),
                    'Kelas' => encode_php_tags(htmlentities($this->request->getVar('Kelas'))),
                    'IDAkunAdmin' => $this->session->get('IDAkunAdmin')
                );
                // Jalan sebuah query untuk menyimpan data kelas
                $SQL = $this->MKelas->save($parameters);
                $param_aktivitas = 'memperbarui';
            } else {
                $this->session->setFlashdata('pesan', '<script>window.onload = function() {
                    swal({
                        title: "Data Kelas",
                        text: "Parameter Tidak Valid !",
                        type: "error",
                        confirmButtonColor: "#57a94f"
                    });
                }</script>');
                // Arahkan halaman website jika parameter tidak valid
                return redirect()->to(site_url('siswa/data_kelas'));
            }

            // Cek apakah query berjalan ?
            if ($SQL) {
                // Buat sebuah variabel untuk menampung logs aktivitas pada pengguna
                $aktivitas = '[Info] : ' . $this->session->get('NamaLengkap') . ' Telah ' . $param_aktivitas . ' kelas baru pada tanggal ' . date('d-F-Y H:i:s') . ' parameters = ' . json_encode($parameters);
                $logs = array(
                    'IDAkunAdmin' => $this->session->get('IDAkunAdmin'),
                    'Waktu' => date('Y-m-d H:i:s'),
                    'Aktivitas' => $aktivitas,
                );
                // Simpan logs aktivitas kedalam database
                $this->MLogs->insert($logs);
                $this->session->setFlashdata('pesan', '<script>window.onload = function() {
                    swal({
                        title: "Data Kelas",
                        text: "Data Kelas Berhasil Disimpan !",
                        type: "success",
                        confirmButtonColor: "#57a94f"
                    });
                }</script>');
                // Arahkan halaman website ke data kelas
                return redirect()->to(site_url('siswa/data_kelas'));
            } else {
                $this->session->setFlashdata('pesan', '<script>window.onload = function() {
                    swal({
                        title: "Data Kelas",
                        text: "Data Kelas Gagal Disimpan !",
                        type: "error",
                        confirmButtonColor: "#57a94f"
                    });
                }</script>');
                // Arahkan halaman website jika tidak berhasil
                return redirect()->to(site_url('siswa/data_kelas'));
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
            return redirect()->to(site_url('siswa/data_kelas'));
        }
    }

    public function hapus_kelas($idkelas = null)
    {
        $parameters = array('IDKelas' => decrypt_url($idkelas));
        $SQL = $this->MKelas->delete($parameters);
        // Cek apakah query berjalan ?
        if ($SQL) {
            // Buat sebuah variabel untuk menampung logs aktivitas pada pengguna
            $aktivitas = '[Info] : ' . $this->session->get('NamaLengkap') . ' Menghapus sebuah kelas pada tanggal ' . date('d-F-Y H:i:s') . ' parameters = ' . json_encode($parameters);
            $logs = array(
                'IDAkunAdmin' => $this->session->get('IDAkunAdmin'),
                'Waktu' => date('Y-m-d H:i:s'),
                'Aktivitas' => $aktivitas,
            );
            // Simpan logs aktivitas kedalam database
            $this->MLogs->insert($logs);
            return redirect()->to(site_url('siswa/data_kelas'));
        } else {
            $this->session->setFlashdata('pesan', '<script>window.onload = function() {
                    swal({
                        title: "Data Kelas",
                        text: "Data Kelas Gagal Dihapus !",
                        type: "error",
                        confirmButtonColor: "#57a94f"
                    });
                }</script>');
            // Arahkan halaman website jika tidak berhasil
            return redirect()->to(site_url('siswa/data_kelas'));
        }
    }

    // Kelola data jurusan

    public function data_jurusan()
    {
        $data = array(
            'session' => \Config\Services::session(),
            'kelas' => $this->MJurusan->select('t_jurusan.*, t_akun_admin.NamaLengkap')->join('t_akun_admin', 't_akun_admin.IDAkunAdmin = t_jurusan.IDAkunAdmin', 'left')->orderBy('Jurusan', 'ASC')->findAll(),
        );
        return view('/admin/V_Data_jurusan', $data);
    }

    public function form_jurusan($parameter = null, $idjurusan = null)
    {
        if (decrypt_url($parameter) == 'Tambah') {
            $status_form = 'Tambah';
            $dt_jurusan = array('IDJurusan' => 'J' . rand(), 'NamaJurusan' => '');
        } elseif (decrypt_url($parameter) == 'Perbarui') {
            $status_form = 'Perbarui';
            $cari_jurusan = $this->MJurusan->find(decrypt_url($idjurusan));
            $dt_jurusan = array('IDJurusan' => $cari_jurusan['IDJurusan'], 'NamaJurusan' => $cari_jurusan['Jurusan']);
        } else {
            $this->session->setFlashdata('pesan', '<script>window.onload = function() {
                    swal({
                        title: "Data Jurusan",
                        text: "Parameter Tidak Valid !",
                        type: "error",
                        confirmButtonColor: "#57a94f"
                    });
                }</script>');
            // Arahkan halaman website jika parameter tidak valid
            return redirect()->to(site_url('siswa/data_jurusan'));
        }

        $data = array(
            'session' => \Config\Services::session(),
            'status_form' => $status_form,
            'jurusan' => $dt_jurusan
        );
        return view('/admin/V_Form_jurusan', $data);
    }

    public function simpan_jurusan($parameter = null)
    {
        // Terapkan aturan dalam validasi
        $this->validation->setRules([
            'IDJurusan' => 'required',
            'Jurusan' => 'required'
        ]);

        // Buat sebuah variabel untuk menjalankan validasi
        $validasi = $this->validation->withRequest($this->request)->run();

        // cek apakah data tervalidasi sesuai dengan aturan ?
        if ($validasi) {
            // Buat sebuah variabel array yang menampung input data dari pengguna
            if (decrypt_url($parameter) == 'Tambah') {
                // Jika parameter post merupakan 'Tambah'
                $parameters = array(
                    'IDJurusan' => encode_php_tags(htmlentities($this->request->getVar('IDJurusan'))),
                    'Jurusan' => ucwords(encode_php_tags(htmlentities($this->request->getVar('Jurusan')))),
                    'IDAkunAdmin' => $this->session->get('IDAkunAdmin')
                );
                // Jalan sebuah query untuk menyimpan data jurusan
                $SQL = $this->MJurusan->insert($parameters);
                $param_aktivitas = 'menambahkan';
            } elseif (decrypt_url($parameter) == 'Perbarui') {
                // Jika parameter post merupakan 'Perbarui'
                $parameters = array(
                    'IDJurusan' => encode_php_tags(htmlentities($this->request->getVar('IDJurusan'))),
                    'Jurusan' => ucwords(encode_php_tags(htmlentities($this->request->getVar('Jurusan')))),
                    'IDAkunAdmin' => $this->session->get('IDAkunAdmin')
                );
                // Jalan sebuah query untuk menyimpan data jurusan
                $SQL = $this->MJurusan->save($parameters);
                $param_aktivitas = 'memperbarui';
            } else {
                $this->session->setFlashdata('pesan', '<script>window.onload = function() {
                    swal({
                        title: "Data Jurusan",
                        text: "Parameter Tidak Valid !",
                        type: "error",
                        confirmButtonColor: "#57a94f"
                    });
                }</script>');
                // Arahkan halaman website jika parameter tidak valid
                return redirect()->to(site_url('siswa/data_jurusan'));
            }

            // Cek apakah query berjalan ?
            if ($SQL) {
                // Buat sebuah variabel untuk menampung logs aktivitas pada pengguna
                $aktivitas = '[Info] : ' . $this->session->get('NamaLengkap') . ' Telah ' . $param_aktivitas . ' jurusan baru pada tanggal ' . date('d-F-Y H:i:s') . ' parameters = ' . json_encode($parameters);
                $logs = array(
                    'IDAkunAdmin' => $this->session->get('IDAkunAdmin'),
                    'Waktu' => date('Y-m-d H:i:s'),
                    'Aktivitas' => $aktivitas,
                );
                // Simpan logs aktivitas kedalam database
                $this->MLogs->insert($logs);
                $this->session->setFlashdata('pesan', '<script>window.onload = function() {
                    swal({
                        title: "Data Jurusan",
                        text: "Data Jurusan Berhasil Disimpan !",
                        type: "success",
                        confirmButtonColor: "#57a94f"
                    });
                }</script>');
                // Arahkan halaman website ke data jurusan
                return redirect()->to(site_url('siswa/data_jurusan'));
            } else {
                $this->session->setFlashdata('pesan', '<script>window.onload = function() {
                    swal({
                        title: "Data Jurusan",
                        text: "Data Jurusan Gagal Disimpan !",
                        type: "error",
                        confirmButtonColor: "#57a94f"
                    });
                }</script>');
                // Arahkan halaman website jika tidak berhasil
                return redirect()->to(site_url('siswa/data_jurusan'));
            }
        } else {
            $this->session->setFlashdata('pesan', '<script>window.onload = function() {
                    swal({
                        title: "Data Jurusan",
                        text: "Data Tidak Valid !",
                        type: "error",
                        confirmButtonColor: "#57a94f"
                    });
                }</script>');
            // Arahkan halaman website jika tidak valid
            return redirect()->to(site_url('siswa/data_jurusan'));
        }
    }

    public function hapus_jurusan($idjurusan = null)
    {
        $parameters = array('IDJurusan' => decrypt_url($idjurusan));
        $SQL = $this->MJurusan->delete($parameters);
        // Cek apakah query berjalan ?
        if ($SQL) {
            // Buat sebuah variabel untuk menampung logs aktivitas pada pengguna
            $aktivitas = '[Info] : ' . $this->session->get('NamaLengkap') . ' Menghapus sebuah jurusan pada tanggal ' . date('d-F-Y H:i:s') . ' parameters = ' . json_encode($parameters);
            $logs = array(
                'IDAkunAdmin' => $this->session->get('IDAkunAdmin'),
                'Waktu' => date('Y-m-d H:i:s'),
                'Aktivitas' => $aktivitas,
            );
            // Simpan logs aktivitas kedalam database
            $this->MLogs->insert($logs);
            return redirect()->to(site_url('siswa/data_jurusan'));
        } else {
            $this->session->setFlashdata('pesan', '<script>window.onload = function() {
                    swal({
                        title: "Data Jurusan",
                        text: "Data Jurusan Gagal Dihapus !",
                        type: "error",
                        confirmButtonColor: "#57a94f"
                    });
                }</script>');
            // Arahkan halaman website jika tidak berhasil
            return redirect()->to(site_url('siswa/data_jurusan'));
        }
    }

    // Kelola data tahun ajaran

    public function data_tahun_ajaran()
    {
        $data = array(
            'session' => \Config\Services::session(),
            'kelas' => $this->MTahunAjaran->select('t_tahun_ajaran.*, t_akun_admin.NamaLengkap')->join('t_akun_admin', 't_akun_admin.IDAkunAdmin = t_tahun_ajaran.IDAkunAdmin', 'left')->orderBy('TahunAjaran', 'ASC')->findAll(),
        );
        return view('/admin/V_Data_tahun_ajaran', $data);
    }

    public function form_tahun_ajaran($parameter = null, $idtahunajaran = null)
    {
        if (decrypt_url($parameter) == 'Tambah') {
            $status_form = 'Tambah';
            $dt_tahun_ajaran = array('IDTahunAjaran' => 'TA' . rand(), 'TahunAjaran' => '');
        } elseif (decrypt_url($parameter) == 'Perbarui') {
            $status_form = 'Perbarui';
            $cari_tahun_ajaran = $this->MTahunAjaran->find(decrypt_url($idtahunajaran));
            $dt_tahun_ajaran = array('IDTahunAjaran' => $cari_tahun_ajaran['IDTahunAjaran'], 'TahunAjaran' => $cari_tahun_ajaran['TahunAjaran']);
        } else {
            $this->session->setFlashdata('pesan', '<script>window.onload = function() {
                    swal({
                        title: "Data Tahun Ajaran",
                        text: "Parameter Tidak Valid !",
                        type: "error",
                        confirmButtonColor: "#57a94f"
                    });
                }</script>');
            // Arahkan halaman website jika parameter tidak valid
            return redirect()->to(site_url('siswa/data_tahun_ajaran'));
        }

        $data = array(
            'session' => \Config\Services::session(),
            'status_form' => $status_form,
            'tahun_ajaran' => $dt_tahun_ajaran
        );
        return view('/admin/V_Form_tahun_ajaran', $data);
    }

    public function simpan_tahun_ajaran($parameter = null)
    {
        // Terapkan aturan dalam validasi
        $this->validation->setRules([
            'IDTahunAjaran' => 'required',
            'TahunAjaran' => 'required'
        ]);

        // Buat sebuah variabel untuk menjalankan validasi
        $validasi = $this->validation->withRequest($this->request)->run();

        // cek apakah data tervalidasi sesuai dengan aturan ?
        if ($validasi) {
            // Buat sebuah variabel array yang menampung input data dari pengguna
            if (decrypt_url($parameter) == 'Tambah') {
                // Jika parameter post merupakan 'Tambah'
                $parameters = array(
                    'IDTahunAjaran' => encode_php_tags(htmlentities($this->request->getVar('IDTahunAjaran'))),
                    'TahunAjaran' => ucwords(encode_php_tags(htmlentities($this->request->getVar('TahunAjaran')))),
                    'IDAkunAdmin' => $this->session->get('IDAkunAdmin')
                );
                // Jalan sebuah query untuk menyimpan data tahun ajaran
                $SQL = $this->MTahunAjaran->insert($parameters);
                $param_aktivitas = 'menambahkan';
            } elseif (decrypt_url($parameter) == 'Perbarui') {
                // Jika parameter post merupakan 'Perbarui'
                $parameters = array(
                    'IDTahunAjaran' => encode_php_tags(htmlentities($this->request->getVar('IDTahunAjaran'))),
                    'TahunAjaran' => ucwords(encode_php_tags(htmlentities($this->request->getVar('TahunAjaran')))),
                    'IDAkunAdmin' => $this->session->get('IDAkunAdmin')
                );
                // Jalan sebuah query untuk menyimpan data tahun ajaran
                $SQL = $this->MJurusan->save($parameters);
                $param_aktivitas = 'memperbarui';
            } else {
                $this->session->setFlashdata('pesan', '<script>window.onload = function() {
                    swal({
                        title: "Data Tahun Ajaran",
                        text: "Parameter Tidak Valid !",
                        type: "error",
                        confirmButtonColor: "#57a94f"
                    });
                }</script>');
                // Arahkan halaman website jika parameter tidak valid
                return redirect()->to(site_url('siswa/data_tahun_ajaran'));
            }

            // Cek apakah query berjalan ?
            if ($SQL) {
                // Buat sebuah variabel untuk menampung logs aktivitas pada pengguna
                $aktivitas = '[Info] : ' . $this->session->get('NamaLengkap') . ' Telah ' . $param_aktivitas . ' tahun ajaran baru pada tanggal ' . date('d-F-Y H:i:s') . ' parameters = ' . json_encode($parameters);
                $logs = array(
                    'IDAkunAdmin' => $this->session->get('IDAkunAdmin'),
                    'Waktu' => date('Y-m-d H:i:s'),
                    'Aktivitas' => $aktivitas,
                );
                // Simpan logs aktivitas kedalam database
                $this->MLogs->insert($logs);
                $this->session->setFlashdata('pesan', '<script>window.onload = function() {
                    swal({
                        title: "Data Tahun Ajaran",
                        text: "Data Tahun Ajaran Berhasil Disimpan !",
                        type: "success",
                        confirmButtonColor: "#57a94f"
                    });
                }</script>');
                // Arahkan halaman website ke data tahun ajaran
                return redirect()->to(site_url('siswa/data_tahun_ajaran'));
            } else {
                $this->session->setFlashdata('pesan', '<script>window.onload = function() {
                    swal({
                        title: "Data Tahun Ajaran",
                        text: "Data Tahun Ajaran Gagal Disimpan !",
                        type: "error",
                        confirmButtonColor: "#57a94f"
                    });
                }</script>');
                // Arahkan halaman website jika tidak berhasil
                return redirect()->to(site_url('siswa/data_tahun_ajaran'));
            }
        } else {
            $this->session->setFlashdata('pesan', '<script>window.onload = function() {
                    swal({
                        title: "Data Tahun Ajaran",
                        text: "Data Tidak Valid !",
                        type: "error",
                        confirmButtonColor: "#57a94f"
                    });
                }</script>');
            // Arahkan halaman website jika tidak valid
            return redirect()->to(site_url('siswa/data_tahun_ajaran'));
        }
    }
    public function hapus_tahun_ajaran($parameter = null)
    {
        $this->MTahunAjaran->delete(decrypt_url($parameter));
        // simpan aktivitas pengguna 
        $aktivitas = '[Info] : ' . $this->session->get('NamaLengkap') . ' Telah Menghapus Tahun Ajaran Pada Tanggal ' . date('d-F-Y H:i:s');
        $logs = array(
            'IDAkunAdmin' => $this->session->get('IDAkunAdmin'),
            'Waktu' => date('Y-m-d H:i:s'),
            'Aktivitas' => $aktivitas
        );
        $this->MLogs->insert($logs);
        return redirect()->to(site_url('siswa/data_tahun_ajaran'));
    }
}

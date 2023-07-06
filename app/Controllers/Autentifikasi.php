<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AutentifikasiModel;
use App\Models\LogsModel;

class Autentifikasi extends BaseController
{
    // Deklarasi variabel library, helper dan lain lain
    protected $validation;
    protected $session;
    // Deklarasi variabel untuk model
    protected $MAuth;
    protected $MLogs;

    public function __construct()
    {
        // Memanggil Library, Helper, Model dan lainnya
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->MAuth = new AutentifikasiModel();
        $this->MLogs = new LogsModel();
        date_default_timezone_set('Asia/Jakarta');
    }

    public function validasi_login_admin()
    {
        // Tetapkan aturan dalam validasi
        $this->validation->setRules(
            [
                'NamaPengguna' => 'required',
                'KataSandi' => 'required'
            ]
        );

        // Buat sebuah variabel untuk menjalakan validasi
        $validasi = $this->validation->withRequest($this->request)->run();

        // Cek apakah data tervalidasi sesuai dengan aturan ?
        if ($validasi) {
            // Buat sebuah variabel array yang menampung input data dari pengguna
            $parameters = array(
                'NamaPengguna' => encode_php_tags(htmlentities($this->request->getVar('NamaPengguna'))),
                'KataSandi' => md5($this->request->getVar('KataSandi')),
                'Aktivasi' => 'Y'
            );
            // Jalankan sebuah query untuk mengecek data pengguna
            $SQL = $this->MAuth->where($parameters)->first();
            if ($SQL) {
                // Buat sebuah variabel array yang menampung data session
                $sess_values = array(
                    'IDAkunAdmin' => $SQL['IDAkunAdmin'],
                    'NamaLengkap' => $SQL['NamaLengkap'],
                    'Status' => $SQL['Status'],
                    'Aktivasi' => $SQL['Aktivasi'],
                    'Foto' => $SQL['Foto'],
                    'LogStatus' => encrypt_url('LoggedAdmin')
                );
                // Tetatpkan session sesuai dengan data yang dibuat
                $this->session->set($sess_values);
                // Buat sebuah variabel untuk menampung logs aktivitas pada pengguna
                $aktivitas = '[Info] : ' . $SQL['NamaLengkap'] . ' Telah login aplikasi pada tanggal ' . date('d-F-Y H:i:s');
                $logs = array(
                    'IDAkunAdmin' => $SQL['NamaLengkap'],
                    'Waktu' => date('Y-m-d H:i:s'),
                    'Aktivitas' => $aktivitas,
                );
                // Simpan logs aktivitas kedalam database
                $this->MLogs->insert($logs);
                // Arahkan halaman website kedashboard jika berhasil login
                return redirect()->to(site_url('dashboard'));
            } else {
                $this->session->setFlashdata('pesan', '<script>window.onload = function() {
                    swal({
                        title: "Login Autentifikasi",
                        text: "Nama Pengguna Atau Kata Sandi Salah !",
                        type: "error",
                        confirmButtonColor: "#57a94f"
                    });
                }</script>');
                // Arahkan halaman website login jika tidak berhasil
                return redirect()->to(site_url('login/admin'));
            }
        } else {
            $this->session->setFlashdata('pesan', '<script>window.onload = function() {
                    swal({
                        title: "Login Autentifikasi",
                        text: "Data Tidak Valid!",
                        type: "error",
                        confirmButtonColor: "#57a94f"
                    });
                }</script>');
            // Arahkan halaman website login jika tidak berhasil
            return redirect()->to(site_url('login/admin'));
        }
    }


    public function logout($status = null)
    {
        // Tutup semua session dan kembali kehalaman login 
        if (decrypt_url($status) == 'LoggedAdmin') {
            $this->session->destroy();
            return redirect()->to(site_url('login/admin'));
        } else {
            $this->session->destroy();
            return redirect()->to(site_url('login/siswa'));
        }
    }
}

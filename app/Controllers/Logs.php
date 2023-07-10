<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LogsModel;

class Logs extends BaseController
{
    protected $MLogs;
    protected $session;

    public function __construct()
    {
        $this->MLogs = new LogsModel();
    }
    public function admin()
    {
        $data = array(
            'logs' => $this->MLogs->join('t_akun_admin', 't_akun_admin.IDAkunAdmin = t_logs_admin.IDAkunAdmin', 'left')->findAll(),
            'session' => \Config\Services::session()
        );
        return view('admin/V_logs_admin', $data);
    }
}

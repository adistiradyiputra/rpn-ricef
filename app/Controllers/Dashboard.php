<?php

namespace App\Controllers;
use App\Models\OrganizationModel;

class Dashboard extends BaseController
{
    protected $organizationModel;

    public function __construct()
    {
        $this->organizationModel = new OrganizationModel();
    }

    public function index(): string
    {
        $data['nodes'] = $this->organizationModel->getAllNodes();
        return view('v_dashboard', $data);
    }
}

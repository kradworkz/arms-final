<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\AssetList;
use App\Models\MemberMunicipality;
use Illuminate\Http\Request;

class AdminHomeController extends Controller
{
    public function total()
    {   
        $counts[] = [  
            $data[] = [
                'name' => 'Total Devices',
                'available' => $a = Device::counts(1),
                'notavailable' => $na = Device::counts(0),
                'count' => $a+$na,
                'color' => 'primary',
                'icon' => 'bxs-chip'
            ],
            $data[]  = [
                'name' => 'Total Assets',
                'available' => $a = AssetList::counts(1),
                'notavailable' => $na = AssetList::counts(0),
                'count' => $a+$na,
                'color' => 'success',
                'icon' => 'bxs-component'
            ],
            $data[] = [
                'name' => 'Total Members',
                'count' => MemberMunicipality::count(),
                'color' => 'danger',
                'icon' => 'bxs-home'
            ],
        ];
        return $counts;
    }
}

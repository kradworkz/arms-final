<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\AssetList;
use Illuminate\Http\Request;

class HomeMemberController extends Controller
{
    public function total()
    {   
        $counts[] = [  
            $data[] = [
                'name' => 'Total Assets',
                'count' => AssetList::counts(1) + AssetList::counts(0),
                'color' => 'primary',
                'icon' => 'bx-list-ul'
            ],
            $data[]  = [
                'name' => 'Available',
                'count' => AssetList::counts(1),
                'color' => 'success',
                'icon' => 'bxs-check-circle'
            ],
            $data[] = [
                'name' => 'Not Available',
                'count' => AssetList::counts(0),
                'color' => 'danger',
                'icon' => 'bxs-x-circle'
            ],
        ];
        return $counts;
    }
}

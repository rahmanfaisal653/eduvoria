<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function index()
    {
        $kpis = [
            [
                'title' => 'Jangkauan Postingan',
                'value' => '15.4K',
                'delta' => '+12%',
                'delta_desc' => 'vs periode lalu',
                'trend' => 'up',
            ],
            [
                'title' => 'Total Interaksi',
                'value' => '2.8K',
                'delta' => '+8.5%',
                'delta_desc' => 'vs periode lalu',
                'trend' => 'up',
            ],
            [
                'title' => 'Anggota Baru',
                'value' => '452',
                'delta' => '-3.1%',
                'delta_desc' => 'vs periode lalu',
                'trend' => 'down',
            ],
            [
                'title' => 'Postingan Dibuat',
                'value' => '89',
                'delta' => '+5%',
                'delta_desc' => 'vs periode lalu',
                'trend' => 'up',
            ],
        ];

        $trend = [
            'labels' => ['Sen','Sel','Rab','Kam','Jum','Sab','Min'],
            'likes'  => [120, 180, 150, 210, 260, 190, 220],
            'comments' => [45, 60, 52, 70, 80, 55, 63],
        ];

        $traffic = [
            ['label' => 'Organik', 'value' => 46],
            ['label' => 'Sosial',  'value' => 32],
            ['label' => 'Direct',  'value' => 14],
            ['label' => 'Referral','value' => 8],
        ];

        return view('users.statistik', compact('kpis','trend','traffic'));
    }
}

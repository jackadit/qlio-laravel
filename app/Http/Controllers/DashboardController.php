<?php

namespace App\Http\Controllers;

use App\Models\SwUser;
use App\Models\SwSoc;
use App\Models\SwStage;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users_count' => SwUser::where('actif', 1)->count(),
            'societes_count' => SwSoc::where('actif', 1)->count(),
            'stages_count' => SwStage::count(),
            'stages_en_cours' => SwStage::where('sta_debut', '<=', now())
                                      ->where('sta_fin', '>=', now())
                                      ->count(),
        ];
        
        $recent_stages = SwStage::orderBy('sta_debut', 'desc')
                               ->limit(5)
                               ->get();
        
        return view('qlio.dashboard', compact('stats', 'recent_stages'));
    }
}

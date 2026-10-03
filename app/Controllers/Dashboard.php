<?php
namespace App\Controllers;
use App\Models\CandidateProfileModel;
class Dashboard extends BaseController
{
    public function index()
    {
        if (!$this->signedIn()) return redirect()->to('/login');
        if ($this->isHR()) return redirect()->to('/hr');
        $profile=(new CandidateProfileModel())->where('user_id',session()->get('user_id'))->first();
        return view('candidate/dashboard',['title'=>'Candidate Dashboard','profile'=>$profile]);
    }
}

<?php
namespace App\Controllers;
use App\Models\CandidateProfileModel;
use App\Models\UserModel;
class HR extends BaseController
{
    private function guard(){if(!$this->signedIn()) return redirect()->to('/login'); if(!$this->isHR()) return redirect()->to('/dashboard'); return null;}
    public function index()
    {
        if($r=$this->guard()) return $r;
        $rows=(new CandidateProfileModel())->select('candidate_profiles.*, users.email, users.is_verified')->join('users','users.id=candidate_profiles.user_id')->orderBy('candidate_profiles.id','DESC')->findAll();
        return view('hr/index',['title'=>'HR Dashboard','candidates'=>$rows]);
    }
    public function view($id)
    {
        if($r=$this->guard()) return $r;
        $p=(new CandidateProfileModel())->select('candidate_profiles.*, users.email, users.is_verified')->join('users','users.id=candidate_profiles.user_id')->find($id);
        if(!$p) return redirect()->to('/hr');
        return view('hr/view',['title'=>'Candidate Details','candidate'=>$p]);
    }
    public function verify($id)
    {
        if($r=$this->guard()) return $r;
        $p=(new CandidateProfileModel())->find($id); if($p) (new UserModel())->update($p['user_id'],['is_verified'=>1]);
        return redirect()->to('/hr/candidate/'.$id)->with('success','Candidate verified.');
    }
    public function interview($id)
    {
        if($r=$this->guard()) return $r;
        $p=(new CandidateProfileModel())->select('candidate_profiles.*, users.email')->join('users','users.id=candidate_profiles.user_id')->find($id);
        if(!$p) return redirect()->to('/hr');
        $email=\Config\Services::email(); $email->setTo($p['email']); $email->setSubject('Interview invitation'); $email->setMessage('Hello '.$p['full_name'].',<br><br>We would like to invite you for an interview. Our HR team will contact you with the details.<br><br>Regards,<br>HR Team');
        if(!$email->send()) return redirect()->to('/hr/candidate/'.$id)->with('error','Email failed. Configure SMTP in .env first.');
        return redirect()->to('/hr/candidate/'.$id)->with('success','Interview email sent.');
    }
}

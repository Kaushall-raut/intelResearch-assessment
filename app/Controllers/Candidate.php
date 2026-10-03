<?php
namespace App\Controllers;
use App\Models\CandidateProfileModel;
class Candidate extends BaseController
{
    private function guard(){ if(!$this->signedIn()) return redirect()->to('/login'); if($this->isHR()) return redirect()->to('/hr'); return null; }
    public function profile()
    {
        if($r=$this->guard()) return $r;
        $m=new CandidateProfileModel(); $p=$m->where('user_id',session()->get('user_id'))->first();
        if($this->request->getMethod()==='POST'){
            $data=['full_name'=>$this->request->getPost('full_name'),'phone'=>$this->request->getPost('phone'),'skills'=>$this->request->getPost('skills'),'experience'=>$this->request->getPost('experience'),'summary'=>$this->request->getPost('summary')];
            $m->update($p['id'],$data); return redirect()->to('/profile')->with('success','Profile updated.');
        }
        return view('candidate/profile',['title'=>'My Profile','profile'=>$p]);
    }
    public function uploadResume()
    {
        if($r=$this->guard()) return $r;
        $file=$this->request->getFile('resume');
        if(!$file || !$file->isValid() || !in_array($file->getMimeType(),['application/pdf','application/msword','application/vnd.openxmlformats-officedocument.wordprocessingml.document'])) return redirect()->to('/profile')->with('error','Upload a valid PDF or Word resume.');
        if($file->getSizeByUnit('mb')>5) return redirect()->to('/profile')->with('error','Maximum resume size is 5 MB.');
        $name=$file->getRandomName(); $file->move(WRITEPATH.'uploads/resumes',$name);
        $m=new CandidateProfileModel(); $p=$m->where('user_id',session()->get('user_id'))->first();
        if($p['resume_path'] && is_file(WRITEPATH.'uploads/resumes/'.$p['resume_path'])) unlink(WRITEPATH.'uploads/resumes/'.$p['resume_path']);
        $m->update($p['id'],['resume_path'=>$name]); return redirect()->to('/profile')->with('success','Resume uploaded.');
    }
    public function resume($id)
    {
        if(!$this->signedIn()) return redirect()->to('/login');
        $m=new CandidateProfileModel(); $p=$m->find($id);
        if(!$p || !$p['resume_path'] || (!$this->isHR() && (int)$p['user_id']!==(int)session()->get('user_id'))) return $this->response->setStatusCode(404);
        $path=WRITEPATH.'uploads/resumes/'.$p['resume_path']; if(!is_file($path)) return $this->response->setStatusCode(404);
        return $this->response->download($path,null)->setFileName('resume-'.$id.'.'.pathinfo($path,PATHINFO_EXTENSION));
    }
}

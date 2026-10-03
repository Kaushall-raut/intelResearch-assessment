<?php
namespace App\Controllers;
use App\Models\UserModel;
class Auth extends BaseController
{
    public function register()
    {
        if ($this->request->getMethod() === 'POST') {
            $rules = ['name'=>'required|min_length[2]|max_length[120]','email'=>'required|valid_email|is_unique[users.email]','password'=>'required|min_length[8]'];
            if (!$this->validate($rules)) return view('auth/register',['title'=>'Register','errors'=>$this->validator->getErrors()]);
            $id=(new UserModel())->insert(['name'=>$this->request->getPost('name'),'email'=>$this->request->getPost('email'),'password'=>password_hash($this->request->getPost('password'),PASSWORD_DEFAULT),'role'=>'candidate','is_verified'=>0],true);
            (new \App\Models\CandidateProfileModel())->insert(['user_id'=>$id,'full_name'=>$this->request->getPost('name')]);
            return redirect()->to('/login')->with('success','Account created. Please sign in.');
        }
        return view('auth/register',['title'=>'Register','errors'=>[]]);
    }
    public function login()
    {
        if ($this->request->getMethod()==='POST') {
            $u=(new UserModel())->where('email',$this->request->getPost('email'))->first();
            if ($u && password_verify((string)$this->request->getPost('password'),$u['password'])) {
                session()->regenerate();
                session()->set(['user_id'=>$u['id'],'name'=>$u['name'],'role'=>$u['role']]);
                return redirect()->to($u['role']==='hr'?'/hr':'/dashboard');
            }
            return view('auth/login',['title'=>'Login','error'=>'Invalid email or password.']);
        }
        return view('auth/login',['title'=>'Login','error'=>null]);
    }
    public function logout(){ session()->destroy(); return redirect()->to('/')->with('success','You have signed out.'); }
}

<?php
namespace App\Models;
use CodeIgniter\Model;
class CandidateProfileModel extends Model
{
    protected $table='candidate_profiles';
     protected $primaryKey='id'; 
     protected $returnType='array';
      protected $allowedFields=['user_id','full_name','phone','skills','experience','summary','resume_path']; 
      protected $useTimestamps=true;
}

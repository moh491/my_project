<?php

namespace App\Http\Controllers;

use App\Services\ProfilePageService;
use App\Services\ProfilePageTeamService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    use ApiResponseTrait;
    protected $ProfilePageTeam;

    public function __construct(ProfilePageTeamService $ProfilePageTeam)
    {
        $this->ProfilePageTeam = $ProfilePageTeam;
    }
    public function getProfilePage($id){
        try {
            $information = $this->ProfilePageTeam->ProfilePage($id);
            return $this->success('get Profile Page',$information);
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }
}

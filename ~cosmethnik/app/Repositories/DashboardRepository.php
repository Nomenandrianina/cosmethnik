<?php

namespace App\Repositories;

use App\Models\Attendance;
use App\Models\Produit_fini;
use App\Models\Produit_semi_finis;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Sites;
use App\Models\User;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/**
 * Class DashboardRepository
 * @package App\Repositories
 * @version July 26, 2021, 12:17 pm UTC
 */

class DashboardRepository
{
    /** @var  UserRepository */
    private $userRepository;
    /** @var  RoleRepository */
    private $roleRepository;
    /** @var  PermissionRepository */
    private $permissionRepository;
    /** @var  AttendanceRepository */
    private $attendanceRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(RoleRepository $roleRepo, UserRepository $userRepo, PermissionRepository $permissionRepo, AttendanceRepository $attendanceRepo)
    {
        $this->permissionRepository = $permissionRepo;
        $this->userRepository = $userRepo;
        $this->roleRepository = $roleRepo;
        $this->attendanceRepository = $attendanceRepo;
    }

    private function getDashboardInfo()
    {
        $dashboardInfo = [];
        $dashboardInfo['user_count'] =  $this->userRepository->count();
        $dashboardInfo['role_count'] =  $this->roleRepository->count();
        $dashboardInfo['permission_count'] =  $this->permissionRepository->count();
        $dashboardInfo['user_online'] =  $this->attendanceRepository->CountUserOnline();
        return $dashboardInfo;
    }
    private function getChartUserCheckinInfo()
    {
        $labels = [];
        $dataset1 = [];
        $dataset1['label'] = 'My Daily';
        $dataset1['data'] = [];
        $dataset1['borderColor'] = 'rgb(75, 192, 192)';

        $data = $this->attendanceRepository->TotalCheckInByDay(auth()->user()->id);
        foreach ($data as $key => $value) {
            $dataset1['data'][$key] = $value;
            $labels[$key] = $key;
        }

        $dataset2 = [];
        $dataset2['label'] = 'User Daily';
        $dataset2['data'] = [];
        $dataset2['borderColor'] = 'rgb(20, 150, 192)';

        $data = $this->attendanceRepository->TotalCheckInByDay();
        foreach ($data as $key => $value) {
            $dataset2['data'][$key ] = $value;
            $labels[$key] = $key;
        }

        $datasets = [];
        $datasets[] = $dataset1;
        $datasets[] = $dataset2;

        $data = [];
        $data['labels'] = array_values($labels);
        $data['datasets'] = $datasets;

        $chart = [];
        $chart['type'] = 'line';
        $chart['data'] = $data;
        return $chart;
    }
    public function GetData()
    {
        $dashboard = [];
        $dashboard['dashboardInfo'] = $this->getDashboardInfo();
        $dashboard['chartUserCheckin'] = $this->getChartUserCheckinInfo();
        $idUtilisateur = Auth::user()->id;
        $dashboard['sites'] = DB::table('sites')
        ->leftJoin('site_user', function ($join) use ($idUtilisateur) {
            $join->on('sites.id', '=', 'site_user.site_id')
                ->where('site_user.user_id', $idUtilisateur);
        })
        ->select('sites.*')
        ->whereIn('sites.user_id', [$idUtilisateur, null])
        ->orWhere('site_user.is_member', 1)
        ->paginate(2);
        $dashboard['produit_fini'] = Produit_fini::paginate(2);
        $user = User::all();
        $select = [];
        foreach($user as $item){
            $select[$item->id] = $item->name;
        }
        $dashboard['users'] = $select;
        return $dashboard;
    }
}

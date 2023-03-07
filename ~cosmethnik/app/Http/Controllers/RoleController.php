<?php

namespace App\Http\Controllers;

use App\DataTables\RoleDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Repositories\RoleRepository;
use App\Repositories\PermissionRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Broadcasting\Broadcasters\PusherBroadcaster;
use Illuminate\Support\Facades\DB;
use Response;

class RoleController extends AppBaseController
{
    /** @var  PermissionRepository */
    private $permissionRepository;

    /** @var  RoleRepository */
    private $roleRepository;

    public function __construct(RoleRepository $roleRepo, PermissionRepository $permissionRepo)
    {
        $this->roleRepository = $roleRepo;
        $this->permissionRepository = $permissionRepo;
    }

    /**
     * Display a listing of the Role.
     *
     * @param RoleDataTable $roleDataTable
     * @return Response
     */
    public function index(RoleDataTable $roleDataTable)
    {
        return $roleDataTable->render('roles.index');
    }

    /**
     * Show the form for creating a new Role.
     *
     * @return Response
     */
    public function create()
    {
        $allPermission = $this->permissionRepository->all();
        return view('roles.create')->with('allPermission', $allPermission);
    }

    /**
     * Store a newly created Role in storage.
     *
     * @param CreateRoleRequest $request
     *
     * @return Response
     */
    public function store(CreateRoleRequest $request)
    {

        $input = $request->all();

        $role = $this->roleRepository->create($input);

        Flash::success('Role saved successfully.');

        return redirect(route('roles.index'));
    }

    /**
     * Display the specified Role.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $role = $this->roleRepository->find($id);

        if (empty($role)) {
            Flash::error('Role not found');

            return redirect(route('roles.index'));
        }

        $allPermission = $this->permissionRepository->all();
        return view('roles.show')->with('role', $role)->with('allPermission', $allPermission);
    }

    /**
     * Show the form for editing the specified Role.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $role = $this->roleRepository->find($id);

        if (empty($role)) {
            Flash::error('Role not found');

            return redirect(route('roles.index'));
        }

        $allPermission = $this->permissionRepository->all();

        return view('roles.edit')->with('role', $role)->with('allPermission', $allPermission);
    }

    /**
     * Update the specified Role in storage.
     *
     * @param  int              $id
     * @param UpdateRoleRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRoleRequest $request)
    {
        $role_id = array();
        $role = $this->roleRepository->find($id);
        // dd($role);

        if (empty($role)) {
            Flash::error('Role not found');

            return redirect(route('roles.index'));
        }
        $permission_data = $request->get('permission_data');
        $role = $this->roleRepository->update($request->all(), $id);
        $role->syncPermissions($permission_data);
        // foreach($permission_data as $item){
        //     array_push($role_id,2);
        // }
        // $merged = collect($permission_data)->zip($role_id)->transform(function ($values) {
        //     return [
        //         'permission_id' => $values[0],
        //         'role_id' => $values[1],
        //     ];
        // });
        // $obj = json_decode(json_encode($merged->all()));
        // foreach ($obj as $key => $value){
        //     DB::insert('insert into role_has_permissions(permission_id,role_id)values(?,?)',[$value->permission_id,$value->role_id]);
        // }

        Flash::success('Role updated successfully.');

        return redirect(route('roles.index'));
    }

    /**
     * Remove the specified Role from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $role = $this->roleRepository->find($id);

        if (empty($role)) {
            Flash::error('Role not found');

            return redirect(route('roles.index'));
        }

        $this->roleRepository->delete($id);

        Flash::success('Role deleted successfully.');

        return redirect(route('roles.index'));
    }
}

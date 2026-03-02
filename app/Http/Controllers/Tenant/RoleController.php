<?php

namespace App\Http\Controllers\Tenant;
use Illuminate\Support\Str;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Validation\Rule;
class RoleController extends Controller
{
    function index(){
         $permissions = Permission::all();
     
      
        return view("roles.create",compact( 'permissions' ));
    }
 public function show()
{
    $roles = Role::where('team_id', tenant('id'))->get();
  

     return view('roles.list', compact('roles'));
    
}
 
    public function store(Request $request){
        $request->validate([
           'name' => [
    'required',
    'string',
    Rule::unique('roles')
        ->where(fn ($query) =>
            $query->where('team_id', tenant('id'))
        )
],
        ]);
        setPermissionsTeamId(tenant()->id);
        $role=Role::create([
            'name'      => Str::lower($request->name),
            'tenant_id'=>tenant()->id,
            'guard_name'=>'web'

        ]);
            $role->permissions()->sync($request->permissions ?? []);
        return view("tenants.dashboard")->with('success', 'Role created successfully!');
    }
public function edit(Role $role)
{
    $permissions = Permission::all();




    $rolePermissions = $role->permissions->pluck('id')->toArray();

    return view('roles.edit', compact('role', 'permissions',  'rolePermissions'));
}
public function update(Request $request, Role $role)
{
    $request->validate([
        'name' => 'required|string|max:255'
    ]);

    $role->update([
    'name'      => Str::lower($request->name),
    ]);

  
    $role->permissions()->sync($request->permissions ?? []);



    return redirect()
        ->route('tenants.dashboard')
        ->with('success', 'Role updated successfully.');
}
 public function destroy($id)
    {
        setPermissionsTeamId(tenant()->id);

        $role = Role::where('team_id', tenant()->id)
                    ->findOrFail($id);

        $role->delete();

         return redirect()
        ->route('roles.view')
        ->with('success', 'Role deleted successfully');
    }
  
}


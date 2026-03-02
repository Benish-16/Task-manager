<?php

namespace App\Http\Controllers;
use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


class PermissionController extends Controller 
{
   
    public function index()
    {
     

    $permissions = Permission::all()

                              ;
                           

    return view('permissions.list', [
        'permissions' => $permissions,
    ]);
    }


    public function create()
    {
        return view('permissions.create');
    }


    public function store(Request $request)
    {
           $tenantId = tenant('id');
      
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:permissions|min:4', 
        ]);

        if ($validator->passes()) {
            Permission::create(['name' => $request->name]);
              Rule::unique('permissions')->where(function ($query) use ($tenantId) {
                return $query->where('tenant_id', $tenantId);
            });
            return redirect()->route('permissions.create')->with('success', 'Permission added successfully!');
        } else {
            return redirect()->route('permissions.create')->withInput()->withErrors($validator);
        }
    }

  
    
    public function edit(Permission $permission) 
    {
        return view('permissions.edit', [
            'permission' => $permission
        ]);
    }




public function update(Request $request, Permission $permission)
{
    $request->validate([
        'name' => 'required|string|max:255'
    ]);

    $permission->update([
        'name' => $request->name
    ]);

    return redirect()
        ->route('permissions.view')
        ->with('success', 'Permission updated successfully.');
}
public function destroy(Permission $permission)
{
    $permission->delete();

    return redirect()
        ->route('permissions.view')
        ->with('success', 'Permission deleted successfully');
}
    }

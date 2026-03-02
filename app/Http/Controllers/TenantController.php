<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Models\Permission;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use Illuminate\Support\Facades\Password; 


class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
{
   $tenants = Tenant::with('domains')->withCount('users')->paginate(10);;
    return view('tenants.list', compact('tenants'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('tenants.create');
    }

    /**
     * Store a newly created resource in storage.
     */
 

public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|max:255',
        'domain' => 'required|string|max:255|unique:domains,domain',
           'number_of_users' => 'required|integer|min:1|max:1000',
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

  
    $tenant = Tenant::create([
        'id' => Str::uuid(),
        'name' => $validated['name'],
        'email' => $validated['email'],
        'number_of_users' => $validated['number_of_users'],
        'password' => bcrypt($validated['password']),
        'data' => ['domain' => $validated['domain']],
    ]);
    $user = User::create([
    'name' => $request->name,
    'email' => $request->email,
    'tenant_id' => $tenant->id,   
    'password' => bcrypt($request->password),
    
]);
 $user->markAsNew();
app(PermissionRegistrar::class)
    ->setPermissionsTeamId($user->tenant_id);
$role = Role::firstOrCreate(
    [
        'name' => 'admin',
        'guard_name' => 'web',
        'team_id' => $user->tenant_id,   
    ]
);
$allPermissions = Permission::pluck('name');


$role->syncPermissions($allPermissions);
           
            $user->syncRoles(['admin']);
            $user->save();
        

 
    $tenant->domains()->create([
        'domain' => $validated['domain'] . '.' . config('app.domain'),
    ]);


    tenancy()->initialize($tenant);


    Artisan::call('tenants:migrate', [
        '--tenants' => [$tenant->id],
        '--force' => true,
    ]);
    
    tenancy()->end();
   
$user->markAsNew();


$token = Password::createToken($user);


$user->sendPasswordResetNotification($token);


return redirect()->route('tenants.index')
    ->with('success', 'Tenant created successfully! Check your email to set your password.');
}


    /**
     * Display the specified resource.
     */
    public function show(Tenant $tenant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
     public function edit(Tenant $tenant)
    {
        return view('tenants.edit', compact('tenant'));
    }

    /**
     * Update the specified resource in storage.
     */
      public function update(Request $request, Tenant $tenant)
    {
      
        $request->validate([
          
  
            'number_of_users' => 'required|integer|min:1|max:1000',
          
        ]);

      
        $data = $tenant->data ?? [];
     
 $tenantDomain = $tenant->domains()->first(); 
    if ($tenantDomain) {
        $tenantDomain->update([
            'domain' => $request->domain ,
        ]);
    } else {
      
        $tenant->domains()->create([
            'domain' => $request->domain . '.' . config('app.domain'),
        ]);
    }

       
    
        $tenant->data = $data;

       
        $tenant->number_of_users = $request->number_of_users;

 
        

        $tenant->save();

        return redirect()->route('tenants.index')->with('success', 'Tenant updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tenant $tenant)
    {
        $tenant->users()->delete();       
    $tenant->domains()->delete();   

    $tenant->delete();

    return redirect()->route('tenants.view')->with('success', 'Tenant deleted successfully.');
    }
}

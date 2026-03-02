<x-app-layout>
    <x-slot name="header">

        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>

            <span class="text-sm text-gray-500">
              <span class="text-sm text-gray-500">
    Welcome, {{ auth()->user()->name }} ({{ auth()->user()->getRoleNames()->first() }})
</span>
            </span>
            
     </div>
           </x-slot>

           @unlessrole('employee')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

          
            <div class="bg-white shadow-lg rounded-2xl p-8">

                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-800">
                         You're logged in!
                    </h3>
                    <p class="text-gray-500 mt-1">
                        Manage roles, cans and users for your tenant.
                    </p>
                </div>

         
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

           @can('create role')
                    <a href="{{ route('roles.index') }}"
                       class="group p-6 rounded-xl border hover:shadow-md transition bg-gradient-to-br from-indigo-50 to-white">
                        <h4 class="font-semibold text-gray-800 mb-2">
                            Create Role
                        </h4>
                        <p class="text-sm text-gray-500">
                            Add and manage new roles
                        </p>
                    </a>
                    @endcan
                

                  @can('view roles')
                    <a href="{{ route('roles.view') }}"
                       class="group p-6 rounded-xl border hover:shadow-md transition bg-gradient-to-br from-emerald-50 to-white">
                        <h4 class="font-semibold text-gray-800 mb-2">
                            View Roles
                        </h4>
                        <p class="text-sm text-gray-500">
                            See existing roles
                        </p>
                    </a>
                    @endcan
@can('view user')

    @role('manager')
        <a href="{{ route('tenants.userlist') }}"
           class="group p-6 rounded-xl border hover:shadow-md transition bg-gradient-to-br from-sky-50 to-white">
            <h4 class="font-semibold text-gray-800 mb-2">
                View Employees
            </h4>
            <p class="text-sm text-gray-500">
                Manage employees
            </p>
        </a>
    @else
        <a href="{{ route('tenants.userlist') }}"
           class="group p-6 rounded-xl border hover:shadow-md transition bg-gradient-to-br from-sky-50 to-white">
            <h4 class="font-semibold text-gray-800 mb-2">
                View Users
            </h4>
            <p class="text-sm text-gray-500">
                Manage tenant users
            </p>
        </a>
    @endrole

@endcan
                    @php
    $tenant = tenant(); 
    $currentUserCount = \App\Models\User::where('tenant_id', $tenant->id)->count();
 
    $userLimitReached = $currentUserCount >= $tenant->number_of_users;
 
@endphp

@can('create user')
    @if($userLimitReached)
        <div class="group p-6 rounded-xl border bg-gray-100 cursor-not-allowed opacity-50" title="User limit exceeded">
            <h4 class="font-semibold text-gray-800 mb-2">
                Create users
            </h4>
            <p class="text-sm text-gray-500">
                User limit exceeded
            </p>
        </div>
    @else
        <a href="{{ route('tenants.register') }}"
           class="group p-6 rounded-xl border hover:shadow-md transition bg-gradient-to-br from-sky-50 to-white">
            <h4 class="font-semibold text-gray-800 mb-2">
                Create users
            </h4>
            <p class="text-sm text-gray-500">
                Create tenant users
            </p>
        </a>
    @endif
@endcan
                     @can('create tasks')
                     <a href="{{ route('tasks.create') }}"
                       class="group p-6 rounded-xl border hover:shadow-md transition bg-gradient-to-br from-sky-50 to-white">
                        <h4 class="font-semibold text-gray-800 mb-2">
                            Create tasks
                        </h4>
                        <p class="text-sm text-gray-500">
                            Create tenant tasks
                        </p>
                    </a>
                         @endcan
                     @can('task view')
                     <a href="{{ route('tasks.index') }}"
                       class="group p-6 rounded-xl border hover:shadow-md transition bg-gradient-to-br from-sky-50 to-white">
                        <h4 class="font-semibold text-gray-800 mb-2">
                            View tasks
                        </h4>
                        <p class="text-sm text-gray-500">
                            View tenant tasks
                        </p>
                    </a>
                         @endcan
                 

                </div>

            </div>
        </div>
    </div>
     @endunlessrole

 @role('employee|manager')
     
  <div class="max-w-7xl mx-auto px-4 py-10">

    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        <div class="bg-white rounded-2xl shadow p-6 border-l-4 border-indigo-500">
            <p class="text-sm text-gray-500">Total Tasks</p>
            <h2 class="text-3xl font-bold text-gray-800 mt-2">
                {{ $totalTasks }}
            </h2>
        </div>

    
        <div class="bg-white rounded-2xl shadow p-6 border-l-4 border-gray-400">
            <p class="text-sm text-gray-500">Pending</p>
            <h2 class="text-3xl font-bold text-gray-800 mt-2">
                {{ $pendingTasks }}
            </h2>
        </div>

       
        <div class="bg-white rounded-2xl shadow p-6 border-l-4 border-yellow-400">
            <p class="text-sm text-gray-500">In Progress</p>
            <h2 class="text-3xl font-bold text-gray-800 mt-2">
                {{ $inProgressTasks }}
            </h2>
        </div>

 
        <div class="bg-white rounded-2xl shadow p-6 border-l-4 border-green-500">
            <p class="text-sm text-gray-500">Completed</p>
            <h2 class="text-3xl font-bold text-gray-800 mt-2">
                {{ $completedTasks }}
            </h2>
        </div>

    </div>
<div class="mt-8 bg-white rounded-2xl shadow p-6">

    <div class="flex justify-between mb-2">
        <span class="text-sm font-medium text-gray-600">Overall progress</span>
        <span class="text-sm font-semibold text-gray-700">
            {{ $progressPercent }}%
        </span>
    </div>

    <div class="w-full bg-gray-200 rounded-full h-3">
        <div class="bg-green-500 h-3 rounded-full"
             style="width: {{ $progressPercent }}%">
        </div>
    </div>

</div>
 
<div class="mt-8 flex justify-end gap-4">
        <a href="{{ route('tasks.employee.index') }}"
           class="inline-flex items-center px-6 py-3 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition">
            View My Tasks
        </a>
    </div>

</div>
@endrole
    

</x-app-layout>
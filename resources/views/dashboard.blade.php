
<x-app-layout>
    <x-slot name="header">

        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
                
            </h2>

            <span class="text-sm text-gray-500">
              <span class="text-sm text-gray-500">
    Welcome, {{ auth()->user()->name }} ({{ auth()->user()->getRoleNames()->first()?null:'Super Admin' }})
</span>
 <a href="{{ url('/telescope') }}"
                   class="px-2 py-2 text-sm font-semibold rounded-lg
                          bg-gray-900 text-white hover:bg-gray-800">
                    Telescope
                </a>
            </span>
            
               
           
     </div>
           </x-slot>

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

           
                    <a href="{{route('permissions.view')}}"
                       class="group p-6 rounded-xl border hover:shadow-md transition bg-gradient-to-br from-indigo-50 to-white">
                        <h4 class="font-semibold text-gray-800 mb-2">
                        View Permissions 
                        </h4>
                        <p class="text-sm text-gray-500">
                           Can see existing permissions
                        </p>
                    </a>
                  
                

                    <a href="{{route('tenants.create')}}"
                       class="group p-6 rounded-xl border hover:shadow-md transition bg-gradient-to-br from-emerald-50 to-white">
                        <h4 class="font-semibold text-gray-800 mb-2">
                           Create Tenants 
                        </h4>
                        <p class="text-sm text-gray-500">
                            Create new tenants
                        </p>
                    </a>
                     <a href="{{route('tenants.view')}}"
                       class="group p-6 rounded-xl border hover:shadow-md transition bg-gradient-to-br from-red-50 to-white">
                        <h4 class="font-semibold text-gray-800 mb-2">
                           View Tenants 
                        </h4>
                        <p class="text-sm text-gray-500">
                            View existing tenants
                        </p>
                    </a>
                  

                  
                    <a href="{{route('permissions.create')}}"
                       class="group p-6 rounded-xl border hover:shadow-md transition bg-gradient-to-br from-sky-50 to-white">
                        <h4 class="font-semibold text-gray-800 mb-2">
                           Create Permissions
                        </h4>
                        <p class="text-sm text-gray-500">
                            Manage Permissions for tenant users
                        </p>
                    </a>
                   
                    
                 

                </div>

            </div>
        </div>
    </div>

</x-app-layout>
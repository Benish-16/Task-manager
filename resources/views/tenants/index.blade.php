<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tenants') }}
            <x-btn-link class="ml-4 float-right" href="{{route('tenants.create')}}">
                Create tenant </x-btn-link >
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-12">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            
           
            </div>
            <div class="relative ">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 px-0;">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-3 py-4" >Id</th>
                            <th scope="col" class="px-5 py-4">Name</th>
                            <th scope="col" class="px-5 py-4">Email</th>
                            <th scope="col" class="px-5 py-4">Domain</th>
                                 <th scope="col" class="px-5 py-4">Action</th>
                         
                        </tr>
                    </thead>
                    <tbody>
                             
                        
                           @foreach($tenants as $tenant)
                                <tr>
                                                                <th scope="col" class="px-3 py-4" >{{$tenant->id}}</th>
                            <th scope="col" class="px-5 py-4">{{$tenant->name}}</th>
                            <th scope="col" class="px-5 py-4">{{$tenant->email}}</th>
                            <th scope="col" class="px-5 py-4">@foreach($tenant->domains as $domain)
    {{ $domain->domain }}{{ $loop->last ? '' : ',' }}
@endforeach

                                
                            </th>
                                </tr>
                         
                          @endforeach
                        
                    </tbody>

                </table>
            
                


            </div>
        </div>
    </div>
</x-app-layout>

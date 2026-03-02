<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Tenant') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form method="POST" action="{{ route('tenants.update', $tenant->id) }}">
                        @csrf
                        @method('PUT')

                      
                       

                
                        <div class="mb-4">
                            <x-input-label for="domain" :value="__('Domain')" />
                            <x-text-input id="domain" class="block mt-1 w-full" type="text" name="domain" 
                                          value="{{ old('domain', $tenant->domains->pluck('domain')->implode(', ') ?? '') }}" 
                                          required />
                            <x-input-error :messages="$errors->get('domain')" class="mt-2" />
                        </div>

                
                     
                        <div class="mb-4">
                            <label for="number_of_users" class="block text-sm font-medium text-gray-700">Number of Users</label>
                            <input type="number" name="number_of_users" id="number_of_users"
                                   min="1"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                   value="{{ old('number_of_users', $tenant->number_of_users ?? 0) }}">
                            <x-input-error :messages="$errors->get('number_of_users')" class="mt-2" />
                        </div>

                 
                  

                            <x-primary-button class="ms-4">
                                {{ __('Update') }}
                            </x-primary-button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
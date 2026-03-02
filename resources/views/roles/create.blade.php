<x-app-layout>
    <x-slot name="header">
        <div class='flex justify-between'>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              Roles/Create
            </h2>
            
    
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
             
                   
                    <form action="{{ route('roles.store') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label class="block mb-1 text-lg">Name</label>
                            <input type="text" value="{{ old('name') }}" name='name' class="border-gray-300 shadow-sm w-1/2 rounded-lg" placeholder="Name">
                        </div>
                        @error('name')
                        <p class="text-red-400 font-medium">{{ $message }}</p>
                        @enderror
                       
                   
                            <div class="mb-10">
                            <h3 class="text-xl font-semibold mb-4 border-b pb-2">
                                Assign Permissions
                            </h3>

                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach($permissions as $permission)
                                    <label class="flex items-center space-x-3 bg-gray-50 p-3 rounded-lg hover:bg-slate-100 transition cursor-pointer">
                                        <input type="checkbox"
                                               name="permissions[]"
                                               value="{{ $permission->id }}"
                                               class="rounded text-slate-600 focus:ring-slate-500"
                                              >
                                        <span class="text-gray-700">
                                            {{ $permission->name }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                       
                        <button class="bg-slate-600 text-sm rounded-md px-5 py-3 text-white">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

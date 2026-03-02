<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                Edit Role
            </h2>
            <a href="{{ route('roles.index') }}"
               class="bg-slate-600 text-sm rounded-md px-5 py-3 text-white hover:bg-slate-500 transition">
                Back to Roles
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-xl">
                <div class="p-8">

                    <form action="{{ route('role.update',$role->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                    
                        <div class="mb-8">
                            <label class="block text-lg font-semibold mb-2">Role Name</label>
                            <input type="text"
                                   name="name"
                                   value="{{ old('name', $role->name) }}"
                                   class="w-full rounded-lg border-gray-300 focus:ring-slate-500 focus:border-slate-500">
                            @error('name')
                                <p class="text-red-500 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                       
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
                                               {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                        <span class="text-gray-700">
                                            {{ $permission->name }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        

                    
                        <div class="flex justify-end">
                            <button type="submit"
                                    class="bg-slate-600 text-white px-6 py-3 rounded-lg hover:bg-slate-500 transition shadow-md">
                                Update Role
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Roles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 text-sm text-green-600">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Roles</h3>

                    @can('create roles')
                        <a href="{{ route('role.create') }}"
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">
                            Create Role
                        </a>
                    @endcan
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200">
                        <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border">#</th>
                            <th class="px-4 py-2 border">Name</th>
                            <th class="px-4 py-2 border">Created</th>
                            <th class="px-4 py-2 border">Actions</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($roles as $role)
                            <tr class="border-t">

                                <td class="px-4 py-2 border">
                                    {{ $role->id }}
                                </td>

                                <td class="px-4 py-2 border">
                                    {{ $role->name }}
                                </td>

                                <td class="px-4 py-2 border">
                                    {{ \Carbon\Carbon::parse($role->created_at)->format('d M, Y') }}
                                </td>

                                <td class="px-4 py-2 border space-x-2">

                                
                                        <a href="{{ route('role.edit', $role->id) }}"
                                           class="inline-flex items-center px-2 py-1 bg-gray-500 text-white rounded text-xs hover:bg-gray-600 mr-3">
                                           <i class="bi bi-pencil"></i>
<span class="ml-1">Edit</span>
                                        </a>    
                                  
                                        <form action="{{ route('role.delete', $role->id) }}"
                                              method="POST"
                                              class="inline">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    onclick="return confirm('Delete this role?')"
                                                    class="inline-flex items-center px-2 py-1 bg-gray-600 text-white rounded text-xs hover:bg-gray-700">
                                                <i class="bi bi-trash"></i>
                                                <span class="ml-1">Delete</span>
                                            </button>
                                        </form>
                               

                                </td>
                            </tr>
                        @endforeach

                        @if($roles->isEmpty())
                            <tr>
                                <td colspan="4" class="px-4 py-4 text-center text-gray-500">
                                    No roles found.
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Permissions') }}
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
                    <h3 class="text-lg font-semibold">Permissions</h3>

                    @can('create permissions')
                        <a href="{{ route('permission.create') }}"
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">
                            Create Permission
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
                        @forelse($permissions as $permission)

                            @if($permission->name !== 'permission')
                                <tr class="border-t">

                                    <td class="px-4 py-2 border">
                                        {{ $permission->id }}
                                    </td>

                                    <td class="px-4 py-2 border">
                                        {{ $permission->name }}
                                    </td>

                                    <td class="px-4 py-2 border">
                                        {{ \Carbon\Carbon::parse($permission->created_at)->format('d M, Y') }}
                                    </td>

                                    <td class="px-4 py-2 border space-x-2">

                                    
                                           <a href="{{ route('permission.edit', $permission->id) }}"
   class="inline-flex items-center px-2 py-1 bg-black text-white rounded text-xs hover:bg-gray-800 mr-3">
    <i class="bi bi-pencil"></i>
    <span class="ml-1">Edit</span>
</a>

           
                                            <form action="{{ route('permission.delete', $permission->id) }}"
                                                  method="POST"
                                                  class="inline">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        onclick="return confirm('Delete this permission?')"
                                                        class="inline-flex items-center px-2 py-1 bg-black text-white rounded text-xs hover:bg-gray-800 mr-3">
                                                    <i class="bi bi-trash"></i>
                                                    <span class="ml-1">Delete</span>
                                                </button>
                                            </form>
                               

                                    </td>
                                </tr>
                            @endif

                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-4 text-center text-gray-500">
                                    No permissions found.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>

                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
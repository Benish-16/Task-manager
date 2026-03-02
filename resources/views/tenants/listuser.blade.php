<x-app-layout>
    <x-slot name="header">
        <div class='flex justify-between items-center'>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Users') }}
            </h2>
            @can('create user')
                <a href="{{ route('tenants.register') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-md text-sm hover:bg-gray-700">
                    Create User
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-12">

          

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200">
                        <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border">ID</th>
                            <th class="px-4 py-2 border">Name</th>
                            <th class="px-4 py-2 border">Email</th>
                            <th class="px-4 py-2 border">Created</th>
                            <th class="px-4 py-2 border">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr class="border-t">
                                <td class="px-4 py-2 border">{{ $user->id }}</td>
                                <td class="px-4 py-2 border">{{ $user->name }}</td>
                                <td class="px-4 py-2 border">{{ $user->email }}</td>
                                <td class="px-4 py-2 border">{{ $user->created_at->format('d M, Y') }}</td>
                                <td class="px-4 py-2 border space-x-2">

                                    @can('edit user')
                                        <a href="{{ route('users.edit', $user->id) }}"
                                           class="inline-flex items-center px-2 py-1 bg-gray-500 text-white rounded text-xs hover:bg-gray-600">
                                            Edit
                                        </a>
                                    @endcan

                                    @can('delete user')
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    onclick="return confirm('Are you sure you want to delete this user?')"
                                                    class="inline-flex items-center px-2 py-1 bg-gray-600 text-white rounded text-xs hover:bg-gray-700">
                                                Delete
                                            </button>
                                        </form>
                                    @endcan

                                </td>
                            </tr>
                        @endforeach

                        @if($users->isEmpty())
                            <tr>
                                <td colspan="5" class="px-4 py-4 text-center text-gray-500">
                                    No users found.
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>

                    <!-- Pagination links -->
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
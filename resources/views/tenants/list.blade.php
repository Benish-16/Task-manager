<x-app-layout>
    <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight"> {{ __('Tenants') }} </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-3">

           
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

             
               <div class="flex justify-between items-center mb-4"> <h3 class="text-lg font-semibold">Tenants</h3> <a href="{{ route('tenants.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-md text-sm hover:bg-gray-700"> Create Tenant </a> </div>

             
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200">
                        <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border text-left text-xs font-medium text-gray-700 uppercase">ID</th>
                            <th class="px-4 py-2 border text-left text-xs font-medium text-gray-700 uppercase">Name</th>
                            <th class="px-4 py-2 border text-left text-xs font-medium text-gray-700 uppercase">Domain</th>
                            <th class="px-4 py-2 border text-left text-xs font-medium text-gray-700 uppercase">Email</th>
                            <th class="px-4 py-2 border text-left text-xs font-medium text-gray-700 uppercase">Number of Users</th>
                            <th class="px-4 py-2 border text-left text-xs font-medium text-gray-700 uppercase">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tenants as $tenant)
                            <tr class="border-t">
                                <td class="px-4 py-2 border">{{ $tenant->id }}</td>
                                <td class="px-4 py-2 border">{{ $tenant->name }}</td>
                                <td class="px-4 py-2 border">
                                    @foreach($tenant->domains as $domain)
                                        {{ $domain->domain }}{{ $loop->last ? '' : ', ' }}
                                    @endforeach
                                </td>
                                <td class="px-4 py-2 border">{{ $tenant->email }}</td>
                                <td class="px-4 py-2 border">{{ $tenant->users_count ?? $tenant->users->count() }}</td>
                                <td class="px-4 py-2 border flex flex-wrap gap-1">
                                    <a href="{{ route('tenants.edit', $tenant->id) }}"
                                       class="inline-flex items-center px-2 py-1 bg-gray-500 text-white rounded text-xs hover:bg-gray-600">
                                        Edit
                                    </a>

                                    <form action="{{ route('tenants.destroy', $tenant) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                onclick="return confirm('Delete this tenant?')"
                                                class="inline-flex items-center px-2 py-1 bg-gray-600 text-white rounded text-xs hover:bg-gray-700">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                        @if($tenants->isEmpty())
                            <tr>
                                <td colspan="6" class="px-4 py-4 text-center text-gray-500">
                                    No tenants found.
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
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tasks') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

          

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Tasks</h3>

                    @can('create tasks')
                        <a href="{{ route('tasks.create') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-md text-sm hover:bg-gray-700">
                            Create Task
                        </a>
                    @endcan
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200">
                        <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border">Title</th>
                            <th class="px-4 py-2 border">Description</th>
                            <th class="px-4 py-2 border">Assigned To</th>
                                 <th class="px-4 py-2 border">Assigned By</th>
                            <th class="px-4 py-2 border">Status</th>
                            <th class="px-4 py-2 border">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tasks as $task)
                            <tr class="border-t">
                                <td class="px-4 py-2 border">{{ $task->title }}</td>
                                <td class="px-4 py-2 border">{{ $task->description }}</td>
                                <td class="px-4 py-2 border">
                                    {{ $task->assignedUser->name ?? 'N/A' }}
                                </td>
                                  <td class="px-4 py-2 border">
                                   {{ $task->creator->name ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-2 border">
                                    {{ ucfirst($task->status) }}
                                </td>
                                <td class="px-4 py-2 border space-x-2">

                                 
                                        <a href="{{ route('tasks.edit', $task->id) }}"
                                           class="inline-flex items-center px-2 py-1 bg-gray-500 text-white rounded text-xs hover:bg-gray-600">
                                            Edit
                                        </a>
                                

                                    @can('task delete')
                                        <form action="{{ route('tasks.destroy', $task) }}"
                                              method="POST"
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    onclick="return confirm('Delete this task?')"
                                                    class="inline-flex items-center px-2 py-1 bg-gray-600 text-white rounded text-xs hover:bg-gray-700">
                                                Delete
                                            </button>
                                        </form>
                                    @endcan

                                </td>
                            </tr>
                        @endforeach

                        @if($tasks->isEmpty())
                            <tr>
                                <td colspan="5" class="px-4 py-4 text-center text-gray-500">
                                    No tasks found.
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
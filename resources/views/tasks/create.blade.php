<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Task
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                <form action="{{ route('tasks.store') }}" method="POST" class="space-y-6">
                    @csrf

                 
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" name="title" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                                      focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" rows="4"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                                         focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    </div>

                
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Assign To</label>
                        <select name="assigned_to" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                                       focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Select user</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

             
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                                       focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="pending">Pending</option>
                            <option value="in_progress">In Progress</option>
                           
                        </select>
                    </div>

                 
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Priority</label>
                        <select name="priority" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                                       focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="low">Low</option>
                            <option value="medium" selected>Medium</option>
                            <option value="high">High</option>
                        </select>
                    </div>

               
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Due Date</label>
                        <input type="datetime-local" name="due_date"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                                      focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                
                    <input type="hidden" name="created_by" value="{{ auth()->id() }}">

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('tasks.index') }}"
                           class="px-4 py-2 text-sm rounded-md border border-gray-300
                                  text-gray-700 hover:bg-gray-100">
                            Cancel
                        </a>

                        <button type="submit"
                                class="px-5 py-2 text-sm font-medium text-white
                                       bg-indigo-600 rounded-md hover:bg-indigo-700">
                            Save Task
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
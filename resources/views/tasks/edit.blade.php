<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Task
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                

               <form action="{{ route('tasks.update', $task) }}"
      method="POST"
      class="space-y-6">

    @csrf
    @method('PUT')

    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 rounded-lg">
            <tbody class="divide-y divide-gray-200">

                <tr>
                    <td class="px-4 py-3 text-sm font-medium text-gray-700 w-1/3">
                        Title
                    </td>
                    <td class="px-4 py-3">
                        <input
                            type="text"
                            name="title"
                            value="{{ old('title', $task->title) }}"
                            required
                            class="w-full rounded-md border-gray-300 shadow-sm
                                   focus:border-indigo-500 focus:ring-indigo-500"
                        >
                    </td>
                </tr>

              
                <tr>
                    <td class="px-4 py-3 text-sm font-medium text-gray-700 align-top">
                        Description
                    </td>
                    <td class="px-4 py-3">
                        <textarea
                            name="description"
                            rows="4"
                            class="w-full rounded-md border-gray-300 shadow-sm
                                   focus:border-indigo-500 focus:ring-indigo-500"
                        >{{ old('description', $task->description) }}</textarea>
                    </td>
                </tr>

          
                <tr>
                    <td class="px-4 py-3 text-sm font-medium text-gray-700">
                        Assign To
                    </td>
                    <td class="px-4 py-3">
                        <select
                            name="assigned_to"
                            required
                            class="w-full rounded-md border-gray-300 shadow-sm
                                   focus:border-indigo-500 focus:ring-indigo-500"
                        >
                            <option value="">Select user</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ old('assigned_to', $task->assigned_to) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                </tr>

          <tr>
    <td class="px-4 py-3 text-sm font-medium text-gray-700">
        Status
    </td>

    <td class="px-4 py-3">
        <select
            name="status"
            required
            class="w-full rounded-md border-gray-300 shadow-sm
                   focus:border-indigo-500 focus:ring-indigo-500"
        >
            <option value="pending"
                {{ old('status', $task->status) == 'pending' ? 'selected' : '' }}>
                Pending
            </option>

            <option value="in_progress"
                {{ old('status', $task->status) == 'in_progress' ? 'selected' : '' }}>
                In Progress
            </option>

            <option value="completed"
                {{ old('status', $task->status) == 'completed' ? 'selected' : '' }}>
                Completed
            </option>
        </select>
    </td>
</tr>
 
<tr>
    <td class="px-4 py-3 text-sm font-medium text-gray-700">
        Priority
    </td>
    <td class="px-4 py-3">
        <select
            name="priority"
            required
            class="w-full rounded-md border-gray-300 shadow-sm
                   focus:border-indigo-500 focus:ring-indigo-500"
        >
            <option value="high"
                {{ old('priority', $task->priority) == 'high' ? 'selected' : '' }}>
                High
            </option>

            <option value="medium"
                {{ old('priority', $task->priority) == 'medium' ? 'selected' : '' }}>
                Medium
            </option>

            <option value="low"
                {{ old('priority', $task->priority) == 'low' ? 'selected' : '' }}>
                Low
            </option>
        </select>
    </td>
</tr>
   <tr>
    <td class="px-4 py-3 text-sm font-medium text-gray-700">
        Due Date
    </td>
    <td class="px-4 py-3">
        <input
            type="date"
            name="due_date"
            value="{{ old('due_date', $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') : '') }}"
            class="w-full rounded-md border-gray-300 shadow-sm
                   focus:border-indigo-500 focus:ring-indigo-500"
        >
    </td>
</tr>
                </tr>

            </tbody>
        </table>
    </div>

    <div class="flex justify-end gap-3 pt-4">
        <a href="{{ route('tasks.index') }}"
           class="px-4 py-2 text-sm rounded-md border border-gray-300
                  text-gray-700 hover:bg-gray-100">
            Cancel
        </a>

        <button
            type="submit"
            class="px-5 py-2 text-sm font-medium text-white
                   bg-indigo-600 rounded-md hover:bg-indigo-700">
            Update Task
        </button>
    </div>

</form>
               
           

            </div>
        </div>
    </div>
</x-app-layout>
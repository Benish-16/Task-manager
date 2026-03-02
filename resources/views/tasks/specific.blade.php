<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 py-8">

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-800">
                Your Tasks
            </h1>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">

            @forelse($tasks ?? collect() as $task)

                @php
                    $isDueToday =
                        $task->due_date &&
                        \Carbon\Carbon::parse($task->due_date)->isToday() &&
                        $task->status !== 'completed';
                @endphp

                <div
                    class="
                        bg-white rounded-2xl shadow-sm p-5 transition
                        hover:shadow-md
                        border
                        {{ $isDueToday ? 'ring-2 ring-red-400 animate-pulse' : 'border-gray-100' }}
                    "
                >

             
                    <div class="flex items-start justify-between mb-2">
                        <h3 class="text-lg font-semibold text-gray-800 leading-tight">
                            {{ $task->title }}
                        </h3>

                        <span
                            class="text-xs font-semibold px-3 py-1 rounded-full
                                @if($task->status === 'completed')
                                    bg-green-100 text-green-700
                                @elseif($task->status === 'in_progress')
                                    bg-yellow-100 text-yellow-700
                                @else
                                    bg-gray-200 text-gray-700
                                @endif
                            "
                        >
                            {{ (str_replace('_',' ',$task->status)) }}
                        </span>
                    </div>

             
                    @if($isDueToday)
                        <div class="mb-2 text-xs font-semibold text-red-600 flex items-center gap-1">
                        <i class="bi bi-exclamation-triangle-fill text-red-600"></i>Due today , please complete this task
                        </div>
                    @endif

         
                    <p class="text-sm text-gray-600 mb-4 line-clamp-3">
                        {{ $task->description ?? 'No description provided.' }}
                    </p>

               
                    <div class="space-y-2 text-xs text-gray-500">

                     
                        <div>
                            <span class="font-semibold text-gray-600">Assigned by:</span>
                            {{ $task->creator->name ?? 'N/A' }}
                        </div>

                   
                        <div class="flex items-center gap-2">
                            <span class="font-semibold text-gray-600">Due:</span>

                            @if($task->due_date)
                                <span
                                    class="
                                        px-2 py-0.5 rounded-full font-semibold
                                        @if(\Carbon\Carbon::parse($task->due_date)->isPast() && $task->status !== 'completed')
                                            bg-red-100 text-red-700
                                        @elseif(\Carbon\Carbon::parse($task->due_date)->isToday())
                                            bg-orange-100 text-orange-700
                                        @else
                                            bg-blue-100 text-blue-700
                                        @endif
                                    "
                                >
                                    {{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}
                                </span>
                            @else
                                <span>N/A</span>
                            @endif
                        </div>

                  
                        <div class="flex items-center gap-2">
                            <span class="font-semibold text-gray-600">Priority:</span>

                            <span
                                class="
                                    px-2 py-0.5 rounded-full font-semibold
                                    @if($task->priority === 'high')
                                        bg-red-100 text-red-700
                                    @elseif($task->priority === 'medium')
                                        bg-yellow-100 text-yellow-700
                                    @else
                                        bg-green-100 text-green-700
                                    @endif
                                "
                            >
                                {{ ucfirst($task->priority) }}
                            </span>
                        </div>
                    </div>

             
                    <div class="flex items-center justify-between mt-4 pt-3 border-t">

                        <div class="text-xs text-gray-400">
                            {{ $task->created_at?->format('d M Y') }}
                        </div>

                        <div class="flex items-center gap-2">

                            <form
                                method="POST"
                                action="{{ route('employee.tasks.updateStatus', $task->id) }}"
                            >
                                @csrf
                                @method('PATCH')

                                <select
                                    name="status"
                                    onchange="this.form.submit()"
                                    class="text-xs rounded-lg border-gray-300 focus:ring-1 focus:ring-blue-400 focus:border-blue-400"
                                    @if($task->status === 'completed') disabled @endif
                                >
                                    <option value="pending" @selected($task->status === 'pending')>
                                        Pending
                                    </option>
                                    <option value="in_progress" @selected($task->status === 'in_progress')>
                                        In progress
                                    </option>
                                    <option value="completed" @selected($task->status === 'completed')>
                                        Completed
                                    </option>
                                </select>
                            </form>

                            <a
                                href="{{ route('tasks.print', $task->id) }}"
                                class="px-2 py-1 bg-indigo-500 text-white rounded text-xs hover:bg-indigo-600"
                            >
                                Print PDF
                            </a>

                        </div>
                    </div>

                </div>

            @empty

                <div class="col-span-full text-center py-12">
                    <p class="text-gray-400 text-sm">
                        No tasks assigned to you yet.
                    </p>
                </div>

            @endforelse

        </div>
    </div>
</x-app-layout>
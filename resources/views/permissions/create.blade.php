<x-app-layout>
    <x-slot name="header">
        <div class='flex justify-between'>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              Permissions/Create
            </h2>
            
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
             
                    
                    <form action="{{ route('permission.store') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label class="block mb-1 text-lg">Name</label>
                            <input type="text" value="{{ old('name') }}" name='name' class="border-gray-300 shadow-sm w-1/2 rounded-lg" placeholder="Bonnie Green">
                        </div>
                        @error('name')
                        <p class="text-red-400 font-medium">{{ $message }}</p>
                        @enderror
                   
                        <button class="bg-slate-600 text-sm rounded-md px-5 py-3 text-white">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

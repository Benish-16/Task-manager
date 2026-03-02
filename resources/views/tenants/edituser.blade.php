<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

           

                <form action="{{ route('users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                   
                    <div class="mb-4">
                        <x-input-label  for="name" :value="__('Name')" />
                        <input  id="name" class="block mt-1 w-full" type="text" name="name"
                                 value="{{ old('name', $user->name) }}" required autofocus />
                        @error('name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                @php
    $currentRole = $user->getRoleNames()->first();
@endphp

                    <div class="mb-4">
                        <x-input-label  for="role" :value="__('Role')" />
                   <select id="role" name="role"
        class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">

    @foreach($roles as $role)
        <option value="{{ $role->name }}"
              {{ $currentRole === $role->name ? 'selected' : '' }}>
            {{ $role->name }}
        </option>
    @endforeach

</select>

                        @error('role')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

              
                    <div class="flex items-center justify-end mt-6">
                      <x-primary-button class="ml-4" type="submit">
    {{ __('Update User') }}
</x-primary-button>

                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>

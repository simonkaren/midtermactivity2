<div class="flex p-10 items-center flex-col">
    <h1 class="text-3xl mb-2">USER</h1>

    @if (session()->has('message'))
        <div class="alert alert-success bg-green-500 text-white mb-4">
            {{session('message')}}
        </div>
    @endif

    <div>
    <div class="flex flex-col items-center">

<!-- Name Input Field -->
<div class="mt-6 w-full max-w-xs">
    <input wire:model.live="name" placeholder="Enter your name" type="text" id="default-input"
        class="bg-gray-50 border @error('name') border-red-500 @enderror border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 text-center w-full">
</div>
<div>
    @error('name')
    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
    @enderror
</div>

<!-- Email Input Field -->
<div class="mt-6 w-full max-w-xs">
    <input wire:model.live="email" placeholder="Enter email" type="text" id="default-input"
        class="bg-gray-50 border @error('email') border-red-500 @enderror border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 text-center w-full">
</div>
<div>
    @error('email')
    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
    @enderror
</div>

<!-- Password Input Field -->
<div class="mt-6 w-full max-w-xs">
    <input wire:model.live="password" placeholder="Password" type="password" id="default-input"
        class="bg-gray-50 border @error('password') border-red-500 @enderror border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 text-center w-full">
</div>
<div>
    @error('password')
    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
    @enderror
</div>

<!-- Submit Button -->
<div class="mt-6 w-full max-w-xs">
    <button type="button" wire:click="submit"
        class="w-full text-blue-600 border border-blue-600 hover:bg-blue-100 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
        Register
    </button>
</div>
</div>

        <div class="mt-8 p-10">
    <h2 class="text-2x1 font-semibold mb-4">Registered Users</h2>

    <table class="min-w-full bg-white border border-gray-200">
        <thead>
            <tr>
                <th class="py-2 px-4 text-left text-gray-900">Name</th>
                <th class="py-2 px-4 text-left text-gray-900">Email</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td class="py-2 px-4 border-t border-gray-200">{{ $user->name }}</td>
                    <td class="py-2 px-4 border-t border-gray-200">{{ $user->email }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

    </div>
</div>

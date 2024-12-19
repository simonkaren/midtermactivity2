<div class="flex p-10 items-center flex-col bg-gray-50 rounded-lg shadow-md">

    <h1 class="text-4xl font-semibold text-gray-800 mb-6">User</h1>

    @if (session()->has('message'))
        <div class="alert alert-success bg-green-500 text-white mb-4 rounded-lg px-4 py-2">
            {{ session('message') }}
        </div>
    @endif

    <!-- Input Fields for Name, Email, and Password -->
    <div class="w-full sm:w-1/2 mt-6">
        <input wire:model="name" type="text" id="name" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 shadow-sm" placeholder="Name" required />
        @error('name') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
    </div>

    <div class="w-full sm:w-1/2 mt-6">
        <input wire:model="email" type="text" id="email" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 shadow-sm" placeholder="Email" required />
        @error('email') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
    </div>

    <div class="w-full sm:w-1/2 mt-6">
        <input wire:model="password" type="password" id="password" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 shadow-sm" placeholder="Password" required />
        @error('password') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
    </div>

    <!-- Submit Button -->
    <div class="mt-6 w-full sm:w-auto">
        <button wire:loading.remove type="submit" wire:click="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-6 py-3 transition duration-200 transform hover:scale-105">
            Submit
        </button>

        <!-- Loading Spinner -->
        <div wire:loading wire:target="submit" class="mt-2 text-center">
            <svg aria-hidden="true" class="inline w-8 h-8 text-gray-200 animate-spin fill-yellow-400" viewBox="0 0 100 101" xmlns="http://www.w3.org/2000/svg">
                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
            </svg>
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <!-- Table and Pagination Section -->
    <div class="mt-8 w-full">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Registered Users</h2>
        <div class="overflow-x-auto bg-white rounded-lg shadow-md">
            <table class="w-full bg-white border border-gray-200">
                <thead>
                    <tr class="text-left bg-gray-100">
                        <th class="py-3 px-4 text-gray-700">Name</th>
                        <th class="py-3 px-4 text-gray-700">Email</th>
                        <th class="py-3 px-4 text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="py-2 px-4 border-t border-gray-200">{{ $user->name }}</td>
                            <td class="py-2 px-4 border-t border-gray-200">{{ $user->email }}</td>
                            <td class="py-2 px-4 border-t border-gray-200 text-right space-x-2">
                                <button wire:click="editUser({{ $user->id }})" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2">Update</button>
                                <button wire:click="confirmDelete({{ $user->id }})" class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4 text-left">
            {{ $users->links() }}
        </div>
    </div>

    <!-- Edit User Modal -->
    @if($isEditModalOpen)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <h3 class="text-lg font-medium text-gray-900 text-center">Edit User</h3>
                <div class="mt-4">
                    <input wire:model="editName" type="text" placeholder="Name" class="mb-3 px-3 py-2 border rounded-md w-full">
                    @error('editName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    
                    <input wire:model="editEmail" type="email" placeholder="Email" class="mb-3 px-3 py-2 border rounded-md w-full">
                    @error('editEmail') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="flex justify-center items-center space-x-4 mt-4">
                    <button wire:click="updateUser" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700 focus:outline-none">Update</button>
                    <button wire:click="closeEditModal" class="px-4 py-2 bg-gray-200 text-black rounded-md hover:bg-gray-300 focus:outline-none">Cancel</button>
                </div>
            </div>
        </div>
    @endif

    <!-- Delete User Modal -->
    @if($isDeleteModalOpen)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <h3 class="text-lg font-medium text-gray-900 text-center">Confirm Delete</h3>
                <p class="text-sm text-gray-500 mt-2 text-center">Are you sure you want to delete this user? This action cannot be undone.</p>
                <div class="flex justify-center items-center space-x-4 mt-6">
                    <button wire:click="deleteUser" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none">Delete</button>
                    <button wire:click="$set('isDeleteModalOpen', false)" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none">Cancel</button>
                </div>
            </div>
        </div>
    @endif

</div>
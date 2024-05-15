<div class="bg-gray-400 p-4 rounded-lg mt-4 mb-4 flex justify-center hidden custom:block">
    <table class="table table-striped w-full table-hover mt-4 mb-4 p-4 border-blue-300 rounded-lg">
        <thead>
            <tr class="bg-indigo-600 text-white">
                <th class="px-4 py-2">{{ __('messages.name') }}</th>
                <th class="px-4 py-2">{{ __('messages.email') }}</th>
                <th class="px-4 py-2">{{ __('messages.is_admin') }}</th>
                <th class="px-4 py-2">{{ __('messages.password') }}</th>
                <th class="px-4 py-2">{{ __('messages.delete') }}</th>
            </tr>
        </thead>
        <tbody class="bg-white border-blue-300">
            @foreach ($users as $user)
            @if (auth()->user()->id == $user->id)
            @continue
            @endif
            <tr>
                <td class="border px-4 py-2">
                    <form method="POST" action="{{ route('user.updateName', $user) }}">
                        @csrf
                        <div class="flex flex-row">
                            <input type="text" id="name" name="name" class="w-full px-4 py-2 rounded-lg border-blue-300 focus:border-indigo-600 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ $user->name }}" required>
                            <button type="submit" class="px-4 py-2 mx-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-600">{{ __('messages.update') }}</button>
                        </div>
                    </form>
                </td>
                <td class="border px-4 py-2">{{ $user->email }}</td>
                <td class="border px-4 py-2 text-center">
                    <form method="POST" action="{{ route('user.update', $user) }}">
                        @csrf
                        <input type="checkbox" name="admin" {{ $user->admin == 1 ? 'checked' : '' }} onchange="this.form.submit()" class="form-checkbox h-5 w-5 text-indigo-600 mt-3 ml-1 p-2 rounded">
                    </form>
                </td>
                <td class="border px-4 py-2">
                    <form method="POST" action="{{ route('user.updatePassword', $user) }}" class="my-4">
                        @csrf
                        <div>
                            <div class="flex flex-row">
                                <input type="password" id="password" name="password" placeholder="{{ __('messages.enter_new_password') }}" class="mt-1 block w-full rounded-md border-blue-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-100" required>
                                <button type="submit" class="px-4 py-2 mx-2 rounded-md text-white bg-indigo-600 mt-1  hover:bg-indigo-600">{{ __('messages.submit') }}</button>
                            </div>
                        </div>
                    </form>
                </td>
                <td class="border px-4 py-2">
                    <form method="POST" action="{{ route('user.delete', $user) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 text-white bg-red-500 rounded hover:bg-red-600">{{ __('messages.delete') }}</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


<!-- Mobileview -->
<div class="grid grid-cols-1 gap-4 px-4 py-6 sm:px-6 lg:px-8 custom:hidden">
    @foreach ($users as $user)
        @if (auth()->user()->id != $user->id)
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="p-4">
                    <form method="POST" action="{{ route('user.updateName', $user) }}">
                        @csrf
                        <div class="mb-2">
                            <label class="block text-sm font-medium text-gray-700">{{ __('messages.name') }}:</label>
                            <div class="flex items-center space-x-2">
                                <input type="text" name="name" class="flex-grow block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" value="{{ $user->name }}" required>
                                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Update</button>
                            </div>
                        </div>
                    </form>
                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700">Email:</label>
                        <p>{{ $user->email }}</p>
                    </div>
                    <form method="POST" action="{{ route('user.update', $user) }}">
                        @csrf
                        <div class="mb-2">
                            <label class="flex items-center space-x-2">
                                <span class="text-sm font-medium text-gray-700">{{ __('messages.is_admin') }}:</span>
                                <input type="checkbox" name="admin" class="form-checkbox h-5 w-5 text-indigo-600" {{ $user->admin ? 'checked' : '' }} onchange="this.form.submit()">
                            </label>
                        </div>
                    </form>
                    <form method="POST" action="{{ route('user.updatePassword', $user) }}">
                        @csrf
                        <div class="mb-2">
                            <label class="block text-sm font-medium text-gray-700">{{ __('messages.password') }}:</label>
                            <div class="flex items-center space-x-2">
                                <input type="password" name="password" placeholder="New password" class="flex-grow block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" required>
                                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Submit</button>
                            </div>
                        </div>
                    </form>
                    <form method="POST" action="{{ route('user.delete', $user) }}">
                        @csrf
                        @method('DELETE')
                        <div class="flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">{{ __('messages.delete') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    @endforeach
</div>



<div class="bg-gray-400 p-4 rounded-lg mt-4 mb-4">
    <h3 class="text-xl font-bold mb-4 text-gray-100">{{ __('messages.createNewUser') }}</h3>
    <form method="POST" action="{{ route('admin.create') }}">
        @csrf
        <div class="mb-4">
            <label for="name" class="text-gray-100">{{ __('messages.name') }}</label>
            <input type="text" id="name" name="name" class="w-full px-4 py-2 rounded-lg border-blue-300 focus:border-indigo-600 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
        </div>
        <div class="mb-4">
            <label for="email" class="text-gray-100">Email</label>
            <input type="email" id="email" name="email" class="w-full px-4 py-2 rounded-lg border-blue-300 focus:border-indigo-600 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
        </div>
        <div class="mb-4">
            <label for="password" class="text-gray-100">{{ __('messages.password') }}</label>
            <input type="password" id="password" name="password" class="w-full px-4 py-2 rounded-lg border-blue-300 focus:border-indigo-600 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
        </div>
        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-600">{{ __('messages.createUser') }}</button>
    </form>
</div>
</div>

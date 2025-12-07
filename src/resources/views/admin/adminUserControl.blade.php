<div class="my-2 overflow-x-auto w-full hidden custom:block">
    <div class="py-2 align-middle inline-block min-w-full">
        <div class="shadow-lg overflow-hidden border-b border-gray-200 sm:rounded-lg bg-zinc-100">
            <table class="table min-w-full divide-y divide-gray-200 mb-2">
                <thead class="imp_bg_white p-2">
                    <tr>
                        <th
                            class="px-6 py-4 text-left text-m font-medium text-gray-800 uppercase tracking-wider align-middle">
                            {{ __('messages.name') }}
                        </th>
                        <th
                            class="px-6 py-4 text-left text-m font-medium text-gray-800 uppercase tracking-wider align-middle">
                            {{ __('messages.email') }}
                        </th>
                        <th
                            class="px-6 py-4 text-m font-medium text-gray-800 uppercase tracking-wider text-center align-middle">
                            {{ __('messages.is_admin') }}
                        </th>
                        <th
                            class="px-6 py-4 text-left text-m font-medium text-gray-800 uppercase tracking-wider align-middle">
                            {{ __('messages.password') }}
                        </th>
                        <th
                            class="px-6 py-4 text-m font-medium text-gray-800 uppercase tracking-wider text-center align-middle">
                            {{ __('messages.delete') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($users as $user)
                        @if (auth()->user()->id == $user->id)
                            @continue
                        @endif
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap align-middle">
                                <form method="POST" action="{{ route('user.updateName', $user) }}">
                                    @csrf
                                    <div class="flex flex-row items-center">
                                        <input type="text" id="name" name="name"
                                            class="w-full px-4 py-2 rounded-lg border-blue-300 focus:border-emerald-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                            value="{{ $user->name }}" required>
                                        <button type="submit"
                                            class="inline-flex items-center justify-center h-9 w-9 bg-emerald-500 text-white rounded-md hover:bg-emerald-600 mx-2"
                                            title="Update">
                                            @svg('mdi-pencil', 'w-5 h-5 text-white')
                                        </button>
                                    </div>
                                </form>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap align-middle">{{ $user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center align-middle">
                                <form method="POST" action="{{ route('user.update', $user) }}">
                                    @csrf
                                    <input type="checkbox" name="admin" {{ $user->admin == 1 ? 'checked' : '' }}
                                        onchange="this.form.submit()"
                                        class="form-checkbox h-5 w-5 text-indigo-600 mt-3 ml-1 p-2 rounded cursor-pointer hover:bg-indigo-100">
                                </form>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap align-middle">
                                <form method="POST" action="{{ route('user.updatePassword', $user) }}" class="my-4">
                                    @csrf
                                    <div>
                                        <div class="flex flex-row items-center">
                                            <input type="password" id="password" name="password"
                                                placeholder="{{ __('messages.enter_new_password') }}"
                                                class="block w-full rounded-md border-blue-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-100"
                                                required>
                                            <button type="submit"
                                                class="inline-flex items-center justify-center h-9 w-9 rounded-md text-white bg-indigo-600 hover:bg-indigo-600 mx-2"
                                                title="Submit">
                                                @svg('mdi-check', 'w-5 h-5 text-white')
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center align-middle">
                                <form method="POST" action="{{ route('user.delete', $user) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center justify-center h-9 w-9 bg-rose-500 rounded-md hover:bg-rose-600 mx-auto"
                                        title="Delete">
                                        @svg('mdi-delete-forever-outline', 'w-5 h-5 text-white')
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Mobileview -->
<div class="grid grid-cols-1 gap-4 px-4 py-6 sm:px-6 lg:px-8 custom:hidden">
    @foreach ($users as $user)
        @if (auth()->user()->id != $user->id)
            <div class="bg-zinc-100 rounded-lg shadow overflow-hidden">
                <div class="p-4">
                    <form method="POST" action="{{ route('user.updateName', $user) }}">
                        @csrf
                        <div class="mb-2">
                            <label class="block text-sm font-medium text-gray-700">{{ __('messages.name') }}:</label>
                            <div class="flex items-center">
                                <input type="text" name="name"
                                    class="flex-grow block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-500 focus:ring-opacity-50"
                                    value="{{ $user->name }}" required>
                                <button type="submit"
                                    class="inline-flex items-center justify-center h-9 w-9 bg-emerald-500 text-white rounded-md hover:bg-emerald-600 mx-2"
                                    title="Update">
                                    @svg('mdi-pencil', 'w-5 h-5 text-white')
                                </button>
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
                                <input type="checkbox" name="admin"
                                    class="form-checkbox h-5 w-5 text-indigo-600 cursor-pointer hover:bg-indigo-100"
                                    {{ $user->admin ? 'checked' : '' }} onchange="this.form.submit()">
                            </label>
                        </div>
                    </form>
                    <form method="POST" action="{{ route('user.updatePassword', $user) }}">
                        @csrf
                        <div class="mb-2">
                            <label
                                class="block text-sm font-medium text-gray-700">{{ __('messages.password') }}:</label>
                            <div class="flex items-center">
                                <input type="password" name="password" placeholder="New password"
                                    class="flex-grow block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                                    required>
                                <button type="submit"
                                    class="inline-flex items-center justify-center h-9 w-9 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 mx-2"
                                    title="Submit">
                                    @svg('mdi-check', 'w-5 h-5 text-white')
                                </button>
                            </div>
                        </div>
                    </form>
                    <form method="POST" action="{{ route('user.delete', $user) }}">
                        @csrf
                        @method('DELETE')
                        <div class="flex flex-row gap-2 items-center">
                            <button type="submit"
                                class="inline-flex items-center justify-center h-9 w-9 bg-rose-500 text-white rounded-md hover:bg-rose-600"
                                title="Delete">
                                @svg('mdi-delete-forever-outline', 'w-5 h-5 text-white')
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    @endforeach

    <div class="bg-zinc-100 rounded-lg shadow overflow-hidden">
        <div class="p-4">
            <h3 class="text-xl font-bold text-black mb-4">{{ __('messages.createNewUser') }}</h3>
            <form method="POST" action="{{ route('admin.create') }}">
                @csrf
                <div class="mb-4">
                    <label for="name"
                        class="block text-sm font-medium text-gray-700">{{ __('messages.name') }}</label>
                    <input type="text" id="name" name="name"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                        required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                        required>
                </div>
                <div class="mb-4">
                    <label for="password"
                        class="block text-sm font-medium text-gray-700">{{ __('messages.password') }}</label>
                    <input type="password" id="password" name="password"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                        required>
                </div>
                <button type="submit"
                    class="px-4 py-2 bg-indigo-500 text-white rounded-md hover:bg-indigo-600 flex items-center justify-center">
                    @svg('mdi-plus', 'w-5 h-5 m-0.5 text-gray-100')
                    <span>{{ __('messages.createUser') }}</span>
                </button>
            </form>
        </div>
    </div>
</div>

<div class="my-2 w-full hidden custom:block">
    <div class="py-2 align-middle w-full">
        <div class="imp_bg_white w-full px-4 py-2 rounded-t-lg">
            <h3 class="text-xl font-bold text-black">{{ __('messages.createNewUser') }}</h3>
        </div>
        <div class="shadow-lg overflow-hidden border-b border-gray-200 sm:rounded-lg bg-zinc-100 rounded-b-lg">
            <div class="bg-white mb-2">
                <div class="px-4">
                    <form method="POST" action="{{ route('admin.create') }}">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="text-black">{{ __('messages.name') }}</label>
                            <input type="text" id="name" name="name"
                                class="w-full px-4 py-2 rounded-lg border-blue-300 focus:border-indigo-600 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                required>
                        </div>
                        <div class="mb-4">
                            <label for="email" class="text-black">Email</label>
                            <input type="email" id="email" name="email"
                                class="w-full px-4 py-2 rounded-lg border-blue-300 focus:border-indigo-600 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                required>
                        </div>
                        <div class="mb-4">
                            <label for="password" class="text-black">{{ __('messages.password') }}</label>
                            <input type="password" id="password" name="password"
                                class="w-full px-4 py-2 rounded-lg border-blue-300 focus:border-indigo-600 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                required>
                        </div>
                        <button type="submit"
                            class="px-4 py-2 bg-indigo-500 text-white rounded-md hover:bg-indigo-600 flex items-center justify-center">
                            @svg('mdi-plus', 'w-5 h-5 m-0.5 text-gray-100')
                            <span>{{ __('messages.createUser') }}</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!--
    TODO:
    @Bruchac @Jakub
    Vsetky style="color:black" musia ist prec a nahradit ich tailwindom tak aby to aj fungovalo
    A ostatne uz necham na vas nech to nejak vyzera
-->
<div class="bg-gray-400 p-4 rounded-lg mt-4 mb-4 flex justify-center">
    <table class="table table-striped table-hover mt-4 mb-4 p-4 border-blue-300 rounded-lg">
        <thead>
            <tr class="bg-indigo-600 text-white">
                <th class="px-4 py-2">Name</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Is Admin</th>
                <th class="px-4 py-2">Password</th>
                <th class="px-4 py-2">Delete</th>
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
                            <button type="submit" class="px-4 py-2 mx-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-600">Update</button>
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
                                <input type="password" id="password" name="password" placeholder="Enter new password" class="mt-1 block w-full rounded-md border-blue-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-100" required>
                                <button type="submit" class="px-4 py-2 mx-2 rounded-md text-white bg-indigo-600 mt-1  hover:bg-indigo-600">Submit</button>
                            </div>
                        </div>
                    </form>
                </td>
                <td class="border px-4 py-2">
                    <form method="POST" action="{{ route('user.delete', $user) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 text-white bg-red-500 rounded hover:bg-red-600">Delete</button>
                    </form>
                </td>
                <!-- Add more columns as needed -->
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="bg-gray-400 p-4 rounded-lg mt-4 mb-4">
    <h3 class="text-xl font-bold mb-4 text-gray-100">Create New User</h3>
    <form method="POST" action="{{ route('admin.create') }}">
        @csrf
        <div class="mb-4">
            <label for="name" class="text-gray-100">Name</label>
            <input type="text" id="name" name="name" class="w-full px-4 py-2 rounded-lg border-blue-300 focus:border-indigo-600 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
        </div>
        <div class="mb-4">
            <label for="email" class="text-gray-100">Email</label>
            <input type="email" id="email" name="email" class="w-full px-4 py-2 rounded-lg border-blue-300 focus:border-indigo-600 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
        </div>
        <div class="mb-4">
            <label for="password" class="text-gray-100">Password</label>
            <input type="password" id="password" name="password" class="w-full px-4 py-2 rounded-lg border-blue-300 focus:border-indigo-600 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
        </div>
        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-600">Create User</button>
    </form>
</div>
</div>

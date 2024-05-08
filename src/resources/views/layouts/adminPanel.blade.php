<p>
    Admin
</p>
<table class="table table-striped table-hover mt-4">
    <thead>
        <tr class="bg-blue-500 text-white">
            <th class="px-4 py-2">Name</th>
            <th class="px-4 py-2">Email</th>
            <th class="px-4 py-2">Is Admin</th>
            <th class="px-4 py-2">Password</th>
            <!-- Add more columns as needed -->
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            @if (auth()->user()->id == $user->id)
                @continue
            @endif
            <tr>
                <td class="border px-4 py-2" >
                    <form method="POST" action="{{ route('user.updateName', $user) }}">
                        @csrf
                        <input type="text" id="name" name="name"  style="color:black" value="{{ $user->name }}" required>
                        <button type="submit">Update Name</button>
                    </form>
                </td>
                <td class="border px-4 py-2">{{ $user->email }}</td>
                <td class="border px-4 py-2">
                    <form method="POST" action="{{ route('user.update', $user) }}">
                        @csrf
                        <input type="checkbox" name="admin" {{ $user->admin == 1 ? 'checked' : '' }} onchange="this.form.submit()">
                    </form>
                </td>
                <td class="border px-4 py-2">
                    <form method="POST" action="{{ route('user.updatePassword', $user) }}" class="mt-4">
                        @csrf
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">New Password:</label>
                            <input type="password" id="password" name="password" style="color:black" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm  focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-100" required>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="px-4 py-2 text-black bg-blue-500 rounded hover:bg-blue-600">Submit</button>
                        </div>
                    </form>
                </td>
                <td class="border px-4 py-2">
                    <form method="POST" action="{{ route('user.delete', $user) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 text-black bg-red-500 rounded hover:bg-red-600">Delete</button>
                    </form>
                </td>
                <!-- Add more columns as needed -->
            </tr>
        @endforeach
    </tbody>
</table>

<form method="POST" action="{{ route('admin.create') }}">
    @csrf
    <div>
        <label for="name">Name</label>
        <input type="text" id="name" name="name" style="color:black" required>
    </div>
    <div>
        <label for="email">Email</label>
        <input type="email" id="email" name="email" style="color:black" required>
    </div>
    <div>
        <label for="password">Password</label>
        <input type="password" id="password" name="password" style="color:black" required>
    </div>
    <button type="submit">Create User</button>
</form>



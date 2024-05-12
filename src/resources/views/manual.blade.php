<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manual') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white  overflow-hidden shadow-sm sm:rounded-lg">
                @if(!auth()->user())
                <div id="guest" class="p-6 text-gray-900">
                    <div class="bg-blue-200 rounded p-3">
                        <h1 class="font-bold text-3xl">GUEST</h1>
                        <div class="p-3">
                            <h3 class="text-2xl">Welcome, Guest!</h3>
                            <p class="m-3">This is the user manual for guests in our app. Here are things you can do
                                as
                                guest:</p>
                            <div class="p-8 pt-3">
                                <ol>
                                    <li class="mb-2">1. Answer questions by providing question code</li>
                                    <li class="mb-2">2. Answer question by scanning question QR code</li>
                                    <li class="mb-2">3. Register to become a user</li>
                                    <li class="mb-2">4. If you already have an account you can log in</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                @elseif (!auth()->user()->isAdmin())
                    <div id="user" class="p-6 text-gray-900">
                        <div class="bg-green-200 rounded p-3">
                            <h1 class="font-bold text-3xl">USER</h1>
                            <div class="p-3">
                                <h3 class="text-2xl">Welcome, User!</h3>
                                <p class="m-3">This is the user manual for users in our app. Here are things you can
                                    do
                                    as
                                    user:</p>
                                <div class="p-8 pt-3">
                                    <ol>
                                        <li class="mb-2">1. Guest functionality</li>
                                        <li class="mb-2">2. Create your own questions</li>
                                        <li class="mb-2">3. Show QR code of question or copy question code to share it
                                        </li>
                                        <li class="mb-2">4. Edit your existing questions</li>
                                        <li class="mb-2">5. Show QR code of question or copy question code to share it
                                        </li>
                                        <li class="mb-2">6. Delete your questions</li>
                                        <li class="mb-2">7. Duplicate your questions</li>
                                        <li class="mb-2">8. Deactivate your questions</li>
                                        <li class="mb-2">9. Show question results</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif (auth()->user()->isAdmin())
                    <div id="admin" class="p-6 text-gray-900">
                        <div class="bg-red-200 rounded p-3">
                            <h1 class="font-bold text-3xl">ADMIN</h1>
                            <div class="p-3">
                                <h3 class="text-2xl">Welcome, Admin!</h3>
                                <p class="m-3">This is the admin manual for admins in our app. Here are things you
                                    can do
                                    as
                                    admin:</p>
                                <div class="p-8 pt-3">
                                    <ol>
                                        <li class="mb-2">1. User functionality</li>
                                        <li class="mb-2">2. Change users name</li>
                                        <li class="mb-2">3. Change users passwords</li>
                                        <li class="mb-2">4. Create new user</li>
                                        <li class="mb-2">5. Delete user</li>
                                        <li class="mb-2">6. Create question in the name of any user</li>
                                        <li class="mb-2">7. Delete and edit all questions</li>
                                        <li class="mb-2">8. Filter user questions</li>
                                        <li class="mb-2">9. Promote user to admin</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    </div>
</x-app-layout>

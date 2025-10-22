<nav x-data="{ open: false, langOpen: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ url('/') }}">
                        <x-application-logo class="block h-full w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('manual')" class="text-black" :active="request()->routeIs('manual')">
                        {{ __('messages.manual') }}
                    </x-nav-link>
                    @if (auth()->user())
                        <x-nav-link :href="route('questions')" class="text-black" :active="request()->routeIs('questions')">
                            {{ __('messages.myQuestions') }}
                        </x-nav-link>
                        <x-nav-link :href="route('quizzes')" class="text-black" :active="request()->routeIs('quizzes')">
                            {{ __('messages.myQuizzes') }}
                        </x-nav-link>
                        @if (auth()->user()->isAdmin())
                            <x-nav-link :href="route('adminUserControl')" class="text-black" :active="request()->routeIs('adminUserControl')">
                                {{ __('messages.users') }}
                            </x-nav-link>
                            <x-nav-link :href="route('adminQuestionControl')" class="text-black" :active="request()->routeIs('adminQuestionControl')">
                                {{ __('messages.userQuestions') }}
                            </x-nav-link>
                            <x-nav-link :href="route('adminQuizControl')" class="text-black" :active="request()->routeIs('adminQuizControl')">
                                {{ __('messages.userQuizzes') }}
                            </x-nav-link>
                        @endif
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown and Language Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-4">
                @if (auth()->user())
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('messages.profile') }}
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('messages.logout') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <x-nav-link :href="route('login')" :active="request()->routeIs('login')">
                        {{ __('messages.login') }}
                    </x-nav-link>
                @endif

                <!-- Language Dropdown -->
                <div class="relative" x-data="{ langOpen: false }">
                    <button @click="langOpen = !langOpen"
                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                        @lang('messages.language')
                        <svg class="ml-2 -mr-1 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="langOpen" @click.away="langOpen = false"
                        class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                        style="display: none;" x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95">
                        <a :href="`/locale/en?redirect=${window.location.pathname}`"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">@lang('messages.english')</a>
                        <a :href="`/locale/sk?redirect=${window.location.pathname}`"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">@lang('messages.slovak')</a>
                    </div>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('manual')" :active="request()->routeIs('manual')">
                {{ __('messages.manual') }}
            </x-responsive-nav-link>
            @if (auth()->user())
                <x-responsive-nav-link :href="route('questions')" :active="request()->routeIs('questions')">
                    {{ __('messages.myQuestions') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('quizzes')" class="text-black" :active="request()->routeIs('quizzes')">
                    {{ __('messages.myQuizzes') }}
                </x-responsive-nav-link>
                @if (auth()->user()->isAdmin())
                    <x-responsive-nav-link :href="route('adminUserControl')" :active="request()->routeIs('adminUserControl')">
                        {{ __('messages.users') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('adminQuestionControl')" :active="request()->routeIs('adminQuestionControl')">
                        {{ __('messages.userQuestions') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('adminQuizControl')" :active="request()->routeIs('adminQuizControl')">
                        {{ __('messages.userQuizzes') }}
                    </x-responsive-nav-link>
                @endif
            @endif
        </div>

        <!-- Responsive Settings Options -->
        @if (auth()->user())
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('messages.profile') }}
                    </x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endif

        <!-- Responsive Language Dropdown -->
        <div class="border-t border-gray-200">
            <div class="px-4 py-3">
                <div class="relative" x-data="{ langOpen: false }">
                    <button @click="langOpen = !langOpen"
                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                        @lang('messages.language')
                        <svg class="ml-2 -mr-1 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="langOpen" @click.away="langOpen = false"
                        class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                        style="display: none;" x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95">
                        <a :href="`/locale/en?redirect=${window.location.pathname}`"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">@lang('messages.english')</a>
                        <a :href="`/locale/sk?redirect=${window.location.pathname}`"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">@lang('messages.slovak')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

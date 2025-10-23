<!-- Admin Secondary Navigation -->
<div class="mb-6">
    <div class="flex flex-wrap gap-3">
        <a href="{{ route('adminUserControl') }}" 
           class="px-6 py-3 rounded-lg font-semibold transition-all duration-200 
                  {{ request()->routeIs('adminUserControl') 
                     ? 'bg-indigo-600 text-white shadow-lg' 
                     : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
            <svg class="inline-block w-5 h-5 mr-2 -mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
            {{ __('messages.user_management') }}
        </a>

        <a href="{{ route('adminQuestionControl') }}" 
           class="px-6 py-3 rounded-lg font-semibold transition-all duration-200 
                  {{ request()->routeIs('adminQuestionControl') 
                     ? 'bg-indigo-600 text-white shadow-lg' 
                     : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
            <svg class="inline-block w-5 h-5 mr-2 -mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ __('messages.question_management') }}
        </a>

        <a href="{{ route('adminQuizControl') }}" 
           class="px-6 py-3 rounded-lg font-semibold transition-all duration-200 
                  {{ request()->routeIs('adminQuizControl') 
                     ? 'bg-indigo-600 text-white shadow-lg' 
                     : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
            <svg class="inline-block w-5 h-5 mr-2 -mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Quiz Management
        </a>
    </div>
</div>

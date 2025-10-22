<input type="text" id="search" class="rounded" placeholder='{{ __('messages.searchUsername') }}'>
<div class="bg-gray-400 p-4 rounded-lg mt-4 mb-4 hidden custom:block">
    <table class="imp_admin_td table bg-white table-striped w-full table-hover mt-4 rounded">
        <thead>
            <tr class="bg-indigo-600 text-white">
                <th class="imp_admin_td px-4 py-2 text-center">{{ __('messages.quiz') }}</th>
                <th class="imp_admin_td px-4 py-2 text-center">{{ __('messages.quizCode') }}</th>
                <th class="imp_admin_td px-4 py-2 text-center">{{ __('messages.owner') }}</th>
                <th class="imp_admin_td px-4 py-2 text-center">{{ __('messages.active') }}</th>
                <th class="imp_admin_td px-4 py-2 text-center">{{ __('messages.edit') }}</th>
                <th class="imp_admin_td px-4 py-2 text-center">{{ __('messages.delete') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($quizzes as $quiz)
                <tr class="imp_admin_td">
                    <td class="px-4 py-2 text-center">{{ $quiz['title'] }}</td>
                    <td class="px-4 py-2 text-center">{{ $quiz['id'] }}</td>
                    <td class="px-4 py-2 text-center">{{ $quiz['owner_name'] }}</td>
                    <td class="px-4 py-2 text-center">
                        <form method="POST" action="{{ route('quiz.update', $quiz) }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="active" value="{{ $quiz->active ? '0' : '1' }}">
                            <input type="checkbox" name="active_checkbox"
                                class="form-checkbox h-5 w-5 text-indigo-600 mt-3 ml-1 p-2 rounded"
                                onchange="this.form.submit()" value="{{ $quiz->id }}"
                                {{ $quiz->active ? 'checked' : '' }}>
                        </form>
                    </td>
                    <td class="px-4 py-2 text-center">
                        <a href="{{ route('quiz.edit', $quiz['id']) }}"
                            class="px-4 py-2 text-white bg-yellow-500 rounded hover:bg-yellow-400">Edit</a>
                    </td>
                    <td class="px-4 py-2 text-center">
                        <form action="{{ route('quiz.destroyAdmin', $quiz['id']) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-4 py-2 text-white bg-red-500 rounded hover:bg-red-600">{{ __('messages.delete') }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Mobileview -->
<div id="mobileTable" class="grid grid-cols-1 gap-4 px-4 py-6 sm:px-6 lg:px-8 custom:hidden">
    @foreach ($quizzes as $quiz)
        <div id="{{ $quiz['id'] }}-{{ $quiz['owner_name'] }}" class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-4">
                <div class="font-semibold text-lg text-purple-800">
                    {{ __('messages.quiz') }}: {{ $quiz['title'] }}
                </div>
                <div class="text-sm text-gray-700">
                    {{ __('messages.code') }}: {{ $quiz['id'] }}
                </div>
                <div class="text-sm text-gray-700">
                    {{ __('messages.owner') }}: {{ $quiz['owner_name'] }}
                </div>
                <div class="flex items-center justify-between mt-2">
                    <div>
                        <strong>{{ __('messages.active') }}:</strong>
                        <input type="checkbox" class="form-checkbox h-5 w-5 text-indigo-600"
                            {{ $quiz['active'] == 1 ? 'checked' : '' }}
                            onchange="event.preventDefault(); document.getElementById('active-toggle-{{ $quiz['id'] }}').submit();">
                        <form id="active-toggle-{{ $quiz['id'] }}" action="{{ route('quiz.update', $quiz['id']) }}"
                            method="POST" style="display: none;">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="active" value="{{ $quiz['active'] == 1 ? 0 : 1 }}">
                        </form>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('quiz.edit', $quiz['id']) }}"
                            class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-400">
                            {{ __('messages.edit') }}
                        </a>
                        <form action="{{ route('quiz.destroyAdmin', $quiz['id']) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                                {{ __('messages.delete') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@push('scripts')
    @vite('resources/js/adminFilterByUsername.js')
@endpush


{{ $quizzes->links() }}

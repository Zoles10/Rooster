<div class="flex flex-col p-2 md:p-6 lg:p-2">
    <div class="flex items-start mb-4">
        <div class="flex-1">
            <h2 class="text-xl mb-3 text-center">@lang('messages.ownerVisible')</h2>
            <div class="flex flex-row justify-center space-x-2 w-full md:w-auto items-center">
                <a href="{{ route('question.edit', $question->id) }}"
                    class="px-2 py-2 bg-green-500 rounded-md text-white hover:bg-green-600 mb-2 md:mb-0 h-9 w-9 transition-colors duration-150 flex items-center justify-center"
                    title="{{ __('messages.edit') }}">
                    @svg('mdi-pencil', 'w-5 h-5')
                </a>
                <form action="{{ route('question.destroy', $question->id) }}" method="POST" class="mb-2 md:mb-0 md:ml-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-2 py-2 bg-rose-500 rounded-md text-white hover:bg-rose-600 h-9 w-9 transition-colors duration-150 flex items-center justify-center"
                        title="{{ __('messages.delete') }}">
                        @svg('mdi-delete-forever-outline', 'w-5 h-5')
                    </button>
                </form>
                <form action="{{ route('question.multiply', $question) }}" method="POST" class="mb-2 md:mb-0 md:ml-2">
                    @csrf
                    @method('POST')
                    <button type="submit"
                        class="px-2 py-2 bg-sky-400 rounded-md text-white hover:bg-sky-600 h-9 w-9 transition-colors duration-150 flex items-center justify-center"
                        title="{{ __('messages.clone') }}">
                        @svg('mdi-content-copy', 'w-5 h-5')
                    </button>
                </form>
            </div>
            <div class="flex justify-center mt-2">
                <form method="POST" action="{{ route('question.update', $question) }}"
                    class="flex flex-col md:flex-row items-center">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="active" value="{{ $question->active ? '0' : '1' }}">
                    <input type="checkbox" name="active_checkbox" id='toggleQuestion'
                        class="form-checkbox h-5 w-5 text-indigo-600 rounded" onchange="this.form.submit()"
                        value="{{ $question->id }}" {{ $question->active ? 'checked' : '' }}>
                    <label
                        class="text-sm text-gray-700 ml-2 md:ml-3">{{ $question->active ? __('messages.deactivate') : __('messages.activate') }}</label>
                    @if (!$question->active)
                        <div class="ml-2 md:ml-7 text-sm text-gray-700 mt-2 md:mt-0">
                            <div>{{ __('messages.lastClosed') }}:
                                {{ \Carbon\Carbon::parse($question->last_closed)->format('d.m.Y') }}</div>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>

@section('title', 'My Questions')
<x-app-layout>
    @push('scripts')
        @vite('resources/js/dashboard.js')
    @endpush
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="flex justify-center items-center">
            <a href="{{ route('question.create') }}" style="background: rgb(79, 70, 229);"
                class="inline-flex items-center px-4 py-2 hover:text-gray-300 bg-purple-800 border border-transparent rounded-md font-semibold text-m text-white uppercase tracking-widest hover:bg-purple-700 active:bg-purple-900 focus:outline-none focus:border-purple-900 focus:ring ring-purple-300 disabled:opacity-25 transition ease-in-out duration-150">
                Create question
            </a>
        </div>
        <div class="flex flex-col mt-5 w-full">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8 w-full">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow-lg overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="w-full divide-y divide-gray-200 mb-2">
                            <thead class="p-2" style="background: rgb(235, 226, 255);">
                                <tr>
                                    <th
                                        class="px-6 py-4 text-left text-m font-medium text-gray-800 uppercase tracking-wider">
                                        Question
                                    </th>
                                    <th
                                        class="px-6 py-4 text-left text-m font-medium text-gray-800 uppercase tracking-wider">
                                        Results
                                    </th>
                                    <th
                                        class="px-6 py-4 text-left text-m font-medium text-gray-800 uppercase tracking-wider">
                                        Question Code
                                    </th>
                                    <th
                                        class="px-6 py-4 text-m font-medium text-gray-800 uppercase tracking-wider text-center ">
                                        Active
                                    </th>
                                    <th
                                        class="px-6 py-4 text-m font-medium text-gray-800 uppercase tracking-wider text-center">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($questions as $question)
                                    <tr class="border">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ route('question.show', $question->id) }}"
                                                class="text-sm text-gray-900">
                                                {{ $question->question }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ route('answer.show', $question->id) }}"
                                                class="text-sm text-gray-900">
                                                Goto Results
                                            </a>
                                        </td>
                                        <td class="px-4 py-2">
                                            <button id="{{ $question->id }}btn"
                                                class="text-blue-500 hover:text-blue-700">
                                                {{ $question->id }}
                                            </button>
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 justify-center items-center">
                                            <div class="flex justify-center items-center">
                                                <form method="POST" action="{{ route('question.update', $question) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="active"
                                                        value="{{ $question->active ? '0' : '1' }}">
                                                    <input type="checkbox" name="active_checkbox"
                                                        class="form-checkbox h-5 w-5 text-indigo-600 mt-3 ml-1 p-2 rounded"
                                                        onchange="this.form.submit()" value="{{ $question->id }}"
                                                        {{ $question->active ? 'checked' : '' }}>
                                                </form>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="flex flex-col space-y-2 justify-center items-center">
                                                <a href="{{ route('question.edit', $question->id) }}"
                                                    style="background: rgb(79, 70, 229); width: 50%; text-align: center;"
                                                    class="text-white p-2 hover:text-gray-300 m-1 border border-transparent rounded-md font-semibold text-xs text-center">Edit</a>
                                            </div>
                                            <form action="{{ route('question.multiply', $question) }}" method="POST" class="mt-1 flex justify-center items-center">
                                                @csrf
                                                @method('POST')

                                                    <button type="submit" class="text-white p-2 hover:text-gray-300 m-1 border border-transparent rounded-md font-semibold text-xs"
                                                    style="background: rgb(70, 200, 229); width: 50%; text-align: center;">Clone</button>
                                            </form>
                                            <form action="{{ route('question.destroy', $question->id) }}" method="POST"
                                                class="mt-1 flex justify-center items-center">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-white p-2 hover:text-gray-300 m-1 border border-transparent rounded-md font-semibold text-xs"
                                                    style="background: red; width: 50%;">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                    </table>
                    {{ $questions->links() }}
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Tailwind Modal -->
    <div id="codeModal" class="hidden fixed inset-0 flex items-center justify-center z-50">
        <div class="bg-white border border-indigo-300 rounded-lg p-8 flex flex-col justify-center">
            <div class="flex flex-col justify-center items-center">

                <h2 class="text-2xl font-bold mb-4">Scan Me</h2>
                <div id="qr-code">

                </div>
                <hr class="mx-3 my-auto">
                <p class="mb-1 mt-3">Or copy this code: <span id="code"></span></p>
                <div class="mt-6 flex justify-center">
                    <button id="hideModalButton" class="px-4 py-2 bg-red-600 text-white rounded-md mr-2">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/qrcodejs/qrcode.min.js"></script>
</x-app-layout>

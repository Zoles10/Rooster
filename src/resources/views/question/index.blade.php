@section("title", "My Questions")
<x-app-layout>
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
                                        <td class="px-4 py-2">
                                            <button class="text-blue-500 hover:text-blue-700"  @click="open = true">
                                                {{ $question->id }}
                                            </button>
                                        </td>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 justify-center items-center">
                                            <div class="flex justify-center items-center">
                                            <form method="POST" action="{{ route('question.update', $question) }}">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="active" value="{{ $question->active ? '0' : '1' }}">
                                                <input type="checkbox" name="active_checkbox" class="form-checkbox h-5 w-5 text-indigo-600 mt-3 ml-1 p-2 rounded" onchange="this.form.submit()" value="{{ $question->id }}" {{     $question->active ? 'checked' : '' }}>
                                            </form>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="flex flex-col space-y-2 justify-center items-center">
                                                <a href="{{ route('question.edit', $question->id) }}"
                                                    style="background: rgb(79, 70, 229); width: 50%; text-align: center;"
                                                    class="text-white p-2 hover:text-gray-300 m-1 border border-transparent rounded-md font-semibold text-xs text-center">Edit</a>
                                            </div>
                    </div>

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
    <button x-data="{ open: false }" @click="open = true">Open Modal</button>

    <!-- Modal -->
    <div x-data="{ open: false }" x-show="open" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen">
            <div class="bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                        Modal Title
                    </h3>
                    <!-- Modal content goes here -->
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <!-- Button to close the modal -->
                    <button @click="open = false">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

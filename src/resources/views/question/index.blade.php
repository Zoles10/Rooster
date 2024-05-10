<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="flex justify-center items-center">
            <a href="{{ route('question.create') }}" style="background: rgb(79, 70, 229);"
                class="inline-flex items-center px-4 py-2 bg-purple-800 border border-transparent rounded-md font-semibold text-m text-white uppercase tracking-widest hover:bg-purple-700 active:bg-purple-900 focus:outline-none focus:border-purple-900 focus:ring ring-purple-300 disabled:opacity-25 transition ease-in-out duration-150">
                Create question
            </a>
        </div>
        <div class="flex flex-col mt-5 w-full">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8 w-full">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow-lg overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="w-full divide-y divide-gray-200">
                            <thead class="p-2" style="background: rgb(235, 226, 255);">
                                <tr>
                                    <th
                                        class="px-6 py-4 text-left text-m font-medium text-gray-800 uppercase tracking-wider">
                                        My questions
                                    </th>
                                    <th
                                        class="px-6 py-4 text-left text-m font-medium text-gray-800 uppercase tracking-wider">
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
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="flex flex-col space-y-2 justify-center items-center">
                                                <a href="{{ route('question.edit', $question->id) }}"
                                                    style="background: rgb(79, 70, 229); width: 50%; text-align: center;"
                                                    class="text-white p-2 hover:text-red-900 m-1 border border-transparent rounded-md font-semibold text-xs text-white text-center">Edit</a>
                                            </div>
                    </div>

                    <form action="{{ route('question.destroy', $question->id) }}" method="POST"
                        class="inline mt-1 flex justify-center items-center">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="text-white p-2 hover:text-red-900 m-1 border border-transparent rounded-md font-semibold text-xs text-white"
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
</x-app-layout>

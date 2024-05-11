<x-app-layout>
   <div class="bg-white min-h-screen flex items-center justify-center text-white">
    <div class="max-w-xl w-full p-6 md:p-8 bg-gray-500 rounded-lg shadow-lg" style="margin: 0 .4rem;">
        <h1 class="text-2xl font-bold mb-5 text-center">Edit your question</h1>
        <form action="{{ route('question.update', $question) }}" method="POST" class="bg-gray-500 p-4 rounded-lg">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <textarea name="question" cols="30" rows="10"
                    class="form-control mt-1 block w-full px-3 py-2 bg-white border border-gray-600 rounded-md shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    placeholder="Enter your question" style="color: rgb(15, 15, 15);">{{ $question->question }}</textarea>
            </div>
            <div class="flex justify-between mt-4">
                <a href="{{ route('question.index') }}"
                    style="background: orange;"
                    class="px-4 py-2 hover:text-gray-300 rounded-md text-white font-semibold text-xs">Back</a>
                <button class="px-4 py-2 rounded-md text-white hover:text-gray-300 font-semibold text-xs"
                    style="background: rgb(79, 70, 229);">Submit</button>
            </div>
        </form>
    </div>
</div>
</x-app-layout>

<input type="text" id="search" class="rounded" placeholder="Search by username" onkeyup="filterTable()">

<script>
function filterTable() {
    var input = document.getElementById("search");
    var filter = input.value.toUpperCase();
    var table = document.querySelector(".table");
    var trs = table.tBodies[0].getElementsByTagName("tr");

    for (var i = 0; i < trs.length; i++) {
        var tds = trs[i].getElementsByTagName("td");
        if (tds.length > 0) {
            var txtValue = tds[2].textContent || tds[2].innerText; // Get the name column
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                trs[i].style.display = "";
            } else {
                trs[i].style.display = "none";
            }
        }
    }
}
</script>
<div class="bg-gray-400 p-4 rounded-lg mt-4 mb-4 hidden custom:block">
    <table class="imp_admin_td table bg-white table-striped w-full table-hover mt-4 rounded">
    <thead>
        <tr class="bg-indigo-600 text-white">
            <th class="imp_admin_td px-4 py-2 text-center">Question</th>
            <th class="imp_admin_td px-4 py-2 text-center">Question Code</th>
            <th class="imp_admin_td px-4 py-2 text-center">Subject</th>
            <th class="imp_admin_td px-4 py-2 text-center">Owner</th>
            <th class="imp_admin_td px-4 py-2 text-center">Active</th>
            <th class="imp_admin_td px-4 py-2 text-center">Edit</th>
            <th class="imp_admin_td px-4 py-2 text-center">Delete</th>
        </tr>
    </thead>
    <tbody>
        @foreach($questions as $question)
            <tr class="imp_admin_td">
                <td class="px-4 py-2 text-center">{{ $question["question"] }}</td>
                <td class="px-4 py-2 text-center">{{ $question["id"] }}</td>
                <td class="px-4 py-2 text-center">{{ $question["subject"]["subject"] }}</td>
                <td class="px-4 py-2 text-center">{{ $question["user_name"] }}</td>
                <td class="px-4 py-2 text-center">
                        <input type="checkbox" class="form-checkbox h-5 w-5 text-indigo-600 mt-3 ml-1 p-2 rounded" name="admin" {{ $question["active"] == 1 ? 'checked' : '' }} onchange="this.form.submit()">
                </td>
                <td class="px-4 py-2 text-center">
                    <a href="{{ route('question.edit', $question["id"]) }}" class="px-4 py-2 text-white bg-yellow-500 rounded hover:bg-yellow-400">Edit</a>
                </td>
                <td class="px-4 py-2 text-center">
                    <form action="{{ route('question.destroyAdmin', $question['id']) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 text-white bg-red-500 rounded hover:bg-red-600">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
</div>

<!-- Mobileview -->
<div class="grid grid-cols-1 gap-4 px-4 py-6 sm:px-6 lg:px-8 custom:hidden">
    @foreach($questions as $question)
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4">
            <div class="font-semibold text-lg text-purple-800">
                Question: {{ $question["question"] }}
            </div>
            <div class="text-sm text-gray-700">
                Code: {{ $question["id"] }}
            </div>
            <div class="text-sm text-gray-700">
                Subject: {{ $question["subject"]["subject"] }}
            </div>
            <div class="text-sm text-gray-700">
                Owner: {{ $question["user_name"] }}
            </div>
            <div class="flex items-center justify-between mt-2">
                <div>
                    <strong>Active:</strong>
                    <input type="checkbox" class="form-checkbox h-5 w-5 text-indigo-600"
                           {{ $question["active"] == 1 ? 'checked' : '' }}
                           onchange="event.preventDefault(); document.getElementById('active-toggle-{{ $question['id'] }}').submit();">
                    <form id="active-toggle-{{ $question['id'] }}" action="{{ route('question.update', $question['id']) }}" method="POST" style="display: none;">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="active" value="{{ $question["active"] == 1 ? 0 : 1 }}">
                    </form>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('question.edit', $question["id"]) }}" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-400">
                        Edit
                    </a>
                    <form action="{{ route('question.destroy', $question['id']) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>



{{ $questions->links() }}

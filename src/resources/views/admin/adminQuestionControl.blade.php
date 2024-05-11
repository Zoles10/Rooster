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
<div class="bg-gray-400 p-4 rounded-lg mt-4 mb-4">
    <table class="table bg-white table-striped w-full table-hover mt-4 rounded" style="border: 1px solid black;">
    <thead>
        <tr class="bg-indigo-600 text-white">
            <th class="px-4 py-2 text-center" style="border: 1px solid black;">Question</th>
            <th class="px-4 py-2 text-center" style="border: 1px solid black;">Subject</th>
            <th class="px-4 py-2 text-center" style="border: 1px solid black;">Owner</th>
            <th class="px-4 py-2 text-center" style="border: 1px solid black;">Active</th>
            <th class="px-4 py-2 text-center" style="border: 1px solid black;">Edit</th>
            <th class="px-4 py-2 text-center" style="border: 1px solid black;">Delete</th>
        </tr>
    </thead>
    <tbody>
        @foreach($questions as $question)
            <tr style="border: 1px solid black;">
                <td class="px-4 py-2 text-center">{{ $question["question"] }}</td>
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
{{ $questions->links() }}

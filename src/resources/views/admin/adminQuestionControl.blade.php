<input type="text" id="search" placeholder="Search by name" onkeyup="filterTable()">

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
<table class="table table-striped table-hover mt-4">
    <thead>
        <tr class="bg-blue-500 text-black">
            <th class="px-4 py-2">Question</th>
            <th class="px-4 py-2">Subject</th>
            <th class="px-4 py-2">Owner</th>
            <th class="px-4 py-2">Active</th>
            <th class="px-4 py-2">Edit</th>
            <th class="px-4 py-2">Delete</th>
        </tr>
    </thead>
    <tbody>
        @foreach($questions as $question)
            <tr>
                <td class="px-4 py-2">{{ $question["question"] }}</td>
                <td class="px-4 py-2">{{ $question["subject"]["subject"] }}</td>
                <td class="px-4 py-2">{{ $question["user_name"] }}</td>
                <td class="px-4 py-2">
                        <input type="checkbox" name="admin" {{ $question["active"] == 1 ? 'checked' : '' }} onchange="this.form.submit()">
                </td>
                <td class="px-4 py-2">
                    <a href="{{ route('question.edit', $question["id"]) }}" class="btn btn-secondary">Edit</a>
                </td>
                <td class="px-4 py-2">
                    <form action="{{ route('question.destroyAdmin', $question['id']) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $questions->links() }}

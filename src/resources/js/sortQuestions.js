const statusSelect = document.getElementById('statusSelect');
const subjectSelect = document.getElementById('subjectSelect');

subjectSelect.addEventListener('change', () => {
    const value = subjectSelect.value;
    const rows = document.querySelectorAll('tbody tr');
    rows.forEach(row => {
        row.style.display = 'table-row';
    });
    rows.forEach(row => {
        const subject = row.children[1].innerText;
        if (value !== 'all' && value !== subject) {
            row.style.display = 'none';
        }
    });
});

statusSelect.addEventListener('change', () => {
    if (statusSelect.value === 'oldest') {
        sortTable(1);
    } else if (statusSelect.value === 'newest') {
        sortTable(1, 'desc');
    }
});

function sortTable(n, order = 'asc') {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.querySelector('table');
    switching = true;
    dir = order === 'asc' ? 'asc' : 'desc';
    while (switching) {
        switching = false;
        rows = table.rows;
        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName('td')[n];
            y = rows[i + 1].getElementsByTagName('td')[n];
            if (dir === 'asc') {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            } else if (dir === 'desc') {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            switchcount++;
        } else {
            if (switchcount === 0 && dir === 'asc') {
                dir = 'desc';
                switching = true;
            }
        }
    }
}

const statusSelect = document.getElementById('statusSelect');
const subjectSelect = document.getElementById('subjectSelect');

subjectSelect.addEventListener('change', () => {
    const value = subjectSelect.value;
    if (document.querySelector('table').offsetParent === null)
        sortDivsOnSubject(value);
    else
        sortTableOnSubject(value);
});

statusSelect.addEventListener('change', () => {
    if (statusSelect.value === 'oldest') {
        if (document.querySelector('table').offsetParent === null)
            sortDivs(1);
        else
            sortTable(1);
    } else if (statusSelect.value === 'newest') {
        if (document.querySelector('table').offsetParent === null)
            sortDivs(1, 'desc');
        else
            sortTable(1, 'desc');
    }
});

function sortDivsOnSubject(value) {
    let mobileTable = document.getElementById("mobileTable");
    let children = mobileTable.children;
    let divs = Array.from(children).filter(child => child.tagName === 'DIV');
    let allDivs = Array.from(children).filter(child => child.tagName === 'DIV');
    // Hide the divs that don't match the filter
    if (value !== 'all') {
        divs = divs.filter(div => {
            let divIdParts = div.id.split('-');
            let divSubject = divIdParts.length > 2 ? divIdParts.slice(2).join('-') : '';
            return divSubject === value;
        });
    }

    allDivs.forEach(div => {
        div.style.display = 'block';
    });
    divs.forEach(div => {
        if (!allDivs.includes(div)) {
            div.style.display = 'none';
        }
    });

    allDivs.forEach(div => {
        if (!divs.includes(div)) {
            div.style.display = 'none';
        }
    });
}

function sortTableOnSubject(value) {
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
}

function sortDivs(n, order = 'asc') {
    let mobileTable = document.getElementById("mobileTable");
    let children = mobileTable.children;
    let divs = Array.from(children).filter(child => child.tagName === 'DIV');

    // Sort the divs based on the date part of the id
    divs.sort((a, b) => {
        let aIdParts = a.id.split('-');
        let bIdParts = b.id.split('-');
        let aDate = aIdParts.length > 1 ? aIdParts[1] : '';
        let bDate = bIdParts.length > 1 ? bIdParts[1] : '';
        return order === 'asc' ? aDate.localeCompare(bDate) : bDate.localeCompare(aDate);
    });
    // Hide the divs that don't match the filter
    for (let i = 0; i < divs.length; i++) {
        mobileTable.appendChild(divs[i]);
    }
}

function sortTable(n, order = 'asc') {
    let table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.querySelector('table');
    switching = true;
    dir = order === 'asc' ? 'desc' : 'asc';
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

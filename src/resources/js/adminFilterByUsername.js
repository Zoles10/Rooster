document.getElementById("search").addEventListener("keyup", filterTable);

function filterTable() {
    let input = document.getElementById("search");
    let filter = input.value.toUpperCase();

    let table = document.querySelector(".table");
    if (table.offsetParent === null) {
        console.log("test");
        let mobileTable = document.getElementById("mobileTable");
        let children = mobileTable.children;
        let divs = Array.from(children).filter(child => child.tagName === 'DIV');
            divs.sort((a, b) => {
                let aUsername = a.id.split('-')[1];
                let bUsername = b.id.split('-')[1];
                return aUsername.localeCompare(bUsername);
            });
            // Hide the divs that don't match the filter
            for (let i = 0; i < divs.length; i++) {
                let username = divs[i].id.split('-')[1];
                if (username.toUpperCase().indexOf(filter) > -1) {
                    divs[i].style.display = "";
                } else {
                    divs[i].style.display = "none";
                }
            }
    } else {
        let trs = table.tBodies[0].getElementsByTagName("tr");
        for (let i = 0; i < trs.length; i++) {
            let tds = trs[i].getElementsByTagName("td");
            if (tds.length > 0) {
                let txtValue = tds[2].textContent || tds[2].innerText; // Get the name column
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    trs[i].style.display = "";
                } else {
                    trs[i].style.display = "none";
                }
            }
        }
    }

}

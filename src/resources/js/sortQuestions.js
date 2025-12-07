import $ from "jquery";

$(function() {
    const statusSelect = $('#statusSelect');
    const subjectSelect = $('#subjectSelect');

    subjectSelect.on('change', function() {
        const selectedSubject = $(this).val();
        filterBySubject(selectedSubject);
    });

    statusSelect.on('change', function() {
        const sortOrder = $(this).val();
        sortByDate(sortOrder);
    });

    function filterBySubject(selectedSubject) {
        if ($('table').is(':visible')) {
            filterTableBySubject(selectedSubject);
        } else {
            filterDivsBySubject(selectedSubject);
        }
    }

    function filterTableBySubject(selectedSubject) {
        const rows = $('tbody tr');

        if (selectedSubject === 'all') {
            rows.show();
        } else {
            rows.each(function() {
                const subjectCell = $(this).find('td').eq(1);
                const subjectText = subjectCell.text().trim();

                if (subjectText === selectedSubject) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }
    }

    function filterDivsBySubject(selectedSubject) {
        const divs = $('#mobileTable > div');

        if (selectedSubject === 'all') {
            divs.show();
        } else {
            divs.each(function() {
                const divId = $(this).attr('id');
                const idParts = divId.split('-');
                const subject = idParts.slice(2).join('-');

                if (subject === selectedSubject) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }
    }

    function sortByDate(sortOrder) {
        if ($('table').is(':visible')) {
            sortTableByDate(sortOrder);
        } else {
            sortDivsByDate(sortOrder);
        }
    }

    function sortTableByDate(sortOrder) {
        const tbody = $('tbody');
        const rows = tbody.find('tr').get();

        rows.sort(function(a, b) {
            const dateA = $(a).find('td').eq(3).text().trim();
            const dateB = $(b).find('td').eq(3).text().trim();

            const dateObjA = parseDate(dateA);
            const dateObjB = parseDate(dateB);

            if (sortOrder === 'newest') {
                return dateObjB - dateObjA;
            } else {
                return dateObjA - dateObjB;
            }
        });
        $.each(rows, function(index, row) {
            tbody.append(row);
        });
    }

    function sortDivsByDate(sortOrder) {
        const mobileTable = $('#mobileTable');
        const divs = mobileTable.children('div').get();

        divs.sort(function(a, b) {
            const idA = $(a).attr('id');
            const idB = $(b).attr('id');

            const dateA = idA.split('-')[1];
            const dateB = idB.split('-')[1];

            const dateObjA = parseDate(dateA);
            const dateObjB = parseDate(dateB);

            if (sortOrder === 'newest') {
                return dateObjB - dateObjA;
            } else {
                return dateObjA - dateObjB;
            }
        });

        $.each(divs, function(index, div) {
            mobileTable.append(div);
        });
    }

    function parseDate(dateString) {
        const parts = dateString.split('.');
        if (parts.length === 3) {
            const day = parseInt(parts[0], 10);
            const month = parseInt(parts[1], 10) - 1;
            const year = parseInt(parts[2], 10);
            return new Date(year, month, day);
        }
        return new Date(0);
    }
});

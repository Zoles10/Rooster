(() => {
    // Read config from window
    const cfg = window.answersShowConfig || {};
    const UPDATE_URL = cfg.updateUrl || null;
    const IS_OWNER = !!cfg.isOwner;
    const EXPORT_URL = cfg.exportUrl || null;
    const NO_RESULTS = cfg.noResults || 'No results';
    const UPDATE_INTERVAL = cfg.updateInterval || 5000;

    if (!UPDATE_URL) return;

    async function updateTable() {
        try {
            const response = await fetch(UPDATE_URL, {method: 'GET', headers: {'Accept': 'application/json'}});
            if (!response.ok) throw new Error('Network response not ok');
            const answerCounts = await response.json();

            const tbody = document.getElementById('multiple-choice-tbody');
            const mobile = document.getElementById('mobileTable');
            if (!tbody || !mobile) return;

            tbody.innerHTML = '';
            // clear mobile cards (header/buttons now rendered below the list)
            mobile.innerHTML = '';

            if (!answerCounts || answerCounts.length === 0) {
                tbody.innerHTML = '<tr><td colspan="3" class="px-6 py-4 text-center text-gray-500">' + NO_RESULTS + '</td></tr>';
                const p = document.createElement('div');
                p.className = 'px-2 text-gray-500';
                p.textContent = NO_RESULTS;
                mobile.appendChild(p);
                return;
            }

            for (const item of answerCounts) {
                const correctIcon = item.correct ? '✓' : '✗';
                const correctClass = item.correct ? 'text-green-600' : 'text-red-600';

                // Desktop row
                const row = document.createElement('tr');
                row.className = 'border';
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${item.user_name}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${item.selected_option}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium ${correctClass}">${correctIcon}</td>
                `;
                tbody.appendChild(row);

                // Mobile card
                const card = document.createElement('div');
                card.className = 'bg-white rounded-lg shadow overflow-hidden';
                card.innerHTML = `
                    <div class="p-4">
                        <div class="font-semibold text-lg text-purple-800">${item.user_name}</div>
                        <div class="text-sm text-gray-700 mt-2">${item.selected_option}</div>
                        <div class="text-sm ${correctClass} mt-1">${correctIcon}${item.comment ? ' ' + item.comment : ''}</div>
                    </div>
                `;
                mobile.appendChild(card);
            }

        } catch (err) {
            // silent
            console.error('Error updating answers:', err);
        }
    }

    updateTable();
    setInterval(updateTable, UPDATE_INTERVAL);
})();

document.addEventListener('DOMContentLoaded', function() {
    const list = document.getElementById('available-list');
    const inputsContainer = document.getElementById('selected-questions-inputs');
    const addAllBtn = document.getElementById('add-all-questions');
    const clearBtn = document.getElementById('clear-selection');

    if (!list) return;

    function hasHiddenFor(id) {
        return !!inputsContainer.querySelector('input[data-selected-input="' + id + '"]');
    }

    function createHiddenFor(id) {
        if (hasHiddenFor(id)) return null;
        const hidden = document.createElement('input');
        hidden.type = 'hidden';
        hidden.name = 'selected_questions[]';
        hidden.value = id;
        hidden.setAttribute('data-selected-input', id);
        inputsContainer.appendChild(hidden);
        return hidden;
    }

    function removeHiddenFor(id) {
        const input = inputsContainer.querySelector('input[data-selected-input="' + id + '"]');
        if (input) input.remove();
    }

    function setBtnSelectedState(btn, selected) {
        const addLabel = btn.dataset.addLabel || 'Add';
        const removeLabel = btn.dataset.removeLabel || 'Remove';
        btn.dataset.selected = selected ? '1' : '0';
        if (selected) {
            btn.textContent = removeLabel;
            btn.classList.remove('bg-indigo-600', 'add-state');
            btn.classList.add('bg-red-600', 'remove-state');
        } else {
            btn.textContent = addLabel;
            btn.classList.remove('bg-red-600', 'remove-state');
            btn.classList.add('bg-indigo-600', 'add-state');
        }
    }

    // initialize buttons from any existing hidden inputs (old() state)
    list.querySelectorAll('.toggle-btn').forEach(btn => {
        const id = btn.dataset.id;
        const selected = hasHiddenFor(id);
        setBtnSelectedState(btn, selected);
    });

    // click handler for toggle buttons
    list.addEventListener('click', function(e) {
        const btn = e.target.closest('.toggle-btn');
        if (!btn) return;

        const id = btn.dataset.id;
        const isSelected = btn.dataset.selected === '1';

        if (isSelected) {
            // remove
            removeHiddenFor(id);
            setBtnSelectedState(btn, false);
        } else {
            // add
            createHiddenFor(id);
            setBtnSelectedState(btn, true);
        }
    });

    // addAll: add hidden inputs for every item and update buttons
    addAllBtn && addAllBtn.addEventListener('click', function() {
        const buttons = list.querySelectorAll('.toggle-btn');
        buttons.forEach(btn => {
            const id = btn.dataset.id;
            if (!hasHiddenFor(id)) {
                createHiddenFor(id);
            }
            setBtnSelectedState(btn, true);
        });
    });

    // clear: remove all hidden inputs and reset buttons
    clearBtn && clearBtn.addEventListener('click', function() {
        // remove all hidden inputs
        const hiddenInputs = inputsContainer.querySelectorAll('input[data-selected-input]');
        hiddenInputs.forEach(i => i.remove());

        // reset all toggle buttons
        const buttons = list.querySelectorAll('.toggle-btn');
        buttons.forEach(btn => setBtnSelectedState(btn, false));
    });
});

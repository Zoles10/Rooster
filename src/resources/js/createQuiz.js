document.addEventListener('DOMContentLoaded', function() {
    const list = document.getElementById('available-list');
    const inputsContainer = document.getElementById('selected-questions-inputs');
    const addAllBtn = document.getElementById('add-all-questions');
    const clearBtn = document.getElementById('clear-selection');
    const mainForm = document.getElementById('main-form');
    const prevPageBtn = document.getElementById('prev-page');
    const nextPageBtn = document.getElementById('next-page');
    const pageInfo = document.getElementById('page-info');

    if (!list) return;

    // Pagination settings
    const itemsPerPage = 10;
    let currentPage = 1;
    let allItems = [];

    // Initialize pagination
    function initPagination() {
        allItems = Array.from(list.querySelectorAll('.question-item'));
        if (allItems.length <= itemsPerPage) {
            // Hide pagination if not needed
            if (document.getElementById('pagination-controls')) {
                document.getElementById('pagination-controls').style.display = 'none';
            }
        } else {
            showPage(currentPage);
        }
    }

    function showPage(page) {
        const totalPages = Math.ceil(allItems.length / itemsPerPage);
        currentPage = Math.max(1, Math.min(page, totalPages));

        const startIdx = (currentPage - 1) * itemsPerPage;
        const endIdx = startIdx + itemsPerPage;

        // Hide all items
        allItems.forEach(item => item.style.display = 'none');

        // Show items for current page
        allItems.slice(startIdx, endIdx).forEach(item => item.style.display = 'flex');

        // Update pagination controls
        if (prevPageBtn) prevPageBtn.disabled = currentPage === 1;
        if (nextPageBtn) nextPageBtn.disabled = currentPage === totalPages;
        if (pageInfo) pageInfo.textContent = `${currentPage} of ${totalPages}`;
    }

    // Pagination button handlers
    if (prevPageBtn) {
        prevPageBtn.addEventListener('click', () => showPage(currentPage - 1));
    }

    if (nextPageBtn) {
        nextPageBtn.addEventListener('click', () => showPage(currentPage + 1));
    }

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

    // Initialize pagination
    initPagination();

    function setBtnSelectedState(btn, selected) {
        btn.dataset.selected = selected ? '1' : '0';
        if (selected) {
            btn.classList.remove('bg-indigo-500', 'hover:bg-indigo-600');
            btn.classList.add('bg-rose-500', 'hover:bg-rose-600');
            btn.innerHTML = '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19,13H5V11H19V13Z"/></svg>';
        } else {
            btn.classList.remove('bg-rose-500', 'hover:bg-rose-600');
            btn.classList.add('bg-indigo-500', 'hover:bg-indigo-600');
            btn.innerHTML = '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19,13H13V19H11V13H5V11H11V5H13V11H19V13Z"/></svg>';
        }
    }

    // initialize buttons from any existing hidden inputs (old() state)
    list.querySelectorAll('.toggle-btn').forEach(btn => {
        const id = btn.dataset.id;
        const selected = hasHiddenFor(id);
        setBtnSelectedState(btn, selected);
    });    // click handler for toggle buttons
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

    // addAll: add all questions across all pages
    addAllBtn && addAllBtn.addEventListener('click', function() {
        allItems.forEach(item => {
            const btn = item.querySelector('.toggle-btn');
            if (btn) {
                const id = btn.dataset.id;
                if (!hasHiddenFor(id)) {
                    createHiddenFor(id);
                }
                setBtnSelectedState(btn, true);
            }
        });
    });

    // clear: remove all hidden inputs and reset all buttons
    clearBtn && clearBtn.addEventListener('click', function() {
        // remove all hidden inputs
        const hiddenInputs = inputsContainer.querySelectorAll('input[data-selected-input]');
        hiddenInputs.forEach(i => i.remove());

        // reset all toggle buttons across all pages
        allItems.forEach(item => {
            const btn = item.querySelector('.toggle-btn');
            if (btn) setBtnSelectedState(btn, false);
        });
    });    // Form validation
    mainForm && mainForm.addEventListener('submit', function(event) {
        const quizInput = document.getElementById('quiz');
        const quizDescriptionInput = document.getElementById('quizDescription');
        const selectedQuestions = inputsContainer.querySelectorAll('input[data-selected-input]');

        // Get translations from window object
        const messages = window.quizValidationMessages || {
            quizTitleRequired: 'Quiz title is required',
            quizDescriptionRequired: 'Quiz description is required',
            atLeastOneQuestionRequired: 'At least one question must be selected'
        };

        let valid = true;

        // Validate quiz title
        if (quizInput && quizInput.value.trim() === '') {
            document.getElementById('quiz-err').textContent = messages.quizTitleRequired;
            document.getElementById('quiz-err').classList.remove('hidden');
            valid = false;
        } else {
            document.getElementById('quiz-err').classList.add('hidden');
        }

        // Validate quiz description
        if (quizDescriptionInput && quizDescriptionInput.value.trim() === '') {
            document.getElementById('quizDescription-err').textContent = messages.quizDescriptionRequired;
            document.getElementById('quizDescription-err').classList.remove('hidden');
            valid = false;
        } else {
            document.getElementById('quizDescription-err').classList.add('hidden');
        }

        // Validate at least one question is selected
        if (selectedQuestions.length === 0) {
            const questionErr = document.getElementById('question-selection-err');
            questionErr.textContent = messages.atLeastOneQuestionRequired;
            questionErr.classList.remove('hidden');
            valid = false;
        } else {
            const questionErr = document.getElementById('question-selection-err');
            if (questionErr) {
                questionErr.classList.add('hidden');
            }
        }

        if (!valid) {
            event.preventDefault();
        }
    });
});

let optionCount = 4;

export function handleQuestionTypeChange() {
    const container = document.getElementById('options-container');
    container.innerHTML = '';
    const addOptionBtn = document.getElementById('add-option-btn');
    optionCount = 4;
    addOptionBtn.classList.remove('hidden');
    container.innerHTML = '<label class="block text-sm font-medium text-grey">' + window.LangMessages.correct + ':</label>';
    for (let i = 0; i < optionCount; i++) {
        addOption(i + 1);
    }
}

export function addOption(optionNumber = null) {
    const container = document.getElementById('options-container');
    const input = document.createElement('input');
    input.type = 'text';
    input.name = 'option' + (optionNumber || ++optionCount);
    input.placeholder = window.LangMessages.optionText;
    input.className = 'form-control flex-1 h-9 px-3 py-2 bg-white border border-gray-600 rounded-md shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm text-black';

    const checkbox = document.createElement('input');
    checkbox.type = 'checkbox';
    checkbox.name = 'isCorrect' + (optionNumber || optionCount);
    checkbox.className = 'form-checkbox h-5 w-5 text-indigo-600 mr-2 rounded';

    // Create X button with Tailwind classes only, always 1:1
    const removeButton = document.createElement('button');
    removeButton.type = 'button';
    removeButton.className = 'inline-flex items-center justify-center bg-rose-500 hover:bg-rose-600 text-white rounded-md w-9 h-9 text-xl font-bold transition-colors duration-150';
    removeButton.innerHTML = '&times;';
    removeButton.addEventListener('click', function() {
        if (optionWrapper.parentNode === container) {
            container.removeChild(optionWrapper);
        }
    });

    const optionWrapper = document.createElement('div');
    optionWrapper.className = 'flex items-center gap-2 mb-3'; // flex + items-center + gap for spacing
    optionWrapper.appendChild(checkbox);
    optionWrapper.appendChild(input);
    optionWrapper.appendChild(removeButton);
    container.appendChild(optionWrapper);
}

// Show/hide "Other Subject" input
document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('submit-btn').addEventListener('click', validateForm);
    handleQuestionTypeChange();
    const addOptionBtn = document.querySelector('#add-option-btn button');
    if (addOptionBtn) {
        addOptionBtn.addEventListener('click', () => addOption());
    }
    // Subject dropdown logic
    const subjectDropdown = document.getElementById('subject');
    const otherSubjectContainer = document.getElementById('other-subject-container');
    if (subjectDropdown && otherSubjectContainer) {
        subjectDropdown.addEventListener('change', function() {
            if (this.value === '0') {
                otherSubjectContainer.classList.remove('hidden');
            } else {
                otherSubjectContainer.classList.add('hidden');
            }
        });
    }
});

export function validateForm(event) {
    event.preventDefault();
    const questionInput = document.getElementById('question');
    const subjectDropdown = document.getElementById('subject');
    const optionErr = document.getElementById('option-err');
    const questionErr = document.getElementById('question-err');
    let valid = true;

    if (questionInput.value.trim() === '') {
        questionErr.innerHTML = window.LangMessages.enterQue;
        questionErr.style.display = 'block';
        valid = false;
    } else {
        questionErr.style.display = 'none';
    }

    if (subjectDropdown.value === '0') {
        const otherSubjectInput = document.getElementById('other-subject');
        if (otherSubjectInput.value.trim() === '') {
            let othersubjectErr = document.getElementById('othersubject-err');
            othersubjectErr.innerHTML = window.LangMessages.enterSubjectName;
            othersubjectErr.style.display = 'block';
            valid = false;
        } else {
            let othersubjectErr = document.getElementById('othersubject-err');
            othersubjectErr.style.display = 'none';
        }
    }

    // Option validation
    const options = document.querySelectorAll('#options-container input[type="text"]');
    const correctCheckboxes = document.querySelectorAll('#options-container input[type="checkbox"]');
    let hasOption = options.length > 0;
    let hasCorrect = Array.from(correctCheckboxes).some(cb => cb.checked);
    let allOptionsFilled = Array.from(options).every(opt => opt.value.trim() !== '');

    if (!hasOption) {
        optionErr.innerHTML = window.LangMessages.atLeastOneOption;
        optionErr.style.display = 'block';
        valid = false;
    } else if (!allOptionsFilled) {
        optionErr.innerHTML = window.LangMessages.optionTextEmpty;
        optionErr.style.display = 'block';
        valid = false;
    } else if (!hasCorrect) {
        optionErr.innerHTML = window.LangMessages.atLeastOneCorrect;
        optionErr.style.display = 'block';
        valid = false;
    } else {
        optionErr.style.display = 'none';
    }

    if (valid) {
        document.getElementById('main-form').submit();
    }
}

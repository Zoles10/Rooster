import $ from "jquery";

let optionCount = 4;

export function handleQuestionTypeChange() {
    const container = $('#options-container');
    container.empty();
    const addOptionBtn = $('#add-option-btn');
    optionCount = 4;
    addOptionBtn.removeClass('hidden');
    container.html('<label class="block text-sm font-medium text-black">' + window.LangMessages.correct + '</label>');
    for (let i = 0; i < optionCount; i++) {
        addOption(i + 1);
    }
}

export function addOption(optionNumber = null) {
    const container = $('#options-container');

    const input = $('<input>', {
        type: 'text',
        name: 'option' + (optionNumber || ++optionCount),
        placeholder: window.LangMessages.optionText,
        class: 'text-black form-control mt-1 block w-full px-3 py-2 bg-white border border-gray-600 rounded-md shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm'
    });

    const checkbox = $('<input>', {
        type: 'checkbox',
        name: 'isCorrect' + (optionNumber || optionCount),
        class: 'form-checkbox imp_checkbox h-5 w-5 text-indigo-500 mt-3 ml-1 p-2 rounded cursor-pointer hover:text-indigo-600'
    });

    // Create X button with consistent styling from questionEdit
    const removeButton = $('<button>', {
        type: 'button',
        html: '&times;',
        class: 'bg-rose-500 hover:bg-rose-600 text-white rounded px-2 py-1 ml-2 mt-1 imp_x_btn',
        click: function() {
            optionWrapper.remove();
        }
    });

    const optionWrapper = $('<div>', {
        class: 'flex items-center mb-3'
    }).append(checkbox, input, removeButton);

    container.append(optionWrapper);
}

// Initialize when document is ready
$(function() {
    $('#submit-btn').on('click', validateForm);
    handleQuestionTypeChange();
    $('#add-option-btn button').on('click', () => addOption());

    // Subject dropdown logic
    $('#subject').on('change', function() {
        if (this.value === '0') {
            $('#other-subject-container').removeClass('hidden');
        } else {
            $('#other-subject-container').addClass('hidden');
        }
    });
});

export function validateForm(event) {
    event.preventDefault();
    const questionInput = $('#question');
    const subjectDropdown = $('#subject');
    const optionErr = $('#option-err');
    const questionErr = $('#question-err');
    let valid = true;

    if (questionInput.val().trim() === '') {
        questionErr.html(window.LangMessages.enterQue).show();
        valid = false;
    } else {
        questionErr.hide();
    }

    if (subjectDropdown.val() === '0') {
        const otherSubjectInput = $('#other-subject');
        if (otherSubjectInput.val().trim() === '') {
            $('#othersubject-err').html(window.LangMessages.enterSubjectName).show();
            valid = false;
        } else {
            $('#othersubject-err').hide();
        }
    }

    // Option validation
    const options = $('#options-container input[type="text"]');
    const correctCheckboxes = $('#options-container input[type="checkbox"]');
    let hasOption = options.length > 0;
    let hasCorrect = correctCheckboxes.toArray().some(cb => $(cb).is(':checked'));
    let allOptionsFilled = options.toArray().every(opt => $(opt).val().trim() !== '');

    if (!hasOption) {
        optionErr.html(window.LangMessages.atLeastOneOption).show();
        valid = false;
    } else if (!allOptionsFilled) {
        optionErr.html(window.LangMessages.optionTextEmpty).show();
        valid = false;
    } else if (!hasCorrect) {
        optionErr.html(window.LangMessages.atLeastOneCorrect).show();
        valid = false;
    } else {
        optionErr.hide();
    }

    if (valid) {
        $('#main-form').submit();
    }
}

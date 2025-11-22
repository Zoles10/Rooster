import $ from "jquery";

// Initialize question editing functionality
$(function() {
    // Get initial option count from data attribute
    let optionCount = parseInt($('#options-container').data('initial-count')) || 0;

    // Update the option count and option ids
    for (var i = 1; i <= optionCount; i++) {
        var currentOptionWrapper = $('#option-wrapper-' + i);
        if (currentOptionWrapper.length) {
            var currentOptionInput = currentOptionWrapper.find('input[name^="option"]');
            var currentCheckboxInput = currentOptionWrapper.find('input[name^="isCorrect"]');
            if (currentOptionInput.length) currentOptionInput.attr('name', 'option' + i);
            if (currentCheckboxInput.length) currentCheckboxInput.attr('name', 'isCorrect' + i);
            currentOptionWrapper.attr('id', 'option-wrapper-' + i);
        }
    }

    // Function to Delete an Option
    window.deleteOption = function(optionNumber) {
        var optionWrapper = $('#option-wrapper-' + optionNumber);
        if (optionWrapper.length) {
            optionWrapper.remove();
            // Update the option count
            optionCount--;
            // Update the remaining option ids
            for (var i = optionNumber + 1; i <= optionCount + 1; i++) {
                var currentOptionWrapper = $('#option-wrapper-' + i);
                if (currentOptionWrapper.length) {
                    var currentOptionInput = currentOptionWrapper.find('input[name^="option' + i + '"]');
                    var currentCheckboxInput = currentOptionWrapper.find('input[name^="isCorrect' + i + '"]');
                    if (currentOptionInput.length) currentOptionInput.attr('name', 'option' + (i - 1));
                    if (currentCheckboxInput.length) currentCheckboxInput.attr('name', 'isCorrect' + (i - 1));
                    currentOptionWrapper.attr('id', 'option-wrapper-' + (i - 1));
                }
            }
        }
    };

    // Function to Add More Options Dynamically
    window.addOption = function(optionNumber = null) {
        var container = $('#options-container');
        if (!container.length) return;

        // Create a new input field for the option
        var input = $('<input>', {
            type: 'text',
            name: 'option' + (optionNumber || ++optionCount),
            placeholder: 'Option Text', // Will be localized in Blade template
            class: 'form-control mt-1 block w-full px-3 py-2 bg-white border border-gray-600 rounded-md shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm',
            css: { color: 'black' }
        });

        // Create a new checkbox for correct option
        var checkbox = $('<input>', {
            type: 'checkbox',
            name: 'isCorrect' + (optionNumber || optionCount),
            class: 'form-checkbox h-5 w-5 text-indigo-600 mt-3 ml-1 p-2 rounded',
            css: { margin: '.25rem 2.7rem 0 .8rem', 'border-radius': '4px' }
        });

        // Add a rose "Remove" button
        var removeButton = $('<button>', {
            type: 'button',
            html: '&times;',
            class: 'bg-rose-400 hover:bg-rose-500 text-white rounded px-2 py-1 ml-2 mt-1',
            click: function() {
                optionWrapper.remove();
            }
        });

        // Wrap the inputs together
        var optionWrapper = $('<div>', {
            class: 'flex items-center mb-3'
        }).append(checkbox, input, removeButton);

        container.append(optionWrapper);
    };

    // Toggle visibility of the "Other" input field based on subject dropdown
    $('#subject').on('change', function() {
        if (this.value === '0') {
            $('#other-subject-container').removeClass('hidden');
        } else {
            $('#other-subject-container').addClass('hidden');
        }
    });

    // Form validation and submission
    function handleSubmit(event) {
        event.preventDefault(); // Prevent default form submission

        // Form validation
        const questionInput = $('#question');
        const subjectDropdown = $('#subject');

        if (questionInput.val().trim() === '') {
            $('#question-err').html('Enter question text').show();
            return;
        } else {
            $('#question-err').hide();
        }

        if (subjectDropdown.val() === '0') {
            const otherSubjectInput = $('#other-subject');
            if (otherSubjectInput.val().trim() === '') {
                $('#othersubject-err').html('Enter subject name').show();
                return;
            } else {
                $('#othersubject-err').hide();
            }
        }

        // Additional validation for multiple choice questions
        const options = $('input[name^="option"]');
        let allValid = true;

        options.each(function() {
            if ($(this).val().trim() === '') {
                allValid = false;
            }
        });

        if (!allValid) {
            $('#option-err').html('Option text is empty').show();
            return;
        } else {
            $('#option-err').hide();
        }

        // Submit the form after validation
        $('#main-form').trigger( "submit" )
    }

    // Attach the handleSubmit function to the submit button
    $('#submit-btn').on('click', handleSubmit);

    // Show the "Add Option" button when the page loads
    $('#add-option-btn').removeClass('hidden').addClass('flex justify-center');
});

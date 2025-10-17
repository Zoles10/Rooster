function limitCheckboxes() {
    let correctOptionsCount = document.getElementById('correctOptionsCount').value;
    let checkedCount = document.querySelectorAll('input[type="checkbox"]:checked').length;
    let checkboxes = document.querySelectorAll('input[type="checkbox"]');
    let ownerBox = document.getElementById('toggleQuestion');
    if (ownerBox)
        checkedCount--;

    console.log(correctOptionsCount, checkedCount)
    if (checkedCount >= correctOptionsCount) {
        checkboxes.forEach((checkbox) => {
            if (!checkbox.checked) {
                checkbox.disabled = true;
            }
        });
    } else {
        checkboxes.forEach((checkbox) => {
            checkbox.disabled = false;
        });
    }
}

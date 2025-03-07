function checkButtonValues(inputIds, buttonId) {
    let allFilled = inputIds.every(id => document.getElementById(id).value.trim() !== "");
    document.getElementById(buttonId).disabled = !allFilled;
}
function checkCheckboxValues(ids, buttonId) {
    let anyChecked = ids.some(id => document.getElementById(id).checked);
    document.getElementById(buttonId).disabled = !anyChecked;
}
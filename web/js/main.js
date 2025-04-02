const check = $("input[id*='other_request']");
const serviceField = $("div[class*='service_id']");
const customServiceField = $("div[class*='custom_service_description']");
function toggleFields() {
    if (check.is(':checked')) {
        serviceField.show().toggle('fade');
        customServiceField.hide().toggle('fade');
    } else {
        serviceField.hide().toggle('fade');
        customServiceField.show().toggle('fade');
    }
}
toggleFields();
check.on('change', toggleFields);

const status = $("select[id*='request-status']");

function toggleCancellationReason() {
    const customField = $("div[class*='cancellation_reason']");
    if(status.val() !== 'cancelled') customField.show().toggle('fade');
    else customField.hide().toggle('fade');
}

toggleCancellationReason();
status.on('change', toggleCancellationReason);

// let check = document.querySelector("input[id*='other_request']");
// let serviceField = document.querySelector("div[class*='service_id']");
// let customServiceField = document.querySelector("div[class*='custom_service_description']");
// customServiceField.style.display = "none";
// check.addEventListener('change', () => {
//     if(check.checked) {
//         serviceField.style.display = "none";
//         customServiceField.style.display = "block";
//     } else {
//         serviceField.style.display = "block";
//         customServiceField.style.display = "none";
//     }
// })
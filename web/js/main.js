let check = document.querySelector("input[id*='other_request']");
let serviceField = document.querySelector("div[class*='service_id']");
let customServiceField = document.querySelector("div[class*='custom_service_description']");
customServiceField.style.display = "none";
check.addEventListener('change', () => {
    if(check.checked) {
        serviceField.style.display = "none";
        customServiceField.style.display = "block";
    } else {
        serviceField.style.display = "block";
        customServiceField.style.display = "none";
    }
})

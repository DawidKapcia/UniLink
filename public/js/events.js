const form = document.querySelector('form[action="add_event"]');
const submit = form.querySelector('button[type="submit"]');

const hour = form.querySelector('input[name="hour"]');

function isHour(hour) {
    return /^(?:[01]\d|2[0-3]):[0-5]\d$/.test(hour);
}

function markValidation(element, condition, message, parametersafter) {

    if (condition) {
        parametersafter.forEach(element => {
            element.disabled = false;
        });

        const existingError = form.querySelector(".warning-box");

        if (existingError) {
            existingError.remove();
            element.classList.remove('no-valid');
        }

    } else {
        const firstInput = form.querySelector('input[name="title"]');

        const errorMessage = document.createElement("p");
        errorMessage.className = "warning-box default-font";
        errorMessage.textContent = message;
    
        if (firstInput) {
            const existingError = form.querySelector(".warning-box");
    
            if (existingError) {
                existingError.remove();
            }
    
            form.insertBefore(errorMessage, firstInput);
            element.classList.add('no-valid');
    
            parametersafter.forEach(element => {
                element.disabled = 'disable';
            });
        }
    }
}

function validateHour() {
    setTimeout(function () {markValidation(hour, isHour(hour.value), 'Incorrect time format!', [submit]);}, 1000);
}

hour.addEventListener('keyup', validateHour);
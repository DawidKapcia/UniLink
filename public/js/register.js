const form = document.querySelector("form");
const submit = form.querySelector('button[type="submit"]');

const email = form.querySelector('input[name="email"]');
const firstname = form.querySelector('input[name="first-name"]');
const lastname = form.querySelector('input[name="last-name"]');
const university = form.querySelector('input[name="university"]');
const password = form.querySelector('input[name="password"]');



function isStudentEmail(email) {
    return /\S+@(?:student\.\S+|\S+\.edu|\S+\.ac)\b/.test(email);
}

function isPassword(password) {
    return /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}$/.test(password);
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
        const firstInput = form.querySelector('input[name="email"]');

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

function validateEmail() {
    setTimeout(function () {markValidation(email, isStudentEmail(email.value), 'Use your student email!', [firstname, lastname, university, password, submit]);}, 1000);
}

function validatePassword() {
    setTimeout(function () {const condition = isPassword(password.value); markValidation(password, condition, 'Password too weak!', [submit]);}, 10);
}

email.addEventListener('keyup', validateEmail);
password.addEventListener('keyup', validatePassword);
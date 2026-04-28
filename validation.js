'use strict';

/* Rules */
const RULES = {
  name: { required: true, min: 2 },
  email: { required: true, pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/ },
  password: { required: true, min: 6 }
};

/* Validate one field */
function validate(name, value) {
  value = value.trim();

  if (RULES[name].required && value === '') {
    return name + ' est obligatoire';
  }

  if (RULES[name].min && value.length < RULES[name].min) {
    return name + ' trop court';
  }

  if (RULES[name].pattern && !RULES[name].pattern.test(value)) {
    return 'email invalide';
  }

  return null;
}

/* Mark input */
function mark(input, error) {
  if (error) {
    input.classList.add('field--error');
  } else {
    input.classList.remove('field--error');
  }
}

/* Show errors */
function showErrors(form, errors) {
  let box = form.querySelector('.error-box');
  if (box) box.remove();

  if (errors.length === 0) return;

  box = document.createElement('div');
  box.className = 'error-box';

  errors.forEach(function (e) {
    let p = document.createElement('p');
    p.textContent = e;
    box.appendChild(p);
  });

  form.prepend(box);
}

/* Init form */
function initForm(formId, fields) {
  let form = document.getElementById(formId);
  if (!form) return;

  form.addEventListener('submit', function (e) {
    let errors = [];

    fields.forEach(function (name) {
      let input = form.querySelector('[name="' + name + '"]');
      let err = validate(name, input.value);

      mark(input, err);

      if (err) errors.push(err);
    });

    if (errors.length > 0) {
      e.preventDefault();
      showErrors(form, errors);
    }
  });
}

/* Start */
document.addEventListener('DOMContentLoaded', function () {
  initForm('form-register', ['name', 'email', 'password']);
  initForm('form-login', ['email', 'password']);
});
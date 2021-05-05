let pwdinput = document.getElementById('password-signup');
pwdinput.addEventListener('input', evt => {
    pwdinput.classList.add('invalid-password');
    let val = pwdinput.value;
    if(val.search(/[a-zA-Z]/) === -1) {
        pwdinput.setCustomValidity('Your password must contain a letter');
        console.log(1)
    } else if(val.search(/[0-9]/) === -1) {
        pwdinput.setCustomValidity('Your password must contain a number');
        console.log(2)
    } else if(val.search(/[`~!@#$%^&*()_+{}[\]|\\:;"'<,>.?/`]/) === -1) {
        pwdinput.setCustomValidity('Your password must contain a special character');
        console.log(3)
    } else if(val.search(/\s/) !== -1) {
        pwdinput.setCustomValidity('Your password cannot contain spaces or line breaks');
        console.log(4)
    } else {
        pwdinput.setCustomValidity('');
        if(val.length >= 8) {
            pwdinput.classList.remove('invalid-password');
            console.log('x')
        }
    }
})

let confirminput = document.getElementById('password-confirm-signup');
confirminput.addEventListener('input', evt => {
    if(confirminput.value !== pwdinput.value) {
        confirminput.setCustomValidity('Passwords do not match');
        confirminput.classList.add('invalid-password');
    } else {
        confirminput.setCustomValidity('');
        confirminput.classList.remove('invalid-password');
    }
})
function formhash(form, password) {
    // Crea una entrada de elemento nuevo, esta será nuestro campo de contraseña con hash. 
    var p = document.createElement("input");
 
    // Agrega el elemento nuevo a nuestro formulario. 
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);
 
    // Asegúrate de que la contraseña en texto simple no se envíe. 
    password.value = "";
 
    // Finalmente envía el formulario. 
    form.submit();
}
 
function regformhash(form, uid, email, password, conf) {
     // Verifica que cada campo tenga un valor
    if (uid.value == ''         || 
          email.value == ''     || 
          password.value == ''  || 
          conf.value == '') {
 
        alert('Deberá brindar toda la información solicitada. Por favor, intente de nuevo');
        return false;
    }
 
    // Verifica el nombre de usuario
 
    re = /^\w+$/; 
    if(!re.test(form.username.value)) { 
        alert("El nombre de usuario deberá contener solo letras, números y guiones bajos. Por favor, inténtelo de nuevo"); 
        form.username.focus();
        return false; 
    }
 
    // Verifica que la contraseña tenga la extensión correcta (mín. 6 caracteres)
    // La verificación se duplica a continuación, pero se incluye para que el
    // usuario tenga una guía más específica.
    if (password.value.length < 6) {
        alert('La contraseña deberá tener al menos 6 caracteres. Por favor, inténtelo de nuevo');
        form.password.focus();
        return false;
    }
 
    // Por lo menos un número, una letra minúscula y una mayúscula 
    // Al menos 6 caracteres
 
    var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/; 
    if (!re.test(password.value)) {
        alert('Las contraseñas deberán contener al menos un número, una letra minúscula y una mayúscula. Por favor, inténtelo de nuevo');
        return false;
    }
 
    // Verifica que la contraseña y la confirmación sean iguales
    if (password.value != conf.value) {
        alert('La contraseña y la confirmación no coinciden. Por favor, inténtelo de nuevo');
        form.password.focus();
        return false;
    }
 
    // Crea una entrada de elemento nuevo, esta será nuestro campo de contraseña con hash. 
    var p = document.createElement("input");
 
    // Agrega el elemento nuevo a nuestro formulario. 
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);
 
    // Asegúrate de que la contraseña en texto simple no se envíe. 
    password.value = "";
    conf.value = "";
 
    // Finalmente envía el formulario. 
    form.submit();
    return true;
}
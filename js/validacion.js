// // js/validacion.js
// document.addEventListener('DOMContentLoaded', function() {
//     const form = document.getElementById('contactForm');
    
//     form.addEventListener('submit', function(event) {
//         if (!form.checkValidity()) {
//             event.preventDefault();
//             event.stopPropagation();
//         }
        
//         form.classList.add('was-validated');
//     });
    
//     // Validación de correo electrónico en tiempo real
//     const emailInput = document.getElementById('correo');
//     emailInput.addEventListener('input', function() {
//         const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
//         if (!emailRegex.test(this.value)) {
//             this.setCustomValidity('Por favor, ingrese un correo electrónico válido');
//         } else {
//             this.setCustomValidity('');
//         }
//     });
    
//     // Validación de longitud mínima para el comentario
//     const comentarioInput = document.getElementById('comentario');
//     comentarioInput.addEventListener('input', function() {
//         if (this.value.length < 10) {
//             this.setCustomValidity('El comentario debe tener al menos 10 caracteres');
//         } else {
//             this.setCustomValidity('');
//         }
//     });
// });

// Validación del formulario
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contactForm');
    
    // Prevenir envío si hay campos inválidos
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    });

    // Validación en tiempo real del correo electrónico
    const emailInput = document.getElementById('correo');
    emailInput.addEventListener('input', function() {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(this.value)) {
            this.setCustomValidity('Por favor, ingresa un correo electrónico válido');
        } else {
            this.setCustomValidity('');
        }
    });

    // Validación de longitud mínima para el mensaje
    const comentarioInput = document.getElementById('comentario');
    comentarioInput.addEventListener('input', function() {
        const minLength = 10;
        if (this.value.length < minLength) {
            this.setCustomValidity(`El mensaje debe tener al menos ${minLength} caracteres`);
        } else {
            this.setCustomValidity('');
        }
    });

    // Limpiar validaciones al modificar los campos
    const inputs = form.querySelectorAll('input, textarea');
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            if (form.classList.contains('was-validated')) {
                form.classList.remove('was-validated');
            }
        });
    });
});
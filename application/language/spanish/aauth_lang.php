<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* E-mail Messages */
/* E-mail Messages */

// Account verification
$lang['permisos_admin'] = 'Se le asignaron permisos de administrador en la empresa: ';
$lang['alta_permisos_admin'] = 'Se registró una cuenta con permisos de administrador en la empresa: ';
$lang['correo_usuario'] = 'Usuario: ';
$lang['aauth_email_verification_subject'] = 'Verificación de Cuenta';
$lang['aauth_email_verification_code'] = 'Su Código de verificación es: ';
$lang['aauth_email_verification_link'] = "Para verificar su cuenta y cambiar su contraseña de clic (o copiar y pegar) en el siguiente enlace:";

// Password reset

$lang['aauth_email_reset_subject'] = 'Cambio de contraseña';
$lang['aauth_email_reset_link'] = "\n\nhttp://localhost/easyCFDi/index.php/usuarios/reset_password/";

// Password reset success
$lang['aauth_email_reset_success_subject'] = 'Cambio de contraseña correcto';
$lang['aauth_email_reset_success_new_password'] = 'Su contraseña ha sido cambiada exitosamente. Su nueva contraseña es : ';

/* Error Messages */

// Account creation errors
$lang['aauth_error_email_exists'] = 'La cuenta de Correo ya existe en el sistema. Si has olvidado tu password reporta al administrador.';
$lang['aauth_error_username_exists'] = "La cuenta ya existe en el sistema con este nombre de usuario. Porfavor ingresa un nombre de usuario diferente, o si has olvidado tu password reporta al administrador.";
$lang['aauth_error_email_invalid'] = 'E-Mail incorrecto';
$lang['aauth_error_password_invalid'] = 'Password Incorrecta';
$lang['aauth_error_username_invalid'] = 'Nombre de Usuario Incorrecto';
$lang['aauth_error_username_required'] = 'Nombre de Usuario requerido';

// Access errors
$lang['aauth_error_no_access'] = 'Lo lamento, no tienes acceso al recurso que solicitaste.';
$lang['aauth_error_login_failed'] = 'E-mail y Password no coinciden.';
$lang['aauth_error_login_attempts_exceeded'] = 'Has exedido tus intentos de iniciar, tu cuenta ha sido bloqueada.';
$lang['aauth_error_recaptcha_not_correct'] = 'Lo lamento, el texto reCAPTCHA que ingresaste es incorrecto.';


// Misc. errors
$lang['aauth_error_no_user'] = 'El usuario no existe';
$lang['aauth_error_account_not_verified'] = 'Tu cuenta no ha sido veerificada. Favor de revisar tu E-Mail y verificar tu cuenta.';
$lang['aauth_error_no_group'] = 'El grupo no existe';
$lang['aauth_error_self_pm'] = 'Es imposible enviarte un mensaje a ti mismo.';
$lang['aauth_error_no_pm'] = 'No se encontro el mensaje privado';


/* Info messages */
$lang['aauth_info_already_member'] = 'El usuario ya es miembro del grupo';
$lang['aauth_info_group_exists'] = 'Nombre del grupo ya existe';
$lang['aauth_info_perm_exists'] = 'Nombre del permiso ya existe';

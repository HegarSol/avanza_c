<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
$lang['aauth_error_email_exists'] = 'Ya existe una cuenta registrada con el mismo correo electrónico. Por favor ingrese uno diferente.';
$lang['aauth_error_username_exists'] = "Ya existe una cuenta con el mismo nombre de Usuario.  Por favor ingrese un nombre diferente.";
$lang['aauth_error_email_invalid'] = 'Correo electrónico inválido';
$lang['aauth_error_password_invalid'] = 'Contraseña inválida';
$lang['aauth_error_username_invalid'] = 'Invalid Username';
$lang['aauth_error_username_required'] = 'El nombre de usuario es requerido';

// Access errors
$lang['aauth_error_no_access'] = 'Sorry, you do not have access to the resource you requested.';
$lang['aauth_error_login_failed'] = 'El usuario y contraseña no coinciden.';
$lang['aauth_error_login_attempts_exceeded'] = 'Ha excedido los intentos de inicio de sesión. Su cuenta ha sido bloqueda. Comuníquese con un administrador.';
$lang['aauth_error_recaptcha_not_correct'] = 'Sorry, the reCAPTCHA text entered was incorrect.';


// Misc. errors

$lang['aauth_error_no_user'] = 'User does not exist';
$lang['aauth_error_account_not_verified'] = 'Your account has not been verified. Please check your e-mail and verify your account.';
$lang['aauth_error_no_group'] = 'Group does not exist';
$lang['aauth_error_self_pm'] = 'It is not possible to send a Message to yourself.';
$lang['aauth_error_no_pm'] = 'Private Message not found';


/* Info messages */
$lang['aauth_info_already_member'] = 'User is already member of group';
$lang['aauth_info_group_exists'] = 'Group name already exists';
$lang['aauth_info_perm_exists'] = 'Permission name already exists';

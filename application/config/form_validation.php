<?php
$config = array(
        'usuarios' => array(
                array('field' => 'correo', 'label' => 'Usuario', 'rules' => 'required|valid_email','errors'=> array('required'=>"El campo <b>%s</b> es requerido",'valid_email'=>"El campo <b>%s</b> debe ser un correo válido.")),
                array('field' => 'contrasena','label' => 'Contraseña','rules' => 'required|min_length[5]','errors'=> array('required'=>"El campo <b>%s</b> es requerido",'min_length'=>"El tamaño mínimo de la contraseña son 5 caracteres")),
                array('field' => 'nombre','label' => 'Nombre Usuario','rules' => 'required','errors'=> array('required'=>"El campo <b>%s</b> es requerido"))
        ),
        'grupos' => array(
                array( 'field' => 'nombre', 'label' => 'Nombre', 'rules' => 'required', 'errors'=> array( 'required'=>"El campo <b>%s</b> es requerido" )),
                array('field' => 'definicion','label' => 'Definición','rules' => 'required','errors'=> array('required'=>"El campo <b>%s</b> es requerido")),
        ),
        'configuracion' => array(
                array('field' => 'rfc','label' => 'RFC','rules' => 'required','errors'=> array('required'=>"El campo <b>%s</b> es requerido")),
                array('field' => 'iva','label' => 'iva','rules' => 'required','errors'=> array('required'=>"El campo <b>%s</b> es requerido")),
        ),
        'empresas' => array(
                array('field' => 'rfc','label' => 'RFC','rules' => 'required','errors'=> array('required'=>"El campo <b>%s</b> es requerido")),
                array('field' => 'basedeDatos','label' => 'Base de Datos','rules' => 'required','errors'=> array('required'=>"El campo <b>%s</b> es requerido")),
                array('field' => 'usuario','label' => 'usuario','rules' => 'required','errors'=> array('required'=>"El campo <b>%s</b> es requerido")),
                array('field' => 'contrasena','label' => 'Contraseña','rules' => 'required','errors'=> array('required'=>"El campo <b>%s</b> es requerido")),
                array('field' => 'host','label' => 'Host','rules' => 'required','errors'=> array('required'=>"El campo <b>%s</b> es requerido"))
        ),
        'cuentas' => array(
              array('field' => 'cuenta','label' => 'cuenta','rules' => 'required','errors' => array('required' => 'El campo <b>%s</b> es requerido')),
              array('field' => 'sub_cta','label' => 'sub_cta','rules' => 'required','errors' => array('required' => 'El campo <b>%s</b> es requerido')),
              array('field' => 'ssub_cta','label' => 'ssub_cta','rules' => 'required','errors' => array('required' => 'El campo <b>%s</b> es requerido')),
              array('field' => 'nombre','label' => 'nombre','rules' => 'required','errors' => array('required' => 'El campo <b>%s</b> es requerido')),
        ),
);
?>

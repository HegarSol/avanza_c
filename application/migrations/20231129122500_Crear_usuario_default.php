
        <?php
class Migration_Crear_usuario_default extends CI_Migration
{
    public function up()
    {
        $salt = md5(1);
		$passwros = hash('sha256', $salt.'lalo38king');
        $data = array(
            'email' => 'lalo-pollo@hotmail.com',
            'pass' => $passwros,
            'name' => 'Super Usuario'
        );
        $this->db->insert('aauth_users',$data);
    }
    public function down()
    {

    }
}
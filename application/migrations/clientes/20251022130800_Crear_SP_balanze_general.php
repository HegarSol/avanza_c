<?php

class Migration_Crear_SP_balanze_general extends CI_Migration {

    public function up()
    {
        $sql = "
        CREATE PROCEDURE balance(pfecha DATE, pCtaCap MEDIUMINT)
            BEGIN
            SELECT c.cuenta,c.sub_cta,c.nombre,(SUM(IF(c_a = '+',monto,0.00))-SUM(IF(c_a = '-',monto,0.00))) AS saldo
                FROM opera_banco_detalle ac LEFT JOIN catalogocta c
                ON ac.cuenta = c.cuenta AND ac.sub_cta = c.sub_cta AND ac.ssub_cta = c.ssub_cta
                WHERE fecha <= pfecha AND c.cuenta <= pCtaCap
                GROUP BY cuenta;
            END
        ";
        $this->db->query($sql);
    }

    public function down()
    {
        $this->db->query("DROP PROCEDURE IF EXISTS GetUsers");
    }
}
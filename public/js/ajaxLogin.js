// JavaScript Document
$(document).ready(function ()
{
    $('#login').click(function ()
    {
        $('#error').html("<span>");
        var username = $("#inputEmail").val();
        var password = $("#inputPassword").val();
        var dataString = 'username=' + username + '&password=' + password;
        if ($.trim(username).length > 0 && $.trim(password).length > 0)
        {
            $.ajax({
                type: "POST",
                url: "/Cobranza/php/ValidaInicioDeSesion.php",
                data: dataString,
                cache: false,
                dataType: 'json',
                beforeSend: function () {
                    $("#login").val('Conectando...');
                    $("#error").html("");
                },
                success: function (data) {
                    if (data.inicioSesion)
                    {
                        window.location.href = "/Cobranza/php/Dashboard.php";
                    }
                    else
                    {
                        $("#login").val('Iniciar');
                        muestraMensaje("<span style='color:#cc0000'>Error: </span>" + data.mensaje,'error');
                    }
                },
                error: function () {
                    $("#login").val('Iniciar');
                    muestraMensaje("<span style='color:#cc0000'>Error: </span> Falla del Servidor.","error");
                }
            });
        }
        return false;
    });
});
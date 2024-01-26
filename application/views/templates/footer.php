<?php
if (!defined('BASEPATH'))
exit('<b><font style="font-size:130px; font-family:arial"> <p align="center">Upss...</p></font></b> <p align ="center"> <font style="font-size:30px; font-family:arial">No se puede accesar directamente al archivo.</font> </p>');
?>
<footer>
  <br><br>
  <div class="col-sm-8">
    <p class="text-muted">
      &copy; HEGAR Soluciones en Sistemas S. de R.L. 2020-<?php echo date('Y');?> (<?php echo ENVIRONMENT;?>)
      Version: <?php echo $this->config->item('version');?>
      <!-- <a href="http://hegarss.com/tools/AnyDesk.exe" class="btn btn-warning btn-xs">AnyDesk</a> -->
    </p>
  </div>
</footer>

<div id="changelog_text">
</body>
</html>

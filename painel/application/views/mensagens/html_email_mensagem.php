<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
</head>
<body style="background-color:#F7FDF9">
<table width="780" border="0" align="center" cellpadding="0" cellspacing="0">
  
  <tr>
    <td height="103">&nbsp;</td>
  </tr>

  <tr>
    <td><table width="780" style="background-color:#FFF; border: #047847 solid 2px; border-radius:10px;" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td height="257"><table width="750" border="0" align="center" class="table_top" cellpadding="0" cellspacing="0">
          <tr>
            <td height="125" align="center"><img src="<?php echo base_url('assets/img/logo_email.png');?>" ></td>
          </tr>
          <tr>
            <td height="94" style="line-height:25px;">
            	<div align="center" >Sua demanda Nº <?php echo $id_demanda; ?> cadastrada no site <?php echo $this->config->item('title'); ;?>, recebeu uma nova mensagem:</div><br>
              <strong>Assunto:</strong><br><?php echo $assunto; ?><br>
              <strong>Mensagem: </strong><br><?php echo $msg; ?></td>
          </tr>
          <tr>
            <td height="19" align="center">Faça login em sua conta no site 
            <a href="http://<?php echo $this->config->item('url_site'); ;?>" style="text-decoration: none; color:#060;">
			<?php echo $this->config->item('url_site'); ;?></a> para maiores informações.<br>
              * Não responder esse e-mail</td>
          </tr>
        </table></td>
      </tr>
     
      <tr>
        <td height="39" align="center"><h2>&nbsp;</h2></td>
      </tr>
      <tr>
        <td height="81" align="center" valign="top">
        <a href="http://<?php echo $this->config->item('url_site'); ;?>" style="text-decoration: none; color:#060; font-size:25px;"><?php echo $this->config->item('url_site'); ;?></a>
        </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="189">&nbsp;</td>
  </tr>
</table>


</body>
</html>
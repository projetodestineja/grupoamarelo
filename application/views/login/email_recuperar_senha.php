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
        <td><table width="750" border="0" align="center" class="table_top" cellpadding="0" cellspacing="0">
          <tr>
            <td height="200" align="center"><img src="<?php echo base_url('assets/img/logo_email.png');?>" ></td>
          </tr>
          <tr>
            <td height="94">Ol&aacute; <strong><?php echo $nome; ?></strong>, foi solicitado a recuperação de senha no site <?php echo $this->config->item('title'); ?>.<br>
              <br>
              Guarde suas informações de acesso com segurança.<br>
              <br>
              
              <div style="background-color:#F8F8F8; border-radius:10px; ">
              <table width="750" height="71" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="75" height="71" align="left" bgcolor=""></td>
                  <td width="675" align="left" style="font-size:22px; padding-top:25px; padding-bottom:25px;">
                  	<strong>Login:</strong> <?php echo $email; ?>
                    <hr>
                    <strong>Senha: </strong> <?php echo $senha; ?>
                  </td>
                </tr>
              </table>
              </div>
              
              </td>
          </tr>
          <tr>
            <td height="19" align="center">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
     
      <tr>
        <td height="39" align="center"><h2>&nbsp;</h2></td>
      </tr>
      <tr>
        <td height="81" align="center" valign="top"><a href="<?php echo site_url();?>" style="text-decoration: none; color:#060; font-size:25px;">www.destineja.com.br</a></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="189">&nbsp;</td>
  </tr>
</table>


</body>
</html>
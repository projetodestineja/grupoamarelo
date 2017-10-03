<form id="form_cad_gerador" action="" method="POST">
		
    <div class="form-row">
        <div class="col-md-12" >
            <h5>Configurações SMTP para o envio de E-mail:</h5>
        </div>
	<div class="form-group col-md-12  required">
            <label for="email_smtp" class="col-form-label">E-mail Usando na coneção SMTP:</label>
            <input type="email" class="form-control" id="smtp_email" value="<?php echo $smtp_email; ?>" name="smtp_email" placeholder="Digite o e-mail">
	</div>
        <div class="form-group col-md-12  required">
            <label for="senha_smtp" class="col-form-label">Senha do e-mail:</label>
            <input type="text" class="form-control" id="smtp_senha" value="<?php echo $smtp_senha; ?>" name="smtp_senha" placeholder="Digite a Senha">
	</div>
        <div class="form-group col-md-12  required">
            <label for="porta_smtp" class="col-form-label">Porta SMTP:</label>
            <input type="text" class="form-control" id="smtp_porta" value="<?php echo $smtp_porta; ?>" name="smtp_porta" placeholder="Digite o número da porta SMTP Geralmente 587 ou 465">
	</div>
        <div class="form-group col-md-12  required">
            <label for="smtp_servidor" class="col-form-label">Endereço do Servidor SMTP:</label>
            <input type="text" class="form-control" id="smtp_servidor" value="<?php echo $smtp_servidor; ?>" name="smtp_servidor" placeholder="Endedeço do servidor SMTP geralmente mail.seudominio.com.br">
	</div>
    </div>
    
    <div class="form-row">
        <div class="col-md-12" >
            <h5>Quem Vai Receber Alerta de Demanda por E-mail:</h5>
        </div>
	<div class="form-group col-md-12  required">
            <label for="smtp_send_email_demanda" class="col-form-label">E-mail para Receber Alerta de Demanda:</label>
            <input type="email" class="form-control" id="smtp_send_email_demanda" value="<?php echo $smtp_send_email_demanda; ?>" name="smtp_send_email_demanda" placeholder="Digite o e-mail, separe por virgural(,) ou ponto e virgula(;)">
	</div>
    </div>
			
    <button class="btn btn-success btn-md" type="submit"> <i class="fa fa-floppy-o" aria-hidden="true"></i> ATUALIZAR INFORMAÇÕES </button>
</form>
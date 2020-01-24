<?php
	include('protect.php');
		protect();
	include_once("conexao/conexao.php"); 
	$codigo = $_SESSION['cd_usuario'];
	
	if(isset($_POST['agendar'])){
			
			$diaSemana = $_POST['diaSemana'];
			$materia = $_POST['materia'];
			$outraMateria = $_POST['outraMateria'];
			$hr = $_POST['hr'];
			
			
				
				if((!empty($outraMateria))){
					$inOutraMateria = $con -> query("call sp_outroPlanejamentoUsuario($codigo, '$outraMateria', $diaSemana, '$hr');
					");
					$row= $inOutraMateria -> fetch(PDO::FETCH_OBJ);
					if(!empty($row->erro)){
						echo "<script>alert('".utf8_encode($row->erro)."');</script>";
						?>
						<script>location.href='index.php';</script>
						<?php
					}else{
						echo "<script>alert('Agendado com sucesso');</script>";
						?>
						<script>location.href='index.php';</script>
						<?php
					}
					
				}else{
			
					$planUser = $con -> query("call sp_planejamentoUsuario($codigo, $materia, $diaSemana, '$hr');");
					$rowplan= $planUser -> fetch(PDO::FETCH_OBJ);
				
					if(!empty($rowplan->erro)){
						echo "<script>alert('".utf8_encode($rowplan->erro)."');</script>";
						?>
						<script>location.href='index.php';</script>
						<?php
					}else{
						echo "<script>alert('Agendado com sucesso');</script>";
						?>
						<script>location.href='index.php';</script>
						<?php
					}
				}
			
		}
?>
<!--==========================
	Cronograma Section
============================-->
<section id="schedule" class="section-with-bg">
	<div class="container wow fadeInUp">
		<div class="section-header">
			<h2>Cronograma</h2>
			<p>Aqui está o seu calendário de tarefas</p>
		</div>

		<ul class="nav nav-tabs" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" href="#dom" role="tab" data-toggle="tab">Dom</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#seg" role="tab" data-toggle="tab">Seg</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#ter" role="tab" data-toggle="tab">Ter</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#qua" role="tab" data-toggle="tab">Qua</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#qui" role="tab" data-toggle="tab">Qui</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#sex" role="tab" data-toggle="tab">Sex</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#sab" role="tab" data-toggle="tab">Sáb</a>
			</li>
		</ul>

		<div class="tab-content row justify-content-center">

			<!-- Cronograma Dom -->
			<div role="tabpanel" class="col-lg-9 tab-pane fade show active" id="dom">
				<?php $dom = $con -> query("select cd_planejamento, hr_planejamento, nm_materia, case dt_planejamento 
								when 1 then 'Domingo' 
								when 2 then 'Segunda - feira' 
								when 3 then 'Terça - feira' 
								when 4 then 'Quarta - feira' 
								when 5 then 'Quinta - feira' 
								when 6 then 'Sexta - feira' 
								when 7 then 'Sabado' 
								end as dt_planejamento 
				from tb_materia join tb_planejamento on tb_materia.cd_materia = tb_planejamento.cd_materia 
                join tb_usuario on tb_planejamento.cd_usuario = $codigo and tb_usuario.cd_usuario  = $codigo and dt_planejamento = 1 
				UNION
				select cd_planejamento, hr_planejamento, nm_outra_materia, case dt_planejamento 
								when 1 then 'Domingo' 
								when 2 then 'Segunda - feira' 
								when 3 then 'Terça - feira' 
								when 4 then 'Quarta - feira' 
								when 5 then 'Quinta - feira' 
								when 6 then 'Sexta - feira' 
								when 7 then 'Sabado' 
								end as dt_planejamento 
							from tb_outra_materia join tb_planejamento on tb_outra_materia.cd_outra_materia = tb_planejamento.cd_outra_materia 
							join tb_usuario on tb_planejamento.cd_usuario = $codigo and tb_usuario.cd_usuario  = $codigo and dt_planejamento = 1 order by hr_planejamento;");
				while($rowDom= $dom -> fetch(PDO::FETCH_OBJ)){
				?>
				<div class="row schedule-item">
					<div class="col-md-2">
						<time><?php echo $rowDom->hr_planejamento; ?></time>
					</div>
					<div class="col-md-10">
						<!--<div class="speaker">
							<img src="img/speakers/1.jpg" alt="Brenden Legros">
						</div>-->
						<h4><?php echo utf8_encode($rowDom->nm_materia); ?></h4>
					</div>
					<div class="col-md-2" >
						<form action="remove_tarefa.php" method="POST"><button type="submit" class="btn btn-danger" value="<?php echo $rowDom->cd_planejamento; ?>" name="cdPlan"><i class="fa fa-trash" aria-hidden="true"></i></button></form>
					</div>
				</div>
				<?php } ?>
			</div>
			<!-- End Cronograma Dom -->

			<!-- Cronograma Seg -->
			<div role="tabpanel" class="col-lg-9  tab-pane fade" id="seg">

				<?php $dom = $con -> query("select cd_planejamento, hr_planejamento, nm_materia, case dt_planejamento 
								when 1 then 'Domingo' 
								when 2 then 'Segunda - feira' 
								when 3 then 'Terça - feira' 
								when 4 then 'Quarta - feira' 
								when 5 then 'Quinta - feira' 
								when 6 then 'Sexta - feira' 
								when 7 then 'Sabado' 
								end as dt_planejamento 
				from tb_materia join tb_planejamento on tb_materia.cd_materia = tb_planejamento.cd_materia 
                join tb_usuario on tb_planejamento.cd_usuario = $codigo and tb_usuario.cd_usuario  = $codigo and dt_planejamento = 2 
				UNION
				select cd_planejamento, hr_planejamento, nm_outra_materia, case dt_planejamento 
								when 1 then 'Domingo' 
								when 2 then 'Segunda - feira' 
								when 3 then 'Terça - feira' 
								when 4 then 'Quarta - feira' 
								when 5 then 'Quinta - feira' 
								when 6 then 'Sexta - feira' 
								when 7 then 'Sabado' 
								end as dt_planejamento 
							from tb_outra_materia join tb_planejamento on tb_outra_materia.cd_outra_materia = tb_planejamento.cd_outra_materia 
							join tb_usuario on tb_planejamento.cd_usuario = $codigo and tb_usuario.cd_usuario  = $codigo and dt_planejamento = 2 order by hr_planejamento;");
				while($rowDom= $dom -> fetch(PDO::FETCH_OBJ)){
				?>
				<div class="row schedule-item">
					<div class="col-md-2">
						<time><?php echo $rowDom->hr_planejamento; ?></time>
					</div>
					<div class="col-md-10">
						<!--<div class="speaker">
							<img src="img/speakers/1.jpg" alt="Brenden Legros">
						</div>-->
						<h4><?php echo utf8_encode($rowDom->nm_materia); ?></h4>
					</div>
					<div class="col-md-2" >
						<form action="remove_tarefa.php" method="POST"><button type="submit" class="btn btn-danger" value="<?php echo $rowDom->cd_planejamento; ?>" name="cdPlan"><i class="fa fa-trash" aria-hidden="true"></i></button></form>
					</div>
				</div>
				<?php } ?>

			</div>
			<!-- End Cronograma Seg -->

			<!-- Cronograma Ter -->
			<div role="tabpanel" class="col-lg-9  tab-pane fade" id="ter">

				<?php $dom = $con -> query("select cd_planejamento, hr_planejamento, nm_materia, case dt_planejamento 
								when 1 then 'Domingo' 
								when 2 then 'Segunda - feira' 
								when 3 then 'Terça - feira' 
								when 4 then 'Quarta - feira' 
								when 5 then 'Quinta - feira' 
								when 6 then 'Sexta - feira' 
								when 7 then 'Sabado' 
								end as dt_planejamento 
				from tb_materia join tb_planejamento on tb_materia.cd_materia = tb_planejamento.cd_materia 
                join tb_usuario on tb_planejamento.cd_usuario = $codigo and tb_usuario.cd_usuario  = $codigo and dt_planejamento = 3 
				UNION
				select cd_planejamento, hr_planejamento, nm_outra_materia, case dt_planejamento 
								when 1 then 'Domingo' 
								when 2 then 'Segunda - feira' 
								when 3 then 'Terça - feira' 
								when 4 then 'Quarta - feira' 
								when 5 then 'Quinta - feira' 
								when 6 then 'Sexta - feira' 
								when 7 then 'Sabado' 
								end as dt_planejamento 
							from tb_outra_materia join tb_planejamento on tb_outra_materia.cd_outra_materia = tb_planejamento.cd_outra_materia 
							join tb_usuario on tb_planejamento.cd_usuario = $codigo and tb_usuario.cd_usuario  = $codigo and dt_planejamento = 3 order by hr_planejamento;");
				while($rowDom= $dom -> fetch(PDO::FETCH_OBJ)){
				?>
				<div class="row schedule-item">
					<div class="col-md-2">
						<time><?php echo $rowDom->hr_planejamento; ?></time>
					</div>
					<div class="col-md-10">
						<!--<div class="speaker">
							<img src="img/speakers/1.jpg" alt="Brenden Legros">
						</div>-->
						<h4><?php echo utf8_encode($rowDom->nm_materia); ?></h4>
					</div>
					<div class="col-md-2">
						<form action="remove_tarefa.php" method="POST"><button type="submit" class="btn btn-danger" value="<?php echo $rowDom->cd_planejamento; ?>" name="cdPlan"><i class="fa fa-trash" aria-hidden="true"></i></button></form>
					</div>
				</div>
				<?php } ?>

			</div>
			<!-- End Cronograma Ter -->
			
			<!-- Cronograma Qua -->
			<div role="tabpanel" class="col-lg-9  tab-pane fade" id="qua">

				<?php $dom = $con -> query("select cd_planejamento, hr_planejamento, nm_materia, case dt_planejamento 
								when 1 then 'Domingo' 
								when 2 then 'Segunda - feira' 
								when 3 then 'Terça - feira' 
								when 4 then 'Quarta - feira' 
								when 5 then 'Quinta - feira' 
								when 6 then 'Sexta - feira' 
								when 7 then 'Sabado' 
								end as dt_planejamento 
				from tb_materia join tb_planejamento on tb_materia.cd_materia = tb_planejamento.cd_materia 
                join tb_usuario on tb_planejamento.cd_usuario = $codigo and tb_usuario.cd_usuario  = $codigo and dt_planejamento = 4 
				UNION
				select cd_planejamento, hr_planejamento, nm_outra_materia, case dt_planejamento 
								when 1 then 'Domingo' 
								when 2 then 'Segunda - feira' 
								when 3 then 'Terça - feira' 
								when 4 then 'Quarta - feira' 
								when 5 then 'Quinta - feira' 
								when 6 then 'Sexta - feira' 
								when 7 then 'Sabado' 
								end as dt_planejamento 
							from tb_outra_materia join tb_planejamento on tb_outra_materia.cd_outra_materia = tb_planejamento.cd_outra_materia 
							join tb_usuario on tb_planejamento.cd_usuario = $codigo and tb_usuario.cd_usuario  = $codigo and dt_planejamento = 4 order by hr_planejamento;");
				while($rowDom= $dom -> fetch(PDO::FETCH_OBJ)){
				?>
				<div class="row schedule-item">
					<div class="col-md-2">
						<time><?php echo $rowDom->hr_planejamento; ?></time>
					</div>
					<div class="col-md-10">
						<!--<div class="speaker">
							<img src="img/speakers/1.jpg" alt="Brenden Legros">
						</div>-->
						<h4><?php echo utf8_encode($rowDom->nm_materia); ?></h4>
					</div>
					<div class="col-md-2" >
						<form action="remove_tarefa.php" method="POST"><button type="submit" class="btn btn-danger" value="<?php echo $rowDom->cd_planejamento; ?>" name="cdPlan"><i class="fa fa-trash" aria-hidden="true"></i></button></form>
					</div>
				</div>
				<?php } ?>

			</div>
			<!-- End Cronograma Qua -->
			
			<!-- Cronograma Qui -->
			<div role="tabpanel" class="col-lg-9  tab-pane fade" id="qui">

				<?php $dom = $con -> query("select cd_planejamento, hr_planejamento, nm_materia, case dt_planejamento 
								when 1 then 'Domingo' 
								when 2 then 'Segunda - feira' 
								when 3 then 'Terça - feira' 
								when 4 then 'Quarta - feira' 
								when 5 then 'Quinta - feira' 
								when 6 then 'Sexta - feira' 
								when 7 then 'Sabado' 
								end as dt_planejamento 
				from tb_materia join tb_planejamento on tb_materia.cd_materia = tb_planejamento.cd_materia 
                join tb_usuario on tb_planejamento.cd_usuario = $codigo and tb_usuario.cd_usuario  = $codigo and dt_planejamento = 5 
				UNION
				select cd_planejamento, hr_planejamento, nm_outra_materia, case dt_planejamento 
								when 1 then 'Domingo' 
								when 2 then 'Segunda - feira' 
								when 3 then 'Terça - feira' 
								when 4 then 'Quarta - feira' 
								when 5 then 'Quinta - feira' 
								when 6 then 'Sexta - feira' 
								when 7 then 'Sabado' 
								end as dt_planejamento 
							from tb_outra_materia join tb_planejamento on tb_outra_materia.cd_outra_materia = tb_planejamento.cd_outra_materia 
							join tb_usuario on tb_planejamento.cd_usuario = $codigo and tb_usuario.cd_usuario  = $codigo and dt_planejamento = 5 order by hr_planejamento;");
				while($rowDom= $dom -> fetch(PDO::FETCH_OBJ)){
				?>
				<div class="row schedule-item">
					<div class="col-md-2">
						<time><?php echo $rowDom->hr_planejamento; ?></time>
					</div>
					<div class="col-md-10">
						<!--<div class="speaker">
							<img src="img/speakers/1.jpg" alt="Brenden Legros">
						</div>-->
						<h4><?php echo utf8_encode($rowDom->nm_materia); ?></h4>
					</div>
					<div class="col-md-2" >
						<form action="remove_tarefa.php" method="POST"><button type="submit" class="btn btn-danger" value="<?php echo $rowDom->cd_planejamento; ?>" name="cdPlan"><i class="fa fa-trash" aria-hidden="true"></i></button></form>
					</div>
				</div>
				<?php } ?>

			</div>
			<!-- End Cronograma Qui -->
			
			<!-- Cronograma Sex -->
			<div role="tabpanel" class="col-lg-9  tab-pane fade" id="sex">

				<?php $dom = $con -> query("select cd_planejamento, hr_planejamento, nm_materia, case dt_planejamento 
								when 1 then 'Domingo' 
								when 2 then 'Segunda - feira' 
								when 3 then 'Terça - feira' 
								when 4 then 'Quarta - feira' 
								when 5 then 'Quinta - feira' 
								when 6 then 'Sexta - feira' 
								when 7 then 'Sabado' 
								end as dt_planejamento 
				from tb_materia join tb_planejamento on tb_materia.cd_materia = tb_planejamento.cd_materia 
                join tb_usuario on tb_planejamento.cd_usuario = $codigo and tb_usuario.cd_usuario  = $codigo and dt_planejamento = 6 
				UNION
				select cd_planejamento, hr_planejamento, nm_outra_materia, case dt_planejamento 
								when 1 then 'Domingo' 
								when 2 then 'Segunda - feira' 
								when 3 then 'Terça - feira' 
								when 4 then 'Quarta - feira' 
								when 5 then 'Quinta - feira' 
								when 6 then 'Sexta - feira' 
								when 7 then 'Sabado' 
								end as dt_planejamento 
							from tb_outra_materia join tb_planejamento on tb_outra_materia.cd_outra_materia = tb_planejamento.cd_outra_materia 
							join tb_usuario on tb_planejamento.cd_usuario = $codigo and tb_usuario.cd_usuario  = $codigo and dt_planejamento = 6 order by hr_planejamento;");
				while($rowDom= $dom -> fetch(PDO::FETCH_OBJ)){
				?>
				<div class="row schedule-item">
					<div class="col-md-2">
						<time><?php echo $rowDom->hr_planejamento; ?></time>
					</div>
					<div class="col-md-10">
						<!--<div class="speaker">
							<img src="img/speakers/1.jpg" alt="Brenden Legros">
						</div>-->
						<h4><?php echo utf8_encode($rowDom->nm_materia); ?></h4>
					</div>
					<div class="col-md-2" >
						<form action="remove_tarefa.php" method="POST"><button type="submit" class="btn btn-danger" value="<?php echo $rowDom->cd_planejamento; ?>" name="cdPlan"><i class="fa fa-trash" aria-hidden="true"></i></button></form>
					</div>
				</div>
				<?php } ?>

			</div>
			<!-- End Cronograma Sex -->
			
			<!-- Cronograma Sáb -->
			<div role="tabpanel" class="col-lg-9  tab-pane fade" id="sab">

				<?php $dom = $con -> query("select cd_planejamento, hr_planejamento, nm_materia, case dt_planejamento 
								when 1 then 'Domingo' 
								when 2 then 'Segunda - feira' 
								when 3 then 'Terça - feira' 
								when 4 then 'Quarta - feira' 
								when 5 then 'Quinta - feira' 
								when 6 then 'Sexta - feira' 
								when 7 then 'Sabado' 
								end as dt_planejamento 
				from tb_materia join tb_planejamento on tb_materia.cd_materia = tb_planejamento.cd_materia 
                join tb_usuario on tb_planejamento.cd_usuario = $codigo and tb_usuario.cd_usuario  = $codigo and dt_planejamento = 7 
				UNION
				select cd_planejamento, hr_planejamento, nm_outra_materia, case dt_planejamento 
								when 1 then 'Domingo' 
								when 2 then 'Segunda - feira' 
								when 3 then 'Terça - feira' 
								when 4 then 'Quarta - feira' 
								when 5 then 'Quinta - feira' 
								when 6 then 'Sexta - feira' 
								when 7 then 'Sabado' 
								end as dt_planejamento 
							from tb_outra_materia join tb_planejamento on tb_outra_materia.cd_outra_materia = tb_planejamento.cd_outra_materia 
							join tb_usuario on tb_planejamento.cd_usuario = $codigo and tb_usuario.cd_usuario  = $codigo and dt_planejamento = 7 order by hr_planejamento;");
				while($rowDom= $dom -> fetch(PDO::FETCH_OBJ)){
				?>
				<div class="row schedule-item">
					<div class="col-md-2">
						<time><?php echo $rowDom->hr_planejamento; ?></time>
					</div>
					<div class="col-md-10">
						<!--<div class="speaker">
							<img src="img/speakers/1.jpg" alt="Brenden Legros">
						</div>-->
						<h4><?php echo utf8_encode($rowDom->nm_materia); ?></h4>
					</div>
					<div class="col-md-2" >
						<form action="remove_tarefa.php" method="POST"><button type="submit" class="btn btn-danger" value="<?php echo $rowDom->cd_planejamento; ?>" name="cdPlan"><i class="fa fa-trash" aria-hidden="true"></i></button></form>
					</div>
				</div>
				<?php } ?>
		
			</div>
			<!-- End Cronograma Sáb -->
		
		</div>
		<center>
		<a data-toggle="modal" data-target="#agendarTarefa" class="about-btn scrollto">Agendar nova tarefa</a>
		</center>
	</div>
	<!-- Modal Agendar nova tarefa -->
		<div id="agendarTarefa" class="modal fade">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Agendar nova tarefa</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form name="formAgenda" action="" method="POST" class="form-signin" onSubmit="return validacaoAgenda();">
							<div class="form-group">
								<select name="hr" id="hr" class="form-control">
									<option value="">-- Selecionar Horário --</option>
									<option value="05/ 06h">05/ 06h</option>
									<option value="06/ 07h">06/ 07h</option>
									<option value="07/ 08h">07/ 08h</option>
									<option value="08/ 09h">08/ 09h</option>
									<option value="09/ 10h">09/ 10h</option>
									<option value="10/ 11h">10/ 11h</option>
									<option value="11/ 12h">11/ 12h</option>
									<option value="12/ 13h">12/ 13h</option>
									<option value="13/ 14h">13/ 14h</option>
									<option value="14/ 15h">14/ 15h</option>
									<option value="15/ 16h">15/ 16h</option>
									<option value="16/ 17h">16/ 17h</option>
									<option value="17/ 18h">17/ 18h</option>
									<option value="18/ 19h">18/ 19h</option>
									<option value="19/ 20h">19/ 20h</option>
									<option value="20/ 21h">20/ 21h</option>
									<option value="21/ 22h">21/ 22h</option>
									<option value="22/ 23h">22/ 23h</option>
									<option value="23/ 00h">23/ 00h</option>
								</select>
							</div>
							<div class="form-group">
								<select name="diaSemana" id="diaSemana" class="form-control">
									<option value="">-- Selecionar Dia da Semana --</option>
									<option value="1">Domingo</option>
									<option value="2">Segunda - feira</option>
									<option value="3">Terça - feira</option>
									<option value="4">Quarta - feira</option>
									<option value="5">Quinta - feira</option>
									<option value="6">Sexta - feira</option>
									<option value="7">Sabado</option>
								</select>
							</div>
							<div class="form-group">
								<select name="materia" id="materia" class="form-control">
									<option value="">-- Selecionar Materia --</option>
									<?php
										$infom = $con -> query("select * from tb_materia;");
										while($row= $infom -> fetch(PDO::FETCH_OBJ)){
									?>
									<option value="<?php echo utf8_encode($row->cd_materia); ?>" ><?php echo utf8_encode($row->nm_materia); ?></option>
									<?php
										}
										unset($_SESSION['msg']);
									?>
									<?php
										$infoMateria = $con -> query("select * from tb_outra_materia where cd_usuario = $codigo;");
										while($row= $infoMateria -> fetch(PDO::FETCH_OBJ)){
									?>
									<option value="<?php echo utf8_encode($row->cd_outra_materia); ?>" ><?php echo utf8_encode($row->nm_outra_materia); ?></option>
									<?php
										}
									?>
								</select>
							</div>
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<div class="input-group-text">
										<input type="checkbox" id="outro" name="outro" value="check" aria-label="Checkbox for following text input">
									</div>
								</div>
								<input type="text" class="form-control" name="outraMateria" id="outraMateria" placeholder="Outros" aria-label="Text input with checkbox">
							</div>
							<div class="text-center">
								<input name="agendar" value="Agendar" type="submit" class='btn'>
							</div>
						</form>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->
</section>
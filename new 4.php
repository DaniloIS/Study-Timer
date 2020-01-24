<?php $mesp1 = $con -> query("select nm_materia as materia,
				concat(date_format(DATE_SUB(curdate(), INTERVAL DAYOFMONTH(curdate())-1 DAY), '%d/%m/%Y'),' - ', date_format(LAST_DAY(curdate()), '%d/%m/%Y')) as dt_data,
				time_format( SEC_TO_TIME( SUM( TIME_TO_SEC( hr_tempo ) ) ),'%H:%i:%s') as hr_tempo,
				concat(ceil(sum(hr_tempo) * 100 / total_tempo),'%') as porcentagem ,
				sum(qt_pomodoro) as qt_pomodoro
					from 
					(SELECT SUM(hr_tempo) as total_tempo from tb_registro_tempo where MONTH(dt_registro_tempo) = month(curdate()) ) as total,
					tb_registro_tempo 
						
						join tb_materia
							on tb_materia.cd_materia = tb_registro_tempo.cd_materia
								where 
									cd_usuario = $codigo 
									and MONTH(dt_registro_tempo) = month(curdate()) 
									and YEAR(dt_registro_tempo) = year(curdate()) 
									and tb_materia.cd_materia = 1;"); ?>
				<div class="box">
					<div class="box-header with-border">
					  <h3 class="box-title"></h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
					  <table class="table table-bordered">
						<tr>
						  <th style="width: 10px">#</th>
						  <th>Materia</th>
						  <th>Progresso</th>
						  <th style="width: 40px">Label</th>
						</tr>
						<tr>
						<?php 
							while($rowm= $mesp1 -> fetch(PDO::FETCH_OBJ)){
						?>
						  <td>1.</td>
						  <td><?php echo utf8_encode($rowm->materia); ?></td>
						  <td>
							<div class="progress progress-xs">
							  <div class="progress-bar progress-bar-danger" style="width: <?php echo $rowm->porcentagem; ?>"></div>
							</div>
						  </td>
						  <td><span class="badge bg-red"><?php echo $rowm->porcentagem; ?></span></td>
						  <?php } ?>
						</tr>
						<tr>
							<?php $mesp2 = $con -> query("select nm_materia as materia,
							concat(date_format(DATE_SUB(curdate(), INTERVAL DAYOFMONTH(curdate())-1 DAY), '%d/%m/%Y'),' - ', date_format(LAST_DAY(curdate()), '%d/%m/%Y')) as dt_data,
							time_format( SEC_TO_TIME( SUM( TIME_TO_SEC( hr_tempo ) ) ),'%H:%i:%s') as hr_tempo,
							concat(ceil(sum(hr_tempo) * 100 / total_tempo),'%') as porcentagem ,
							sum(qt_pomodoro) as qt_pomodoro
								from 
								(SELECT SUM(hr_tempo) as total_tempo from tb_registro_tempo where MONTH(dt_registro_tempo) = month(curdate()) ) as total,
								tb_registro_tempo 
									
									join tb_materia
										on tb_materia.cd_materia = tb_registro_tempo.cd_materia
											where 
												cd_usuario = $codigo 
												and MONTH(dt_registro_tempo) = month(curdate()) 
												and YEAR(dt_registro_tempo) = year(curdate()) 
												and tb_materia.cd_materia = 2;"); 
							while($rowm= $mesp2 -> fetch(PDO::FETCH_OBJ)){
						  ?>
						  <td>2.</td>
						  <td><?php echo utf8_encode($rowm->materia); ?></td>
						  <td>
							<div class="progress progress-xs">
							  <div class="progress-bar progress-bar-yellow" style="width: <?php echo $rowm->porcentagem; ?>"></div>
							</div>
						  </td>
						  <td><span class="badge bg-yellow"><?php echo $rowm->porcentagem; ?></span></td>
							<?php } ?>
						</tr>
						<tr>
							<?php $mesp3 = $con -> query("select nm_materia as materia,
							concat(date_format(DATE_SUB(curdate(), INTERVAL DAYOFMONTH(curdate())-1 DAY), '%d/%m/%Y'),' - ', date_format(LAST_DAY(curdate()), '%d/%m/%Y')) as dt_data,
							time_format( SEC_TO_TIME( SUM( TIME_TO_SEC( hr_tempo ) ) ),'%H:%i:%s') as hr_tempo,
							concat(ceil(sum(hr_tempo) * 100 / total_tempo),'%') as porcentagem ,
							sum(qt_pomodoro) as qt_pomodoro
								from 
								(SELECT SUM(hr_tempo) as total_tempo from tb_registro_tempo where MONTH(dt_registro_tempo) = month(curdate()) ) as total,
								tb_registro_tempo 
									
									join tb_materia
										on tb_materia.cd_materia = tb_registro_tempo.cd_materia
											where 
												cd_usuario = $codigo 
												and MONTH(dt_registro_tempo) = month(curdate()) 
												and YEAR(dt_registro_tempo) = year(curdate()) 
												and tb_materia.cd_materia = 3;"); 
							while($rowm= $mesp3 -> fetch(PDO::FETCH_OBJ)){
						  ?>
						  <td>3.</td>
						  <td><?php echo utf8_encode($rowm->materia); ?></td>
						  <td>
							<div class="progress progress-xs">
							  <div class="progress-bar progress-bar-yellow" style="width: <?php echo $rowm->porcentagem; ?>"></div>
							</div>
						  </td>
						  <td><span class="badge bg-yellow"><?php echo $rowm->porcentagem; ?></span></td>
							<?php } ?>
						</tr>
						<tr>
							<?php $mesp4 = $con -> query("select nm_materia as materia,
							concat(date_format(DATE_SUB(curdate(), INTERVAL DAYOFMONTH(curdate())-1 DAY), '%d/%m/%Y'),' - ', date_format(LAST_DAY(curdate()), '%d/%m/%Y')) as dt_data,
							time_format( SEC_TO_TIME( SUM( TIME_TO_SEC( hr_tempo ) ) ),'%H:%i:%s') as hr_tempo,
							concat(ceil(sum(hr_tempo) * 100 / total_tempo),'%') as porcentagem ,
							sum(qt_pomodoro) as qt_pomodoro
								from 
								(SELECT SUM(hr_tempo) as total_tempo from tb_registro_tempo where MONTH(dt_registro_tempo) = month(curdate()) ) as total,
								tb_registro_tempo 
									
									join tb_materia
										on tb_materia.cd_materia = tb_registro_tempo.cd_materia
											where 
												cd_usuario = $codigo 
												and MONTH(dt_registro_tempo) = month(curdate()) 
												and YEAR(dt_registro_tempo) = year(curdate()) 
												and tb_materia.cd_materia = 4;"); 
							while($rowm= $mesp4 -> fetch(PDO::FETCH_OBJ)){
						  ?>
						  <td>4.</td>
						  <td><?php echo utf8_encode($rowm->materia); ?></td>
						  <td>
							<div class="progress progress-xs">
							  <div class="progress-bar progress-bar-yellow" style="width: <?php echo $rowm->porcentagem; ?>"></div>
							</div>
						  </td>
						  <td><span class="badge bg-yellow"><?php echo $rowm->porcentagem; ?></span></td>
							<?php } ?>
						</tr>
						<tr>
							<?php $mesp5 = $con -> query("select nm_materia as materia,
							concat(date_format(DATE_SUB(curdate(), INTERVAL DAYOFMONTH(curdate())-1 DAY), '%d/%m/%Y'),' - ', date_format(LAST_DAY(curdate()), '%d/%m/%Y')) as dt_data,
							time_format( SEC_TO_TIME( SUM( TIME_TO_SEC( hr_tempo ) ) ),'%H:%i:%s') as hr_tempo,
							concat(ceil(sum(hr_tempo) * 100 / total_tempo),'%') as porcentagem ,
							sum(qt_pomodoro) as qt_pomodoro
								from 
								(SELECT SUM(hr_tempo) as total_tempo from tb_registro_tempo where MONTH(dt_registro_tempo) = month(curdate()) ) as total,
								tb_registro_tempo 
									
									join tb_materia
										on tb_materia.cd_materia = tb_registro_tempo.cd_materia
											where 
												cd_usuario = $codigo 
												and MONTH(dt_registro_tempo) = month(curdate()) 
												and YEAR(dt_registro_tempo) = year(curdate()) 
												and tb_materia.cd_materia = 5;"); 
							while($rowm= $mesp5 -> fetch(PDO::FETCH_OBJ)){
						  ?>
						  <td>5.</td>
						  <td><?php echo utf8_encode($rowm->materia); ?></td>
						  <td>
							<div class="progress progress-xs">
							  <div class="progress-bar progress-bar-yellow" style="width: <?php echo $rowm->porcentagem; ?>"></div>
							</div>
						  </td>
						  <td><span class="badge bg-yellow"><?php echo $rowm->porcentagem; ?></span></td>
							<?php } ?>
						</tr>
					  </table>
					</div>
					<!-- /.box-body -->
					<div class="box-footer clearfix">
					  <ul class="pagination pagination-sm no-margin pull-right">
						<li><a href="#">&laquo;</a></li>
						<li><a href="#">1</a></li>
						<li><a href="#">2</a></li>
						<li><a href="#">3</a></li>
						<li><a href="#">&raquo;</a></li>
					  </ul>
					</div>
				  </div>
				  <!-- /.box -->
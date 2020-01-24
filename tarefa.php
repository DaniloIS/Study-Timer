<?php
	include('protect.php');
		protect();
	
$diaSemana = $con -> query("select hr_planejamento, nm_materia, case hr_planejamento
			when '05/ 06h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 5 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 6, 'Está na hora de estudar', null))
            when '06/ 07h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 6 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 7, 'Está na hora de estudar', null))
            when '07/ 08h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 7 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 8, 'Está na hora de estudar', null))
            when '08/ 09h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 8 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 9, 'Está na hora de estudar', null))
            when '09/ 10h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 9 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 10, 'Está na hora de estudar', null))
            when '10/ 11h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 10 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 11, 'Está na hora de estudar', null))
            when '11/ 12h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 11 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 12, 'Está na hora de estudar', null))
            when '12/ 13h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 12 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 13, 'Está na hora de estudar', null))
            when '13/ 14h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 13 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 14, 'Está na hora de estudar', null))
            when '14/ 15h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 14 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 15, 'Está na hora de estudar', null))
            when '15/ 16h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 15 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 16, 'Está na hora de estudar', null))
            when '16/ 17h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 16 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 17, 'Está na hora de estudar', null))
            when '17/ 18h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 17 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 18, 'Está na hora de estudar', null))
            when '18/ 19h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 18 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 19, 'Está na hora de estudar', null))
            when '19/ 20h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 19 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 20, 'Está na hora de estudar', null))
            when '20/ 21h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 20 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 21, 'Está na hora de estudar', null))
            when '21/ 22h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 21 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 22, 'Está na hora de estudar', null))
            when '22/ 23h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 22 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 23, 'Está na hora de estudar', null))
            when '23/ 00h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 23 and (select(TIME_FORMAT(CURTIME(), '%H'))) <= 2359, 'Está na hora de estudar', null)) end as ds_obs
        from tb_materia join tb_planejamento on tb_materia.cd_materia = tb_planejamento.cd_materia and tb_planejamento.dt_planejamento = dayofweek(curdate()) join tb_usuario on tb_planejamento.cd_usuario = $codigo and tb_usuario.cd_usuario  = $codigo
		union
		select hr_planejamento, nm_outra_materia, case hr_planejamento
			when '05/ 06h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 5 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 6, 'Está na hora de estudar', null))
            when '06/ 07h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 6 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 7, 'Está na hora de estudar', null))
            when '07/ 08h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 7 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 8, 'Está na hora de estudar', null))
            when '08/ 09h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 8 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 9, 'Está na hora de estudar', null))
            when '09/ 10h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 9 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 10, 'Está na hora de estudar', null))
            when '10/ 11h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 10 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 11, 'Está na hora de estudar', null))
            when '11/ 12h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 11 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 12, 'Está na hora de estudar', null))
            when '12/ 13h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 12 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 13, 'Está na hora de estudar', null))
            when '13/ 14h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 13 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 14, 'Está na hora de estudar', null))
            when '14/ 15h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 14 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 15, 'Está na hora de estudar', null))
            when '15/ 16h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 15 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 16, 'Está na hora de estudar', null))
            when '16/ 17h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 16 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 17, 'Está na hora de estudar', null))
            when '17/ 18h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 17 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 18, 'Está na hora de estudar', null))
            when '18/ 19h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 18 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 19, 'Está na hora de estudar', null))
            when '19/ 20h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 19 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 20, 'Está na hora de estudar', null))
            when '20/ 21h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 20 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 21, 'Está na hora de estudar', null))
            when '21/ 22h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 21 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 22, 'Está na hora de estudar', null))
            when '22/ 23h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 22 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 23, 'Está na hora de estudar', null))
            when '23/ 00h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 23 and (select(TIME_FORMAT(CURTIME(), '%H'))) <= 2359, 'Está na hora de estudar', null)) end as ds_obs
        from tb_outra_materia join tb_planejamento on tb_outra_materia.cd_outra_materia = tb_planejamento.cd_outra_materia and tb_planejamento.dt_planejamento = dayofweek(curdate()) join tb_usuario on tb_planejamento.cd_usuario = $codigo and tb_usuario.cd_usuario  = $codigo order by hr_planejamento;");
?>
		<section id="tarefa">
				<div class="container">
					
					<div class="row">
						<div class="col-lg-12">
							<div class="container wow fadeInUp">
							<div class="section-header">
								<h2>Tarefa do dia</h2>
								<p>Aqui está as suas tarefas do dia</p>
							</div>
								<div class="limiter">
									<div class="container-table100">
										<div class="wrap-table100">
											<div class="table100">
												<table>
													<thead>
														<tr class="table100-head">
															<th class="column1"  style="color: #999999;">Hora</th>
															<th class="column2"  style="color: #999999;">Materia</th>
															<th class="column3"  style="color: #999999;">Obs</th>
														</tr>
													</thead>
													<tbody>
														<?php
															while($row= $diaSemana -> fetch(PDO::FETCH_OBJ)){
														?>
															<tr style="color: #fff;">
																<td class="column1"><?php echo $row->hr_planejamento; ?>&nbsp </td>
																<td class="column2"><?php echo utf8_encode($row->nm_materia); ?>&nbsp </td>
																<td class="column3"><?php echo $row->ds_obs; ?>&nbsp </td>
															</tr>
														<?php
															}
														?>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
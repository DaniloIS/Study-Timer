<?php
	include('protect.php');
		protect();
	
	session_start();
	include_once('conexao/conexao.php');

	if(isset($_SESSION['log'])){
		$codigo = $_SESSION['cd_usuario'];
	
	$notificacao = $con -> query("select hr_planejamento, nm_materia, case hr_planejamento
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
        from tb_materia join tb_planejamento on tb_materia.cd_materia = tb_planejamento.cd_materia and tb_planejamento.dt_planejamento = dayofweek(curdate()) join tb_usuario on tb_planejamento.cd_usuario = $codigo and tb_usuario.cd_usuario  = $codigo where hr_planejamento = (select case (select(TIME_FORMAT(CURTIME(), '%H')))
			when 5 then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 5 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 6, '05/ 06h', null))
            when 6 then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 6 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 7, '06/ 07h', null))
            when 7 then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 7 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 8, '07/ 08h', null))
            when 8 then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 8 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 9, '08/ 09h', null))
            when 9 then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 9 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 10, '09/ 10h', null))
            when 10 then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 10 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 11, '10/ 11h', null))
            when 11 then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 11 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 12, '11/ 12h', null))
            when 12 then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 12 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 13, '12/ 13h', null))
            when 13 then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 13 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 14, '13/ 14h', null))
            when 14 then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 14 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 15, '14/ 15h', null))
            when 15 then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 15 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 16, '15/ 16h', null))
            when 16 then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 16 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 17, '16/ 17h', null))
            when 17 then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 17 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 18, '17/ 18h', null))
            when 18 then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 18 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 19, '18/ 19h', null))
            when 19 then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 19 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 20, '19/ 20h', null))
            when 20 then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 20 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 21, '20/ 21h', null))
            when 21 then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 21 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 22, '21/ 22h', null))
            when 22 then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 22 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 23, '22/ 23h', null))
            when 23 then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 23 and (select(TIME_FORMAT(CURTIME(), '%H'))) <= 2359, '23/ 00h', null)) end)
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
        from tb_outra_materia join tb_planejamento on tb_outra_materia.cd_outra_materia = tb_planejamento.cd_outra_materia and tb_planejamento.dt_planejamento = dayofweek(curdate()) join tb_usuario on tb_planejamento.cd_usuario = $codigo and tb_usuario.cd_usuario  = $codigo where hr_planejamento = (select case (select(TIME_FORMAT(CURTIME(), '%H')))
			when 5 then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 5 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 6, '05/ 06h', null))
            when 6 then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 6 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 7, '06/ 07h', null))
            when 7 then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 7 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 8, '07/ 08h', null))
            when 8 then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 8 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 9, '08/ 09h', null))
            when 9 then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 9 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 10, '09/ 10h', null))
            when 10 then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 10 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 11, '10/ 11h', null))
            when 11 then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 11 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 12, '11/ 12h', null))
            when 12 then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 12 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 13, '12/ 13h', null))
            when 13 then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 13 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 14, '13/ 14h', null))
            when 14 then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 14 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 15, '14/ 15h', null))
            when 15 then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 15 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 16, '15/ 16h', null))
            when 16 then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 16 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 17, '16/ 17h', null))
            when 17 then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 17 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 18, '17/ 18h', null))
            when 18 then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 18 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 19, '18/ 19h', null))
            when 19 then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 19 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 20, '19/ 20h', null))
            when 20 then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 20 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 21, '20/ 21h', null))
            when 21 then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 21 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 22, '21/ 22h', null))
            when 22 then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 22 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 23, '22/ 23h', null))
            when 23 then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 23 and (select(TIME_FORMAT(CURTIME(), '%H'))) <= 2359, '23/ 00h', null)) end);");
			
			$notif= $notificacao -> fetch(PDO::FETCH_OBJ);
			if(!empty($notif->ds_obs)){
				$_SESSION['notificacao'] = $notif->ds_obs. ' '. utf8_encode($notif->nm_materia);
				header("location:index.php");
			}
	}
			header("location:index.php");
?>
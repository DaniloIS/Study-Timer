<?php
	session_start();
	include_once("conexao/conexao.php");
	date_default_timezone_set('America/Sao_Paulo');
	
	$codigo = $_SESSION['cd_usuario'];
	$t = $_POST['postt'];
	$p = $_POST['postp'];
	
	if (isset($t) && isset($p)) {
		$hora = $con -> query("SELECT (CASE
		when TIME_FORMAT(CURTIME(), '%H') >= 5 and TIME_FORMAT(CURTIME(), '%H') < 6 then '05/ 06h'
        when TIME_FORMAT(CURTIME(), '%H') >= 6 and TIME_FORMAT(CURTIME(), '%H') < 7 then '06/ 07h'
        when TIME_FORMAT(CURTIME(), '%H') >= 7 and TIME_FORMAT(CURTIME(), '%H') < 8 then '07/ 08h'
        when TIME_FORMAT(CURTIME(), '%H') >= 8 and TIME_FORMAT(CURTIME(), '%H') < 9 then '08/ 09h'
        when TIME_FORMAT(CURTIME(), '%H') >= 9 and TIME_FORMAT(CURTIME(), '%H') < 10 then '09/ 10h'
        when TIME_FORMAT(CURTIME(), '%H') >= 10 and TIME_FORMAT(CURTIME(), '%H') < 11 then '10/ 11h'
        when TIME_FORMAT(CURTIME(), '%H') >= 11 and TIME_FORMAT(CURTIME(), '%H') < 12 then '11/ 12h'
        when TIME_FORMAT(CURTIME(), '%H') >= 12 and TIME_FORMAT(CURTIME(), '%H') < 13 then '12/ 13h'
        when TIME_FORMAT(CURTIME(), '%H') >= 13 and TIME_FORMAT(CURTIME(), '%H') < 14 then '13/ 14h'
        when TIME_FORMAT(CURTIME(), '%H') >= 14 and TIME_FORMAT(CURTIME(), '%H') < 15 then '14/ 15h'
        when TIME_FORMAT(CURTIME(), '%H') >= 15 and TIME_FORMAT(CURTIME(), '%H') < 16 then '15/ 16h'
        when TIME_FORMAT(CURTIME(), '%H') >= 16 and TIME_FORMAT(CURTIME(), '%H') < 17 then '16/ 17h'
        when TIME_FORMAT(CURTIME(), '%H') >= 17 and TIME_FORMAT(CURTIME(), '%H') < 18 then '17/ 18h'
        when TIME_FORMAT(CURTIME(), '%H') >= 18 and TIME_FORMAT(CURTIME(), '%H') < 19 then '18/ 19h'
        when TIME_FORMAT(CURTIME(), '%H') >= 19 and TIME_FORMAT(CURTIME(), '%H') < 20 then '19/ 20h'
        when TIME_FORMAT(CURTIME(), '%H') >= 20 and TIME_FORMAT(CURTIME(), '%H') < 21 then '20/ 21h'
        when TIME_FORMAT(CURTIME(), '%H') >= 21 and TIME_FORMAT(CURTIME(), '%H') < 22 then '21/ 22h'
        when TIME_FORMAT(CURTIME(), '%H') >= 22 and TIME_FORMAT(CURTIME(), '%H') < 23 then '22/ 23h'
        when TIME_FORMAT(CURTIME(), '%H') >= 23 and TIME_FORMAT(CURTIME(), '%H') <= 23 then '23/ 00h'
	end)  as hora");
	$row= $hora -> fetch(PDO::FETCH_OBJ);
	$hr = $row->hora;
		$tarefa = $con -> query("select hr_planejamento, tb_materia.cd_materia, nm_materia, dt_planejamento, case hr_planejamento
			when '5/ 6h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 5 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 6, 'Está na hora de estduar', null))
            when '6/ 7h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 6 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 7, 'Está na hora de estduar', null))
            when '7/ 8h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 7 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 8, 'Está na hora de estduar', null))
            when '8/ 9h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 8 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 9, 'Está na hora de estduar', null))
            when '9/ 10h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 9 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 10, 'Está na hora de estduar', null))
            when '10/ 11h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 10 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 11, 'Está na hora de estduar', null))
            when '11/ 12h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 11 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 12, 'Está na hora de estduar', null))
            when '12/ 13h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 12 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 13, 'Está na hora de estduar', null))
            when '13/ 14h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 13 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 14, 'Está na hora de estduar', null))
            when '14/ 15h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 14 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 15, 'Está na hora de estduar', null))
            when '15/ 16h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 15 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 16, 'Está na hora de estduar', null))
            when '16/ 17h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 16 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 17, 'Está na hora de estduar', null))
            when '17/ 18h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 17 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 18, 'Está na hora de estduar', null))
            when '18/ 19h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 18 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 19, 'Está na hora de estduar', null))
            when '19/ 20h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 19 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 20, 'Está na hora de estduar', null))
            when '20/ 21h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 20 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 21, 'Está na hora de estduar', null))
            when '21/ 22h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 21 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 22, 'Está na hora de estduar', null))
            when '22/ 23h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 22 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 23, 'Está na hora de estduar', null))
            when '23/ 00h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 23 and (select(TIME_FORMAT(CURTIME(), '%H%i'))) <= 2359, 'Está na hora de estduar', null)) end as ds_obs
        from tb_materia  join tb_planejamento on tb_materia.cd_materia = tb_planejamento.cd_materia and tb_planejamento.dt_planejamento = dayofweek(curdate()) and tb_planejamento.hr_planejamento = '$hr' join tb_usuario on tb_planejamento.cd_usuario = $codigo and tb_usuario.cd_usuario  = $codigo
		union
		select hr_planejamento, tb_outra_materia.cd_outra_materia, nm_outra_materia, dt_planejamento, case hr_planejamento
			when '5/ 6h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 5 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 6, 'Está na hora de estduar', null))
            when '6/ 7h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 6 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 7, 'Está na hora de estduar', null))
            when '7/ 8h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 7 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 8, 'Está na hora de estduar', null))
            when '8/ 9h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 8 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 9, 'Está na hora de estduar', null))
            when '9/ 10h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 9 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 10, 'Está na hora de estduar', null))
            when '10/ 11h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 10 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 11, 'Está na hora de estduar', null))
            when '11/ 12h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 11 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 12, 'Está na hora de estduar', null))
            when '12/ 13h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 12 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 13, 'Está na hora de estduar', null))
            when '13/ 14h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 13 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 14, 'Está na hora de estduar', null))
            when '14/ 15h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 14 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 15, 'Está na hora de estduar', null))
            when '15/ 16h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 15 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 16, 'Está na hora de estduar', null))
            when '16/ 17h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 16 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 17, 'Está na hora de estduar', null))
            when '17/ 18h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 17 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 18, 'Está na hora de estduar', null))
            when '18/ 19h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 18 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 19, 'Está na hora de estduar', null))
            when '19/ 20h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 19 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 20, 'Está na hora de estduar', null))
            when '20/ 21h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 20 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 21, 'Está na hora de estduar', null))
            when '21/ 22h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 21 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 22, 'Está na hora de estduar', null))
            when '22/ 23h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 22 and (select(TIME_FORMAT(CURTIME(), '%H'))) < 23, 'Está na hora de estduar', null))
            when '23/ 00h' then (select if((select(TIME_FORMAT(CURTIME(), '%H'))) >= 23 and (select(TIME_FORMAT(CURTIME(), '%H%i'))) <= 2359, 'Está na hora de estduar', null)) end as ds_obs
        from tb_outra_materia  join tb_planejamento on tb_outra_materia.cd_outra_materia = tb_planejamento.cd_outra_materia and tb_planejamento.dt_planejamento = dayofweek(curdate()) and tb_planejamento.hr_planejamento = '$hr' join tb_usuario on tb_planejamento.cd_usuario = $codigo and tb_usuario.cd_usuario  = $codigo;");
		$row= $tarefa -> fetch(PDO::FETCH_OBJ);
		$tf = $row->cd_materia;
		
		if($tf > 5){
			$registro = $con -> query("insert into tb_registro_tempo (hr_registro_tempo, dt_registro_tempo, hr_tempo, qt_pomodoro, cd_usuario, cd_outra_materia) values (curTime(), curDate(), '$t', $p, $codigo, $tf);");
		}else{
			$registro = $con -> query("insert into tb_registro_tempo (hr_registro_tempo, dt_registro_tempo, hr_tempo, qt_pomodoro, cd_usuario, cd_materia) values (curTime(), curDate(), '$t', $p, $codigo, $tf);");
		}
		
	}else{
		echo "Erro!";
	}
?>
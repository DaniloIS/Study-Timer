-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 11-Jun-2019 às 03:48
-- Versão do servidor: 10.1.39-MariaDB
-- versão do PHP: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_study_timer`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp` (IN `codigo` INT, IN `data` DATE, IN `mes` INT, IN `ano` INT, IN `materia` INT)  begin
select nm_materia as materia,
		concat(date_format(DATE_SUB(data, INTERVAL DAYOFMONTH(data)-1 DAY), '%d/%m/%Y'),' - ', date_format(LAST_DAY(data), '%d/%m/%Y')) as dt_data,
		time_format( SEC_TO_TIME( SUM( TIME_TO_SEC( hr_tempo ) ) ),'%H:%i:%s') as hr_tempo,
		concat(ceil(sum(hr_tempo) * 100 / total_tempo),'%') as porcentagem ,
		sum(qt_pomodoro) as qt_pomodoro
			from 
			(SELECT SUM(hr_tempo) as total_tempo from tb_registro_tempo where MONTH(dt_registro_tempo) = mes) as total,
			tb_registro_tempo 
				
				join tb_materia
					on tb_materia.cd_materia = tb_registro_tempo.cd_materia
						where 
							cd_usuario = codigo 
							and MONTH(dt_registro_tempo) = mes and 
							YEAR(dt_registro_tempo) = ano 
							and tb_materia.cd_materia = materia;
		
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_alteraUsuario` (IN `codigo` INT, IN `nome` VARCHAR(100), IN `login` VARCHAR(45), IN `novoLogin` VARCHAR(45), IN `email` CHAR(45), IN `novoEmail` CHAR(45), IN `senha` CHAR(20))  begin
	if exists(select cd_usuario from tb_usuario where cd_usuario = codigo) then
		if exists (select nm_email from tb_usuario where nm_email <> email and nm_email = novoEmail) then
			select concat('E-mail: ',novoEmail,' Já está cadastrado') as erro;
		else
			if exists (select nm_login from tb_usuario where nm_login <> login and nm_login = novoLogin) then
				select concat('Login: ',novoLogin,' Já está cadastrado') as erro;
			else
				update tb_usuario set nm_usuario = nome, nm_login = novoLogin, nm_email = novoEmail, cd_senha = senha where cd_usuario = codigo;
                select concat('Usuario alterado com sucesso') as msg;
			end if;
		end if;
	else
		select concat('Usuario não encontrado') as erro;
	end if;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_cadastroUsuario` (IN `usuario` VARCHAR(100), IN `login` VARCHAR(45), IN `email` CHAR(45), IN `senha` CHAR(45))  begin
	if exists (select nm_email from tb_usuario where nm_email = email) then
		select concat('E-mail: ',email,' Já está cadastrado') as erro;
	else
		if exists (select nm_login from tb_usuario where nm_login = login) then
			select concat('Nome de login: ',login,' Já está cadastrado') as erro;
		else
		insert into tb_usuario (nm_usuario, nm_login, nm_email, cd_senha)
			values (usuario, login, email, senha);
		select concat('Usuário: ',usuario,' cadastrado com sucesso') as msg;
        end if;
	end if;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_cronograma` (IN `codigo` INT, IN `semana` INT)  begin
	select cd_planejamento, hr_planejamento, nm_materia, case dt_planejamento 
								when 1 then 'Domingo' 
								when 2 then 'Segunda - feira' 
								when 3 then 'Terça - feira' 
								when 4 then 'Quarta - feira' 
								when 5 then 'Quinta - feira' 
								when 6 then 'Sexta - feira' 
								when 7 then 'Sabado' 
								end as dt_planejamento 
				from tb_materia join tb_planejamento on tb_materia.cd_materia = tb_planejamento.cd_materia 
                join tb_usuario on tb_planejamento.cd_usuario = codigo and tb_usuario.cd_usuario  = codigo and dt_planejamento = semana 
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
                join tb_usuario on tb_planejamento.cd_usuario = codigo and tb_usuario.cd_usuario  = codigo and dt_planejamento = semana order by hr_planejamento;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_deletaUsuario` (IN `codigo` INT)  begin
	if exists(select cd_usuario from tb_usuario where cd_usuario = codigo) then
		delete from tb_usuario where cd_usuario = codigo;
        select concat('Usuario deletado') as msg;
	else
		select concat('Usuario não encontrado') as erro;
	end if;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_diaSemana` (IN `codigo` INT)  begin
	declare valor int;
    set valor = dayofweek(curdate());
    case valor
		when 1 then  select hr_planejamento, nm_materia, case dt_planejamento when 1 then 'Domingo' end as dt_planejamento from tb_materia join tb_planejamento on tb_materia.cd_materia = tb_planejamento.cd_materia and tb_planejamento.dt_planejamento = 1 join tb_usuario on tb_planejamento.cd_usuario = codigo and tb_usuario.cd_usuario  = codigo;
        when 2 then select hr_planejamento, nm_materia, case dt_planejamento when 2 then 'Segunda - feira' end as dt_planejamento from tb_materia join tb_planejamento on tb_materia.cd_materia = tb_planejamento.cd_materia and tb_planejamento.dt_planejamento = 2 join tb_usuario on tb_planejamento.cd_usuario = codigo and tb_usuario.cd_usuario  = codigo;
        when 3 then select hr_planejamento, nm_materia, case dt_planejamento when 3 then 'Terça - feira' end as dt_planejamento from tb_materia join tb_planejamento on tb_materia.cd_materia = tb_planejamento.cd_materia and tb_planejamento.dt_planejamento = 3 join tb_usuario on tb_planejamento.cd_usuario = codigo and tb_usuario.cd_usuario  = codigo;
        when 4 then select hr_planejamento, nm_materia, case dt_planejamento when 4 then 'Quarta - feira' end as dt_planejamento from tb_materia join tb_planejamento on tb_materia.cd_materia = tb_planejamento.cd_materia and tb_planejamento.dt_planejamento = 4 join tb_usuario on tb_planejamento.cd_usuario = codigo and tb_usuario.cd_usuario  = codigo;
        when 5 then select hr_planejamento, nm_materia, case dt_planejamento when 5 then 'Quinta - feira' end as dt_planejamento from tb_materia join tb_planejamento on tb_materia.cd_materia = tb_planejamento.cd_materia and tb_planejamento.dt_planejamento = 5 join tb_usuario on tb_planejamento.cd_usuario = codigo and tb_usuario.cd_usuario  = codigo;
        when 6 then select hr_planejamento, nm_materia, case dt_planejamento when 6 then 'Sexta - feira' end as dt_planejamento from tb_materia join tb_planejamento on tb_materia.cd_materia = tb_planejamento.cd_materia and tb_planejamento.dt_planejamento = 6 join tb_usuario on tb_planejamento.cd_usuario = codigo and tb_usuario.cd_usuario  = codigo;
        when 7 then select hr_planejamento, nm_materia, case dt_planejamento when 7 then 'Sabado' end as dt_planejamento from tb_materia join tb_planejamento on tb_materia.cd_materia = tb_planejamento.cd_materia and tb_planejamento.dt_planejamento = 7 join tb_usuario on tb_planejamento.cd_usuario = codigo and tb_usuario.cd_usuario  = codigo;
	end case;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_diaSemana1` (IN `codigo` INT)  begin
	declare valor int;
    set valor = dayofweek(curdate());
    case valor
		when 1 then  select hr_planejamento, nm_materia, case dt_planejamento when 1 then 'Domingo' end as dt_planejamento, case hr_planejamento
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
        from tb_materia join tb_planejamento on tb_materia.cd_materia = tb_planejamento.cd_materia and tb_planejamento.dt_planejamento = 1 join tb_usuario on tb_planejamento.cd_usuario = codigo and tb_usuario.cd_usuario  = codigo
		union
		select hr_planejamento, nm_outra_materia, case dt_planejamento when 1 then 'Domingo' end as dt_planejamento, case hr_planejamento
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
        from tb_outra_materia join tb_planejamento on tb_outra_materia.cd_outra_materia = tb_planejamento.cd_outra_materia and tb_planejamento.dt_planejamento = 1 join tb_usuario on tb_planejamento.cd_usuario = codigo and tb_usuario.cd_usuario  = codigo;
        when 2 then select hr_planejamento, nm_materia, case dt_planejamento when 2 then 'Segunda - feira' end as dt_planejamento, case hr_planejamento
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
        from tb_materia join tb_planejamento on tb_materia.cd_materia = tb_planejamento.cd_materia and tb_planejamento.dt_planejamento = 2 join tb_usuario on tb_planejamento.cd_usuario = codigo and tb_usuario.cd_usuario  = codigo
		union
		select hr_planejamento, nm_outra_materia, case dt_planejamento when 2 then 'Segunda - feira' end as dt_planejamento, case hr_planejamento
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
        from tb_outra_materia join tb_planejamento on tb_outra_materia.cd_outra_materia = tb_planejamento.cd_outra_materia and tb_planejamento.dt_planejamento = 2 join tb_usuario on tb_planejamento.cd_usuario = codigo and tb_usuario.cd_usuario  = codigo;
		
        when 3 then select hr_planejamento, nm_materia, case dt_planejamento when 3 then 'Terça - feira' end as dt_planejamento, case hr_planejamento
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
            from tb_materia join tb_planejamento on tb_materia.cd_materia = tb_planejamento.cd_materia and tb_planejamento.dt_planejamento = 3 join tb_usuario on tb_planejamento.cd_usuario = codigo and tb_usuario.cd_usuario  = codigo
			union
			select hr_planejamento, nm_outra_materia, case dt_planejamento when 3 then 'Terça - feira' end as dt_planejamento, case hr_planejamento
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
			from tb_outra_materia join tb_planejamento on tb_outra_materia.cd_outra_materia = tb_planejamento.cd_outra_materia and tb_planejamento.dt_planejamento = 3 join tb_usuario on tb_planejamento.cd_usuario = codigo and tb_usuario.cd_usuario  = codigo;
			
        when 4 then select hr_planejamento, nm_materia, case dt_planejamento when 4 then 'Quarta - feira' end as dt_planejamento, case hr_planejamento
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
		from tb_materia join tb_planejamento on tb_materia.cd_materia = tb_planejamento.cd_materia and tb_planejamento.dt_planejamento = 4 join tb_usuario on tb_planejamento.cd_usuario = codigo and tb_usuario.cd_usuario  = codigo
		union
		select hr_planejamento, nm_outra_materia, case dt_planejamento when 4 then 'Quarta - feira' end as dt_planejamento, case hr_planejamento
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
		from tb_outra_materia join tb_planejamento on tb_outra_materia.cd_outra_materia = tb_planejamento.cd_outra_materia and tb_planejamento.dt_planejamento = 4 join tb_usuario on tb_planejamento.cd_usuario = codigo and tb_usuario.cd_usuario  = codigo;
		
        when 5 then select hr_planejamento, nm_materia, case dt_planejamento when 5 then 'Quinta - feira' end as dt_planejamento, case hr_planejamento
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
		from tb_materia join tb_planejamento on tb_materia.cd_materia = tb_planejamento.cd_materia and tb_planejamento.dt_planejamento = 5 join tb_usuario on tb_planejamento.cd_usuario = codigo and tb_usuario.cd_usuario  = codigo
		union
		select hr_planejamento, nm_outra_materia, case dt_planejamento when 5 then 'Quinta - feira' end as dt_planejamento, case hr_planejamento
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
		from tb_outra_materia join tb_planejamento on tb_outra_materia.cd_outra_materia = tb_planejamento.cd_outra_materia and tb_planejamento.dt_planejamento = 5 join tb_usuario on tb_planejamento.cd_usuario = codigo and tb_usuario.cd_usuario  = codigo;
		
        when 6 then select hr_planejamento, nm_materia, case dt_planejamento when 6 then 'Sexta - feira' end as dt_planejamento, case hr_planejamento
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
		from tb_materia join tb_planejamento on tb_materia.cd_materia = tb_planejamento.cd_materia and tb_planejamento.dt_planejamento = 6 join tb_usuario on tb_planejamento.cd_usuario = codigo and tb_usuario.cd_usuario  = codigo
		union
		select hr_planejamento, nm_outra_materia, case dt_planejamento when 6 then 'Sexta - feira' end as dt_planejamento, case hr_planejamento
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
		from tb_outra_materia join tb_planejamento on tb_outra_materia.cd_outra_materia = tb_planejamento.cd_outra_materia and tb_planejamento.dt_planejamento = 6 join tb_usuario on tb_planejamento.cd_usuario = codigo and tb_usuario.cd_usuario  = codigo;
        when 7 then select hr_planejamento, nm_materia, case dt_planejamento when 7 then 'Sabado' end as dt_planejamento, case hr_planejamento
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
		from tb_materia join tb_planejamento on tb_materia.cd_materia = tb_planejamento.cd_materia and tb_planejamento.dt_planejamento = 7 join tb_usuario on tb_planejamento.cd_usuario = codigo and tb_usuario.cd_usuario  = codigo
		union
		select hr_planejamento, nm_outra_materia, case dt_planejamento when 7 then 'Sabado' end as dt_planejamento, case hr_planejamento
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
		from tb_outra_materia join tb_planejamento on tb_outra_materia.cd_outra_materia = tb_planejamento.cd_outra_materia and tb_planejamento.dt_planejamento = 7 join tb_usuario on tb_planejamento.cd_usuario = codigo and tb_usuario.cd_usuario  = codigo;
	end case;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_loginUsuario` (IN `login` VARCHAR(45), IN `senha` CHAR(20))  begin
	if exists (select nm_login, cd_senha from tb_usuario where nm_login = login and cd_senha = senha) then
		select * from tb_usuario where nm_login = login and cd_senha = senha;
	else
		select concat('Login ou senha inválido') as erro;
	end if;
    
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_outroPlanejamentoUsuario` (IN `usuario` INT, IN `materia` CHAR(45), IN `semana` INT, IN `hr` CHAR(10))  begin
	if exists (select * from tb_planejamento 
    join tb_outra_materia on tb_planejamento.cd_usuario = tb_outra_materia.cd_usuario 
    and tb_planejamento.cd_outra_materia = tb_outra_materia.cd_outra_materia 
    where tb_outra_materia.nm_outra_materia = materia) then
		select concat('Essa materia já existe') as erro;
	else
		if exists (select * from tb_planejamento 
		join tb_materia on tb_planejamento.cd_materia = tb_materia.cd_materia 
		where tb_materia.nm_materia = materia) then
			select concat('Essa materia já existe') as erro;
            
		else
			 if exists (select * from tb_planejamento where cd_usuario = usuario and dt_planejamento = semana and hr_planejamento = hr) then
				select concat('O horario ',hr,' já foi agendado no(a) ',case semana
							 when 1 then 'Domingo' 
							 when 2 then 'Segunda - feira' 
							 when 3 then 'Terça - feira' 
							 when 4 then 'Quarta - feira' 
							 when 5 then 'Quinta - feira' 
							 when 6 then 'Sexta - feira' 
							 when 7 then 'Sabado'
							 end) as erro;
			
            else
				insert into tb_outra_materia (nm_outra_materia, cd_usuario) values (materia, usuario);
				insert into tb_planejamento (cd_usuario, cd_outra_materia, dt_planejamento, hr_planejamento) values (usuario, (select max(cd_outra_materia) from tb_outra_materia), semana, hr);
			
            end if;
		end if;
    end if;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_planejamentoUsuario` (IN `usuario` INT, IN `materia` INT, IN `semana` INT, IN `hr` CHAR(10))  begin
    if exists (select * from tb_planejamento where cd_usuario = usuario and dt_planejamento = semana and hr_planejamento = hr) then
		select concat('O horario ',hr,' já foi agendado no(a) ',case semana
                     when 1 then 'Domingo' 
        			 when 2 then 'Segunda - feira' 
        			 when 3 then 'Terça - feira' 
        			 when 4 then 'Quarta - feira' 
        			 when 5 then 'Quinta - feira' 
         			 when 6 then 'Sexta - feira' 
       				 when 7 then 'Sabado'
                     end) as erro;
	else
		if exists (select * from tb_materia where cd_materia = materia) then
			insert into tb_planejamento (cd_usuario, cd_materia, dt_planejamento, hr_planejamento) values (usuario, materia, semana, hr);
		else
			if exists (select * from tb_outra_materia where cd_outra_materia = materia) then
				insert into tb_planejamento (cd_usuario, cd_outra_materia, dt_planejamento, hr_planejamento) values (usuario, materia, semana, hr);
			else
            select concat('ERRO!') as erro;
            
            end if;
        end if;
    end if;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_planejamentoUsuario1` (IN `usuario` INT, IN `materia` INT, IN `semana` INT, IN `hr` CHAR(10))  begin
    if exists (select * from tb_planejamento where cd_usuario = usuario and dt_planejamento = semana and hr_planejamento = hr) then
		select concat('O horario ',hr,' já foi agendado no(a) ',case semana
                     when 1 then 'Domingo' 
        			 when 2 then 'Segunda - feira' 
        			 when 3 then 'Terça - feira' 
        			 when 4 then 'Quarta - feira' 
        			 when 5 then 'Quinta - feira' 
         			 when 6 then 'Sexta - feira' 
       				 when 7 then 'Sabado'
                     end) as erro;
	else
		insert into tb_planejamento (cd_usuario, cd_materia, dt_planejamento, hr_planejamento) values (usuario, materia, semana, hr);
    end if;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_porcentagem` (IN `codigo` INT, IN `data` INT, IN `mes` INT, IN `ano` INT)  begin
declare materia int;
set materia = 1;
while(materia >= sum(tb_materia.cd_materia)) do
select nm_materia,
		concat(date_format(DATE_SUB(data, INTERVAL DAYOFMONTH(data)-1 DAY), '%d/%m/%Y'),' - ', date_format(LAST_DAY(data), '%d/%m/%Y')) as dt_data,
		time_format( SEC_TO_TIME( SUM( TIME_TO_SEC( hr_tempo ) ) ),'%H:%i:%s') as hr_tempo,
		concat(ceil(sum(hr_tempo) * 100 / total_tempo),'%') as porcentagem ,
		sum(qt_pomodoro) as qt_pomodoro
			from 
			(SELECT SUM(hr_tempo) as total_tempo from tb_registro_tempo where MONTH(dt_registro_tempo) = mes) as total,
			tb_registro_tempo 
				
				join tb_materia
					on tb_materia.cd_materia = tb_registro_tempo.cd_materia
						where 
							cd_usuario = codigo 
							and MONTH(dt_registro_tempo) = mes and 
							YEAR(dt_registro_tempo) = ano 
							and tb_materia.cd_materia = materia;
		set materia = materia + 1;
	end while;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_porcentagemMensal` (IN `codigo` INT, IN `data` INT, IN `mes` INT, IN `ano` INT)  begin
select nm_materia,
		concat(date_format(DATE_SUB(data, INTERVAL DAYOFMONTH(data)-1 DAY), '%d/%m/%Y'),' - ', date_format(LAST_DAY(data), '%d/%m/%Y')) as dt_data,
		time_format( SEC_TO_TIME( SUM( TIME_TO_SEC( hr_tempo ) ) ),'%H:%i:%s') as hr_tempo,
		concat(ceil(sum(hr_tempo) * 100 / total_tempo),'%') as porcentagem ,
		sum(qt_pomodoro) as qt_pomodoro
			from 
			(SELECT SUM(hr_tempo) as total_tempo from tb_registro_tempo where MONTH(dt_registro_tempo) = mes) as total,
			tb_registro_tempo 
				
				join tb_materia
					on tb_materia.cd_materia = tb_registro_tempo.cd_materia
						where 
							cd_usuario = codigo 
							and MONTH(dt_registro_tempo) = mes and 
							YEAR(dt_registro_tempo) = ano 
							;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_porcentagemMensallll` (IN `codigo` INT, IN `data` DATE, IN `mes` INT, IN `ano` INT)  begin
	declare i int;
	set i = 1;
    simple_loop: loop
select nm_materia as materia,
		concat(date_format(DATE_SUB(data, INTERVAL DAYOFMONTH(data)-1 DAY), '%d/%m/%Y'),' - ', date_format(LAST_DAY(data), '%d/%m/%Y')) as dt_data,
		time_format( SEC_TO_TIME( SUM( TIME_TO_SEC( hr_tempo ) ) ),'%H:%i:%s') as hr_tempo,
		concat(ceil(sum(hr_tempo) * 100 / total_tempo),'%') as porcentagem ,
		sum(qt_pomodoro) as qt_pomodoro
			from 
			(SELECT SUM(hr_tempo) as total_tempo from tb_registro_tempo where MONTH(dt_registro_tempo) = mes) as total,
			tb_registro_tempo 
				
				join tb_materia
					on tb_materia.cd_materia = tb_registro_tempo.cd_materia
						where 
							tb_registro_tempo.cd_usuario = codigo 
							and MONTH(dt_registro_tempo) = mes and 
							YEAR(dt_registro_tempo) = ano 
							and tb_materia.cd_materia = i
                            and tb_materia.cd_materia is not null
                            UNION
                            select tb_outra_materia.nm_outra_materia as materia,
		concat(date_format(DATE_SUB(data, INTERVAL DAYOFMONTH(data)-1 DAY), '%d/%m/%Y'),' - ', date_format(LAST_DAY(data), '%d/%m/%Y')) as dt_data,
		time_format( SEC_TO_TIME( SUM( TIME_TO_SEC( hr_tempo ) ) ),'%H:%i:%s') as hr_tempo,
		concat(ceil(sum(hr_tempo) * 100 / total_tempo),'%') as porcentagem ,
		sum(qt_pomodoro) as qt_pomodoro
			from 
			(SELECT SUM(hr_tempo) as total_tempo from tb_registro_tempo where MONTH(dt_registro_tempo) = mes) as total,
			tb_registro_tempo 
				
				join tb_outra_materia
					on tb_outra_materia.cd_outra_materia = tb_registro_tempo.cd_outra_materia
						where 
							tb_registro_tempo.cd_usuario = codigo 
							and MONTH(dt_registro_tempo) = mes and 
							YEAR(dt_registro_tempo) = ano 
							and tb_outra_materia.cd_outra_materia = i
                            and tb_outra_materia.cd_outra_materia is not null;
		set i = i + 1;
        if (i > 50)then
			leave simple_loop;
		end if;
	end loop simple_loop;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tarefas` (IN `cd` INT)  begin
		select	cd_planejamento, hr_planejamento, nm_materia, case dt_planejamento 
        when 1 then 'Domingo' 
        when 2 then 'Segunda - feira' 
        when 3 then 'Terça - feira' 
        when 4 then 'Quarta - feira' 
        when 5 then 'Quinta - feira' 
        when 6 then 'Sexta - feira' 
        when 7 then 'Sabado' 
        
        end as dt_planejamento from tb_materia join tb_planejamento on tb_materia.cd_materia = tb_planejamento.cd_materia join tb_usuario on tb_planejamento.cd_usuario = cd and tb_usuario.cd_usuario  = cd order by dt_planejamento, hr_planejamento;
end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_materia`
--

CREATE TABLE `tb_materia` (
  `cd_materia` int(11) NOT NULL,
  `nm_materia` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `tb_materia`
--

INSERT INTO `tb_materia` (`cd_materia`, `nm_materia`) VALUES
(1, 'Matemática'),
(2, 'Português'),
(3, 'História'),
(4, 'Geografia'),
(5, 'Ciências');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_outra_materia`
--

CREATE TABLE `tb_outra_materia` (
  `cd_outra_materia` int(11) NOT NULL,
  `nm_outra_materia` char(45) NOT NULL,
  `cd_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_outra_materia`
--

INSERT INTO `tb_outra_materia` (`cd_outra_materia`, `nm_outra_materia`, `cd_usuario`) VALUES
(6, 'TLBD', 3),
(9, 'TLBD2', 3),
(10, 'TLBD3', 3),
(11, 'TLBD4', 3),
(12, 'TLBD5', 3),
(13, 'PHP', 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_planejamento`
--

CREATE TABLE `tb_planejamento` (
  `cd_planejamento` int(11) NOT NULL,
  `cd_usuario` int(11) DEFAULT NULL,
  `cd_materia` int(11) DEFAULT NULL,
  `cd_outra_materia` int(11) DEFAULT NULL,
  `dt_planejamento` int(1) DEFAULT NULL,
  `hr_planejamento` char(10) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `tb_planejamento`
--

INSERT INTO `tb_planejamento` (`cd_planejamento`, `cd_usuario`, `cd_materia`, `cd_outra_materia`, `dt_planejamento`, `hr_planejamento`) VALUES
(6, 3, 4, NULL, 4, '05/ 06h'),
(9, 3, 2, NULL, 5, '05/ 06h'),
(12, 3, 4, NULL, 6, '05/ 06h'),
(13, 3, 3, NULL, 7, '05/ 06h'),
(15, 3, 2, NULL, 2, '05/ 06h'),
(17, 3, 2, NULL, 3, '05/ 06h'),
(22, 3, 1, NULL, 1, '07/ 08h'),
(27, 3, 1, NULL, 1, '05/ 06h'),
(33, 3, 1, NULL, 7, '06/ 07h'),
(34, 3, 3, NULL, 7, '13/ 14h'),
(36, 3, 1, NULL, 2, '23/ 00h'),
(37, 3, 1, NULL, 3, '14/ 15h'),
(38, 7, 1, NULL, 3, '05/ 06h'),
(39, 3, 1, NULL, 3, '16/ 17h'),
(46, 3, NULL, 9, 1, '20/ 21h'),
(47, 3, NULL, 10, 1, '19/ 20h'),
(50, 3, 4, NULL, 1, '09/ 10h'),
(51, 3, 3, NULL, 1, '10/ 11h'),
(52, 3, 3, NULL, 1, '11/ 12h'),
(53, 3, NULL, 6, 1, '12/ 13h'),
(54, 3, NULL, 6, 1, '14/ 15h'),
(57, 3, NULL, 10, 1, '06/ 07h'),
(59, 3, NULL, 13, 2, '06/ 07h'),
(60, 3, NULL, 11, 3, '06/ 07h'),
(62, 3, NULL, 12, 2, '19/ 20h'),
(65, 3, NULL, 11, 2, '22/ 23h');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_registro_tempo`
--

CREATE TABLE `tb_registro_tempo` (
  `cd_registro_tempo` int(11) NOT NULL,
  `hr_registro_tempo` time DEFAULT NULL,
  `dt_registro_tempo` date DEFAULT NULL,
  `hr_tempo` time DEFAULT NULL,
  `qt_pomodoro` int(11) DEFAULT NULL,
  `cd_usuario` int(11) DEFAULT NULL,
  `cd_materia` int(11) DEFAULT NULL,
  `cd_outra_materia` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_registro_tempo`
--

INSERT INTO `tb_registro_tempo` (`cd_registro_tempo`, `hr_registro_tempo`, `dt_registro_tempo`, `hr_tempo`, `qt_pomodoro`, `cd_usuario`, `cd_materia`, `cd_outra_materia`) VALUES
(11, '00:24:24', '2019-04-30', '00:00:00', 1, 3, 2, NULL),
(10, '00:20:51', '2019-04-30', '00:25:00', 1, 3, 2, NULL),
(15, '20:26:37', '2019-05-27', '00:01:00', 1, 3, 2, NULL),
(4, '23:02:16', '2019-04-01', '00:01:00', 1, 3, 1, NULL),
(5, '23:03:59', '2019-04-26', '00:01:00', 1, 3, 1, NULL),
(6, '23:06:45', '2019-04-26', '00:02:00', 1, 3, 1, NULL),
(7, '23:13:24', '2019-04-26', '00:01:00', 1, 3, 1, NULL),
(8, '12:07:54', '2019-04-29', '00:01:00', 1, 3, 1, NULL),
(9, '23:48:30', '2019-04-29', '00:01:00', 1, 3, 2, NULL),
(12, '00:25:52', '2019-04-30', '00:11:00', 1, 3, 2, NULL),
(13, '00:27:31', '2019-04-30', '00:01:00', 1, 3, 2, NULL),
(14, '00:30:15', '2019-04-30', '00:01:00', 1, 3, 2, NULL),
(16, '20:30:59', '2019-05-27', '00:01:00', 1, 3, 2, NULL),
(17, '20:36:16', '2019-05-27', '00:01:00', 1, 3, 2, NULL),
(18, '20:39:42', '2019-05-27', '00:02:00', 1, 3, 2, NULL),
(19, '00:52:31', '2019-05-28', '00:01:00', 1, 3, 1, NULL),
(20, '01:06:29', '2019-05-28', '00:01:00', 1, 7, 1, NULL),
(21, '15:53:56', '2019-06-01', '00:01:00', 1, 3, 1, NULL),
(22, '22:03:40', '2019-06-03', '00:01:00', 1, 3, 1, NULL),
(23, '19:18:30', '2019-06-10', '00:01:00', 1, 3, NULL, 13),
(24, '19:36:17', '2019-06-10', '00:01:00', 1, 3, NULL, 12),
(25, '22:26:19', '2019-06-10', '00:01:00', 1, 3, NULL, 11);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_usuario`
--

CREATE TABLE `tb_usuario` (
  `cd_usuario` int(11) NOT NULL,
  `nm_login` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nm_usuario` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nm_email` char(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cd_senha` char(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `tb_usuario`
--

INSERT INTO `tb_usuario` (`cd_usuario`, `nm_login`, `nm_usuario`, `nm_email`, `cd_senha`) VALUES
(3, 'Danilo', 'Danilo Isidoro dos Santos', 'danilo@email.com', '123'),
(4, 'Diego', 'Diego Isidoro', 'diego@email.com', '321'),
(5, 'Santos', 'Danilo Isidoro', 'danilosantos@email.com', '123'),
(6, 'Teste', 'Teste', 'teste@email.com', '123'),
(7, 'Danilo123', 'Danilo Isidoro dos Santos', 'danilosantos-pg@hotmail.com', '123'),
(8, 'Danilo1', 'Danilo Isidoro dos Santos', 'danilosntos-pg@hotmail.com', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_materia`
--
ALTER TABLE `tb_materia`
  ADD PRIMARY KEY (`cd_materia`);

--
-- Indexes for table `tb_outra_materia`
--
ALTER TABLE `tb_outra_materia`
  ADD PRIMARY KEY (`cd_outra_materia`),
  ADD KEY `fk_outra_materia_usuario` (`cd_usuario`) USING BTREE;

--
-- Indexes for table `tb_planejamento`
--
ALTER TABLE `tb_planejamento`
  ADD PRIMARY KEY (`cd_planejamento`),
  ADD KEY `fk_planejamento_usuario` (`cd_usuario`),
  ADD KEY `fk_planejamento_materia` (`cd_materia`),
  ADD KEY `fk_planejamento_outras_materias` (`cd_outra_materia`);

--
-- Indexes for table `tb_registro_tempo`
--
ALTER TABLE `tb_registro_tempo`
  ADD PRIMARY KEY (`cd_registro_tempo`),
  ADD KEY `fk_registro_tempo_usuario` (`cd_usuario`),
  ADD KEY `fk_registro_tempo_materia` (`cd_materia`),
  ADD KEY `fk_registro_tempo_outra_materia` (`cd_outra_materia`);

--
-- Indexes for table `tb_usuario`
--
ALTER TABLE `tb_usuario`
  ADD PRIMARY KEY (`cd_usuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_materia`
--
ALTER TABLE `tb_materia`
  MODIFY `cd_materia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_outra_materia`
--
ALTER TABLE `tb_outra_materia`
  MODIFY `cd_outra_materia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tb_planejamento`
--
ALTER TABLE `tb_planejamento`
  MODIFY `cd_planejamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `tb_registro_tempo`
--
ALTER TABLE `tb_registro_tempo`
  MODIFY `cd_registro_tempo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tb_usuario`
--
ALTER TABLE `tb_usuario`
  MODIFY `cd_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `tb_outra_materia`
--
ALTER TABLE `tb_outra_materia`
  ADD CONSTRAINT `fk_outras_materias_usuario` FOREIGN KEY (`cd_usuario`) REFERENCES `tb_usuario` (`cd_usuario`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `tb_planejamento`
--
ALTER TABLE `tb_planejamento`
  ADD CONSTRAINT `fk_planejamento_materia` FOREIGN KEY (`cd_materia`) REFERENCES `tb_materia` (`cd_materia`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_planejamento_outras_materias` FOREIGN KEY (`cd_outra_materia`) REFERENCES `tb_outra_materia` (`cd_outra_materia`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_planejamento_usuario` FOREIGN KEY (`cd_usuario`) REFERENCES `tb_usuario` (`cd_usuario`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

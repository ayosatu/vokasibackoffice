create or replace function F_CRUD_BOT_COMMAND
(
	IN istr_operator character varying,
	IN iint_bot_command_id numeric,
	IN istr_command character varying,
	IN istr_description character varying,
	IN istr_title character varying,
	IN istr_is_param character varying,
	IN istr_store_proc character varying,
	IN istr_username character varying,
	
	OUT oint_res numeric,
	OUT ostr_msg character varying  
)
Returns record AS 
$BODY$
	DECLARE 
		v_msg character varying(500);
		incek numeric(10);
		LS_step character varying(10);
Begin
	LS_step :='1';
	-----Block Insert -------
	if istr_operator = 'I' then
		insert into bot_command
		(
		bot_command_id,
		command,
		description,
		title,
		is_param,
		store_proc,
		created_date,
		update_date,
		created_by,
		update_by
		)
		Values
		(
		(Select 
			Case
				when max(bot_command_id) is null then 1
				else max(bot_command_id)+1
				end from bot_command
		),
		upper(istr_command),
		istr_description,
		istr_title,
		istr_is_param,
		istr_store_proc,
		current_date,
		current_date,
		istr_username,
		istr_username
		);
		
		oint_res := 1;
		ostr_msg := 'Data Has Been Input';
		return;
	end if;
	----Block Update----
	if istr_operator = 'U' then
		
		--Block Update data
		update bot_command
		set	
			name = upper(istr_command),
			description = istr_description,
			title = istr_title,
			is_param = istr_is_param,
			update_date = current_date,
			update_by = istr_username
		where bot_command_id = iint_bot_command_id;
		
		oint_res := 1;
		ostr_msg := 'Data Has Been Diupdate';
		return;
		
	end if;
	-----Block Delete------
	if istr_operator = 'D' then

		select count(*) INTO incek
		from bot_command
		where bot_command_id = iint_bot_command_id;
		
		if incek = 0 then
			oint_res := 111111;
			ostr_msg := 'Data Not Found';
			return;
		end if;
		delete from bot_command
			where bot_command_id= iint_bot_command_id;
	end if;
	oint_res := 1;
	ostr_msg := 'Data Has Been Deleted';
	return;

exception when others then 
		BEGIN
		
			SELECT description into v_msg 
			FROM vw_ref_eror_msg 
			WHERE code = sqlstate;
			oint_res := sqlstate;
			ostr_msg := v_msg;
			
		exception when others then
		oint_res := -1;
		ostr_msg :=LS_step || ' Error : ' || sqlstate || ' - ' || sqlerrm;
		return;
		END; 
end;
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;

select * from F_CRUD_BOT_COMMAND
(
	'I',
	null,
	'Selamat Pagi!',
	'Sapaan',
	'Pagi',
	'Y',
	'-',
	null,
	null,
	'admin',
	'admin'
);


------------------------------------------------------------------------

create or replace function F_CRUD_BOT_COMMAND_USER
(
	IN istr_operator character varying,
	IN iint_bot_com_user_id numeric,
	IN iint_bot_command_id numeric,
	IN iint_user_id numeric,
	IN idt_valid_from date,
	IN idt_valid_until date,
	IN istr_username character varying,
	
	OUT oint_res numeric,
	OUT ostr_msg character varying  
)
Returns record AS 
$BODY$
	DECLARE 
		v_msg character varying(500);
		incek numeric(10);
		LS_step character varying(10);
Begin
	LS_step :='1';
	-----Block Insert -------
	if istr_operator = 'I' then
		insert into bot_command_user
		(
		bot_com_user_id,
		bot_command_id,
		user_id,
		valid_from,
		valid_until,
		created_date,
		update_date,
		created_by,
		update_by
		)
		Values
		(
		(Select 
			Case
				when max(bot_com_user_id) is null then 1
				else max(bot_com_user_id)+1
				end from bot_command_user
		),
		iint_bot_command_id,
		iint_user_id,
		idt_valid_from,
		idt_valid_until,
		current_date,
		current_date,
		istr_username,
		istr_username
		);
		
		oint_res := 1;
		ostr_msg := 'Data Has Been Input';
		return;
	end if;
	----Block Update----
	if istr_operator = 'U' then
		
		--Block Update data
		update bot_command_user
		set	
			bot_command_id = iint_bot_command_id,
			user_id = iint_user_id,
			valid_from = idt_valid_from,
			valid_until = idt_valid_until,
			update_date = current_date,
			update_by = istr_username
		where bot_com_user_id = iint_bot_com_user_id;
		
		oint_res := 1;
		ostr_msg := 'Data Has Been Diupdate';
		return;
		
	end if;
	-----Block Delete------
	if istr_operator = 'D' then

		select count(*) INTO incek
		from bot_command_user
		where bot_com_user_id = iint_bot_com_user_id;
		
		if incek = 0 then
			oint_res := 111111;
			ostr_msg := 'Data Not Found';
			return;
		end if;
		delete from bot_command_user
			where bot_com_user_id= iint_bot_com_user_id;
	end if;
	oint_res := 1;
	ostr_msg := 'Data Has Been Deleted';
	return;

exception when others then 
		BEGIN
		
			SELECT description into v_msg 
			FROM vw_ref_eror_msg 
			WHERE code = sqlstate;
			oint_res := sqlstate;
			ostr_msg := v_msg;
			
		exception when others then
		oint_res := -1;
		ostr_msg :=LS_step || ' Error : ' || sqlstate || ' - ' || sqlerrm;
		return;
		END; 
end;
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
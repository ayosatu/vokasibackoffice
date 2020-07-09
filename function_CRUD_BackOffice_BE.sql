create or replace function F_CRUD_INSTITUTION
(
	IN istr_operator character varying,
	IN iint_ins_id numeric,
	IN istr_name character varying,
	IN istr_since_period character varying,
	IN idt_f_date date,
	IN istr_npwp character varying,
	IN istr_no_permit character varying,
	IN istr_img_path character varying,
	IN istr_no_tlp character varying,
	IN istr_no_fax character varying,
	IN istr_email character varying,
	IN istr_no_hp character varying,
	IN istr_addres character varying,
	IN istr_username character varying,
	
	OUT oint_res numeric,
	OUT ostr_msg character varying  
)
Returns record AS 
$BODY$
	DECLARE 
		incek numeric(10);
		LS_step character varying(10);
Begin
	LS_step :='1';
	-----Block Insert -------
	if istr_operator = 'I' then
		insert into institution
		(
		ins_id,
		name,
		since_period,
		f_date,
		npwp,
		no_permit,
		img_path,
		created_date,
		update_date,
		created_by,
		update_by,
		no_tlp,
		no_fax,
		email,
		no_hp,
		address
		)
		Values
		(
		(Select 
			Case
				when max(ins_id) is null then 1
				else max(ins_id)+1
				end from institution
		),
		upper(istr_name),
		istr_since_period,
		idt_f_date,
		istr_npwp,
		istr_no_permit,
		istr_img_path,
		current_date,
		current_date,
		istr_username,
		istr_username,
		istr_no_tlp,
		istr_no_fax,
		istr_email,
		istr_no_hp,
		istr_addres
		);
		
		oint_res := 1;
		ostr_msg := 'Data Has Been Input';
		return;
	end if;
	----Block Update----
	if istr_operator = 'U' then
		
		--Block Update data
		update institution
		set	
			name = upper(istr_name),
			img_path = istr_img_path,
			no_tlp = istr_no_tlp,
			no_fax = istr_no_fax,
			email = istr_email,
			no_hp = istr_no_hp,
			address = istr_addres,
			update_date = current_date,
			update_by = istr_username
		where ins_id = iint_ins_id;
		
		oint_res := 1;
		ostr_msg := 'Data Has Been Diupdate';
		return;
		
	end if;
	-----Block Delete------
	if istr_operator = 'D' then

		select count(*) INTO incek
		from institution
		where ins_id = iint_ins_id;
		
		if incek = 0 then
			oint_res := 111111;
			ostr_msg := 'Data Not Found';
			return;
		end if;
		delete from institution
			where ins_id = iint_ins_id;
	end if;
	oint_res := 1;
	ostr_msg := 'Data Has Been Deleted';
	return;
	
	exception when others then 
		oint_res := -1;
		ostr_msg :=LS_step || 'Error' || sqlerrm;
		return;
End;
$BODY$
language plpgsql VOLATILE
cost 100;

select * from f_crud_institution
(
	'D',
	1,
	null,
	null,
	null,
	null,
	null,
	null,
	null,
	null,
	null,
	null,
	null,
	null
);
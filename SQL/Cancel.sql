begin try
	begin transaction
		delete
		from reserved_list
		where ticket_number in(
			select ticket_number
			from ticket_of
			where reservation_number='{$pid}');
	
		insert into reservation_canceled values ('{$pid}');
		commit transaction
	end try
begin catch
	select
		ERROR_MESSAGE() AS ErrorMessage;
    if @@trancount>0
        rollback transaction
end catch
--是否已經訂票過
begin try
insert into guest values ('234','名','姓','手機','信箱');
--如果已經訂票過
end try
begin catch
update guest
	set name_first='123',
		name_last='123',
		phone_mobile='123',
		email_address='123'
	where guest_ID='234'
end catch;

--寫入座位
begin try
	begin transaction
	insert into ticket values ('234','2012-12-28','609',2,1,8);
	--php loop start
	insert into reserved_list values ('2012-12-28','609',2,1,'234');
	insert into reserved_list values ('2012-12-28','609',2,2,'234');
	insert into reserved_list values ('2012-12-28','609',2,3,'234');
	insert into reserved_list values ('2012-12-28','609',2,4,'234');
	insert into reserved_list values ('2012-12-28','609',2,5,'234');
	insert into reserved_list values ('2012-12-28','609',2,6,'234');
	insert into reserved_list values ('2012-12-28','609',2,7,'234');
	--loop end
	insert into reservation values ('234','234');
	insert into ticket_of values ('234','234');

	commit transaction--以上皆成功，寫入資料庫
end try
begin catch
	select
		ERROR_MESSAGE() AS ErrorMessage;
    if @@trancount>0
        rollback transaction--有問題，回朔到 begin
end catch

--訂位成功，顯示車票資訊
select *
from ticket
where ticket_number='車票代碼'

--座位號碼對應
select car_number, seat_number
from seat
where seat_ID='座位號碼'

--訂票人資訊
select *
from guest
where guest_ID='身分證'

--價格
select *
from price
where station_start=起站
	and station_end=迄站
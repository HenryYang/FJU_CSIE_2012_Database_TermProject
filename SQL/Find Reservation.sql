--以身分證跟手機查詢訂票
select reservation_number, ticket_date, train_number, start_station, end_station, seat_ID
from ticket_of full outer join ticket on ticket_of.ticket_number=ticket.ticket_number
where reservation_number in(
	select reservation_number
	from reservation
	where guest_ID in(
		select guest_ID
		from guest
		where guest_ID='身分證' and phone_mobile='手機號碼'))
	and
	reservation_number not in(
		select *
		from reservation_canceled)
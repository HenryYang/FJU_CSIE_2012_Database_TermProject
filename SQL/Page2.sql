--選擇可用的個隨機空位
select top 1 seat_ID
from seat
where seat_ID in((
	select seat_ID
	from seat)
	except(
		select seat_ID
		from reserved_list
		where train_date = '2013-01-04'--乘車日期
			and train_number = 620))
	or
	seat_ID not in(
		select seat_ID
		from reserved_list
		where train_number = 620
			and station_ID between 2 and 8--搭車區間
			and train_date = '2013-01-04')--乘車日期
order by NEWID();

--查詢票價				
select price
from price
where station_start = 2 and station_end = 4--起迄站

--查詢時間
select depart_time
from train_stop_at
where train_number='605' and station_ID=2
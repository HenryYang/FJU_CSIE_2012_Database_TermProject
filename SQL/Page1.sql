select distinct top 10 A.train_number, A.depart_time, B.depart_time as arrive_time
from train_stop_at as A left outer join train_stop_at as B on A.train_number=B.train_number
where 
	--找出不是全車都有訂位的列車
	A.train_number in(
		select A.train_number
		from train_stop_at as S
		where
		exists((
			select distinct seat_ID
			from seat)
			except(
				select seat_ID
				from reserved_list as T
				where S.train_number=T.train_number
					and A.station_ID between 5 and 7--已經有訂位但在客戶搭乘「區間（最後一站減一）」有空位
					and train_date='乘車日期')))
	and A.station_ID=5--客戶選擇的啟程站
	and B.station_ID=8
	and A.depart_time>=360--客戶選擇的啟程時間 ex.360
	and A.train_number in(
		select A.train_number
		from train
		where start_station<end_station)--南下北上 ex.南下（<）北上（>）
	order by A.depart_time asc;--以出發時間排序
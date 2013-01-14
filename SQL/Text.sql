select train_number, depart_time
from train_stop_at
where 
	--找出某輛車全車（不管哪一個區段）都有沒有訂位
	train_number in(
		select distinct train_number
		from train_stop_at as S
		where
			not exists((
				select distinct seat_ID
				from seat)
				except(
					select distinct T.seat_ID
					from reserved_list as T
					where train_date='2012-12-21'
						--檢查該車次日期
						and S.train_number = T.train_number)))
	or train_number in(
	)
	and station_ID=3--客戶選擇的啟程站 ex.3
	and depart_time>=360--客戶選擇的啟程時間 ex.360
order by depart_time asc;
--以出發時間排序




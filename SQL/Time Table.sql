select train_number
from train
where start_station=1

select station_ID, depart_time
from train_stop_at
where train_number='605'
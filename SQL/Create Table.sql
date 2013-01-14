--建立車站表格
create table station(
	station_ID numeric(2,0),
	station_name varchar(20) not null,

	primary key(station_ID));

--建立車次表格
create table train(
	train_number varchar(4),
	start_station numeric(2,0) not null,
	end_station numeric(2,0) not null,

	primary key(train_number),
	foreign key(start_station) references station,
	foreign key(end_station) references station);

--建立車次停靠車站表格
create table train_stop_at(
	train_number varchar(4),
	station_ID numeric(2,0),
	depart_time numeric(4,0),

	foreign key (train_number) references train,
	foreign key (station_ID) references station,
	check (depart_time>0 and depart_time<1440));

--建立列車座位表格
create table seat(
	seat_ID numeric(4,0),
	car_number varchar(2),
	seat_number varchar(3),

	primary key (seat_ID));

--建立使用者資訊表格
create table guest(
	guest_ID varchar(10),
	name_first varchar(10),
	name_last varchar(10),
	phone_mobile varchar(10) not null,
	email_address varchar(40),

	primary key (guest_ID));

--建立車票資訊表格
create table ticket(
	ticket_number varchar(13),
	ticket_date date,
	train_number varchar(4),
	seat_ID numeric(4,0),
	start_station numeric(2,0),
	end_station numeric(2,0),

	primary key (ticket_number),
	foreign key (train_number) references train,
	foreign key (seat_ID) references seat,
	foreign key (start_station) references station,
	foreign key (end_station) references station);

--建立訂票資訊表格
create table reservation(
	reservation_number varchar(15),
	guest_ID varchar(10),

	primary key (reservation_number),
	foreign key (guest_ID) references guest);

--建立取消的訂票表格
create table reservation_canceled(
	reservation_number varchar(15),
	
	primary key (reservation_number),
	foreign key (reservation_number) references reservation);

--車票屬於訂位編號
create table ticket_of(
	reservation_number varchar(15),
	ticket_number varchar(13),

	foreign key (reservation_number) references reservation,
	foreign key (ticket_number) references ticket);

--所有已訂位列車座位
create table reserved_list(
	train_date date,
	train_number varchar(4),
	seat_ID numeric(4,0),
	station_ID numeric(2,0),
	ticket_number varchar(13),

	primary key (train_date, train_number, seat_ID, station_ID),
	foreign key (ticket_number) references ticket,
	foreign key (station_ID) references station,
	foreign key (train_number) references train,
	foreign key (seat_ID) references seat);

--建立票價資訊表格
create table price(
	station_start numeric(2,0),
	station_end numeric (2,0),
	price numeric(4,0),

	foreign key (station_start) references station,
	foreign key (station_end) references station);
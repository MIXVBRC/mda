create table if not exists mda_medusa_multi_shop (
   ID int(18) not null auto_increment,
   FUSER_ID int(18) not null,
   USER_ID int(18),
   XML_ID varchar(255) not null,
   AUTO_SELECT bool not null default true,
   DATE_CREATE datetime not null default current_timestamp,
   DATE_UPDATE datetime on update current_timestamp not null default current_timestamp,
   primary key (ID));
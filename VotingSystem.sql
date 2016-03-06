create database VotingSystem;

use VotingSystem;

create table login(
    pk_int_login_id int primary key auto_increment,
    vchr_emailid varchar(100),
    vchr_password varchar(20),
    bln_login_status tinyint(1)
 );

create table voterslist(
    pk_int_voter_id int primary key auto_increment,
    vchr_voter_name varchar(100),
    vchr_father_name varchar(100),
    vchr_mother_name varchar(100),
    vchr_state varchar(100),
    vchr_district varchar(100),
    vchr_muncipality varchar(100),
    fk_int_login_id int,
    foreign key(fk_int_login_id) references login(pk_int_login_id)
);

create table trackUpdates(
pk_int_doc_id int primary key auto_increment,
fk_int_login_id int,
dat_created_on date,
vchr_created_on_time varchar(30),
dat_updated_on date,
vchr_updated_on_time varchar(30),
foreign key(fk_int_login_id) references login(pk_int_login_id)
);

create table countVotes(
    pk_int_vote_id int primary key auto_increment,
    vchr_party_name varchar(100),
    vchr_nominee_name varchar(100),
    int_vote_count int
);






delimiter //
create procedure voterRegistration(in voter_name varchar(90),in father_name varchar(90),in mother_name varchar(90),in state varchar(90),in district varchar(90),in muncipality varchar(90),in created_date date,in created_time varchar(90),in emailid varchar(200),in password varchar(20),in bln_status tinyint(1))
begin
declare log_id int default 0;
declare flag int default 0;
declare continue handler for sqlexception,sqlwarning set flag=1;
start transaction;
insert into login(vchr_emailid,vchr_password,bln_login_status) values(emailid,password,bln_status);
set log_id=last_insert_id(); 
insert into voterslist(vchr_voter_name,vchr_father_name,vchr_mother_name,vchr_state,vchr_district,vchr_muncipality,fk_int_login_id)values(voter_name,father_name,mother_name,state,district,muncipality,log_id);
insert into trackUpdates(fk_int_login_id,dat_created_on,vchr_created_on_time,dat_updated_on,vchr_updated_on_time)values(log_id,created_date,created_time,created_date,created_time);
if flag=0 then
commit;
else rollback;
end if;
end //    
delimiter ;




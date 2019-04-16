 create table student(
 id int(10) unsigned not null auto_increment primary key,
 stu_id int(10) unsigned not null comment '学号',
 stu_name varchar(50) not null default '' comment '学生姓名',
 stu_sex enum('1','2','3') default '1' comment '性别  1男 2女 3保密',
 stu_add varchar(50) not null default '' comment '家庭住址',
 stu_phone char(11) not null default '' comment '联系电话信息'
)engine = innodb default charset=utf8 collate = utf8_general_ci;


 alter table student add degree enum('1','2','3','4','5') default '1' comment '学历  1专科 2本科 3小学 4初中 5高中'

alter table student add age tinyint(200)


insert into student(stu_id,stu_name,stu_sex,stu_add,stu_phone,degree,age) values 
					(1001,'lili','2','北京','12345678912','1',20),
					(1002,'pipi','1','河南','12345678912','2',20),
					(1003,'didi','2','武汉','12345678912','2',20);
						 

select * from student where degree = "2"

select stu_sex,count(*) from student group by stu_sex

select count(*) from student group by age having 15<age>20,10<age>25

1.创建一张学生表，包含学号，姓名，性别，家庭住址，联系电话信息
2.修改学生表结构，增加学历字段
3.随机插入3条学生信息
4.查询出年龄小于20岁，学历为本科的所有学员信息
5.统计所有学生的男女人数
6.统计学生年龄在15-20,20-25,25-30三个区间的人数分别为多少
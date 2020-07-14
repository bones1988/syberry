drop schema if exists employees;
create schema employees;
use employees;
create table if not exists employees (
id bigint auto_increment primary key,
name varchar(16) not null);
create table if not exists time_reports(
id bigint auto_increment primary key,
employee_id bigint,
hours float(4,2),
date date,
foreign key (employee_id) REFERENCES employees(id)
);

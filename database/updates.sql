-- Active: 1636088492019@@127.0.0.1@3306@goh_referral
alter table user_categories add column deleted tinyint(1) not null default 0 after permissions;
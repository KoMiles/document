#!/usr/bin/python
#coding=utf-8
#读取一个列表

# This is my user list
user_list = {
        123:'张三',
        456:'李四',
        789:'王五',
        258:'赵六',
        }

for user_id,user_name in user_list.items():
    print ' 用户名：%s  编号： %s ' % (user_name, user_id)

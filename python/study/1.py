#!/usr/bin/python3.4
#coding=utf-8
#后一个数字是前面两个数字之和

a,b = 0,1
while b <= 10:
    print(b)
    a,b = b,a+b

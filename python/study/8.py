#!/usr/bin/python
#coding=utf-8
#九九乘法表
lista = listb = range(1,10);
for i in lista:
    for j in listb:
        if j<=i:
            print i,'*',j,'=',i*j,' ',
    print

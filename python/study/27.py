#!/bin/python
name = raw_input("please input your name:")
y = ''
while True:
    if(y == 'bye'):
        print "your name is ", name, "bye,bye~~"
        break
    a = input("Please input a num:")
    sum = 0
    for i in range(1,a+1):
        sum += i
    print "Hello ",name ,"your sum num is : 1+2+3...+",i ,"=",sum
    y = raw_input("Please input 'bye' to exit or input any key to continue:")

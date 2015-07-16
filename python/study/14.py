#coding=utf-8
#对输入的输入进行判断

x = int(input("Please input num a:"))
if x < 0:
    print("the num is not less than zero!")
elif x == 0:
    print("the num is zero!")
elif x == 1:
    print("the num is 1")
else:
    print x

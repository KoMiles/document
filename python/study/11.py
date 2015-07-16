#coding=utf-8
#在某一个区间内查找一个质数
import math
for i in range(50, 101):
    for j in range(2,int(math.sqrt(i)) + 1):
        if i % j == 0:
            break
    else:
        print i

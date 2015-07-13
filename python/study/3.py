# encoding=UTF-8
# 石头剪子布 程序
# 李忠
import random

# 定义石头剪子布字典
dict = {1:'剪子',2:'石头',3:'布'}

for row in dict:
    print '编号:',row,' = ',dict[row]
    print '您出什么？'
    loop = True
    while loop:
        you = raw_input('请输入编号回车: ')
    try:
        you = int(you)
        if you>=1 and you<=3:
            loop = False
        else:
            print '请输入 1-3 范围内的编号'
            #except Exception,e:
            #print '请输入正确的数字编号'

        dn = random.randint(1,3)
        print '你出：',dict[you]
        print '电脑出：',dict[dn]
        print '结果：',

if dn==you:
    print '平局'
elif (you>dn and you-dn==1) or you+2==dn:
    print '你胜'
else:
    print '电脑胜'

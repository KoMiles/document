#!/usr/bin/python
#coding=utf-8
#读取一个列表

# This is my shopping list
shoplist = ['apple', 'mango', 'carrot', 'banana']

shoplist.sort()
print shoplist;
exit('退出一下');
print 'I have', len(shoplist),'items to purchase.'
exit('退出一下');

print 'These items are:', # Notice the comma at end of the line
for item in shoplist:
    print item,

    print '\nI also have to buy rice.'
    shoplist.append('rice')
    print 'My shopping list is now', shoplist

    print 'I will sort my list now'
    shoplist.sort()
    print 'Sorted shopping list is', shoplist

    print 'The first item I will buy is', shoplist[0]
    olditem = shoplist[0]
    del shoplist[0]
    print 'I bought the', olditem
    print 'My shopping list is now', shoplist

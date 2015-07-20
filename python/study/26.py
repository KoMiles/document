#PlisCal V1.9 (alpha) by:b1ta - 2015/07/17/09:07
name = raw_input("Eh,What is your name:")
print "Hello," + name + "!"
y = 1
while y < 2:
    a = input("Please enter a number:")
    sum = 0
    for i in range(1,a+1):
        sum += i
    print "Nice,1+2+3+..." ,a,"=",sum
    y = input("If you want to try it again,Enter number 1,or enter other number to exit:")
    print name + ",Press your 'Enter' to say Good-bye."
exit()
#Have fun!

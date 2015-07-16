def ask_ok(prompt, retries=4, complaint='Yes or no, please!'):
    while True:
        ok = input(prompt)
        return ok
        #if ok in ('y', 'ye', 'yes'):
            #return True
        #if ok in ('n', 'no', 'nop', 'nope'):
            #return False
        #retries = retries - 1
        #if retries < 0:
            #raise OSError('uncooperative user')
        #print(complaint)


a =  ask_ok('OK to overwrite the file?')
print a

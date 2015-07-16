def ask_ok(prompt, retries = 4, complaint = "Yes or no ,please!"):
    while True:
        ok = raw_input(prompt)
        if ok in ('y', 'ye', 'yes'):
            print "your input is right!"
            return True
        if ok in ('n', 'no', 'nop', 'nope'):
            print "your input is wrong!"
            return False
        retries = retries - 1
        if retries < 0:
            raise OSError('Times is overs!')
        print(complaint)


ask_ok('OK to overwrite the file?',2)

while True:
    try:
        x = int(input("Please enter a number:"))
        print x
        break
    except ValueError:
        print("Oh,the num is valid number. Try agin...")

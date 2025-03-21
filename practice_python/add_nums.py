#write a program that takes 2 numbers from the user and asks them 
# what operation they want to perform, then prints the final result
num_1 = int(input("what is your first number? "))
num_2 = int(input ("what is your second number? "))
final_num = 0 #this is a placeholder for the final number you print
math_type = input ("what math operation would you like to preform ") 

if math_type == ("add"):
    final_num = num_1 + num_2
elif math_type == ("sub"):
    final_num = num_1 - num_2
elif math_type == ("mult"): 
     final_num = num_1 * num_2
else:
    final_num  = num_1 / num_2

print(final_num)
import pandas as pd
import glob

# Find all the csv files in the folder
csv_files = glob.glob("nba_data/*.csv")
# Read all CSV files into a list of DataFrames
df_list = [pd.read_csv(file) for file in csv_files]
# Concatenate all DataFrames into a single DataFrame
df_all = pd.concat(df_list, ignore_index=True)

# Ask the user what question they want to know
question = input("What do you want to know: ")

#Create 1 if statement for each question
if question == "q1":
    max_value = df_all['PTS_Visitor'].max()
    row_with_max = df_all[df_all['PTS_Visitor'] == max_value]
    print("The team with the highest amount of visitor points is:")
    print(row_with_max)
elif question == "q2":
    max_value = df_all['PTS_Home'].astype(float).max()
    row_with_max = df_all[df_all['PTS_Home'] == max_value]
    print("The team with the highest home points is: ")
    print(row_with_max)
elif question == "q3":
    max_attendance = df_all['Attend.'].max()
    df_max = df_all[df_all['Attend.'] == max_attendance]
    print("The team with the highest attendence total")
    print(df_max["Arena"])
else:
    print("This many games were played at crypto.com arena")
    print(len(df_all[df_all["Arena"]=="Crypto.com Arena"]))
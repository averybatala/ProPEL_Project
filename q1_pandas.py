#Which visitor team scored the most points?
#To get the maximum value of a specific column, use df['column_name'].max()
#
import pandas as pd
import glob

# Use glob to find all CSV files in the directory
csv_files = glob.glob("nba_data/*.csv")

# Read all CSV files into a list of DataFrames
df_list = [pd.read_csv(file) for file in csv_files]

# Concatenate all DataFrames into a single DataFrame
df_all = pd.concat(df_list, ignore_index=True)

max_value = df_all['PTS_Visitor'].max()
row_with_max = df_all[df_all['PTS_Visitor'] == max_value]
print(row_with_max)


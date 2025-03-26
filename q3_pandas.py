#Which stadium had the highest attendance?
#I want to only show the stadium name and the attendence

## Choose which columns to display (for example, 'colname' and 'other_col')
#columns_to_display = ['colname', 'other_col']

# Print only the selected columns of the row
#print(row_with_max[columns_to_display])

#Which stadium had the highest attendance?
import pandas as pd
df_q3_pandas = pd.read_csv("nba_data/November_2024.csv")
#df = df_q3_pandas['PTS_Visitor'].max()

max_value = df_q3_pandas['Attend.'].max()
row_with_max = df_q3_pandas[df_q3_pandas['Attend.'] == max_value]
print(row_with_max)
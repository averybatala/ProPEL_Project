#Which visitor team scored the most points?
#To get the maximum value of a specific column, use df['column_name'].max()
import pandas as pd

df_q1_pandas = pd.read_csv("nba_data/November_2024.csv")
#df = df_q1_pandas['PTS_Visitor'].max()

max_value = df_q1_pandas['PTS_Visitor'].max()
row_with_max = df_q1_pandas[df_q1_pandas['PTS_Visitor'] == max_value]
print(row_with_max)

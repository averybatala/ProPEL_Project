#Which home team scored the most points?
import pandas as pd
df_q1_pandas = pd.read_csv("nba_data/November_2024.csv")
#df = df_q1_pandas['PTS_Visitor'].max()

max_value = df_q1_pandas['PTS_Home/Neutral'].max()
row_with_max = df_q1_pandas[df_q1_pandas['PTS_Home/Neutral'] == max_value]
print(row_with_max)
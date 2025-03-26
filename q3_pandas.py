#Which stadium had the highest attendance?
 
import pandas as pd
df_q3_pandas = pd.read_csv("nba_data/November_2024.csv")
 

max_attendance = df_q3_pandas['Attend.'].max()
df_max = df_q3_pandas[df_q3_pandas['Attend.'] == max_attendance]
print(df_max["Arena"])

 
import pandas as pd
df_q4_pandas = pd.read_csv("nba_data/November_2024.csv")
print(len(df_q4_pandas[df_q4_pandas["Arena"]=="Crypto.com Arena"]))
 
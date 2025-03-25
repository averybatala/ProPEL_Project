import pandas as pd

df_nba_data = pd.read_csv("nba_data/December_2024.csv,February_2025.csv,January_2025.csv,November_2024.csv,October_2024.csv")
df_nba_data['Notes'].fillna("No notes", inplace=True) 
df_combined = pd.concat([df_november, df_october,df_january,df_february, df_december], ignore_index=True)
df_combined['Date'] = pd.to_datetime(df_combined['Date'], format='%a %b %d %Y')
df_combined = df_combined.sort_values(by='Date', ascending=True)
df_combined.reset_index(drop=True, inplace=True)
df_combined.to_csv('concat_dec_feb_jan_nov_oct.csv', index=False)
df_combined.reset_index(drop=True, inplace=True)
df = df[df["PTS"] > "Away"]

import pandas as pd

#df = pd.read_csv("December_2024.csv")

#df = df[df["PTS"] > 100]

#df.info()

#df.to_csv('December_2024_modified.csv', index=False)

#1. Load January_2025.csv into a dataframe
#2. Filter to Attend. > 1000 
#3. Filter to PTS < 100
#4. Save as Janurary_2025_modified.csv

# df_november = pd.read_csv("nba_data/November_2024.csv")
# df_november['Notes'].fillna("No notes", inplace=True)

# df_october = pd.read_csv("nba_data/October_2024.csv")
# df_october['Notes'].fillna("No notes", inplace=True)

# df_combined = pd.concat([df_november, df_october], ignore_index=True)
# df_combined['Date'] = pd.to_datetime(df_combined['Date'], format='%a %b %d %Y')
# df_combined = df_combined.sort_values(by='Date', ascending=True)
# df_combined.reset_index(drop=True, inplace=True)

# df_combined.to_csv('concat_nov_oct.csv', index=False)


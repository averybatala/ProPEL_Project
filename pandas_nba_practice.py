import pandas as pd


# df_november = pd.read_csv("nba_data/November_2024.csv")
# df_november['Notes'].fillna("No notes", inplace=True)

# df_october = pd.read_csv("nba_data/October_2024.csv")
# df_october['Notes'].fillna("No notes", inplace=True)

# df_combined = pd.concat([df_november, df_october], ignore_index=True)
# df_combined['Date'] = pd.to_datetime(df_combined['Date'], format='%a %b %d %Y')
# df_combined = df_combined.sort_values(by='Date', ascending=True)
# df_combined.reset_index(drop=True, inplace=True)

# df_combined.to_csv('concat_nov_oct.csv', index=False)

#1. read and save 2 CSV files to variables: January_2025 and February_2025
#2. create a df_combined and combine the 2 dataframes you created in step 1
#3. Convert the date column into dates
#4. sort by ascending=False for dates
#5. reset row index
#6. save your combined csv with an appropriate name
df_January = pd.read_csv("nba_data/January_2025.csv")
df_January['Notes'].fillna("No notes", inplace=True)

df_February = pd.read_csv("nba_data/February_2025.csv")
df_February['Notes'].fillna("No notes", inplace=True)

df_combined = pd.concat([df_January, df_February], ignore_index=True)
df_combined['Date'] = pd.to_datetime(df_combined['Date'], format='%a %b %d %Y')
df_combined = df_combined.sort_values(by='Date', ascending=True)
df_combined.reset_index(drop=True, inplace=True)

df_combined.to_csv('concat_jan_feb.csv', index=False)
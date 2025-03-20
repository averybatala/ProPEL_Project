import pandas as pd

#df = pd.read_csv("December_2024.csv")

#df = df[df["PTS"] > 100]

#df.info()

#df.to_csv('December_2024_modified.csv', index=False)

#1. Load January_2025.csv into a dataframe
#2. Filter to Attend. > 1000 
#3. Filter to PTS < 100
#4. Save as Janurary_2025_modified.csv
df = pd.read_csv("January_2025.csv")
df = df[df["Attend."] > 1000]
df = df[df["PTS"] > 100]
df.to_csv('January_2025_modified.csv', index=False)
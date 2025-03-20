```python
#import pandas as pd
```
###### Imports the pandas library, which is used for data manipulation and analysis.
```python
#df = pd.read_csv("December_2024.csv")
```
###### Reads the CSV file `December_2024.csv` into a pandas DataFrame called `df`.
```python
#df = df[df["PTS"] > 100]
```
###### Filters the DataFrame `df` to include only rows where the `PTS` column is greater than 100.
```python
#df.info()
```
###### Prints a concise summary of the DataFrame `df`, showing the number of non-null entries and data types of each column.
```python
#df.to_csv('December_2024_modified.csv', index=False)
```
###### Saves the filtered DataFrame `df` (with rows where PTS > 100) to a new CSV file `December_2024_modified.csv`, excluding the index column.
```python
# df_november = pd.read_csv("nba_data/November_2024.csv")
```
###### Reads the CSV file `November_2024.csv` into a DataFrame called df_november`.
```python
# df_november['Notes'].fillna("No notes", inplace=True)
```
###### Fills any missing values (NaN) in the `Notes` column of `df_november` with the text "No notes" and modifies the DataFrame in place.
```python
# df_october = pd.read_csv("nba_data/October_2024.csv")
```
###### Reads the CSV file `October_2024.csv` into a DataFrame called `df_october`.
```python
# df_october['Notes'].fillna("No notes", inplace=True)
```
###### Fills any missing values (NaN) in the `Notes` column of `df_october` with the text "No notes" and modifies the DataFrame in place.
```python
# df_combined = pd.concat([df_november, df_october], ignore_index=True)
```
###### Concatenates the two DataFrames `df_november` and `df_october` into a single DataFrame called `df_combined`.
###### The `ignore_index=True` ensures that the index is reset and doesn't keep the index from the original DataFrames.

```python 
df_combined['Date'] = pd.to_datetime(df_combined['Date'], format='%a %b %d %Y')
```
###### Converts the `Date` column in `df_combined` from a string format (e.g., "Tue Oct 22 2024") to pandas `datetime` objects,
###### using the specified format (`%a %b %d %Y`).
```python
# df_combined = df_combined.sort_values(by='Date', ascending=True)
```
###### Sorts the rows of `df_combined` by the `Date` column in ascending order (from the oldest date to the latest date).
```python
# df_combined.reset_index(drop=True, inplace=True)
```
###### Resets the index of `df_combined` after sorting. The `drop=True` ensures the old index is not added as a new column.
###### The `inplace=True` modifies the DataFrame directly.
```python
# df_combined.to_csv('concat_nov_oct.csv', index=False)
```
###### Saves the `df_combined` DataFrame (which contains data from both November and October 2024) into a new CSV file named `concat_nov_oct.csv`, without including the index column.



## FOR 3/26/25:
#### Which visitor team scored the most points?
#### Which home team scored the most points? 
#### Which stadium had the highest attendance?
#### How many games were played at Crypto.com arena? 
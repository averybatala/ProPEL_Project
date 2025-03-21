# Github usage instructions
For pushing and making changes to your github repo
1. Use "git add ." to get your files ready to be pushed
- Optional: Use "git add filename" to add individual files
2. Use "git status" to make sure you have only changed the files you want
3. Use "git commit -m "commit message" to get files staged for push and put a descriptive message
4. Use "git push" to push your local changes to your repo

# Python Cheatsheet

## Python Syntax
### Basic Structure
```python
print("Hello, World!")
```
###### `print()` is used to output text to the console.

---

## Comments
### Single-line Comment
```python
# This is a single-line comment
```
###### Use `#` for single-line comments.

### Multi-line Comment
```python
"""
This is a multi-line comment.
It spans multiple lines.
"""
```
###### Use triple quotes (`"""` or `'''`) for multi-line comments.

---

## Variables & Data Types
### String Variables
```python
animal = "dog"
```
###### `"dog"` is a string, hence it's surrounded by quotes.

### Integer Variables
```python
number = 1
```
###### `1` is an integer with no decimals.

### Float Variables
```python
pi = 3.14
```
###### `3.14` is a float (a number with decimals).

### Boolean Variables
```python
is_python_fun = True
```
###### `True` and `False` are boolean values.

---

## Strings & Casting
### String Concatenation
```python
greeting = "Hello, " + "World!"
```
###### Use `+` to concatenate strings.

### String Length
```python
length = len("Python")
```
###### `len()` returns the length of a string.

### Casting to String
```python
num_str = str(123)
```
###### `str()` converts a number to a string.

### Casting to Integer
```python
num_int = int("456")
```
###### `int()` converts a string to an integer.

---

## Lists & List Comprehensions
### Creating a List
```python
fruits = ["apple", "banana", "cherry"]
```
###### Lists are ordered and mutable collections.

### Accessing List Elements
```python
first_fruit = fruits[0]
```
###### Use `[index]` to access elements (index starts at 0).

### List Comprehension
```python
squares = [x**2 for x in range(10)]
```
###### Create a new list by applying an expression to each item.

---

#dictionaries
### Creating a Dictionary
```python
person = {"name": "Alice", "age": 25}
```
#####dictionaries store key-value pairs.

### Accessing Dictionary Values
```python
name = person["name"]
```
###### Use `[key]` to access the value associated with a key.

### Adding to a Dictionary
```python
person["city"] = "New York"
```
###### Add new key-value pairs by assigning a value to a new key.

---

## If Statements
### Basic If Statement
```python
if 10 > 5:
    print("10 is greater than 5")
```
###### Use `if` to execute code conditionally.

### If-Else Statement
```python
if age >= 18:
    print("Adult")
else:
    print("Minor")
```
###### Use `else` to handle the opposite condition.

### If-Elif-Else Statement
```python
if score >= 90:
    print("A")
elif score >= 80:
    print("B")
else:
    print("C")
```
###### Use `elif` for multiple conditions.

---

## For Loops
### Basic For Loop
```python
for i in range(5):
    print(i)
```
###### `range(5)` generates numbers from 0 to 4.

### Looping Through a List
```python
for fruit in fruits:
    print(fruit)
```
###### Loop through each item in a list.

### Looping with Index
```python
for index, fruit in enumerate(fruits):
    print(index, fruit)
```
###### `enumerate()` provides both index and value.

---


# Pandas Notes
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
df_november = pd.read_csv("nba_data/November_2024.csv")
```
###### Reads the CSV file `November_2024.csv` into a DataFrame called df_november`.
```python
df_november['Notes'].fillna("No notes", inplace=True)
```
###### Fills any missing values (NaN) in the `Notes` column of `df_november` with the text "No notes" and modifies the DataFrame in place.
```python
df_october = pd.read_csv("nba_data/October_2024.csv")
```
###### Reads the CSV file `October_2024.csv` into a DataFrame called `df_october`.
```python
df_october['Notes'].fillna("No notes", inplace=True)
```
###### Fills any missing values (NaN) in the `Notes` column of `df_october` with the text "No notes" and modifies the DataFrame in place.
```python
df_combined = pd.concat([df_november, df_october], ignore_index=True)
```
###### Concatenates the two DataFrames `df_november` and `df_october` into a single DataFrame called `df_combined`.
###### The `ignore_index=True` ensures that the index is reset and doesn't keep the index from the original DataFrames.

```python 
df_combined['Date'] = pd.to_datetime(df_combined['Date'], format='%a %b %d %Y')
```
###### Converts the `Date` column in `df_combined` from a string format (e.g., "Tue Oct 22 2024") to pandas `datetime` objects,
###### using the specified format (`%a %b %d %Y`).
```python
df_combined = df_combined.sort_values(by='Date', ascending=True)
```
###### Sorts the rows of `df_combined` by the `Date` column in ascending order (from the oldest date to the latest date).
```python
df_combined.reset_index(drop=True, inplace=True)
```
###### Resets the index of `df_combined` after sorting. The `drop=True` ensures the old index is not added as a new column.
###### The `inplace=True` modifies the DataFrame directly.
```python
df_combined.to_csv('concat_nov_oct.csv', index=False)
```
###### Saves the `df_combined` DataFrame (which contains data from both November and October 2024) into a new CSV file named `concat_nov_oct.csv`, without including the index column.

## FOR 3/26/25:
### Do these all in 1 python file with 4 separate dataframes
#### Which visitor team scored the most points?
#### Which home team scored the most points? 
#### Which stadium had the highest attendance?
#### How many games were played at Crypto.com arena? 
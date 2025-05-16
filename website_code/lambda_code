import boto3
import pandas as pd
from io import StringIO
import json
import logging
from datetime import datetime

# Configure logging
logger = logging.getLogger()
logger.setLevel(logging.INFO)

# Constants
VALID_QUESTIONS = {'full', 'q1', 'q2'}
S3_BUCKET = "nba-csv-bat"
MAX_CSV_SIZE = 50 * 1024 * 1024  # 50MB limit for CSV processing

def lambda_handler(event, context):
    """AWS Lambda handler for processing NBA statistics requests."""
    try:
        logger.info("Lambda function started")
        logger.debug(f"Event received: {json.dumps(event)}")

        # Extract and validate parameters
        params = event.get('queryStringParameters', {})
        question, months = _validate_parameters(params)
        
        # Process requested months
        month_year_tuples = _parse_months(months)
        if not month_year_tuples:
            return _response(400, {"error": "No valid months provided (use format MM-YYYY)"})

        # Get matching CSV files from S3
        csv_files = _get_matching_csv_files(month_year_tuples)
        if not csv_files:
            return _response(404, {"error": "No data found for specified months"})

        # Load and process data
        df_all = _load_and_combine_data(csv_files)
        logger.info(f"Combined DataFrame shape: {df_all.shape}")

        # Handle question types
        if question == 'full':
            return _handle_full_request(df_all)
        elif question == 'q1':
            return _handle_visitor_request(df_all)
        elif question == 'q2':
            return _handle_home_request(df_all)

    except Exception as e:
        logger.error(f"Error in Lambda function: {str(e)}", exc_info=True)
        return _response(500, {"error": "Internal server error"})

def _validate_parameters(params):
    """Validate and extract query parameters."""
    question = params.get('question', '').strip().lower()
    months = params.get('months')
    
    if not months:
        raise ValueError("Please specify months (e.g., months=10-2024&months=11-2024)")
    
    if question and question not in VALID_QUESTIONS:
        raise ValueError(f"Question not recognized. Valid options are: {', '.join(VALID_QUESTIONS)}")
    
    return question, months

def _parse_months(months_input):
    """Parse month-year strings into (month, year) tuples."""
    if isinstance(months_input, str):
        requested_months = [m.strip() for m in months_input.split(',')]
    elif isinstance(months_input, list):
        requested_months = [m.strip() for m in months_input]
    else:
        requested_months = []

    month_year_tuples = []
    current_year = datetime.now().year
    
    for month_str in requested_months:
        try:
            month, year = map(int, month_str.split('-'))
            if not (1 <= month <= 12):
                raise ValueError(f"Invalid month: {month}")
            if not (2020 <= year <= current_year + 1):  # Reasonable year range
                raise ValueError(f"Invalid year: {year}")
            month_year_tuples.append((month, year))
        except (ValueError, AttributeError) as e:
            logger.warning(f"Invalid month format '{month_str}': {str(e)}")
            continue
            
    return month_year_tuples

def _get_matching_csv_files(month_year_tuples):
    """Get list of S3 CSV files matching the requested months."""
    s3 = boto3.client("s3")
    response = s3.list_objects_v2(Bucket=S3_BUCKET)
    csv_files = []
    
    for obj in response.get("Contents", []):
        if not obj["Key"].endswith(".csv"):
            continue
            
        try:
            # Expected filename format: nba_YYYY_MM.csv
            parts = obj["Key"].split('_')
            if len(parts) != 3:
                continue
                
            year = int(parts[1])
            month = int(parts[2].split('.')[0])
            
            if (month, year) in month_year_tuples:
                # Check file size before adding to processing list
                if obj["Size"] <= MAX_CSV_SIZE:
                    csv_files.append(obj["Key"])
                else:
                    logger.warning(f"File {obj['Key']} exceeds size limit ({obj['Size']} bytes)")
                    
        except (IndexError, ValueError) as e:
            logger.warning(f"Could not parse month/year from filename {obj['Key']}: {str(e)}")
            continue
            
    return csv_files

def _load_and_combine_data(csv_files):
    """Load and combine data from multiple CSV files."""
    s3 = boto3.client("s3")
    dfs = []
    
    for file_key in csv_files:
        try:
            logger.info(f"Loading file: {file_key}")
            obj = s3.get_object(Bucket=S3_BUCKET, Key=file_key)
            
            # Use chunks for large files
            if obj['ContentLength'] > 10 * 1024 * 1024:  # 10MB
                df = pd.concat(
                    pd.read_csv(StringIO(chunk.decode('utf-8')))
                    for chunk in obj['Body'].iter_chunks(chunk_size=5 * 1024 * 1024)
                )
            else:
                df = pd.read_csv(StringIO(obj["Body"].read().decode("utf-8")))
                
            dfs.append(df)
            
        except Exception as e:
            logger.error(f"Error loading file {file_key}: {str(e)}")
            continue
            
    if not dfs:
        raise ValueError("No valid data loaded from CSV files")
        
    return pd.concat(dfs, ignore_index=True)

def _handle_full_request(df):
    """Handle request for full dataset."""
    csv_buffer = StringIO()
    df.to_csv(csv_buffer, index=False)
    
    return {
        "statusCode": 200,
        "headers": {
            "Content-Type": "text/csv",
            "Access-Control-Allow-Origin": "*"
        },
        "body": csv_buffer.getvalue()
    }

def _handle_visitor_request(df):
    """Handle request for max visitor points."""
    max_val = df['PTS_Visitor'].max()
    filtered_df = df[df['PTS_Visitor'] == max_val]
    
    if filtered_df.empty:
        raise ValueError("No matching rows for max visitor points")
    
    return _response(200, {
        "answer": {
            "team": filtered_df['Visitor/Neutral'].iloc[0],
            "max_value": float(max_val)
        },
        "filtered_rows": filtered_df.head(100).to_dict(orient='records')  # Limit to 100 rows
    })

def _handle_home_request(df):
    """Handle request for max home points."""
    max_val = df['PTS_Home'].max()
    filtered_df = df[df['PTS_Home'] == max_val]
    
    if filtered_df.empty:
        raise ValueError("No matching rows for max home points")
    
    return _response(200, {
        "answer": {
            "team": filtered_df['Home/Neutral'].iloc[0],
            "max_value": float(max_val)
        },
        "filtered_rows": filtered_df.head(100).to_dict(orient='records')  # Limit to 100 rows
    })

def _response(status_code, body_dict):
    """Generate standardized API response."""
    return {
        "statusCode": status_code,
        "headers": {
            "Content-Type": "application/json",
            "Access-Control-Allow-Origin": "*"
        },
        "body": json.dumps(body_dict, default=str)  # Handle datetime serialization
    }

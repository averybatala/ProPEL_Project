# NBA Game Statistics Explorer - Project Overview

## Project Description
The NBA Game Statistics Explorer is an interactive dashboard that provides insights into team performance during the 2024-2025 NBA season. It allows users to analyze game data across different months, identifying top-performing teams both as visitors and on their home courts.

## Key Features
- **Interactive Month Selection**: Users can select specific months (October 2024 through April 2025) to analyze
- **Five Analytical Queries**:
  1. Load full game data for selected months
  2. Identify highest-scoring visitor team overall
  3. Compare top visitor teams by month
  4. Find highest-scoring home team overall
  5. Track home team dominance month-by-month
- **Visual Presentation**: Clean interface with highlighted results and filtered data tables
- **Responsive Design**: Works seamlessly across desktop and mobile devices

## AWS Architecture Design

### Core Components
1. **Frontend**:
   - WordPress-hosted interface with custom JavaScript
   - Responsive design with NBA-themed styling

2. **API Layer**:
   - **API Gateway**: REST API endpoint with CORS support
   - **Endpoint**: `https://dnevampawe.execute-api.us-east-1.amazonaws.com/dev`
   - **Methods**: GET with query parameters (`question` and `months`)

3. **Backend Processing**:
   - **AWS Lambda**: Python 3.x function for data processing
   - **Runtime**: 3-5 seconds typical execution
   - **Memory**: Configured for CSV processing (up to 50MB files)

4. **Data Storage**:
   - **S3 Bucket**: `nba-csv-bucket` containing monthly game data
   - **File Format**: CSV with standardized naming convention (`nba_YYYY_MM.csv`)

### Key Design Decisions

1. **Serverless Architecture**:
   - Chose Lambda + API Gateway for cost efficiency and automatic scaling
   - Eliminates need for managing servers
   - Pay-per-use model ideal for intermittent traffic patterns

2. **Data Processing Approach**:
   - Implemented chunked CSV reading for large files (>10MB)
   - Pandas library for efficient data manipulation
   - 100-row limit on filtered results to prevent oversized responses

3. **Error Handling**:
   - Comprehensive input validation
   - Graceful degradation for partial data availability
   - Detailed CloudWatch logging for troubleshooting

4. **Security**:
   - IAM roles with least-privilege access
   - S3 bucket policies restricting access to Lambda function
   - API Gateway request validation

5. **Performance Optimization**:
   - Monthly data segmentation for faster queries
   - Client-side caching of previously loaded months
   - Parallel processing of independent month requests

## Technical Specifications

### API Gateway Configuration
- **Integration Type**: Lambda Proxy
- **CORS Support**: Enabled for all origins
- **Query Parameters**:
  - `question` (required): `full`, `q1`, or `q2`
  - `months` (optional): Comma-separated MM-YYYY values
- **Request Mapping**: Custom template for query string parameters

### Lambda Function Details
- **Runtime**: Python 3.9
- **Memory**: 1024MB (adjustable based on CSV sizes)
- **Timeout**: 30 seconds
- **Dependencies**:
  - boto3 (AWS SDK)
  - pandas (data processing)
  - Standard Python libraries

### Data Schema
CSV files contain game records with these key columns:
- `Date`: Game date
- `Visitor/Neutral`: Visiting team name
- `PTS_Visitor`: Points scored by visitor
- `Home/Neutral`: Home team name
- `PTS_Home`: Points scored by home team
- `Attend.`: Attendance figures

## Business Value Proposition

### Benefits
1. **Actionable Insights**: Quickly surfaces performance trends that would require manual data analysis
2. **Time Savings**: Reduces hours of spreadsheet work to seconds
3. **Accessibility**: Makes advanced analytics available to non-technical users
4. **Cost Effective**: Serverless architecture minimizes operational costs
5. **Scalable**: Handles increased usage without infrastructure changes

### Use Cases
- **Coaching Staff**: Identify opponents' strengths/weaknesses by venue
- **Fantasy Players**: Discover consistent high-scoring teams for roster decisions
- **Sports Analysts**: Track seasonal performance trends
- **Team Management**: Evaluate home court advantage metrics
- **Media**: Quickly access talking points for broadcasts/articles

## Performance Metrics
- **Response Times**:
  - Simple queries (single month): <1.5s
  - Complex queries (multiple months): 3-5s
  - Full data loads: 2-4s depending on data volume
- **Scalability**:
  - Concurrent users: Limited only by Lambda concurrency (1000+ by default)
  - Data volume: Handles full season data (~1,230 games)

## Maintenance Considerations
1. **Data Updates**:
   - Monthly CSV uploads to S3 required
   - No code changes needed for new data
2. **Monitoring**:
   - CloudWatch alarms for Lambda errors
   - API Gateway access logging
3. **Cost Management**:
   - Lambda pricing based on invocation count and duration
   - S3 costs minimal for this data volume
4. **Scaling**:
   - Automatic with AWS services
   - May need Lambda concurrency limit increases for heavy usage

## Potential Enhancements
1. **Additional Analytics**:
   - Point differentials
   - Winning streaks
   - Performance by day of week
2. **Visualizations**:
   - Charts/graphs of trends
   - Team comparison tools
3. **Advanced Features**:
   - User accounts for saving queries
   - Email/SMS alerts for specific team performances
4. **Architecture Improvements**:
   - DynamoDB cache for frequent queries
   - Step Functions for complex multi-step analyses

## Implementation Notes
- WordPress integration requires "code snippets" plugin
- API Gateway needs CORS configuration and proper parameter mapping
- S3 bucket requires standardized naming convention for monthly files

## Sample Queries
1. Highest visitor in November 2024:
   `` `GET /dev?question=q1&months=11-2024` ``
2. Monthly home leaders for Oct-Dec 2024:
   `` `GET /dev?question=q2&months=10-2024,11-2024,12-2024` ``
3. Full December 2024 data:
   `` `GET /dev?question=full&months=12-2024` ``
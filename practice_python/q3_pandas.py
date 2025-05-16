{
    "Version": "2012-10-17",
    "Statement": [
        {
            "Effect": "Allow",
            "Action": [
                "s3:GetObject",
                "s3:ListBucket"
            ],
            "Resource": [
                "arn:aws:s3:::nba-csv-bat",
                "arn:aws:s3:::nba-csv-bat/*"
            ]
        }
    ]
}


mkdir -p python/lib/python3.8/site-packages
cd python/lib/python3.8/site-packages
pip install pandas -t .
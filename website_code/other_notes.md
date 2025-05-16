Make sure to use this mapping template in API Gateway:
{
  "queryStringParameters": {
    #foreach($param in $input.params().querystring.keySet())
    "$param": "$util.escapeJavaScript($input.params().querystring.get($param))"#if($foreach.hasNext),#end
    #end
  }
}

And setup months and question as URL string params in API Gateway Settings

Make sure to install the code snippets extension in wordpress
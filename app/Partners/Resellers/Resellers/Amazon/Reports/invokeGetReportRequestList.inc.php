<?php
try {
	$response = $service->getReportRequestList($request);

	//echo ("Service Response\n");
	//echo ("=============================================================================\n");

	//echo("        GetReportRequestListResponse\n");
	if ($response->isSetGetReportRequestListResult()) {
		//echo("            GetReportRequestListResult\n");
		$getReportRequestListResult = $response->getGetReportRequestListResult();
		if ($getReportRequestListResult->isSetNextToken())
		{
			//echo("                NextToken\n");
			//echo("                    " . $getReportRequestListResult->getNextToken() . "\n");
		}
		if ($getReportRequestListResult->isSetHasNext())
		{
			//echo("                HasNext\n");
			//echo("                    " . $getReportRequestListResult->getHasNext() . "\n");
		}
		$reportRequestInfoList = $getReportRequestListResult->getReportRequestInfoList();
		foreach ($reportRequestInfoList as $reportRequestInfo) {
			//echo("                ReportRequestInfo\n");
			if ($reportRequestInfo->isSetReportRequestId())
			{
				//echo("                    ReportRequestId\n");
				//echo("                        " . $reportRequestInfo->getReportRequestId() . "\n");
			}
			if ($reportRequestInfo->isSetReportType())
			{
				//echo("                    ReportType\n");
				//echo("                        " . $reportRequestInfo->getReportType() . "\n");
			}
			if ($reportRequestInfo->isSetStartDate())
			{
				//echo("                    StartDate\n");
				//echo("                        " . $reportRequestInfo->getStartDate()->format(DATE_FORMAT) . "\n");
			}
			if ($reportRequestInfo->isSetEndDate())
			{
				//echo("                    EndDate\n");
				//echo("                        " . $reportRequestInfo->getEndDate()->format(DATE_FORMAT) . "\n");
			}
			if ($reportRequestInfo->isSetSubmittedDate())
			{
				//echo("                    SubmittedDate\n");
				//echo("                        " . $reportRequestInfo->getSubmittedDate()->format(DATE_FORMAT) . "\n");
			}
			if ($reportRequestInfo->isSetReportProcessingStatus())
			{
				//echo("                    ReportProcessingStatus\n");
				////echo("                        " . $reportRequestInfo->getReportProcessingStatus() . "\n");
				$reportProcessingStatus = $reportRequestInfo->getReportProcessingStatus();
			}
		}
	}
	if ($response->isSetResponseMetadata()) {
		//echo("            ResponseMetadata\n");
		$responseMetadata = $response->getResponseMetadata();
		if ($responseMetadata->isSetRequestId())
		{
			//echo("                RequestId\n");
			//echo("                    " . $responseMetadata->getRequestId() . "\n");
		}
	}

	//echo("            ResponseHeaderMetadata: " . $response->getResponseHeaderMetadata() . "\n");
} catch (MarketplaceWebService_Exception $ex) {
	echo("Caught Exception: " . $ex->getMessage() . "\n");
	$statusCode = $ex->getStatusCode() ;
	if ($statusCode == 503 ) {
		task::push('AmazonMWS_Reports2014_Reports', 'GetReportRequestList',array($reportType),$date->format('Y-m-d H:i:s'  , time()+120 ),2);
		//task::push('AmazonMWS_Reports2014_Reports', 'GetReportList', array($reportType), date('Y-m-d H:i:s' , time()+120 ), 2);
	}
	echo("Response Status Code: " . $statusCode . "\n");
	echo("Error Code: " . $ex->getErrorCode() . "\n");
	//echo("Caught Exception: " . $ex->getMessage() . "\n");
	//echo("Response Status Code: " . $ex->getStatusCode() . "\n");
	//echo("Error Code: " . $ex->getErrorCode() . "\n");
	//echo("Error Type: " . $ex->getErrorType() . "\n");
	//echo("Request ID: " . $ex->getRequestId() . "\n");
	//echo("XML: " . $ex->getXML() . "\n");
	//echo("ResponseHeaderMetadata: " . $ex->getResponseHeaderMetadata() . "\n");
}
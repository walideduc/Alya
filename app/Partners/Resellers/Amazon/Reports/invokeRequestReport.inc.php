<?php
try {
	$response = $service->requestReport($request);
	//echo ("Service Response\n");
	//echo ("=============================================================================\n");

	//echo("        RequestReportResponse\n");
	if ($response->isSetRequestReportResult()) {
		//echo("            RequestReportResult\n");
		$requestReportResult = $response->getRequestReportResult();

		if ($requestReportResult->isSetReportRequestInfo()) {

			$reportRequestInfo = $requestReportResult->getReportRequestInfo();
			//echo("                ReportRequestInfo\n");
			if ($reportRequestInfo->isSetReportRequestId())
			{
				//echo("                    ReportRequestId\n");
				//echo("                        " . $reportRequestInfo->getReportRequestId() . "\n");
				$reportRequestId = $reportRequestInfo->getReportRequestId();
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
				//echo("                        " . $reportRequestInfo->getReportProcessingStatus() . "\n");
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
	echo("Response Status Code: " . $ex->getStatusCode() . "\n");
/*	echo("Error Code: " . $ex->getErrorCode() . "\n");
	echo("Error Type: " . $ex->getErrorType() . "\n");
	echo("Request ID: " . $ex->getRequestId() . "\n");
	echo("XML: " . $ex->getXML() . "\n");
	echo("ResponseHeaderMetadata: " . $ex->getResponseHeaderMetadata() . "\n");*/
}

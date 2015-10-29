<?php
try {
	$response = $service->getReportList($request);

//	echo ("Service Response\n");
//	echo ("=============================================================================\n");

	//echo("        GetReportListResponse\n");
	if ($response->isSetGetReportListResult()) {
		//echo("            GetReportListResult\n");
		$getReportListResult = $response->getGetReportListResult();
		if ($getReportListResult->isSetNextToken())
		{
			//echo("                NextToken\n");
			//echo("                    " . $getReportListResult->getNextToken() . "\n");
		}
		if ($getReportListResult->isSetHasNext())
		{
			//echo("                HasNext\n");
			//echo("                    " . $getReportListResult->getHasNext() . "\n");
		}
		$reportInfoList = $getReportListResult->getReportInfoList();
		foreach ($reportInfoList as $reportInfo) {
			$reportInfo_object = new stdClass();
			echo("                ReportInfo\n");
			if ($reportInfo->isSetReportId())
			{
				//echo("                    ReportId\n");
				//echo("                        " . $reportInfo->getReportId() . "\n");
				//$reportIdArray[$i]['reportId'] = $reportInfo->getReportId();
				$reportInfo_object->reportId = $reportInfo->getReportId();
			}
			if ($reportInfo->isSetReportType())
			{
				echo("                    ReportType\n");
				echo("                        " . $reportInfo->getReportType() . "\n");
				//$reportIdArray[$i]['reportType'] = $reportInfo->getReportType();
				$reportInfo_object->reportType = $reportInfo->getReportType();
			}
			if ($reportInfo->isSetReportRequestId())
			{
				echo("                    ReportRequestId\n");
				echo("                        " . $reportInfo->getReportRequestId() . "\n");
				//$reportIdArray[$i]['reportRequestId'] = $reportInfo->getReportRequestId();
				$reportInfo_object->reportRequestId = $reportInfo->getReportRequestId();
			}
			if ($reportInfo->isSetAvailableDate())
			{
				echo("                    AvailableDate\n");
				echo("                        " . $reportInfo->getAvailableDate()->format(DATE_FORMAT) . "\n");
				//$reportIdArray[$i]['availableDate'] = $reportInfo->getAvailableDate()->format(DATE_FORMAT);
				$reportInfo_object->availableDate = $reportInfo->getAvailableDate()->format('Y-m-d H:i:s');
			}
			if ($reportInfo->isSetAcknowledged())
			{
				echo("                    Acknowledged\n");
				echo("                        " . $reportInfo->getAcknowledged() . "\n");
				//$reportIdArray[$i]['acknowledged'] = $reportInfo->getAcknowledged() ;
				$reportInfo_object->acknowledged = $reportInfo->getAcknowledged() ;
			}
			if ($reportInfo->isSetAcknowledgedDate())
			{
				echo("                    AcknowledgedDate\n");
				echo("                        " . $reportInfo->getAcknowledgedDate()->format(DATE_FORMAT) . "\n");
				//$reportIdArray[$i]['acknowledgedDate'] = $reportInfo->getAcknowledgedDate()->format(DATE_FORMAT) ;// MonAMGMT+0000E_December+0000RDecAMGMT+0000
				$reportInfo_object->acknowledgedDate =  $reportInfo->getAcknowledgedDate()->format('Y-m-d H:i:s') ;//  2013-12-30 10:36:24
			}
			$reportIdArray[] = $reportInfo_object;
		}
	}
	if ($response->isSetResponseMetadata()) {
		echo("            ResponseMetadata\n");
		$responseMetadata = $response->getResponseMetadata();
		if ($responseMetadata->isSetRequestId())
		{
			echo("                RequestId\n");
			echo("                    " . $responseMetadata->getRequestId() . "\n");
		}
	}

	echo("            ResponseHeaderMetadata: " . $response->getResponseHeaderMetadata() . "\n");
} catch (MarketplaceWebService_Exception $ex) {
	echo("Caught Exception: " . $ex->getMessage() . "\n");
	echo("Response Status Code: " . $ex->getStatusCode() . "\n");
	echo("Error Code: " . $ex->getErrorCode() . "\n");
	echo("Error Type: " . $ex->getErrorType() . "\n");
	echo("Request ID: " . $ex->getRequestId() . "\n");
	echo("XML: " . $ex->getXML() . "\n");
	echo("ResponseHeaderMetadata: " . $ex->getResponseHeaderMetadata() . "\n");
}
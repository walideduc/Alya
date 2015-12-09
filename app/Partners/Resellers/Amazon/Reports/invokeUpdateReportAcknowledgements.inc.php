<?php
try {
	$response = $service->updateReportAcknowledgements($request);

	echo ("Service Response\n");
	echo ("=============================================================================\n");

	echo("        UpdateReportAcknowledgementsResponse\n");
	if ($response->isSetUpdateReportAcknowledgementsResult()) {
		echo("            UpdateReportAcknowledgementsResult\n");
		$updateReportAcknowledgementsResult = $response->getUpdateReportAcknowledgementsResult();
		if ($updateReportAcknowledgementsResult->isSetCount())
		{
			echo("                Count\n");
			echo("                    " . $updateReportAcknowledgementsResult->getCount() . "\n");
			$count = $updateReportAcknowledgementsResult->getCount();
		}
		//$reportInfoList = $updateReportAcknowledgementsResult->getReportInfo();
		$reportInfoList = $updateReportAcknowledgementsResult->getReportInfoList();
		foreach ($reportInfoList as $reportInfo) {
			echo("                ReportInfo\n");
			if ($reportInfo->isSetReportId())
			{
				echo("                    ReportId\n");
				echo("                        " . $reportInfo->getReportId() . "\n");
			}
			if ($reportInfo->isSetReportType())
			{
				echo("                    ReportType\n");
				echo("                        " . $reportInfo->getReportType() . "\n");
			}
			if ($reportInfo->isSetReportRequestId())
			{
				echo("                    ReportRequestId\n");
				echo("                        " . $reportInfo->getReportRequestId() . "\n");
			}
			if ($reportInfo->isSetAvailableDate())
			{
				echo("                    AvailableDate\n");
				echo("                        " . $reportInfo->getAvailableDate()->format(DATE_FORMAT) . "\n");
			}
			if ($reportInfo->isSetAcknowledged())
			{
				echo("                    Acknowledged\n");
				echo("                        " . $reportInfo->getAcknowledged() . "\n");
			}
			if ($reportInfo->isSetAcknowledgedDate())
			{
				echo("                    AcknowledgedDate\n");
				echo("                        " . $reportInfo->getAcknowledgedDate()->format(DATE_FORMAT) . "\n");
			}
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

/*	echo("Response Status Code: " . $ex->getStatusCode() . "\n");
	echo("Error Code: " . $ex->getErrorCode() . "\n");
	echo("Error Type: " . $ex->getErrorType() . "\n");
	echo("Request ID: " . $ex->getRequestId() . "\n");
	echo("XML: " . $ex->getXML() . "\n");
	echo("ResponseHeaderMetadata: " . $ex->getResponseHeaderMetadata() . "\n");
	$date = new DateTime();*/

    $job = ( new \Alyya\Jobs\Resellers\Amazon\Reports\UpdateReportAcknowledgements($reportType,true) )->onQueue(self::$queuesCategory)->delay(900);
    $this->dispatch($job);
    dd("Caught Exception: " . $ex->getMessage() . "\n");
	//task::push(__CLASS__, 'UpdateReportAcknowledgements',array($reportType,true),$date->format('Y-m-d H:i:s'),2);
}
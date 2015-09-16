<?php
try {
	$response = $service->submitFeed($request);
	if ($response->isSetSubmitFeedResult()) {
		$submitFeedResult = $response->getSubmitFeedResult();
		if ($submitFeedResult->isSetFeedSubmissionInfo()) {
			$feedSubmissionInfo = $submitFeedResult->getFeedSubmissionInfo();
			if ($feedSubmissionInfo->isSetFeedSubmissionId())
			{
				$submissionId = $feedSubmissionInfo->getFeedSubmissionId();
			}
			if ($feedSubmissionInfo->isSetFeedType())
			{
			}
			if ($feedSubmissionInfo->isSetSubmittedDate())
			{
			}
			if ($feedSubmissionInfo->isSetFeedProcessingStatus())
			{
			}
			if ($feedSubmissionInfo->isSetStartedProcessingDate())
			{
			}
			if ($feedSubmissionInfo->isSetCompletedProcessingDate())
			{
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
	$messageException = $ex->getMessage();
	echo("Response Status Code: " . $ex->getStatusCode() . "\n");
	$statusCodeException = $ex->getStatusCode();
	//echo("Error Code: " . $ex->getErrorCode() . "\n");
	$errorCodeException = $ex->getErrorCode();
	//echo("Error Type: " . $ex->getErrorType() . "\n");
	$errorTypeException = $ex->getErrorType();
	//echo("Request ID: " . $ex->getRequestId() . "\n");
	$requestIdException = $ex->getRequestId();
	//echo("XML: " . $ex->getXML() . "\n");
	$xmlException = $ex->getXML();
	//echo("ResponseHeaderMetadata: " . $ex->getResponseHeaderMetadata() . "\n");
	$responseHeaderMetadataException = $ex->getResponseHeaderMetadata();
    //dd($messageException);
}












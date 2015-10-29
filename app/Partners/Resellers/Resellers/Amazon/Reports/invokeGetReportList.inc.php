<?php
      try {
              $response = $service->getReportList($request);
              
                //echo ("Service Response\n");
                //echo ("=============================================================================\n");

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
                        //echo("                ReportInfo\n");
                        if ($reportInfo->isSetReportId()) 
                        {
                            //echo("                    ReportId\n");
                            //echo("                        " . $reportInfo->getReportId() . "\n");
                            $reportId = $reportInfo->getReportId();
                        }
                        if ($reportInfo->isSetReportType()) 
                        {
                            //echo("                    ReportType\n");
                            //echo("                        " . $reportInfo->getReportType() . "\n");
                        }
                        if ($reportInfo->isSetReportRequestId()) 
                        {
                            //echo("                    ReportRequestId\n");
                            //echo("                        " . $reportInfo->getReportRequestId() . "\n");
                        }
                        if ($reportInfo->isSetAvailableDate()) 
                        {
                            //echo("                    AvailableDate\n");
                            //echo("                        " . $reportInfo->getAvailableDate()->format(DATE_FORMAT) . "\n");
                        }
                        if ($reportInfo->isSetAcknowledged()) 
                        {
                            //echo("                    Acknowledged\n");
                            //echo("                        " . $reportInfo->getAcknowledged() . "\n");
                        }
                        if ($reportInfo->isSetAcknowledgedDate()) 
                        {
                            //echo("                    AcknowledgedDate\n");
                            //echo("                        " . $reportInfo->getAcknowledgedDate()->format(DATE_FORMAT) . "\n");
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
         	// I will see letter how to mange this with the laravel queues .
         	//task::push('AmazonMWS_Reports2014_Reports', 'GetReportList', array($reportType), date('Y-m-d H:i:s' , time()+120 ), 2);
         }
         echo("Response Status Code: " . $statusCode . "\n");
         echo("Error Code: " . $ex->getErrorCode() . "\n");
         //echo("Error Type: " . $ex->getErrorType() . "\n");
         //echo("Request ID: " . $ex->getRequestId() . "\n");
         //echo("XML: " . $ex->getXML() . "\n");
         //echo("ResponseHeaderMetadata: " . $ex->getResponseHeaderMetadata() . "\n");
     }
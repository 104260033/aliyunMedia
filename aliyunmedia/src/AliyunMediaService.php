<?php
	/**
	 * Created by PhpStorm.
	 * User: fff
	 * Date: 26/3/16
	 * Time: PM9:37
	 */

	namespace Fff\AliyunMedia;

	use Fff\AliyunMedia\aliyunOpenapiSdk\Core\Auth\Credential;
	use Fff\AliyunMedia\aliyunOpenapiSdk\Core\Profile\DefaultProfile;
	use Fff\AliyunMedia\aliyunOpenapiSdk\Core\DefaultAcsClient;
	use Fff\AliyunMedia\aliyunOpenapiSdk\Mts\Mts\Request\V20140618\SubmitSnapshotJobRequest;


	class AliyunMediaService
	{
		public function media($inputObject)
		{

			include_once __DIR__.'/aliyunOpenapiSdk/Core/Config.php';
			$bucket = env('ALIOSS_BUCKET_PUBLIC');
			$location = env('ALIOSS_LOCATION_PUBLIC');
			$outputObject = date('YmdHis') . uniqid() . '.jpg';
			$iClientProfile = DefaultProfile::getProfile("cn-shenzhen", "DVQZgRl6jBEUdZsH", "OVRDSgwc31XBj3TvugBYDpxOcb5g4X");
			$client = new DefaultAcsClient($iClientProfile);
			$iSigner = $client->iClientProfile->getSigner();
			$credential = new Credential(env('ALIOSS_AK'), env('ALIOSS_SK'));
			$SubmitSnapshotJobRequest = new SubmitSnapshotJobRequest();
			$input = json_encode(['Bucket' => $bucket, 'Location' => $location, 'Object' => $inputObject]);
			$snapshotconfig = json_encode([
				'OutputFile' => [
					'Bucket'   => $bucket,
					'Location' => $location,
					"Object"   => $outputObject,
				],
				'Time'       => 5,
			]);
			$request = $SubmitSnapshotJobRequest;

			$request->setRegionId('cn-shenzhen');
			$request->setAcceptFormat('json');
			$apiParams["SignatureNonce"] = uniqid();
			$request->setActionName('SubmitSnapshotJob');
			$request->setInput($input);
			$request->setSnapshotConfig($snapshotconfig);
			$request->setAcceptFormat('json');
			$domain = "mts.aliyuncs.com";
			$request->setPipelineId("37e104bda4e94579932988819e0169c7");
			$url = $request->composeUrl($iSigner, $credential, $domain);
			dd($url);
		}
	}
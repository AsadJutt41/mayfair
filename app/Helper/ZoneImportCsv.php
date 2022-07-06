<?php

namespace App\Helper;
use App\Models\{ Zone};

class ZoneImportCsv {

	protected $file;
	protected $zoneValidatedData = [
		'Zone',
	];
	protected $mapingArray = [
		'zone'
	];

	protected $errorArray =  [];
	protected $zoneInstertedRecord = [];
	protected $successRecordsTotal = 0;
    protected $numberArray = [];

	public function __construct($file)
	{
		$this->file = $file;
	}

	public function importCsv()
	{
		$file = $this->file;
		$csvFile = fopen($file->getPathName(), 'r');
		fgetcsv($csvFile);

		$lineNumber = 0;

		while (($line = fgetcsv($csvFile)) !== false) {
			$lineNumber++;
			$validateResponse = $this->validateZoneRequredData($line, $lineNumber);
		    if ($validateResponse === false) {
		    	continue;
		    }
             //Check for Zone
             $zonename = $line[0];
             $zoneCodeData = Zone::where('zone', $zonename)->select('zone')->first();
             if ($zoneCodeData) {
                array_push($this->errorArray, ['errorMessage' => $zonename . '  Zone  already exist (line no(line no: '. $lineNumber .')']);
                 continue;
             }

		    $ZoneRecordData = $this->getZoneRecordArray($line);

		    Zone::create($ZoneRecordData);
		    $this->successRecordsTotal++;

		}
        if ($this->successRecordsTotal > 0) {
			return true;
		}
		return false;

	}

    protected function validateZoneRequredData($array, $lineNumber = 1)
	{
		foreach ($this->zoneValidatedData as $index => $value) {
			if (empty($array[$index])) {
                $erorrMessageArray = [
					'errorMessage' => $value . ' are required field (line number: '.$lineNumber
				];
				array_push($this->errorArray, $erorrMessageArray);
            	return false;
			}
		}
		return true;
	}

    protected function getZoneRecordArray($data)
	{
		$zoneRecordDataArray = [];
		foreach($this->mapingArray as $index => $dbFiled) {
			$zoneRecordDataArray[$dbFiled] = $data[$index];
		}

		return $zoneRecordDataArray;
	}

	public function getErrors()
	{
		return $this->errorArray;
	}

	public function getSuccessCount()
	{
		return $this->successRecordsTotal;
	}


}

<?php

namespace App\Helper;
use App\Models\{ City};

class CityImportCsv {

	protected $file;
	protected $cityValidatedData = [
		'Name',
	];
	protected $mapingArray = [
		'name'
	];

	protected $errorArray =  [];
	protected $cityInstertedRecord = [];
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
			$validateResponse = $this->validateCityRequredData($line, $lineNumber);
		    if ($validateResponse === false) {
		    	continue;
		    }
             //Check for city
             $cityname = $line[0];
             $cityCodeData = City::where('name', $cityname)->select('name')->first();
             if ($cityCodeData) {
                array_push($this->errorArray, ['errorMessage' => $cityname . '  city name already exist (line no(line no: '. $lineNumber .')']);
                 continue;
             }

		    $CityRecordData = $this->getCityRecordArray($line);
		    City::create($CityRecordData);
		    $this->successRecordsTotal++;
		}
        if ($this->successRecordsTotal > 0) {
			return true;
		}
		return false;

	}

    protected function validateCityRequredData($array, $lineNumber = 1)
	{
		foreach ($this->cityValidatedData as $index => $value) {
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

    protected function getCityRecordArray($data)
	{
		$cityRecordDataArray = [];
		foreach($this->mapingArray as $index => $dbFiled) {
			$cityRecordDataArray[$dbFiled] = $data[$index];
		}
		return $cityRecordDataArray;
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

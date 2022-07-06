<?php

namespace App\Helper;
use App\Models\{ User , StaffRole , City, Designation, Zone};
use Illuminate\Support\Facades\Hash;

class StaffImportCsv {

	protected $file;
	protected $staffValidatedData = [
		'FirstName',
        'LastName',
        'Email',
        'Password',
        'PhoneNO',
        'Designation',
        'StaffRole',
        'OverLimit',
        'SapID',
        'JoiningDate',
        'BaseTown',
        'Zone',
        'Address',
        'ImageUrl',
        'LineManager'
	];
	protected $mapingArray = [
        'firstname',
        'lastname',
        'email',
        'password',
        'phone_number',
        'designation',
        'role',
        'over_limit_approver',
        'sap_id',
        'joining_date',
        'base_town',
        'zone',
        'address',
        'profile_photo_path',
        'line_manager'
	];

	protected $errorArray =  [];
	protected $staffInstertedRecord = [];
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
			$validateResponse = $this->validateStaffRequredData($line, $lineNumber);
		    if ($validateResponse === false) {
		    	continue;
		    }


            //Check for Staff
            $firstname = $line[0];
            $lastname = $line[1];

            $password = $line[3];
            $phoneno = $line[4];
            $sapid = $line[8];
            $overlimit = $line[7];
            $address = $line[12];
            $image = $line[13];
            $joinindate = $line[9];


            $designation = $line[5];
            $staffrole = $line[6];
            $basetown = $line[10];
            $zone = $line[11];

            $line[3] = Hash::make($line[3]);


            //check for email
            $email = $line[2];
            $staffCodeData = User::where('email', $email)->select('email')->first();
            if ($staffCodeData) {
            array_push($this->errorArray, ['errorMessage' => $email . '  Staff  already exist (line no(line no: '. $lineNumber .')']);
                continue;
            }

            //check for line manager
            // $manager = $line[14];
            // $linemanager = User::where('line_manager', $manager)->select('line_manager')->first();
            // if (!$linemanager) {
            // array_push($this->errorArray, ['errorMessage' => $manager . '  Line manager  didnot  exist (line no(line no: '. $lineNumber .')']);
            //     continue;
            // }
            // $line[14] = $linemanager->line_manager;


            //check for zone
            $zonename = trim($line[11]);

            $zonesdata = Zone::where('zone', $zonename)->select('id')->first();

            if (!$zonesdata) {
            array_push($this->errorArray, ['errorMessage' => $line[11] . ' Zone didnot exist (line no(line no: '. $lineNumber .')']);
                continue;
            }
            $line[11] = $zonesdata->id;

            //check for basetown
            $cityname = trim($line[10]);

            $basetowndata = City::where('name', $cityname)->select('id')->first();
            if (!$basetowndata) {
            array_push($this->errorArray, ['errorMessage' => $cityname . ' City didnot exist exist (line no(line no: '. $lineNumber .')']);
                continue;
            }
            $line[10] = $basetowndata->id;

            //check for designation
            $designationname = trim($line[5]);
            $designationdata = Designation::where('name', $designationname)->select('id')->first();
            if (!$designationdata) {
            array_push($this->errorArray, ['errorMessage' => $designationname . '  Designation didnot exist (line no(line no: '. $lineNumber .')']);
                continue;
            }
            $line[5] = $designationdata->id;

            // check for staff role
            $staffrolename = trim($line[6]);
            $staffroledata = StaffRole::where('role', $staffrolename)->select('id')->first();
            if (!$staffroledata) {
            array_push($this->errorArray, ['errorMessage' => $staffrolename . '  Staffrole didnot exist (line no(line no: '. $lineNumber .')']);
                continue;
            }
            $line[6] = $staffroledata->id;





		    $StaffRecordData = $this->getStaffRecordArray($line);

            $StaffRecordData['user_type'] = 2;

		    User::create($StaffRecordData);
		    $this->successRecordsTotal++;
		}
        if ($this->successRecordsTotal > 0) {
			return true;
		}
		return false;

	}

    protected function validateStaffRequredData($array, $lineNumber = 1)
	{
		foreach ($this->staffValidatedData as $index => $value) {

			if (empty($array[$index])  ) {
                $erorrMessageArray = [
					'errorMessage' => $value . ' are required field (line number: '.$lineNumber
				];
				array_push($this->errorArray, $erorrMessageArray);
            	return false;
			}
		}
		return true;
	}

    protected function getStaffRecordArray($data)
	{
		$StaffRecordDataArray = [];
		foreach($this->mapingArray as $index => $dbFiled) {
			$StaffRecordDataArray[$dbFiled] = $data[$index];
		}
		return $StaffRecordDataArray;
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

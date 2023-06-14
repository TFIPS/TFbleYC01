<?php
class TFbleYC01 extends IPSModule
{
    
    public function Create()
	{
        parent::Create();
        $this->ConnectParent("{C6D2AEB3-6E1F-4B2E-8E69-3A1A00246850}");

		if (!IPS_VariableProfileExists('TFYC.ph')) 
		{
            IPS_CreateVariableProfile('TFYC.ph', 2);
			IPS_SetVariableProfileIcon ('TFYC.ph', 'Gauge');
			IPS_SetVariableProfileDigits('TFYC.ph', 1); 
			IPS_SetVariableProfileValues('TFYC.ph', 0, 14, 1);
			IPS_SetVariableProfileAssociation('TFYC.ph', 0, 'sauer %.2f', 'Warning', 0xFF0000);
			IPS_SetVariableProfileAssociation('TFYC.ph', 6.8, '%.2f', '', 0x00FF00);
			IPS_SetVariableProfileAssociation('TFYC.ph', 7.4, 'alkalisch %.2f', 'Warning', 0x0000FF);
		}

		if (!IPS_VariableProfileExists('TFYC.cl')) 
		{
            IPS_CreateVariableProfile('TFYC.cl', 2);
			IPS_SetVariableProfileIcon ('TFYC.cl', 'Speedo');
			IPS_SetVariableProfileText('TFYC.cl', '', ' mg/L');
			IPS_SetVariableProfileDigits('TFYC.cl', 1); 
			IPS_SetVariableProfileValues('TFYC.cl', 0, 4, 1);
			IPS_SetVariableProfileAssociation('TFYC.cl', 0, 'niedrig %.2f', 'Warning', 0x0000FF);
			IPS_SetVariableProfileAssociation('TFYC.cl', 0.5, '%.2f', '', 0x00FF00);
			IPS_SetVariableProfileAssociation('TFYC.cl', 1.3, 'hoch %.2f', 'Warning', 0xFF0000);
		}

		if (!IPS_VariableProfileExists('TFYC.ec')) 
		{
            IPS_CreateVariableProfile('TFYC.ec', 1);
			IPS_SetVariableProfileIcon ('TFYC.ec', 'Electricity');
			IPS_SetVariableProfileText('TFYC.ec', '', ' µS/cm');
			IPS_SetVariableProfileValues('TFYC.ec', 0, 10000, 10);
			IPS_SetVariableProfileAssociation('TFYC.ec', 0, 'niedrig %d', 'Warning', 0x0000FF);
			IPS_SetVariableProfileAssociation('TFYC.ec', 5400, '%d', '', 0x00FF00);
			IPS_SetVariableProfileAssociation('TFYC.ec', 6810, 'hoch %d', 'Warning', 0xFF0000);
		}
		if (!IPS_VariableProfileExists('TFYC.tds')) 
		{
            IPS_CreateVariableProfile('TFYC.tds', 1);
			IPS_SetVariableProfileIcon ('TFYC.tds', 'Snow');
			IPS_SetVariableProfileText('TFYC.tds', '', ' ppm');
			IPS_SetVariableProfileDigits('TFYC.tds', 0); 
			IPS_SetVariableProfileValues('TFYC.tds', 0, 5000, 10);
			IPS_SetVariableProfileAssociation('TFYC.tds', 0, 'niedrig %d', 'Warning', 0x0000FF);
			IPS_SetVariableProfileAssociation('TFYC.tds', 250, '%d', '', 0x00FF00);
			IPS_SetVariableProfileAssociation('TFYC.tds', 2000, 'hoch %d', 'Warning', 0xFF0000);
		}
        if (!IPS_VariableProfileExists('TFYC.saltTds')) 
		{
            IPS_CreateVariableProfile('TFYC.saltTds', 1);
			IPS_SetVariableProfileIcon ('TFYC.saltTds', 'Snow');
			IPS_SetVariableProfileText('TFYC.saltTds', '', ' ppm'); 
			IPS_SetVariableProfileValues('TFYC.saltTds', 0, 10000, 10);
			IPS_SetVariableProfileAssociation('TFYC.saltTds', 0, 'niedrig %d', 'Warning', 0x0000FF);
			IPS_SetVariableProfileAssociation('TFYC.saltTds', 2500, '%d', '', 0x00FF00);
			IPS_SetVariableProfileAssociation('TFYC.saltTds', 3500, 'hoch %d', 'Warning', 0xFF0000);
		}

		if (!IPS_VariableProfileExists('TFYC.orp')) 
		{
            IPS_CreateVariableProfile('TFYC.orp', 1);
			IPS_SetVariableProfileIcon ('TFYC.orp', 'DoctorBag');
			IPS_SetVariableProfileText('TFYC.orp', '', ' mV');
			IPS_SetVariableProfileValues('TFYC.orp', 0, 5000, 10);
			IPS_SetVariableProfileAssociation('TFYC.orp', 0, 'niedrig %d', 'Warning', 0x0000FF);
			IPS_SetVariableProfileAssociation('TFYC.orp', 650, '%d', '', 0x00FF00);
			IPS_SetVariableProfileAssociation('TFYC.orp', 750, 'hoch %d', 'Warning', 0xFF0000);
		}

		if (!IPS_VariableProfileExists('TFbleGW.deviceState')) 
		{
            IPS_CreateVariableProfile('TFbleGW.deviceState', 1);
			IPS_SetVariableProfileIcon ('TFbleGW.deviceState', 'Network');
			IPS_SetVariableProfileAssociation('TFbleGW.deviceState', 0, 'Blockiert', 'Warning', 0xFF0000);
			IPS_SetVariableProfileAssociation('TFbleGW.deviceState', 1, 'Offline', 'Power', 0xFF8800);
			IPS_SetVariableProfileAssociation('TFbleGW.deviceState', 2, 'Verbunden', 'Plug', 0xFFFF00);
			IPS_SetVariableProfileAssociation('TFbleGW.deviceState', 3, 'Online', 'Eyes', 0xFFFF00);
			IPS_SetVariableProfileAssociation('TFbleGW.deviceState', 4, 'Bereit', 'Sleep', 0xFFFF00);
			IPS_SetVariableProfileAssociation('TFbleGW.deviceState', 5, 'Aktiv', 'Repeat', 0x00FF00);
		}
    }
    
    public function ApplyChanges()
	{
        parent::ApplyChanges();
		$ph_ID			= $this->RegisterVariableFloat("ph", "pH", "TFYC.ph", 1);
		$cl_ID			= $this->RegisterVariableFloat("cl", "Chlorgehalt", "TFYC.cl", 2);
		$ec_ID			= $this->RegisterVariableInteger("ec", "Leitwert (EC)", "TFYC.ec", 3);
		$tds_ID			= $this->RegisterVariableInteger("tds", "Feststoffe (TDS)", "TFYC.tds", 4);
		$saltTds_ID		= $this->RegisterVariableInteger("saltTds", "Salzgehalt", "TFYC.saltTds", 5);
		$orp_ID			= $this->RegisterVariableInteger("orp", "Redoxpotenzial", "TFYC.orp", 6);
		$temp_ID		= $this->RegisterVariableFloat("temp", "Temperatur", "~Temperature", 7);
		$batt_ID		= $this->RegisterVariableInteger("batt", "Batterie", "~Battery.100", 8);
		$backlight_ID	= $this->RegisterVariableBoolean("backlight", "Display-Beleuchtung", "~Switch", 9);
		$holdReading_ID	= $this->RegisterVariableBoolean("holdReading", "Lesen angehalten", "~Switch", 10);
		$getData_ID		= $this->RegisterVariableBoolean("getData", "Daten abrufen", "~Switch", 11);
		$lastData_ID	= $this->RegisterVariableInteger("lastData", "Letzter Abruf", "~UnixTimestamp", 12);

		$io1_ID			= $this->RegisterVariableInteger("io1", "IO1", "", 20);
		$io2_ID			= $this->RegisterVariableInteger("io2", "IO2", "", 21);
		$io3_ID			= $this->RegisterVariableInteger("io3", "IO3", "", 22);
		$io4_ID			= $this->RegisterVariableInteger("io4", "IO4", "", 23);
		$io5_ID			= $this->RegisterVariableInteger("io5", "IO5", "", 24);
		$io6_ID			= $this->RegisterVariableInteger("io6", "IO6", "", 25);		

		$deviceState_ID	= $this->RegisterVariableInteger("deviceState", "Status", "TFbleGW.deviceState", 95);
		$uptime_ID		= $this->RegisterVariableString("uptime", "Uptime", "", 96);
		$fVersion_ID	= $this->RegisterVariableString("fVersion", "Version", "", 97);
		$ipAdress_ID	= $this->RegisterVariableString("ipAddress", "IP-Adresse", "", 98);
		$wlanSignal_ID	= $this->RegisterVariableInteger("wlanSignal", "WLAN-Signal", "~Intensity.100", 99);
		// Icons
		IPS_SetIcon($holdReading_ID, "Sleep");
		IPS_SetIcon($lastData_ID, "Link");
		IPS_SetIcon($uptime_ID, "Hourglass");
		IPS_SetIcon($fVersion_ID, "Calendar");
		IPS_SetIcon($ipAdress_ID, "Network");

		IPS_SetIcon($io1_ID, "Move");
		IPS_SetIcon($io2_ID, "Move");
		IPS_SetIcon($io3_ID, "Move");
		IPS_SetIcon($io4_ID, "Move");
		IPS_SetIcon($io5_ID, "Move");
		IPS_SetIcon($io6_ID, "Move");

		// State default
		SetValueInteger($deviceState_ID, 1);
		// Actions
		$this->EnableAction("getData");
    }
	

	public function MessageSink($time, $sender, $message, $data) 
	{
		// IPS_LogMessage("MessageSink", "Message from SenderID ".$senderID." with Message ".$message."\r\n Data: ".print_r($data, true));
		$getData_ID = IPS_GetObjectIDByIdent("getData", $this->InstanceID);		
	}

	
	public function GetData()
	{
		$this->SendCMD("action", "getData");
	}

	public function RebootGw()
	{
		$this->SendCMD("action", "reboot");
	}
		
    public function ReceiveData($JSONString)
    {
		$data = json_decode($JSONString, true);
		if($data['DataID'] == '{7F7632D9-FA40-4F38-8DEA-C83CD4325A32}')
		{
			$deviceTopic	= "tfblegw";
			$topic			= explode('/', $data['Topic']);
			
			if($topic[0] == $deviceTopic)
			{
				$valueData = json_decode($data["Payload"], true);
				switch($topic[1])
				{
					// STATE
					case "state" 		:
						switch($valueData["deviceState"])
						{
							case 'ban' 			: $deviceState = 0; break;
							case 'offline' 		: $deviceState = 1; break;
							case 'connected'	: $deviceState = 2; break;
							case 'online'		: $deviceState = 3; break;
							case 'ready'		: $deviceState = 4; break;
							case 'active'		: $deviceState = 5; break;
						}
						$deviceState != $this->GetValue("deviceState") ? $this->SetValue("deviceState", $deviceState) : 1;

						$valueData["fVersion"] != $this->GetValue("fVersion") ? $this->SetValue("fVersion", $valueData["fVersion"]) : 1;
						$valueData["ipAddress"] != $this->GetValue("ipAddress") ? $this->SetValue("ipAddress", $valueData["ipAddress"]) : 1;
						$valueData["wlanSignal"] != $this->GetValue("wlanSignal") ? $this->SetValue("wlanSignal", $valueData["wlanSignal"]) : 1;
						$valueData["uptime"] != $this->GetValue("uptime") ? $this->SetValue("uptime", $valueData["uptime"]) : 1;
					break;
					// BLE-YC01 Data
					case "bleYc01Data" 		:
						$valueData["ec"] != $this->GetValue("ec") ? $this->SetValue("ec", $valueData["ec"]) : 1;
						$valueData["tds"] != $this->GetValue("tds") ? $this->SetValue("tds", $valueData["tds"]) : 1;
						$valueData["saltTds"] != $this->GetValue("saltTds") ? $this->SetValue("saltTds", $valueData["saltTds"]) : 1;
						$valueData["ph"] != $this->GetValue("ph") ? $this->SetValue("ph", $valueData["ph"]) : 1;
						$valueData["orp"] != $this->GetValue("orp") ? $this->SetValue("orp", $valueData["orp"]) : 1;
						$valueData["cl"] != $this->GetValue("cl") ? $this->SetValue("cl", $valueData["cl"]) : 1;
						$valueData["temp"] != $this->GetValue("temp") ? $this->SetValue("temp", $valueData["temp"]) : 1;
						$valueData["battery"] != $this->GetValue("batt") ? $this->SetValue("batt", $valueData["battery"]) : 1;
						$valueData["holdReading"] != $this->GetValue("holdReading") ? $this->SetValue("holdReading", $valueData["holdReading"]) : 1;
						$valueData["backlight"] != $this->GetValue("backlight") ? $this->SetValue("backlight", $valueData["backlight"]) : 1;
						$this->SetValue("lastData", time());
					break;
					case "ioData" 		:
						$valueData["id"] != $this->GetValue("io".$valueData["id"]) ? $this->SetValue("io".$valueData["id"], $valueData["value"]) : 1;
					break;
				}
			}
		}        
    }
	
	public function SendCMD(string $command, string $value)
	{
		$data['DataID'] 			= '{043EA491-0325-4ADD-8FC2-A30C8EEB4D3F}';
        $data['PacketType'] 		= 3;
        $data['QualityOfService'] 	= 0;
        $data['Retain'] 			= false;
		$data['Topic'] 				= "tfblegw/cmnd/".$command;
        $data['Payload'] 			= strval($value);
        $dataJSON 					= json_encode($data,JSON_UNESCAPED_SLASHES);
        $this->SendDataToParent($dataJSON);
	}
	
	public function RequestAction($ident, $value) 
	{
		switch($ident)
		{
			case "getData" :
				if($value)
				{
					$this->SendCMD("action", "getData");
					$this->SetValue("getData", 0);
				}
			break;
		}
	}
}

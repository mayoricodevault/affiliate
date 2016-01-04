<?php
/**
 * 'formatcurrency' Function to convert your floating int into a
 * @author Joel Peterson - @joelasonian - www.joelpeterson.com
 * @param flatcurr	float	integer to convert
 * @param curr	string of desired currency format
 * @return formatted number
 */
function formatcurrency($floatcurr, $curr = $cur){
	
	$currencies['CAD'] = array(2,'.',',');			//	Canadian Dollar
	
	$currencies['EUR'] = array(2,',','.');			//	Euro

	$currencies['HKD'] = array(2,'.',',');			//	Hong Kong Dollar
	
	$currencies['JPY'] = array(0,'',',');			//	Japan, Yen
	
	$currencies['MXN'] = array(2,'.',',');			//	Mexican Peso
	
	$currencies['GBP'] = array(2,'.',',');			//	Pound Sterling
	
	$currencies['AED'] = array(2,'.',',');			//	UAE Dirham
	
	$currencies['USD'] = array(2,'.',',');			//	US Dollar

	
	function formatinr($input){
		//CUSTOM FUNCTION TO GENERATE ##,##,###.##
		$dec = "";
		$pos = strpos($input, ".");
		if ($pos === false){
			//no decimals	
		} else {
			//decimals
			$dec = substr(round(substr($input,$pos),2),1);
			$input = substr($input,0,$pos);
		}
		$num = substr($input,-3); //get the last 3 digits
		$input = substr($input,0, -3); //omit the last 3 digits already stored in $num
		while(strlen($input) > 0) //loop the process - further get digits 2 by 2
		{
			$num = substr($input,-2).",".$num;
			$input = substr($input,0,-2);
		}
		return $num . $dec;
	}
	
	
	if ($curr == "INR"){	
		return formatinr($floatcurr);
	} else {
		return number_format($floatcurr,$currencies[$curr][0],$currencies[$curr][1],$currencies[$curr][2]);
	}
}


/*
formatcurrency(1000045.25);				//1,000,045.25 (USD)		
formatcurrency(1000045.25, "CHF");		//1'000'045.25
formatcurrency(1000045.25, "EUR");		//1.000.045,25
formatcurrency(1000045, "JPY");			//1,000,045
formatcurrency(1000045, "LBP");			//1 000 045
formatcurrency(1000045.25, "INR");		//10,00,045.25
*/

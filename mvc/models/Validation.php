<?php
namespace Haskris\Base;

class Validation
{
    public static function checkRequiredFields(array $fields): bool
	{
		foreach($fields as $field){
			if(empty($field)){
				return false;
			}
		}
		return true;
	}
    
    public static function isPositiveNumber($input): bool 
    {
        return is_numeric($input) && $input >= 0;
    }
    
    // Validate date format YYYY-MM-DD 
    public static function isValidDateFormat(string $inputDate): bool 
    { 
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $inputDate)) {
            $dateParts = explode('-', $inputDate);
            return checkdate(
                (int)$dateParts[1], 
                (int)$dateParts[2], 
                (int)$dateParts[0]
            );
        }
        return false;
    }

    public static function isValidGssId(mixed $value): bool 
	{
    	//Must be a string
		//Must contain 1-8 numerical digits
		return is_string($value) && preg_match('/^[0-9]{1,8}$/', $value) === 1;
	}

	public static function isValidFlag(mixed $value): bool 
	{
    	return 
		$value === '0' || 
		$value === '1' || 
		$value === 0 || 
		$value === 1;
	}

	public static function isValidHaskrisEmail(?string $email): bool 
	{
		//May contain Alphanumeric characters, underscores, and hyphens
		//First and last name may be separated by dot
		//Must end with @haskris.com
		//Empty or null values are allowed
				
		if ($email === null || $email === '') {
			return true;
		}
		return preg_match('/^[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)?@haskris\.com$/', $email) === 1;
	}
}

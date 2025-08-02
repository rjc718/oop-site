<?php
namespace Site\Models;

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

	public static function isValidFlag(mixed $value): bool 
	{
    	return 
		$value === '0' || 
		$value === '1' || 
		$value === 0 || 
		$value === 1;
	}
}

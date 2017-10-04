<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 24/09/15
 * Time: 11:42 AM
 */

namespace SymfonyStandaloneForms\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class StrToTimeTransformer implements DataTransformerInterface
{
	/**
	 * Transform (does nothing)
	 *
	 * @param string|null $value
	 * @return string
	 */
	public function transform($value)
	{
		if (null === $value) {
			return '';
		}
		
		return $value;
	}
	
	/**
	 * Transforms a string (a time entered by the user) to an hh:mm:ss format
	 *
	 * @param string $hhmmStr
	 * @return string|null
	 * @throws TransformationFailedException if the time entered isn't valid
	 */
	public function reverseTransform($hhmmStr)
	{
		// nothing entered? It's optional, so that's ok
		if (empty($hhmmStr)) {
			return;
		}
		
		if (!is_string($hhmmStr)) {
			throw new TransformationFailedException('Expected a string.');
		}
		
		$timeStr = null;
		if(preg_match('/^([0-9]{1,2})[:.,\s]?([0-9]{2})([:.,\s]?([0-9]{2}))?\s?(am|pm)?$/i', $hhmmStr, $matches) > 0) {
			list($orig, $hour, $minute) = $matches;
			$seconds = $matches[4] ?? 0;
			$amPm = $matches[5] ?? null;
			
			if($seconds >= 60) {
				$minute += 1;
				$seconds %= 60;
			}
			
			if($minute >= 60) {
				$hour += 1;
				$minute %= 60;
			}
			
			if(strtolower($amPm) == 'am') {
				if($hour == '12') {
					$hour = 0;
				} else if($hour > 12) {
					throw new TransformationFailedException();
				}
			} else if(strtolower($amPm) == 'pm') {
				if($hour < '12') {
					$hour += 12;
				}
			}
			if($hour >= 24) {
				$hour %= 24;
			}
			
			$timeStr =
				str_pad($hour, 2, '0', STR_PAD_LEFT) .
				':' .
				$minute
			;
		}
		
		if (null === $timeStr) {
			// causes a validation error
			// this message is not shown to the user
			// see the invalid_message option
			throw new TransformationFailedException(sprintf(
				'String provided could not be converted to hh:mm',
				$hhmmStr
			));
		}
		
		return $timeStr;
	}
}
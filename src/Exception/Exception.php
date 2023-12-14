<?php declare(strict_types = 1);

namespace Adbros\Shoptet\Exception;

use Throwable;

class Exception extends \Exception
{

	/** @var array<array{errorCode: string, errorMessage: string, instance: string}> */
	protected array $errors = [];

	/**
	 * @param array<array{errorCode: string, errorMessage: string, instance: string}> $errors
	 */
	public function __construct(string $message = '', int $code = 0, ?Throwable $previous = null, array $errors = [])
	{
		parent::__construct($message, $code, $previous);

		$this->errors = $errors;
	}

	/**
	 * @return array<array{errorCode: string, errorMessage: string, instance: string}>
	 */
	public function getErrors(): array
	{
		return $this->errors;
	}

}

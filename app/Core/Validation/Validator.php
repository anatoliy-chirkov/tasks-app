<?php

namespace Core\Validation;

class Validator
{
    private const FUNCTIONS_FOR_VALIDATORS = [
        IType::XSS      => 'validateXss',
        IType::REQUIRED => 'validateRequired',
        IType::EMAIL    => 'validateEmail',
        IType::LENGTH   => 'validateLength',
    ];

    private const DEFAULT_VALIDATORS = [
        IType::XSS,
    ];

    private $errors = [];

    public function isValid(array $data, array $rules)
    {
        foreach ($rules as $key => $rulesRowForThisDataRow) {
            $rulesForThisDataRow = explode(',', $rulesRowForThisDataRow);
            $rulesForThisDataRow = array_merge($rulesForThisDataRow, self::DEFAULT_VALIDATORS);

            foreach ($rulesForThisDataRow as $validationType) {
                $delimiterPos = strpos($validationType, '|');

                if ($delimiterPos) {
                    $additionalParam = substr($validationType, $delimiterPos);
                    $validationType = substr($validationType, 0, $delimiterPos);
                }

                $methodName = self::FUNCTIONS_FOR_VALIDATORS[$validationType];

                $isValid = isset($additionalParam)
                    ? $this->$methodName($data[$key], $additionalParam)
                    : $this->$methodName($data[$key])
                ;

                if (!$isValid) {
                    $this->errors[] = $this->getErrorText($key, $validationType);
                }
            }
        }

        return empty($this->errors);
    }

    public function getFirstError()
    {
        return !empty($this->errors) ? $this->errors[0] : null;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    private function getErrorText($key, string $type)
    {
        return "{$key} is invalid";
    }

    private function validateLength($value, $length)
    {
        return strlen($value) <= $length;
    }

    private function validateEmail($value)
    {
        $matches = [];
        preg_match('/[a-z]+@[a-z]+.[a-z]+/', $value, $matches);

        return count($matches) > 0;
    }

    private function validateXss($value)
    {
        return strpos($value, '<script') === false;
    }

    private function validateRequired($value)
    {
        return !empty($value);
    }
}

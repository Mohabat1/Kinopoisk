<?php

namespace App\Kernel\Validator;

class Validator
{
    private array $errors = [];
    private array $data;

    public function validate(array $data, array $rules): bool
    {
        $this->data = $data;
        $this->errors = [];

        foreach ($rules as $key => $rule) {
            if (is_string($rule)) {
                $rule = [$rule];
            }

            foreach ($rule as $singleRule) {
                $ruleParts = explode(':', $singleRule);

                $ruleName = $ruleParts[0];
                $ruleValue = $ruleParts[1] ?? null;

                $error = $this->validateRule($key, $ruleName, $ruleValue);

                if ($error) {
                    $this->errors[$key][] = $error;
                }
            }
        }
        return empty($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }


    private function validateRule(string $key, string $ruleName, string $ruleValue = null): string|false
    {
        $value = $this->data[$key] ?? null;

        switch ($ruleName) {
            case 'required':
                if (empty($value)) {
                    return "Field $key is required";
                }
                break;
            case 'string':
                if (!is_string($value)) {
                    return "Field $key must be a string";
                }
                break;
            case 'integer':
                if (!is_int($value)) {
                    return "Field $key must be an integer";
                }
                break;
            case 'email':
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    return " Field $key must be a valid email address";
                }
                break;
            case 'min':
                if (strlen($value) < $ruleValue) {
                    return "Field $key must be at least $ruleValue characters long";
                }
                break;
            case 'max':
                if (strlen($value) > $ruleValue) {
                    return "Field $key must be at most $ruleValue characters long";
                }
                break;
            default:
                return false;
        }

        return false;
    }
}







<?php namespace App;

use InvalidArgumentException;

class Validator {

    public $fails = false;
    public $errors;

    /**
     * Validate input data based on rules.
     *
     * @param array $data
     * @param $rules
     * @internal param $field
     * @internal param $value
     * @internal param $matches
     */
    public function validate(array $data, $rules)
    {
        $inputField = $data['field'];
        $value = $data['value'];

        foreach ($rules as $ruleField => $rule)
        {
            if ($inputField == $ruleField)
            {
                $fieldRules = $this->convertRulesToArray($rule);
                $this->callRules($fieldRules, $value, $ruleField);
            }
        }
    }

    /**
     * Check if input is in predefined values.
     *
     * @param $input
     * @param array $values
     * @param $field
     */
    private function in($input, array $values, $field)
    {
        $allValues = '';
        foreach ($values as $value)
        {
            if ($input == $value) return true;
            $allValues .= $value . ',';
        }

        $field = ucfirst($field);
        $allValues = substr($allValues, 0, -1);

        $this->fails = true;
        $this->errors = "{$field} should be one of the following: {$allValues}";
    }

    /**
     * Check if input has min length.
     *
     * @param $input
     * @param $value
     * @param $field
     * @return bool
     */
    private function minLength($input, $value, $field)
    {
        if ( strlen($input) < $value )
        {
            $field = ucfirst($field);

            $this->fails = true;
            $this->errors = "{$field} should have min: {$value} characters.";
        }

        return true;
    }

    /**
     * Check if input has max length.
     * @param $input
     * @param $value
     * @param $field
     * @return bool
     */
    private function maxLength($input, $value, $field)
    {
        if ( strlen($input) > $value )
        {
            $field = ucfirst($field);

            $this->fails = true;
            $this->errors = "{$field} should have max: {$value} characters.";
        }

        return true;
    }

    /**
     * Check if input's length is equal to rule's value.
     *
     * @param $input
     * @param $value
     * @param $field
     * @return bool
     */
    private function equalLength($input, $value, $field)
    {
        if ( strlen($input) > $value )
        {
            $field = ucfirst($field);

            $this->fails = true;
            $this->errors = "{$field} should have {$value} characters.";
        }

        return true;
    }

    /**
     * @param $methodName
     * @throws InvalidArgumentException
     */
    private function throwExpectionForMissingMethod($methodName)
    {
        $this->fails = true;
        $this->errors = "Method {$methodName} does not exist.";
        throw new InvalidArgumentException("Method {$methodName} does not exist.");
    }

    /**
     * @param $string
     * @return mixed
     */
    private function getTextBetweenBrackets($string)
    {
//        var_dump($string);
        preg_match("^\[(.*?)\]^", $string, $matches);

        if (isset($matches) && ! empty($matches))
        {
//            var_dump($matches);
            return $matches[1];
        }
        else
        {
            return false;
        }
    }

    /**
     * @param $ruleValues
     * @return bool
     */
    private function hasManyRuleValues($ruleValues)
    {
        return strpos($ruleValues, ',') !== false;
    }

    /**
     * @param $fieldRule
     * @return mixed
     */
    private function getMethodName($fieldRule)
    {
        return current(explode("[", $fieldRule));
    }

    /**
     * @param $rule
     * @return array
     */
    private function convertRulesToArray($rule)
    {
        return explode('|', $rule);
    }

    /**
     * @param $ruleValues
     * @return array
     */
    private function getAllRuleValues($ruleValues)
    {
        return explode(',', $ruleValues);
    }

    /**
     * @param array $fieldRules
     * @param $value
     * @param $ruleField
     */
    private function callRules(array $fieldRules, $value, $ruleField)
    {
        foreach ($fieldRules as $fieldRule)
        {
            $methodName = $this->getMethodName($fieldRule);
            $ruleValues = $this->getTextBetweenBrackets($fieldRule);

            // Check if there are more than one value per rule.
            $ruleValues = $this->hasManyRuleValues($ruleValues) ? $this->getAllRuleValues($ruleValues) : $ruleValues;

            method_exists($this, $methodName)
                ? call_user_func_array([$this, $methodName], [$value, $ruleValues, $ruleField])
                : $this->throwExpectionForMissingMethod($methodName);
        }
    }
}

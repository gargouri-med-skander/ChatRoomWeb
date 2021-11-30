<?php

namespace App\Security;
/**
 * verifyEmail exception handler
 */
class verifyEmailException extends \Exception
{
    /**
     * Prettify error message output
     * @return string
     */
    public function errorMessage(): string
    {
        $errorMsg = $this->getMessage();
        return $errorMsg;
    }
}
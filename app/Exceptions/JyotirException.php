<?php

namespace App\Exceptions;

use Exception;

class JyotirException extends Exception
{
    // ...

    /**
     * Get the exception's context information.
     *
     * @return array
     */
    public function context()
    {
        return ['teste' => $this->a];
    }
}

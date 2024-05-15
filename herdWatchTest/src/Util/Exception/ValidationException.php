<?php

namespace App\Util\Exception;

use Symfony\Component\Validator\ConstraintViolationList;

class ValidationException extends BaseException
{
    /**
     * @inheritdoc
     */
    protected $message = 'Invalid data.';

    /**
     * @var array
     */
    protected array $errors;

    /**
     * @param ConstraintViolationList $errors
     */
    public function __construct(ConstraintViolationList $errors) {
        parent::__construct();

        $this->errors = $this->mapErrorsList($errors);
    }

    /**
     * @param ConstraintViolationList $errors
     * @return array
     */
    private function mapErrorsList(ConstraintViolationList $errors): array
    {
        $errorsArray = [];

        foreach ($errors as $error) {
            $errorProperty = $error->getPropertyPath();

            if (!empty($errorsArray[$errorProperty])) {
                $errorsArray[$errorProperty] = sprintf(
                    '%s %s',
                    $errorsArray[$errorProperty],
                    $this->sanitizeMessage($error->getMessage())
                );

                continue;
            }

            $errorsArray[$errorProperty] = $this->sanitizeMessage($error->getMessage());
        }

        return $errorsArray;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param string $message
     * @return string
     */
    private function sanitizeMessage(string $message): string
    {
        $message = str_replace('|(Traversable&ArrayAccess)', '', $message);

        return str_replace('"', '', $message);
    }
}

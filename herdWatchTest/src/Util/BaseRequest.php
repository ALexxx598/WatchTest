<?php

namespace App\Util;

use App\Util\Exception\ValidationException;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class BaseRequest
{
    /**
     * @var ConstraintViolationListInterface
     */
    protected ConstraintViolationListInterface $errors;

    protected Request $request;

    /**
     * @param ValidatorInterface $validator
     *
     */
    public function __construct(
        protected ValidatorInterface $validator,
        protected RequestStack $requestStack,
    ) {
        $this->populate();

        if ($this->needToValidate()) {
            $this->validate();
        }
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request ?? $this->request = $this->requestStack->getCurrentRequest();
    }

    /**
     * @return ConstraintViolationListInterface
     */
    public function getErrors(): ConstraintViolationListInterface
    {
        return $this->errors;
    }

    /**
     * @return ConstraintViolationListInterface
     */
    public function validate(): ConstraintViolationListInterface
    {
        $this->errors = $this->validator->validate($this);

        if ($this->errors->count() > 0) {
            throw new ValidationException($this->errors);
        }

        return $this->errors;
    }

    /**
     *
     */
    protected function populate(): void
    {
        try {
            $requestArray = $this->getRequest()->toArray();
        } catch (Exception $e) {
            $requestArray = $this->getRequest()->query->all();
        }

        foreach ($requestArray as $property => $value) {
            if (property_exists($this, $property)) {
                $this->{$property} = $value;
            }
        }
    }

    /**
     * @return bool
     */
    protected function needToValidate(): bool
    {
        return true;
    }
}

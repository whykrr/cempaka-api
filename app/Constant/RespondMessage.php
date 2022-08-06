<?php

namespace App\Constant;

/**
 * Class for get message responde
 */

class RespondMessage
{
    // Success Respond
    public const SUCCESS_RETRIEVE = 'Data successfully retrieved';
    public const SUCCESS_CREATE = 'Data successfully created';
    public const SUCCESS_UPDATE = 'Data successfully updated';
    public const SUCCESS_DELETE = 'Data successfully deleted';

    // Error Respond
    public const ERROR_RETRIEVE = 'Data not retrieved';
    public const ERROR_NOT_FOUND = 'Data not found';
    public const ERROR_TARGET_NOT_FOUND = 'Target not found';

    public const ERROR_VALIDATION = 'Validation error';
    public const ERROR = 'Error';
}

<?php

namespace Dduers\T3GamingRecords\Controller;

use TYPO3\CMS\Core\Http\PropagateResponseException;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Frontend\Controller\ErrorController;

class BaseController extends ActionController
{
    private const DEBUG_ENABLED = true;

    /**
     * trigger http error
     * 
     * @param int $code
     * @param string $message = ''
     * @throws PropagateResponseException
     * @return void
     */
    protected function triggerHttpError(int $code, string $message = ''): void
    {
        switch ($code) {
            case 404:
                $response = GeneralUtility::makeInstance(ErrorController::class)->pageNotFoundAction(
                    $this->request,
                    $message
                );
                // middleware aware
                throw new PropagateResponseException($response, 1704787250);
                //throw new ImmediateResponseException($response, 1704787250);
                break;
        }
    }

    /**
     * debug output of variables with title and context information (controller and action name)
     *
     * @param mixed $data
     * @param string $title
     */
    protected function var_dump(mixed $data, ?string $title = null): bool
    {
        return self::DEBUG_ENABLED
            ? DebuggerUtility::var_dump($data, $this->request->getControllerName() . '->' . $this->request->getControllerActionName() . ': ' . $title)
            : false;
    }
}

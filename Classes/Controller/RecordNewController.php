<?php

namespace Dduers\T3GamingRecords\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Http\ForwardResponse;

class RecordNewController extends BaseController
{
    /**
     * LIST ACTION
     */
    public function showAction(): ResponseInterface
    {
        $context = GeneralUtility::makeInstance(Context::class);
        $userId = $context->getPropertyFromAspect('frontend.user', 'id');

        $this->view->assign('data', [
            'playerId' => $userId,
            'recordStoragePid' => $this->settings['recordStoragePid'],
            'imageStorage' => $this->settings['imageStorage'],
        ]);

        return $this->htmlResponse();
    }

    public function performAction(): ResponseInterface
    {
        return (new ForwardResponse('show'));
    }
}
